<?php

namespace App\Http\Controllers;

use App\Events\UserRegisterEvent;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {

        return view("auth.login");
    }

    public function signup()
    {
        return view("auth.signup");
    }

    public function processLogin(LoginRequest $request)
    {
        try {
            $user = User::query()->where('email', $request->get('email'))
                ->firstOrFail();
            if (!Hash::check($request->get('password'), $user->password)) {
                throw new \Exception('Invalid password');
            }
            if (isset($user)) {
                Auth::login($user, true);
            }
            if ($user->role === 0) {
                return redirect()->route('admin.users.index');
            } else {
                return redirect()->route('user.index');
            }
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', 'sai email hoặc password');
        }
    }

    public function processSignup(RegisterRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            UserRegisterEvent::dispatch($user);
            return redirect()->route('login')->with('success', 'dang ky thanh cong');
        } catch (\Throwable $e) {
            return redirect()->route('signup')->with('error', 'sai email hoặc password');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
