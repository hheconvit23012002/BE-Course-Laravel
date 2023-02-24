<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    private object $model;
    private string $table;
    public function __construct(){
        $this->model = User::query();
        $this->table =(new User())->getTable();
        View::share('title',ucwords($this->table));
        View::share('table',$this->table);
    }
    public function index(){
        $data = $this->model
            ->select([
                'id',
                'name',
                'email',
                'birthdate',
                'phone_number',
                'logo',
            ])
            ->paginate();
//        return response()->json($data);
        return view("admin.$this->table.index",[
            'data' => $data
        ]);
    }

    public function show($request){
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
            ->get();
        return \view("admin.users.show",[
           'user'=>$user,
            'courses'=>$courses
        ]);
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
            ->get();
        return \view("admin.users.edit",[
            'user'=>$user,
            'courses'=>$courses
        ]);
    }
    public function create(){
        return view("admin.$this->table.create");
    }
    public function update(UpdateRequest $request,$user){
        $arrUpdate           = $request->except('_token','_method','logo_new','logo_old');
        $arr = $request->validated();
        SignupCourse::query()->where('user',$user)->delete();
        if(isset($arr['course'])){
            $courseNew = $arr['course'];
            foreach ($courseNew as $course){
                $arrCourse = [];
                $arrCourse['user'] = $user;
                $arrCourse['course'] = $course;
                SignupCourse::create($arrCourse);
            }
        }
        if(isset($arr['logo_new'])){
            Storage::deleteDirectory("public/$user");
            $path = Storage::disk('public')->putFile($user, $request->file('logo_new'));
            $arrUpdate['logo'] = $path;
        }
        $this->model->where('id',$user)->first()->update($arrUpdate);
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
