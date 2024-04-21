<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\checkEmailRequest;
use App\Http\Requests\auth\CheckVerificationCodeRequest;
use App\Http\Requests\auth\ProfileUpdateRequest;
use App\Http\Requests\auth\SignInRequest;
use App\Http\Requests\auth\SignUpRequest;
use App\Models\User;
use App\Traits\SendEmailTrait;
use Carbon\Carbon;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    use SendEmailTrait;
    use MustVerifyEmail;

    public function register()
    {
        return view('auth.register');
    }

    public function signup(SignUpRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $verificationCode = rand(10000, 99999);
        $data = $request->validated();
        $data['verification_code'] = $verificationCode;
        $user = User::create($data);
        session()->put('user', $user);
        $this->sendVerifyEmail($request->email, $request->name, $verificationCode);
        return redirect()->route('verificationCode');
    }

    public function checkVerificationCode(CheckVerificationCodeRequest $request, String $preRoute)
    {
        $verification_code = implode('', $request->verification_code);
        if (!session()->has('user')) return;
        if(auth()->check()) $user = auth()->user();
        else $user = session()->get('user');
        if ($user->verification_code != $verification_code) return back()->with('error', 'Verification Code Not Match');
        $user->email_verified_at = Carbon::now();
        $user->save();
        if ($preRoute == 'forgetPassword') {
            return redirect()->route('resetPassword');
        } else if ($preRoute == 'register' || $preRoute == 'login') {
            Auth::login($user);
            return redirect()->route('tasks.index');
        } else if ($preRoute == 'profile.show') {
            $data = session()->get('updateProfile');
            $user->update($data);
            session()->remove('updateProfile');
            return redirect()->route('tasks.index');
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function signIn(SignInRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return back()->with('error', 'Information Not Match');
        return redirect()->route('tasks.index');
    }

    public function verificationCode()
    {
        return view('auth.verificationCode');
    }

    public function forgetPassword()
    {
        return view('auth.checkEmail');
    }

    public function checkEmail(checkEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) return back()->with('error', 'Email Not Found');
        session()->put('user', $user);
        $verificationCode = rand(10000, 99999);
        $user->verification_code = $verificationCode;
        $user->email_verified_at = null;
        $user->save();
        $this->sendVerifyEmail($request->email, $request->name, $verificationCode);
        return redirect()->route('verificationCode');
    }

    public function resetPassword()
    {
        return view('auth.resetPassword');
    }

    public function updatePassword(Request $request)
    {
        if (!session()->has('user')) return;
        $user = session()->get('user');
        $user->password = $request->password;
        $user->save();
        Auth::login($user);
        return redirect()->route('tasks.index');
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function profile(){ 
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }

    public function profileUpdate(ProfileUpdateRequest $request) 
    {
        $user = auth()->user();
        if($user->email != $request->email) {
            $verificationCode = rand(10000, 99999);
            $user->verification_code = $verificationCode;
            $user->save();
            $this->sendVerifyEmail($request->email, $request->name, $verificationCode);
            session()->put('updateProfile', $request->validated());
            return redirect()->route('verificationCode');
        }
        else {
            $data = $request->validated();
            $user->update($data);
            return redirect()->route('tasks.index');
        }
    }
}
