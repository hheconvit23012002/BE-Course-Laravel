<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CoursesExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Imports\CourseImport;
use App\Models\Course;
use App\Models\SignupCourse;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = Course::query();
        $this->table = (new Course())->getTable();
        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        return view("admin.$this->table.index");
    }

    public function courses(Request $request)
    {
        try {
            $q = $request->get('q');
            $field = $request->get('field');
            $query = $this->model
                ->select([
                    'id',
                    'name',
                    'description',
                    'start_date',
                    'end_date',
                ]);
            if (isset($q) && isset($field)) {
                $query->where("courses.$field", 'like', '%' . $q . '%');
            }
            $data = $query->paginate()
                ->appends(['q' => $q])
                ->appends(['field' => $field]);
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function course($id)
    {
        try {
            if (empty($id)) {
                throw new NotFound('Course not found');
            }
            $course = $this->model
                ->select([
                    'id',
                    'name',
                    'description',
                    'start_date',
                    'end_date',
                ])
                ->where('id', $id)
                ->firstOrFail();
            $users = SignupCourse::query()
                ->with('users:id,name,email,phone_number')
                ->where('course', $id)
                ->where('expire', 1)
                ->get();
            $arr['course'] = $course;
            $arr['users'] = $users;
            return $this->successResponse($arr);
        } catch (NotFound $e) {
            return $this->errorResponse("Vui lòng nhập id ", 404);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Không tồn tạiiiiiii", 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show($request)
    {
        return \view("admin.$this->table.show");
    }

    public function edit($request)
    {
        return view("admin.$this->table.edit");
    }

    public function update(UpdateRequest $request, $course)
    {
        try {
            Course::query()->where('id', $course)->firstOrFail();
            $arr = $request->validated();
            if (empty($arr['description'])) {
                $arr['description'] = '';
            }
            $this->model->where('id', $course)->update($arr);
            return $this->successResponse();
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Người dùng không tôn tại', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function create()
    {
        return view("admin.$this->table.create");
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->model->create($request->validated());
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
//        $this->model->create($request->validated());
//        return redirect()->route("admin.$this->table.index")->with('success', 'Thêm thành công');
    }

    public function destroy($id)
    {
        try {
            Course::query()->
            where('id', $id)
                ->firstOrFail();
            Course::destroy($id);
            return $this->successResponse();
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Không tồn tại khoá học được xóa", 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
//        Course::destroy($userId);
//        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function importCsv(Request $request)
    {
        try {
            Excel::import(new CourseImport(), $request->file('file'));
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function exportCsv()
    {
        try {
            return Excel::download(new CoursesExport(), 'course.xlsx');
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }
}
