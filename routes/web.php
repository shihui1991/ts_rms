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
    /*---------- 登陆 ----------*/
    Route::get('/','IndexController@index')->name('g_index');
    Route::post('/login','IndexController@login')->name('g_login');
    Route::get('/logout','IndexController@logout')->name('g_logout');
    /*---------- 首页 ----------*/
    Route::any('/home','HomeController@index')->name('g_home');
    /*---------- 组织与部门 ----------*/
    Route::get('/dept','DeptController@index')->name('g_dept');
    Route::any('/dept_add','DeptController@add')->name('g_dept_add');
    Route::get('/dept_info','DeptController@info')->name('g_dept_info');
    Route::post('/dept_edit','DeptController@edit')->name('g_dept_edit');
});


Route::namespace('system')->prefix('system')->group(function (){
    /*---------- 登陆后台 ----------*/
    Route::any('/','IndexController@index')->name('sys_index');
    Route::any('login','IndexController@login')->name('sys_login');
    Route::any('logout','IndexController@logout')->name('sys_logout');
    /*---------- 控制台 ----------*/
    Route::any('home','HomeController@index')->name('sys_home');
    /*----- 功能与菜单 -----*/
    Route::any('menu','MenuController@index')->name('sys_menu');
    Route::any('menu_all','MenuController@all')->name('sys_menu_all');
    Route::any('menu_add/{id?}','MenuController@add')->name('sys_menu_add');
    Route::any('menu_info/{id?}','MenuController@info')->name('sys_menu_info');
    Route::any('menu_edit/{id?}','MenuController@edit')->name('sys_menu_edit');
    Route::any('menu_sort','MenuController@sort')->name('sys_menu_sort');
    Route::any('menu_display','MenuController@display')->name('sys_menu_display');
    Route::any('menu_delete','MenuController@delete')->name('sys_menu_delete');
    Route::any('menu_restore','MenuController@restore')->name('sys_menu_restore');
    Route::any('menu_destroy','MenuController@destroy')->name('sys_menu_destroy');
    /*----- 项目进度 -----*/
    Route::any('schedule','ScheduleController@index')->name('sys_schedule');
    Route::any('schedule_add','ScheduleController@add')->name('sys_schedule_add');
    Route::any('schedule_info','ScheduleController@info')->name('sys_schedule_info');
    Route::any('schedule_edit','ScheduleController@edit')->name('sys_schedule_edit');
    Route::any('schedule_delete','ScheduleController@delete')->name('sys_schedule_delete');
    Route::any('schedule_restore','ScheduleController@restore')->name('sys_schedule_restore');
    Route::any('schedule_destroy','ScheduleController@destroy')->name('sys_schedule_destroy');
    /*----- 项目流程 -----*/
    Route::any('process','ProcessController@index')->name('sys_process');
    Route::any('process_add','ProcessController@add')->name('sys_process_add');
    Route::any('process_info','ProcessController@info')->name('sys_process_info');
    Route::any('process_edit','ProcessController@edit')->name('sys_process_edit');
    Route::any('process_delete','ProcessController@delete')->name('sys_process_delete');
    Route::any('process_restore','ProcessController@restore')->name('sys_process_restore');
    Route::any('process_destroy','ProcessController@destroy')->name('sys_process_destroy');
    /*----- 项目流程-功能菜单 -----*/
    Route::any('processmenu_info','ProcessmenuController@info')->name('sys_processmenu_info');
    Route::any('processmenu_edit','ProcessmenuController@edit')->name('sys_processmenu_edit');
    /*----- 必备附件分类 -----*/
    Route::any('filetable','FiletableController@index')->name('sys_filetable');
    /*----- 项目资金进出类型 -----*/
    Route::any('itemfundscate','ItemfundscateController@index')->name('sys_itemfundscate');
    Route::any('itemfundscate_add','ItemfundscateController@add')->name('sys_itemfundscate_add');
    Route::any('itemfundscate_info','ItemfundscateController@info')->name('sys_itemfundscate_info');
    Route::any('itemfundscate_edit','ItemfundscateController@edit')->name('sys_itemfundscate_edit');
    /*----- 项目通知分类 -----*/
    Route::any('itemnoticecate','ItemnoticecateController@index')->name('sys_itemnoticecate');
    Route::any('itemnoticecate_add','ItemnoticecateController@add')->name('sys_itemnoticecate_add');
    Route::any('itemnoticecate_info','ItemnoticecateController@info')->name('sys_itemnoticecate_info');
    Route::any('itemnoticecate_edit','ItemnoticecateController@edit')->name('sys_itemnoticecate_edit');
    /*----- 状态代码 -----*/
    Route::any('statecode','StatecodeController@index')->name('sys_statecode');
    /*----- 通知公告分类 -----*/
    Route::any('newscate','NewscateController@index')->name('sys_newscate');
    Route::any('newscate_add','NewscateController@add')->name('sys_newscate_add');
    Route::any('newscate_info','NewscateController@info')->name('sys_newscate_info');
    Route::any('newscate_edit','NewscateController@edit')->name('sys_newscate_edit');
    /*----- 重要补偿科目 -----*/
    Route::any('subject','SubjectController@index')->name('sys_subject');
    Route::any('subject_add','SubjectController@add')->name('sys_subject_add');
    Route::any('subject_info','SubjectController@info')->name('sys_subject_info');
    Route::any('subject_edit','SubjectController@edit')->name('sys_subject_edit');
});
