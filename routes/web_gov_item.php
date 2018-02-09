<?php
/*
|--------------------------------------------------------------------------
| 征收管理端 限制项目路由
|--------------------------------------------------------------------------
*/
/*---------- 项目配置 ----------*/
// 项目信息
Route::get('/iteminfo','IteminfoController@index')->name('g_iteminfo');  // 项目概述
Route::get('/iteminfo_info','IteminfoController@info')->name('g_iteminfo_info');  // 项目信息
Route::any('/iteminfo_edit','IteminfoController@edit')->name('g_iteminfo_edit');  // 修改项目
// 时间规划
Route::any('/itemtime','ItemtimeController@index')->name('g_itemtime');  // 时间规划
Route::any('/itemtime_edit','ItemtimeController@edit')->name('g_itemtime_edit');  // 修改时间规划
// 项目人员
Route::any('/itemuser','ItemuserController@index')->name('g_itemuser');  // 项目人员
Route::any('/itemuser_add','ItemuserController@add')->name('g_itemuser_add');  // 配置项目人员
Route::any('/itemuser_edit','ItemuserController@edit')->name('g_itemuser_edit');  // 调整项目人员
Route::any('/itemuser_del','ItemuserController@del')->name('g_itemuser_del');  // 删除项目人员
//项目负责人
Route::any('/itemadmin','ItemadminController@index')->name('g_itemadmin');  // 项目负责人
Route::any('/itemadmin_add','ItemadminController@add')->name('g_itemadmin_add');  // 添加项目负责人
Route::any('/itemadmin_del','ItemadminController@del')->name('g_itemadmin_del');  // 删除项目负责人