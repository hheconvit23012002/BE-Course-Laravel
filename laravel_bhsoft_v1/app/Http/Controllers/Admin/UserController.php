<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User())->getTable();
        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        return view("admin.users.index");
    }

    public function users(Request $request)
    {
        try {
            $q = $request->get('q');
            $field = $request->get('field');
            $query = $this->model
                ->addSelect('users.id', 'users.name', 'users.email', 'users.birthdate', 'users.phone_number', 'users.logo')
                ->selectRaw('COUNT(signup_courses.course) as number_courses')
                ->leftJoin('signup_courses', 'signup_courses.user', 'users.id')
                ->groupBy('users.id')
                ->where('users.role', 1);
            if (isset($q) && isset($field)) {
                if ($field !== 'number_courses') {
                    $query->where("users.$field", 'like', '%' . $q . '%');
                } else {
                    $query->having('number_courses', '=', $q);
                }
            }
            $data = $query
                ->paginate()
                ->appends(['q' => $q])
                ->appends(['field' => $field]);
            $arr['data'] = $data->getCollection();
            $arr['pagination'] = $data->linkCollection();
            return $this->successResponse($arr);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function user($id)
    {
        try {
            if (empty($id)) {
                throw new NotFound('User not found');
            }
            $user = $this->model
                ->select([
                    'id',
                    'name',
                    'email',
                    'birthdate',
                    'phone_number',
                    'logo',
                ])
                ->where('id', $id)
                ->firstOrFail();
            $courses = SignupCourse::query()
                ->with('courses:id,name,start_date,end_date')
                ->where('user', $id)
                ->where('expire', 1)
                ->get();
            $arr['user'] = $user;
            $arr['course'] = $courses;
            return $this->successResponse($arr);
        } catch (NotFound $e) {
            return $this->errorResponse("Vui lòng nhập id ", 404);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Không tồn tại", 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show()
    {
        return view("admin.users.show");
    }

    public function edit($request)
    {
        return view("admin.users.edit");
    }

    public function create()
    {
        return view("admin.$this->table.create");
    }

    public function update(UpdateRequest $request, $user_id)
    {
        try {
            $arr_update = $request->except('_token', '_method', 'logo_new', 'logo_old', 'course');
            $arr = $request->validated();
            $course_new = $arr['course'];
            $user = User::query()->where('id',$user_id)->firstOrFail();
            $user->courses()->sync($course_new);
            if (isset($arr['logo_new'])) {
                Storage::deleteDirectory("public/$user_id");
                $path = Storage::disk('public')->putFile($user_id, $request->file('logo_new'));
                $arr_update['logo'] = $path;
            }
            $this->model->where('id', $user_id)->update($arr_update);
            return $this->successResponse();
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Không tồn tại người sửa", 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $arr = $request->validated();
            $arr['password'] = Hash::make('1');
            $courses = $arr['course'];
            $this->model->create($arr);
            $email = $arr['email'];
            $user_new = $this->model->select(['id'])->where('email', $email)->first();
            foreach ($courses as $course) {
                $arr_course = [];
                $arr_course['user'] = $user_new->id;
                $arr_course['course'] = $course;
                SignupCourse::create($arr_course);
            }
            $path = Storage::disk('public')->putFile($user_new->id, $request->file('logo'));
            $arr['logo'] = $path;
            $this->model->where('id', $user_new->id)->first()->update($arr);
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function destroy(Request $request)
    {
        try {
            $this->model->where('id', $request->id)
                ->firstOrFail();
            Storage::deleteDirectory("public/$request->id");
            User::destroy($request->id);
            return $this->successResponse();
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Không tồn tại người xóa", 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
