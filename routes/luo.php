<?php
/*---------- 权限与角色 ----------*/
Route::get('/role','RoleController@index')->name('g_role');
Route::any('/role_add','RoleController@add')->name('g_role_add');
Route::get('/role_info','RoleController@info')->name('g_role_info');
Route::any('/role_edit','RoleController@edit')->name('g_role_edit');

/*---------- 功能与菜单 ----------*/
Route::get('/menu','MenuController@index')->name('g_menu');
Route::any('/menu_role','MenuController@role')->name('g_menu_role');