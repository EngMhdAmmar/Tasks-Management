<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)
    ->middleware(['guest'])
    ->group(function () {
        Route::get('/register',  'register')->name('register');
        Route::post('/signup',  'signup')->name('signup');
        Route::post('/checkVerificationCode/{preRoute}',  'checkVerificationCode')->name('checkVerificationCode')->withoutMiddleware(['guest'])->middleware(['updateProfile']);
        Route::get('/login',  'login')->name('login');
        Route::post('/signIn',  'signIn')->name('signIn')->middleware('isVerified');
        Route::get('/forgetPassword',  'forgetPassword')->name('forgetPassword');
        Route::post('/checkEmail',  'checkEmail')->name('checkEmail');
        Route::get('/resetPassword',  'resetPassword')->name('resetPassword');
        Route::post('/updatePassword',  'updatePassword')->name('updatePassword');
        Route::get('/verificationCode' ,'verificationCode')->name('verificationCode')->withoutMiddleware(['guest'])->middleware(['updateProfile']);
        Route::get('/profile',  'profile')->withoutMiddleware(['guest'])->name('profile.show');
        Route::post('/profile/update',  'profileUpdate')->withoutMiddleware(['guest'])->name('profile.update');
        Route::get('/logout',  'logout')->withoutMiddleware(['guest'])->name('logout');
    });
    
