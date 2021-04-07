<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function login()
    {
        return view("users.login");
    }

    public function auth(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8|max:25"
        ]);

        $credentials = $request->only(['email', 'password']);
        $remember = $request->post("remember-me");

        if(Auth::attempt($credentials, $remember))
            return redirect()->route("home");
        else
        {
            return back()->with(["message" => "Users not found!"]);
        }
    }

    public function create()
    {
        return view("users.registration");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "surname" => "required",
            "middle_name" => "required",
            "email" => "required|unique:users",
            "password" => "required|confirmed|min:8|max:25",
            "terms" => "accepted",
        ]);

        $user = Users::create([
            "name" => $request->name,
            "surname" => $request->surname,
            "middle_name" => $request->middle_name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "seller" => $request->seller,
            "admin" => 0
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('email.verify');
    }

    public function verify_notice()
    {
        return view("users.email");
    }

    public function forgot_password()
    {
        return view('users.forgot-password');
    }

    public function send_password(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset_password($token)
    {
        return view("users.reset-password")->with("token", $token);
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('loggin')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
