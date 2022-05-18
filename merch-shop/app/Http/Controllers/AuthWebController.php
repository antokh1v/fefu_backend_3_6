<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseLoginFormRequest;
use App\Http\Requests\BaseRegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthWebController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(BaseLoginFormRequest $request)
    {

        $data = $request->validated();

        if (Auth::attempt($data, true)){
            $request->session()->regenerate();

            return redirect(route('profile'));
        }

        return back()->withErrors([
            'email'=>'invalid',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function registerForm(){
        return view('register');
    }

    public function register(BaseRegisterFormRequest $request)
    {
        $data = $request->validated();

        $user = User::createFromRequest($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect(route('profile'));
    }
}
