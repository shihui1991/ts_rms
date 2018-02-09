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
    /*---------- 首页 ----------*/
    Route::any('/home','HomeController@index')->name('g_home');
    /*---------- 组织与部门 ----------*/
    Route::get('/dept','DeptController@index')->name('g_dept');
    Route::any('/dept_add','DeptController@add')->name('g_dept_add');
    Route::get('/dept_info','DeptController@info')->name('g_dept_info');
    Route::any('/dept_edit','DeptController@edit')->name('g_dept_edit');
    require 'zhang.php';

    require 'luo.php';
});


Route::namespace('system')->prefix('sys')->group(function (){
    /*---------- 登录后台 ----------*/
    Route::any('/','IndexController@index')->name('sys_index'); //登录页
    Route::any('/login','IndexController@login')->name('sys_login'); //登录
    Route::any('/logout','IndexController@logout')->name('sys_logout'); //退出
    /*---------- 首页 ----------*/
    Route::any('/home','HomeController@index')->name('sys_home');
    /*----- 功能与菜单 -----*/
    Route::any('/menu','MenuController@index')->name('sys_menu'); //树形列表
    Route::any('/menu_add','MenuController@add')->name('sys_menu_add'); //添加菜单
    Route::any('/menu_info','MenuController@info')->name('sys_menu_info'); //菜单详情
    Route::any('/menu_edit','MenuController@edit')->name('sys_menu_edit'); //修改菜单

    /*----- 项目进度 -----*/
    Route::any('/schedule','ScheduleController@index')->name('sys_schedule'); //项目进度及流程
    Route::any('/schedule_add','ScheduleController@add')->name('sys_schedule_add'); //添加进度
    Route::any('/schedule_edit','ScheduleController@edit')->name('sys_schedule_edit'); //修改进度

    /*----- 项目流程 -----*/
    Route::any('/process','ProcessController@index')->name('sys_process'); //项目流程
    Route::any('/process_add','ProcessController@add')->name('sys_process_add'); // 添加流程
    Route::any('/process_edit','ProcessController@edit')->name('sys_process_edit'); // 修改流程

    /*----- 控制类型 -----*/
    Route::any('/ctrlcate','CtrlcateController@index')->name('sys_ctrlcate'); //控制类型
    Route::any('/ctrlcate_add','CtrlcateController@add')->name('sys_ctrlcate_add'); // 添加控制类型
    Route::any('/ctrlcate_edit','CtrlcateController@edit')->name('sys_ctrlcate_edit'); // 修改控制类型
    
    /*----- 必备附件分类-数据表 -----*/
    Route::any('/filetable','FiletableController@index')->name('sys_filetable'); //必备附件分类-数据表
    Route::any('/filetable_add','FiletableController@add')->name('sys_filetable_add'); // 添加分类数据表
    Route::any('/filetable_edit','FiletableController@edit')->name('sys_filetable_edit'); // 修改分类数据表

    /*----- 项目资金进出类型 -----*/
    Route::any('/fundscate','FundscateController@index')->name('sys_fundscate');
    Route::any('/fundscate_add','FundscateController@add')->name('sys_fundscate_add');
    Route::any('/fundscate_edit','FundscateController@edit')->name('sys_fundscate_edit');

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
