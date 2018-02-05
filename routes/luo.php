<?php
/*---------- 权限与角色 ----------*/
Route::get('/role','RoleController@index')->name('g_role');
Route::any('/role_add','RoleController@add')->name('g_role_add');
Route::get('/role_info','RoleController@info')->name('g_role_info');
Route::any('/role_edit','RoleController@edit')->name('g_role_edit');

/*---------- 功能与菜单 ----------*/
Route::get('/menu','MenuController@index')->name('g_menu');
Route::any('/menu_role','MenuController@role')->name('g_menu_role');

/*---------- 人员管理 ----------*/
Route::get('/user','UserController@index')->name('g_user');
Route::any('/user_add','UserController@add')->name('g_user_add');
Route::get('/user_info','UserController@info')->name('g_user_info');
Route::any('/user_edit','UserController@edit')->name('g_user_edit');
Route::any('/user_resetpwd','UserController@resetpwd')->name('g_user_resetpwd');