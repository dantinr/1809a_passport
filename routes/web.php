<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//TEST
Route::get('/test/redis','Test\TestController@testRedis'); //用户登录


//用户登录

Route::get('/user/login','User\LoginController@loginIndex'); //用户登录
Route::post('/login','User\LoginController@login');          //用户登录


//API
Route::post('/api/user/reg','Api\LoginController@reg'); //用户注册
Route::get('/api/user/login','Api\LoginController@login'); //用户登录




