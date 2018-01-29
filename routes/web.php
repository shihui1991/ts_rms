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
Route::any('/', function () {
    return view('index');
});

Route::namespace('system')->prefix('system')->group(function (){
    /*---------- 登陆后台 ----------*/
    Route::any('index','IndexController@index')->name('sys_index');
    Route::any('login','IndexController@login')->name('sys_login');
    /*---------- 控制台 ----------*/
    Route::any('home','HomeController@index')->name('sys_home');
    /*----- 功能与菜单 -----*/
    Route::any('menu','MenuController@index')->name('sys_menu');
    Route::any('menu_all','MenuController@all')->name('sys_menu_all');
    Route::any('menu_add','MenuController@add')->name('sys_menu_add');
    Route::any('menu_info','MenuController@info')->name('sys_menu_info');
    Route::any('menu_edit','MenuController@edit')->name('sys_menu_edit');
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
});
