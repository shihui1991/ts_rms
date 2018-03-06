<?php
/*---------- 项目进度与流程 ----------*/
Route::any('/itemprocess','ItemprocessController@index')->name('g_itemprocess'); //项目进度与流程
Route::any('/itemprocess_c2dc','ItemprocessController@check_to_dept_check')->name('g_itemprocess_c2dc'); //项目审查 -  提交部门审查
Route::any('/itemprocess_cdc','ItemprocessController@check_dept_check')->name('g_itemprocess_cdc'); //项目审查 -  部门审查
Route::any('/itemprocess_crb','ItemprocessController@check_roll_back')->name('g_itemprocess_crb'); //项目审查 -  审查驳回处理
Route::any('/itemprocess_retry','ItemprocessController@check_iteminfo_retry')->name('g_itemprocess_retry'); //项目审查 -  重新提交审查资料
Route::any('/itemprocess_stop','ItemprocessController@check_item_stop')->name('g_itemprocess_stop'); //项目审查 -  不予受理
Route::any('/itemprocess_c2gc','ItemprocessController@check_to_gov_check')->name('g_itemprocess_c2gc'); //项目审查 -  提交区政府审查
Route::any('/itemprocess_cgc','ItemprocessController@check_gov_check')->name('g_itemprocess_cgc'); //项目审查 -  提交区政府审查
Route::any('/itemprocess_css','ItemprocessController@check_start_set')->name('g_itemprocess_css'); //项目审查 -  开启项目启动配置
Route::any('/itemprocess_csia','ItemprocessController@check_set_itemadmin')->name('g_itemprocess_csia'); //项目审查 -  配置项目负责人
Route::any('/itemprocess_csiu','ItemprocessController@check_set_itemuser')->name('g_itemprocess_csiu'); //项目审查 -  配置项目人员
Route::any('/itemprocess_csit','ItemprocessController@check_set_itemtime')->name('g_itemprocess_csit'); //项目审查 -  配置项目时间规划
Route::any('/itemprocess_cs2c','ItemprocessController@check_set_to_check')->name('g_itemprocess_cs2c'); //项目审查 -  项目配置提交审查
Route::any('/itemprocess_csc','ItemprocessController@check_set_check')->name('g_itemprocess_csc'); //项目审查 -  项目配置审查
Route::any('/itemprocess_cis','ItemprocessController@check_item_start')->name('g_itemprocess_cis'); //项目审查 -  项目启动


/*---------- 初步预算 ----------*/
Route::any('/initbudget','InitbudgetController@index')->name('g_initbudget'); //初步预算
Route::any('/initbudget_add','InitbudgetController@add')->name('g_initbudget_add'); //添加初步预算
Route::any('/initbudget_edit','InitbudgetController@edit')->name('g_initbudget_edit'); //修改初步预算


/*---------- 资金管理 ----------*/
Route::any('/funds','FundsController@index')->name('g_funds'); //项目资金
Route::any('/funds_add','FundsController@add')->name('g_funds_add'); //录入资金
Route::any('/funds_info','FundsController@info')->name('g_funds_info'); //转账详情

/*---------- 通知公告 ----------*/
Route::any('/news','NewsController@index')->name('g_news'); //政务公告
Route::any('/news_add','NewsController@add')->name('g_news_add'); //添加公告
Route::any('/news_info','NewsController@info')->name('g_news_info'); //公告详情
Route::any('/news_edit','NewsController@edit')->name('g_news_edit'); //修改公告

/*---------- 评估机构投票 ----------*/
Route::any('/companyvote','CompanyvoteController@index')->name('g_companyvote'); //评估机构投票
Route::any('/companyvote_info','CompanyvoteController@info')->name('g_companyvote_info'); //评估机构投票详情

/*---------- 兑付 ----------*/
Route::any('/pay','PayController@index')->name('g_pay'); //兑付
Route::any('/pay_add','PayController@add')->name('g_pay_add'); //生成兑付
Route::any('/pay_info','PayController@info')->name('g_pay_info'); //兑付详情
Route::any('/pay_edit','PayController@edit')->name('g_pay_edit'); //修改兑付

Route::any('/paysubject_add','PaysubjectController@add')->name('g_paysubject_add'); //添加补偿科目
Route::any('/paysubject_edit','PaysubjectController@edit')->name('g_paysubject_edit'); //修改补偿科目

/*---------- 操作控制 ----------*/
Route::any('/itemctrl','ItemctrlController@index')->name('g_itemctrl'); //操作控制
Route::any('/itemctrl_add','ItemctrlController@add')->name('g_itemctrl_add'); //添加操作
Route::any('/itemctrl_edit','ItemctrlController@edit')->name('g_itemctrl_edit'); //修改操作