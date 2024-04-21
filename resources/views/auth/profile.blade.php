@extends('layouts.tasks_url') @section('content') @use('App\Enums\ScheduleType') @use('App\Enums\Priority')
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="#">
                    <h2 class="brand-text">IxCoders</h2>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('profile.show') }}"><i
                            data-feather="user"></i><span class="menu-title text-truncate"
                            data-i18n="Email">Profile</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('tasks.index') }}"><i
                            data-feather="check"></i><span class="menu-title text-truncate" data-i18n="Email">My Leading
                            Tasks</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('tasks.user') }}"><i
                            data-feather="check-square"></i><span class="menu-title text-truncate" data-i18n="Email">My
                            Tasks</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('tasks.all')}}"><i data-feather="list"></i><span
                            class="menu-title text-truncate" data-i18n="Email">All Tasks</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('logout') }}"><i
                            data-feather="log-out"></i><span class="menu-title text-truncate"
                            data-i18n="Email">Logout</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content todo-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-area-wrapper container-xxl p-0">
        <div class="content-right">
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="modal-content" style="margin-left: 10%; margin-top: 10%">
                        <div class="modal-body pb-5 px-sm-5 pt-50">
                            <div class="text-center mb-2">
                                <h1 class="mb-1">Edit Profile Information</h1>
                            </div>
                            <form id="editUserForm" class="row gy-1 pt-75" action="{{route('profile.update')}}" method="POST">
                                @csrf @method('POST')
                                <div class="col-12">
                                    <label class="form-label" for="modalEditUserName">Name</label>
                                    <input type="text" id="modalEditUserName" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$user->name}}" placeholder="example" /> @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="modalEditUserName">Email</label>
                                    <input type="text" id="modalEditUserName" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}" placeholder="exmaple@gmail.com" /> @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="modalEditUserName">New Password</label>
                                    <input type="text" id="modalEditUserName" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="........" /> @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 text-center mt-2 pt-50">
                                    <input type="submit" value="Update" class="btn btn-primary me-1">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
@endsection