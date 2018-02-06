<?php
/*---------- 公产单位 ----------*/
Route::get('/adminunit','AdminunitController@index')->name('g_adminunit');
Route::any('/adminunit_add','AdminunitController@add')->name('g_adminunit_add');
Route::get('/adminunit_info','AdminunitController@info')->name('g_adminunit_info');
Route::any('/adminunit_edit','AdminunitController@edit')->name('g_adminunit_edit');
/*---------- 银行 ----------*/
Route::get('/bank','BankController@index')->name('g_bank');
Route::any('/bank_add','BankController@add')->name('g_bank_add');
Route::get('/bank_info','BankController@info')->name('g_bank_info');
Route::any('/bank_edit','BankController@edit')->name('g_bank_edit');
/*---------- 建筑结构类型 ----------*/
Route::get('/buildingstruct','BuildingstructController@index')->name('g_buildingstruct');
Route::any('/buildingstruct_add','BuildingstructController@add')->name('g_buildingstruct_add');
Route::get('/buildingstruct_info','BuildingstructController@info')->name('g_buildingstruct_info');
Route::any('/buildingstruct_edit','BuildingstructController@edit')->name('g_buildingstruct_edit');
/*---------- 建筑用途 ----------*/
Route::get('/buildinguse','BuildinguseController@index')->name('g_buildinguse');
Route::any('/buildinguse_add','BuildinguseController@add')->name('g_buildinguse_add');
Route::get('/buildinguse_info','BuildinguseController@info')->name('g_buildinguse_info');
Route::any('/buildinguse_edit','BuildinguseController@edit')->name('g_buildinguse_edit');
/*---------- 评估机构 ----------*/
Route::get('/company','CompanyController@index')->name('g_company');
Route::any('/company_add','CompanyController@add')->name('g_company_add');
Route::get('/company_info','CompanyController@info')->name('g_company_info');
Route::any('/company_edit','CompanyController@edit')->name('g_company_edit');
/*---------- 评估机构(操作员) ----------*/
Route::get('/companyuser','CompanyuserController@index')->name('g_companyuser');
Route::any('/companyuser_add','CompanyuserController@add')->name('g_companyuser_add');
Route::get('/companyuser_info','CompanyuserController@info')->name('g_companyuser_info');
Route::any('/companyuser_edit','CompanyuserController@edit')->name('g_companyuser_edit');
/*---------- 评估机构(评估师) ----------*/
Route::get('/companyvaluer','CompanyvaluerController@index')->name('g_companyvaluer');
Route::any('/companyvaluer_add','CompanyvaluerController@add')->name('g_companyvaluer_add');
Route::get('/companyvaluer_info','CompanyvaluerController@info')->name('g_companyvaluer_info');
Route::any('/companyvaluer_edit','CompanyvaluerController@edit')->name('g_companyvaluer_edit');
/*---------- 特殊人群 ----------*/
Route::get('/crowd','CrowdController@index')->name('g_crowd');
Route::any('/crowd_add','CrowdController@add')->name('g_crowd_add');
Route::get('/crowd_info','CrowdController@info')->name('g_crowd_info');
Route::any('/crowd_edit','CrowdController@edit')->name('g_crowd_edit');
/*---------- 必备附件分类 ----------*/
Route::get('/filecate','FilecateController@index')->name('g_filecate');
Route::get('/filecate_info','FilecateController@info')->name('g_filecate_info');
/*---------- 房屋户型 ----------*/
Route::get('/layout','LayoutController@index')->name('g_layout');
Route::any('/layout_add','LayoutController@add')->name('g_layout_add');
Route::get('/layout_info','LayoutController@info')->name('g_layout_info');
Route::any('/layout_edit','LayoutController@edit')->name('g_layout_edit');
/*---------- 民族 ----------*/
Route::get('/nation','NationController@index')->name('g_nation');
Route::any('/nation_add','NationController@add')->name('g_nation_add');
Route::get('/nation_info','NationController@info')->name('g_nation_info');
Route::any('/nation_edit','NationController@edit')->name('g_nation_edit');