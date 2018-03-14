<?php
/*
|--------------------------------------------------------------------------
| 评估机构端 限制登录路由
|--------------------------------------------------------------------------
*/
/*============================================ 【首页】 ================================================*/
Route::any('/home','HomeController@index')->name('c_home');
/*============================================ 【简介】 ================================================*/
Route::any('/company_info','CompanyController@info')->name('c_company_info');
Route::any('/company_edit','CompanyController@edit')->name('c_company_edit');
/*============================================ 【项目】 ================================================*/
/*---------- 项目 ----------*/
Route::get('/item','ItemController@index')->name('c_item');
/*---------- 项目-地块 ----------*/
Route::any('/itemland','ItemlandController@index')->name('c_itemland');
Route::any('/itemland_add','ItemlandController@add')->name('c_itemland_add');
Route::get('/itemland_info','ItemlandController@info')->name('c_itemland_info');
Route::any('/itemland_edit','ItemlandController@edit')->name('c_itemland_edit');
/*---------- 项目-地块楼栋 ----------*/
Route::any('/itembuilding','ItembuildingController@index')->name('c_itembuilding');
Route::any('/itembuilding_add','ItembuildingController@add')->name('c_itembuilding_add');
Route::get('/itembuilding_info','ItembuildingController@info')->name('c_itembuilding_info');
Route::any('/itembuilding_edit','ItembuildingController@edit')->name('c_itembuilding_edit');
/*---------- 项目-公共附属物 ----------*/
Route::any('/itempublic','ItempublicController@index')->name('c_itempublic');
Route::any('/itempublic_add','ItempublicController@add')->name('c_itempublic_add');
Route::get('/itempublic_info','ItempublicController@info')->name('c_itempublic_info');
Route::any('/itempublic_edit','ItempublicController@edit')->name('c_itempublic_edit');
/*---------- 项目-地块户型 ----------*/
Route::any('/landlayout','LandlayoutController@index')->name('c_landlayout');
Route::any('/landlayout_add','LandlayoutController@add')->name('c_landlayout_add');
Route::get('/landlayout_info','LandlayoutController@info')->name('c_landlayout_info');
Route::any('/landlayout_edit','LandlayoutController@edit')->name('c_landlayout_edit');
/*---------- 入户摸底【评估】 ----------*/
Route::get('/household','HouseholdController@index')->name('c_household');
Route::get('/household_info','HouseholdController@info')->name('c_household_info');
Route::any('/household_add','HouseholdController@add')->name('c_household_add');
Route::any('/household_edit','HouseholdController@edit')->name('c_household_edit');
/*---------- 评估【公共附属物】 ----------*/
Route::get('/compublic','CompublicController@index')->name('c_compublic');
Route::any('/compublic_add','CompublicController@add')->name('c_compublic_add');
Route::any('/compublic_edit','CompublicController@edit')->name('c_compublic_edit');
/*============================================ 【管理】 ================================================*/
/*---------- 操作员 ----------*/
Route::get('/companyuser','CompanyuserController@index')->name('c_companyuser');
Route::any('/companyuser_add','CompanyuserController@add')->name('c_companyuser_add');
Route::any('/companyuser_info','CompanyuserController@info')->name('c_companyuser_info');
Route::any('/companyuser_edit','CompanyuserController@edit')->name('c_companyuser_edit');
/*---------- 评估师 ----------*/
Route::get('/companyvaluer','CompanyvaluerController@index')->name('c_companyvaluer');
Route::any('/companyvaluer_add','CompanyvaluerController@add')->name('c_companyvaluer_add');
Route::any('/companyvaluer_info','CompanyvaluerController@info')->name('c_companyvaluer_info');
Route::any('/companyvaluer_edit','CompanyvaluerController@edit')->name('c_companyvaluer_edit');
/*============================================ 【设置】 ================================================*/
/*---------- 个人中心 ----------*/
Route::get('/userself','UserselfController@index')->name('c_userself'); // 个人信息
Route::any('/userself_edit','UserselfController@edit')->name('c_userself_edit'); // 修改信息
Route::any('/userself_pwd','UserselfController@password')->name('c_userself_pwd'); // 修改密码