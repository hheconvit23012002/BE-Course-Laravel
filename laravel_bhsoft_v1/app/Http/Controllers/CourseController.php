<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use ResponseTrait;
    private object $model;
    public function __construct(){
        $this->model = Course::query();
    }
    public function index(Request $request){
        try{
            $data = $this->model
                ->where('name','like','%'.$request->get('q').'%')
                ->get();
            return $this->successResponse($data);
        }catch (\Throwable $e ){
            return $this->errorResponse($e);
        }
    }
    //
}
