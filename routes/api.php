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
    Route::any('select_deptname','DeptController@select_deptname')->name('gov_select_deptname');
    Route::any('dept_add','DeptController@add')->name('gov_dept_add');
    Route::any('dept_info','DeptController@info')->name('gov_dept_info');
    Route::any('dept_edit','DeptController@edit')->name('gov_dept_edit');
    Route::any('dept_delete','DeptController@delete')->name('gov_dept_delete');
    Route::any('dept_restore','DeptController@restore')->name('gov_dept_restore');
    Route::any('dept_destroy','DeptController@destroy')->name('gov_dept_destroy');
    /*----- 权限与角色 -----*/
    Route::any('role','RoleController@index')->name('gov_role');
    Route::any('role_all','RoleController@all')->name('gov_role_all');
    Route::any('role_select_parent','RoleController@select_parent')->name('gov_role_select_parent');
    Route::any('role_add','RoleController@add')->name('gov_role_add');
    Route::any('role_info','RoleController@info')->name('gov_role_info');
    Route::any('role_edit','RoleController@edit')->name('gov_role_edit');
    Route::any('role_delete','RoleController@delete')->name('gov_role_delete');
    Route::any('role_restore','RoleController@restore')->name('gov_role_restore');
    Route::any('role_destroy','RoleController@destroy')->name('gov_role_destroy');
    /*----- 用户 -----*/
    Route::any('user','UserController@index')->name('gov_user');
    Route::any('user_add','UserController@add')->name('gov_user_add');
    Route::any('user_info','UserController@info')->name('gov_user_info');
    Route::any('user_edit','UserController@edit')->name('gov_user_edit');
    Route::any('edit_password','UserController@edit_password')->name('gov_edit_password');
    Route::any('user_delete','UserController@delete')->name('gov_user_delete');
    Route::any('user_restore','UserController@restore')->name('gov_user_restore');
    Route::any('user_destroy','UserController@destroy')->name('gov_user_destroy');
    /*----- 银行 -----*/
    Route::any('bank','BankController@index')->name('gov_bank');
    Route::any('bank_add','BankController@add')->name('gov_bank_add');
    Route::any('bank_info','BankController@info')->name('gov_bank_info');
    Route::any('bank_edit','BankController@edit')->name('gov_bank_edit');
    /*----- 建筑结构类型 -----*/
    Route::any('buildingstruct','BuildingstructController@index')->name('gov_buildingstruct');
    Route::any('buildingstruct_add','BuildingstructController@add')->name('gov_buildingstruct_add');
    Route::any('buildingstruct_info','BuildingstructController@info')->name('gov_buildingstruct_info');
    Route::any('buildingstruct_edit','BuildingstructController@edit')->name('gov_buildingstruct_edit');
    /*----- 建筑用途 -----*/
    Route::any('buildinguse','BuildinguseController@index')->name('gov_buildinguse');
    Route::any('buildinguse_add','BuildinguseController@add')->name('gov_buildinguse_add');
    Route::any('buildinguse_info','BuildinguseController@info')->name('gov_buildinguse_info');
    Route::any('buildinguse_edit','BuildinguseController@edit')->name('gov_buildinguse_edit');
    /*----- 特殊人群 -----*/
    Route::any('crowdcate','CrowdController@index')->name('gov_crowdcate');
    Route::any('crowd','CrowdController@index_childs')->name('gov_crowd');
    Route::any('crowdcate_add','CrowdController@add')->name('gov_crowdcate_add');
    Route::any('crowd_add','CrowdController@add_childs')->name('gov_crowd_add');
    Route::any('crowdcate_info','CrowdController@info')->name('gov_crowdcate_info');
    Route::any('crowd_info','CrowdController@info_childs')->name('gov_crowd_info');
    Route::any('crowdcate_edit','CrowdController@edit')->name('gov_crowdcate_edit');
    Route::any('crowd_edit','CrowdController@edit_childs')->name('gov_crowd_edit');
    /*----- 房屋户型 -----*/
    Route::any('layout','LayoutController@index')->name('gov_layout');
    Route::any('layout_add','LayoutController@add')->name('gov_layout_add');
    Route::any('layout_info','LayoutController@info')->name('gov_layout_info');
    Route::any('layout_edit','LayoutController@edit')->name('gov_layout_edit');
    /*----- 民族 -----*/
    Route::any('nation','NationController@index')->name('gov_nation');
    Route::any('nation_add','NationController@add')->name('gov_nation_add');
    Route::any('nation_info','NationController@info')->name('gov_nation_info');
    Route::any('nation_edit','NationController@edit')->name('gov_nation_edit');
    /*----- 房源社区 -----*/
    Route::any('housecommunity','HousecommunityController@index')->name('gov_housecommunity');
    Route::any('housecommunity_add','HousecommunityController@add')->name('gov_housecommunity_add');
    Route::any('housecommunity_info','HousecommunityController@info')->name('gov_housecommunity_info');
    Route::any('housecommunity_edit','HousecommunityController@edit')->name('gov_housecommunity_edit');
});
