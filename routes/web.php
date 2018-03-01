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
Route::any('/', function () {
    return view('welcome');
});


/*========== 征收管理端 ==========*/
Route::namespace('gov')->prefix('gov')->group(function (){
    /*---------- 登录 ----------*/
    Route::get('/','IndexController@index')->name('g_index');
    Route::post('/login','IndexController@login')->name('g_login');
    Route::get('/logout','IndexController@logout')->name('g_logout');

    Route::middleware('CheckLogin:gov_user,g_index')->group(function (){
        /*---------- 工具 ----------*/
        Route::any('/error','ToolsController@error')->name('g_error'); // 错误提示
        Route::any('/upl','ToolsController@upl')->name('g_upl'); // 文件上传
        Route::any('/noticenum','ToolsController@noticenum')->name('g_noticenum'); // 工作提醒数量
    });

    Route::middleware('CheckLogin:gov_user,g_index','CheckAuth')->group(function (){
        require 'web_gov_login.php';

        require 'web_gov_auth.php';

        require 'zhang.php';

        require 'luo.php';
        require 'jia.php';
    });

    Route::middleware('CheckLogin:gov_user,g_index','CheckAuth','CheckItem')->group(function (){
        require 'web_gov_item.php';
    });
});


/*========== 后台管理端 ==========*/
Route::namespace('system')->prefix('sys')->group(function (){
    /*---------- 登录后台 ----------*/
    Route::any('/','IndexController@index')->name('sys_index'); //登录页
    Route::any('/login','IndexController@login')->name('sys_login'); //登录
    Route::any('/logout','IndexController@logout')->name('sys_logout'); //退出

    Route::middleware('CheckLogin:sys_user,sys_index')->group(function (){
        require 'web_sys_login.php';
    });
});


/*========== 评估机构端 ==========*/
Route::namespace('com')->prefix('com')->group(function (){
    /*---------- 登录后台 ----------*/
    Route::any('/','IndexController@index')->name('c_index'); //登录页
    Route::any('/login','IndexController@login')->name('c_login'); //登录
    Route::any('/logout','IndexController@logout')->name('c_logout'); //退出

    Route::middleware('CheckLogin:com_user,c_index')->group(function (){
        require 'web_com_login.php';
    });
});
