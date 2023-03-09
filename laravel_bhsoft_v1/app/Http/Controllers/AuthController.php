<?php

namespace App\Http\Controllers;

use App\Events\UserRegisterEvent;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseTrait;

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
                $token = $user->createToken('access-token');
            }
            $arr = [];
            if ($user->role === 0) {
                $arr['route'] = '/admin/users/';
            } else {
                $arr['route'] = '/';
            }
            $arr['_token'] = $token->accessToken;
            return $this->successResponse($arr);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('sai email hoặc password', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
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
            return $this->successResponse();
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        $tokens = $user->tokens;
        foreach ($tokens as $token) {
            $token->delete();
        }
        auth()->logout();
        return redirect()->route('login');
    }
}
