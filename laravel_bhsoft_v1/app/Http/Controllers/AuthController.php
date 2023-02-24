<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        if(session()->get('role') === 0){
            return redirect()->route('admin.users.index');
        }else if(session()->get('role') === 1){
            return redirect()->route('user.index');
        }
        return view("auth.login");
    }
    public function processLogin(LoginRequest $request){
        try{
            $user = User::query()->where('email',$request->get('email'))
                ->firstOrFail();
            if (!Hash::check($request->get('password'), $user->password)) {
                throw new \Exception('Invalid password');
            }
            session()->put('id',$user->id);
            session()->put('name',$user->name);
            session()->put('role',$user->role);
            if($user->role === 0){
                return  redirect()->route('admin.users.index');
            }else{
                return redirect()->route('user.index');
            }
        }catch (\Throwable $e){
            return redirect()->route('login')->with('error','sai email hoặc password');
        }

    }
    public function logout(){
        session()->flush();
        return redirect()->route('login');
    }
}
