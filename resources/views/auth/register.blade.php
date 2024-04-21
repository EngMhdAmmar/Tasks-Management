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
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{asset('app-assets/images/pages/register-v2.svg')}}" alt="Register V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Register-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">Adventure starts here 🚀</h2>
                            <p class="card-text mb-2">Make your app management easy and fun!</p>
                            <form class="auth-register-form mt-2" action="{{route('signup')}}" method="POST">
                                @csrf @method('POST')
                                <div class="mb-1">
                                    <label class="form-label" for="register-username">Your Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="register-username" type="text" name="name" placeholder="Example" aria-describedby="register-username" autofocus="" tabindex="1" />
                                </div>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                <div class="mb-1">
                                    <label class="form-label" for="register-email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="register-email" type="text" name="email" placeholder="example@example.com" aria-describedby="register-email" tabindex="2" />
                                </div>
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                <div class="mb-1">
                                    <label class="form-label" for="register-password">Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="register-password" type="password" name="password" placeholder="············" aria-describedby="register-password" tabindex="3" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                <input type="submit" value="Sign up" class="btn btn-primary w-100" tabindex="5">
                            </form>
                            <p class="text-center mt-2"><span>Already have an account?</span><a href="{{route('login')}}"><span>&nbsp;Sign in instead</span></a></p>
                        </div>
                    </div>
                    <!-- /Register-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection