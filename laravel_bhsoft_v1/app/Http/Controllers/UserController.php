<?php

namespace App\Http\Controllers;

use App\Models\SignupCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
        $userId = auth()->user()->id;
        $user = $this->model
            ->select([
                'id',
                'name',
                'email',
                'birthdate',
                'phone_number',
                'logo',
            ])
            ->where('id',$userId)
            ->first();
        $courses = SignupCourse::query()
            ->with('courses:id,name,start_date,end_date')
            ->where('user',$userId)
            ->get();
        return \view("user.index",[
            'user'=>$user,
            'courses'=>$courses
        ]);
    }
}
