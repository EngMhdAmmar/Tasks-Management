@extends('layouts.auth_url') @section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Brand logo-->
                    <a class="brand-logo" href="index.html">
                        <h2 class="brand-text text-primary ms-1">IxCoders</h2>
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{asset('app-assets/images/pages/login-v2.svg')}}" alt="Login V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">Welcome to IxCoders! 👋</h2>
                            <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                            <form class="auth-login-form mt-2" action="{{route('signIn')}}" method="POST">
                                @csrf @method('POST')
                                <div class="mb-1">
                                    <label class="form-label" for="login-email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="login-email" type="text" name="email" placeholder="example@example.com" aria-describedby="login-email" autofocus="" tabindex="1" />
                                </div>
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">Password</label><a href="{{route('forgetPassword')}}"><small>Forgot Password?</small></a>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>@enderror @if(session()->has('error'))
                                <div class="alert alert-danger"> {{ session('error') }} </div> @endif
                                <input type="submit" value="Login" class="btn btn-primary w-100" tabindex="4">
                            </form>
                            <p class="text-center mt-2"><span>New on our platform?</span><a href="{{route('register')}}"><span>&nbsp;Create an account</span></a></p>
                        </div>
                    </div>
                    <!-- /Login-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection