<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Course;
use App\Models\SignupCourse;
use App\Models\User;
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
    public function __construct(){
        $this->model = User::query();
        $this->table =(new User())->getTable();
        View::share('title',ucwords($this->table));
        View::share('table',$this->table);
    }
    public function index(){
        return view("admin.users.index");
    }
    public function allUser(Request $request){
        $q    = $request->get('q');
        $field    = $request->get('field');
        $query = $this->model
            ->addSelect('users.id','users.name','users.email','users.birthdate','users.phone_number','users.logo')
            ->selectRaw('COUNT(signup_courses.course) as number_courses')
            ->leftJoin('signup_courses','signup_courses.user','users.id')
            ->groupBy('users.id')
            ->where('users.role',1);

        if(isset($q) && isset($field)){
            if($field !== 'number_courses'){
                $query->where("users.$field",'like','%'.$q.'%');
            }else{
                $query->having('number_courses', '=', $q);
            }
        }
        $data = $query
            ->paginate()
            ->appends(['q' => $q])
            ->appends(['field' => $field]);

//        return response()->json($data);
        $arr['data'] = $data->getCollection();

        $arr['pagination'] = $data->linkCollection();
        return $this->successResponse($arr);
    }
    public function getUser(Request $request){
        if(empty($request->user)){
            return redirect()->back();
        }
        $id = $request->user;
        $user = $this->model
            ->select([
                'id',
                'name',
                'email',
                'birthdate',
                'phone_number',
                'logo',
            ])
            ->where('id',$id)
            ->first();
        $courses = SignupCourse::query()
            ->with('courses:id,name,start_date,end_date')
            ->where('user',$id)
            ->where('expire',1)
            ->get();
        $arr['user'] = $user;
        $arr['course'] = $courses;
        return $this->successResponse($arr);
    }
    public function show(){
        return view("admin.users.show");
    }
    public function edit($request){
        if(empty($request)){
            return redirect()->back();
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
            ->where('id',$request)
            ->first();
        $courses = SignupCourse::query()
            ->with('courses:id,name,start_date,end_date')
            ->where('user',$request)
            ->where('expire',1)
            ->get();
        return \view("admin.users.edit",[
            'user'=>$user,
            'courses'=>$courses
        ]);
    }
    public function create(){
        return view("admin.$this->table.create");
    }
    public function update(UpdateRequest $request,$userID){
        $arrUpdate           = $request->except('_token','_method','logo_new','logo_old','course');
        $arr = $request->validated();
        $courseNew = $arr['course'];
        $user = User::find($userID);
        $user->courses()->sync($courseNew);
        if(isset($arr['logo_new'])){
            Storage::deleteDirectory("public/$user");
            $path = Storage::disk('public')->putFile($user, $request->file('logo_new'));
            $arrUpdate['logo'] = $path;
        }
        $this->model->where('id',$userID)->update($arrUpdate);
        return redirect()->route('admin.users.index')->with('success','Thay đổi thành công');
    }
    public function store(StoreRequest $request){
        $arr           = $request->validated();
        $arr['password'] = Hash::make('1');
        $courses = $arr['course'];
        $this->model->create($arr);
        $email = $arr['email'];
        $userNew = $this->model->select(['id'])->where('email', $email)->first();
        foreach ($courses as $course){
            $arrCourse = [];
            $arrCourse['user'] = $userNew->id;
            $arrCourse['course'] = $course;
            SignupCourse::create($arrCourse);
        }
        $path = Storage::disk('public')->putFile($userNew->id, $request->file('logo'));
        $arr['logo'] = $path;

        $this->model->where('id',$userNew->id)->first()->update($arr);
        return redirect()->route('admin.users.index')->with('success','Thêm thành công');
    }
    public function destroy($userId){
//        Storage::deleteDirectory($id,0711, true, true);
        Storage::deleteDirectory("public/$userId");
//        File::deleteDirectory(public_path($userId));
        User::destroy($userId);
        return redirect()->back()->with('success','Xóa thành công');
    }
}
