<?php
/*---------- 权限与角色 ----------*/
Route::get('/role','RoleController@index')->name('g_role');
Route::any('/role_add','RoleController@add')->name('g_role_add');
Route::get('/role_info','RoleController@info')->name('g_role_info');
Route::any('/role_edit','RoleController@edit')->name('g_role_edit');