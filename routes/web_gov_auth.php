<?php
/*
|--------------------------------------------------------------------------
| 征收管理端 限制权限路由
|--------------------------------------------------------------------------
*/
/*---------- 组织与部门 ----------*/
Route::get('/dept','DeptController@index')->name('g_dept');
Route::any('/dept_add','DeptController@add')->name('g_dept_add');
Route::get('/dept_info','DeptController@info')->name('g_dept_info');
Route::any('/dept_edit','DeptController@edit')->name('g_dept_edit');

/*---------- 权限与角色 ----------*/
Route::get('/role','RoleController@index')->name('g_role'); // 角色列表（树形）
Route::any('/role_add','RoleController@add')->name('g_role_add'); // 添加角色
Route::get('/role_info','RoleController@info')->name('g_role_info'); // 角色详情
Route::any('/role_edit','RoleController@edit')->name('g_role_edit'); // 修改角色

/*---------- 功能与菜单 ----------*/
Route::get('/menu','MenuController@index')->name('g_menu'); // 所有功能（树形）
Route::any('/menu_role','MenuController@role')->name('g_menu_role'); // 授权角色

/*---------- 人员管理 ----------*/
Route::get('/user','UserController@index')->name('g_user'); // 人员列表
Route::any('/user_add','UserController@add')->name('g_user_add'); // 添加人员
Route::get('/user_info','UserController@info')->name('g_user_info'); // 人员详情
Route::any('/user_edit','UserController@edit')->name('g_user_edit'); // 人员调整
Route::any('/user_resetpwd','UserController@resetpwd')->name('g_user_resetpwd'); // 重置密码

/*---------- 项目管理 ----------*/
Route::get('/item','ItemController@index')->name('g_item');  // 我的项目
Route::get('/item_all','ItemController@all')->name('g_item_all'); // 所有项目
Route::any('/item_add','ItemController@add')->name('g_item_add'); // 新建项目

