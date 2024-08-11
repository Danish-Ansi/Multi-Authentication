<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'account'],function(){

    Route::group(['middleware'=>'guest'],function(){
        Route::get('login',[LoginController::class,'index'])->name('account.login');
        Route::post('authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
        Route::get('register',[LoginController::class,'register'])->name('account.register');
        Route::post('process-register',[LoginController::class,'processRegister'])->name('account.processRegister');

    });
    
    Route::group(['middleware'=>'auth'],function(){
        Route::get('logout',[AdminLoginController::class,'logout'])->name('account.logout');
        Route::get('dashboard',[DashboardController::class,'dashboard'])->name('account.dashboard');

    });
});

Route::group(['prefix'=>'admin'],function(){

    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');

    });
    
    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('logout',[AdminLoginController::class,'logout'])->name('admin.logout');
        Route::get('dashboard',[AdminDashboardController::class,'dashboard'])->name('admin.dashboard');

    });
});