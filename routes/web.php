<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('login', 'AppController@login')->middleware('guest');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('forgot-password', 'AppController@forgotPassword')->middleware('guest');
Route::get('reset-password/{token}/{email}', 'AppController@resetPassword')->name('password.reset');

Route::get('register-by-token/{token}', 'AppController@registerByToken');

Route::group(['prefix' => 'api'], function() {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('validate-token', 'Auth\RegisterController@validateToken');
    Route::get('validate-login', 'Auth\RegisterController@validateLogin');
    Route::post('send-reset-link', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('reset-password', 'Auth\ResetPasswordController@reset');

    Route::get('me', 'Auth\LoginController@me');
});

Route::get('{path}', 'AppController@index')->where('path', '(.*)');
