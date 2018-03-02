<?php
/*
|--------------------------------------------------------------------------
| 征收管理端 限制登录路由
|--------------------------------------------------------------------------
*/
/*---------- 首页 ----------*/
Route::any('/home','HomeController@index')->name('h_home');


/*---------- 项目 ----------*/
Route::any('/itemrisk_info','ItemriskController@info')->name('h_itemrisk_info');
Route::any('/itemrisk_add','ItemriskController@add')->name('h_itemrisk_add');
Route::any('/itemrisk_edit','ItemriskController@edit')->name('h_itemrisk_edit');
