<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('gov')->prefix('gov')->group(function (){
    /*----- 组织与部门 -----*/
    Route::any('dept','DeptController@index')->name('gov_dept');
    Route::any('dept_all','DeptController@all')->name('gov_dept_all');
    Route::any('dept_add','DeptController@add')->name('gov_dept_add');
    Route::any('dept_info','DeptController@info')->name('gov_dept_info');
    Route::any('dept_edit','DeptController@edit')->name('gov_dept_edit');
    Route::any('dept_delete','DeptController@delete')->name('gov_dept_delete');
    Route::any('dept_restore','DeptController@restore')->name('gov_dept_restore');
    Route::any('dept_destroy','DeptController@destroy')->name('gov_dept_destroy');
    /*----- 权限与角色 -----*/
    Route::any('role','RoleController@index')->name('gov_role');
    Route::any('role_all','RoleController@all')->name('gov_role_all');
    Route::any('role_add','RoleController@add')->name('gov_role_add');
    Route::any('role_info','RoleController@info')->name('gov_role_info');
    Route::any('role_edit','RoleController@edit')->name('gov_role_edit');
    Route::any('role_delete','RoleController@delete')->name('gov_role_delete');
    Route::any('role_restore','RoleController@restore')->name('gov_role_restore');
    Route::any('role_destroy','RoleController@destroy')->name('gov_role_destroy');
    /*----- 用户 -----*/
    Route::any('user','UserController@index')->name('gov_user');
    Route::any('user_all','UserController@all')->name('gov_user_all');
    Route::any('user_add','UserController@add')->name('gov_user_add');
    Route::any('user_info','UserController@info')->name('gov_user_info');
    Route::any('user_edit','UserController@edit')->name('gov_user_edit');
    Route::any('user_delete','UserController@delete')->name('gov_user_delete');
    Route::any('user_restore','UserController@restore')->name('gov_user_restore');
    Route::any('user_destroy','UserController@destroy')->name('gov_user_destroy');
});
