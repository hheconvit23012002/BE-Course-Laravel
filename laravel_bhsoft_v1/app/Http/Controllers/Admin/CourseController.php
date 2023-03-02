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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    use ResponseTrait;
    private object $model;
    private string $table;
    public function __construct(){
        $this->model = Course::query();
        $this->table =(new Course())->getTable();
        View::share('title',ucwords($this->table));
        View::share('table',$this->table);
    }

    public function index(){
        return view("admin.$this->table.index");
    }
    public function allCourse(Request $request){
        $q    = $request->get('q');
        $field    = $request->get('field');
        $query = $this->model
            ->select([
                'id',
                'name',
                'description',
                'start_date',
                'end_date',
            ]);
        if(isset($q) && isset($field)){
            $query->where("courses.$field",'like','%'.$q.'%');
        }
        $data = $query->paginate()
            ->appends(['q' => $q])
            ->appends(['field' => $field]);
        $arr['data']= $data->getCollection();
        $arr['pagination'] = $data->linkCollection();
        return $this->successResponse($arr);
    }
    public function getCourse(Request $request){
        if(empty($request->course)){
            return redirect()->back();
        }
        $id = $request->course;
        $course = $this->model
            ->select([
                'id',
                'name',
                'description',
                'start_date',
                'end_date',
            ])
            ->where('id',$id)
            ->first();
        $users = SignupCourse::query()
            ->with('users:id,name,email,phone_number')
            ->where('course',$id)
            ->where('expire',1)
            ->get();
        $arr['course'] = $course;
        $arr['users'] = $users;
        return $this->successResponse($arr);
    }
    public function show($request){
        return \view("admin.$this->table.show");
    }
    public function edit($request){
        if(empty($request)){
            return redirect()->back();
        }
        $course = $this->model
            ->select([
                'id',
                'name',
                'description',
                'start_date',
                'end_date',
            ])
            ->where('id',$request)
            ->first();
        return \view("admin.$this->table.edit",[
            'course'=>$course,
        ]);
    }
    public function update(UpdateRequest $request,$user){
        $arr = $request->validated();
        if(empty($arr['description'])){
            $arr['description'] = '';
        }
        $this->model->where('id',$user)->first()->update($arr);
        return redirect()->route("admin.$this->table.index")->with('success','Thay đổi thành công');
    }
    public function create(){
        return view("admin.$this->table.create");
    }
    public function store(StoreRequest $request){
//        return response()->json($request);
        $this->model->create($request->validated());
        return redirect()->route("admin.$this->table.index")->with('success','Thêm thành công');
//        return view("admin.$this->table.create");
    }
    public function destroy($userId){
        Course::destroy($userId);
        return redirect()->back()->with('success','Xóa thành công');
    }
    public function importCsv(Request $request){
        try {
            Excel::import(new CourseImport(), $request->file('file'));
            return $this->successResponse();
        }catch (\Exception $e){
            return $this->errorResponse();
        }
    }
    public function exportCsv(Request $request){
        try {
            return Excel::download(new CoursesExport(), 'course.xlsx');
        }catch (\Exception $e){
            return $this->errorResponse();
        }
    }
}
