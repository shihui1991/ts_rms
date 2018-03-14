<?php
/*---------- 项目进度与流程 ----------*/
Route::any('/itemprocess','ItemprocessController@index')->name('g_itemprocess'); //项目进度与流程
Route::any('/check_to_dept_check','ItemprocessController@check_to_dept_check')->name('g_check_to_dept_check'); //项目审查 -  提交部门审查
Route::any('/check_dept_check','ItemprocessController@check_dept_check')->name('g_check_dept_check'); //项目审查 -  部门审查
Route::any('/check_roll_back','ItemprocessController@check_roll_back')->name('g_check_roll_back'); //项目审查 -  审查驳回处理
Route::any('/check_iteminfo_retry','ItemprocessController@check_iteminfo_retry')->name('g_check_iteminfo_retry'); //项目审查 -  重新提交审查资料
Route::any('/check_item_stop','ItemprocessController@check_item_stop')->name('g_check_item_stop'); //项目审查 -  不予受理
Route::any('/check_to_gov_check','ItemprocessController@check_to_gov_check')->name('g_check_to_gov_check'); //项目审查 -  提交区政府审查
Route::any('/check_gov_check','ItemprocessController@check_gov_check')->name('g_check_gov_check'); //项目审查 -  提交区政府审查
Route::any('/check_start_set','ItemprocessController@check_start_set')->name('g_check_start_set'); //项目审查 -  开启项目启动配置
Route::any('/check_set_itemadmin','ItemprocessController@check_set_itemadmin')->name('g_check_set_itemadmin'); //项目审查 -  配置项目负责人
Route::any('/check_set_itemuser','ItemprocessController@check_set_itemuser')->name('g_check_set_itemuser'); //项目审查 -  配置项目人员
Route::any('/check_set_itemtime','ItemprocessController@check_set_itemtime')->name('g_check_set_itemtime'); //项目审查 -  配置项目时间规划
Route::any('/check_set_to_check','ItemprocessController@check_set_to_check')->name('g_check_set_to_check'); //项目审查 -  项目配置提交审查
Route::any('/check_set_check','ItemprocessController@check_set_check')->name('g_check_set_check'); //项目审查 -  项目配置审查
Route::any('/check_item_start','ItemprocessController@check_item_start')->name('g_check_item_start'); //项目审查 -  项目启动

Route::any('/ready_init_check','ItemprocessController@ready_init_check')->name('g_ready_init_check'); //项目准备 -  初步预算审查
Route::any('/ready_prepare','ItemprocessController@ready_prepare')->name('g_ready_prepare'); //项目准备 -  开启项目筹备


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
Route::any('/pay_add','PayController@add')->name('g_pay_add'); //补偿决定
Route::any('/pay_info','PayController@info')->name('g_pay_info'); //兑付详情
Route::any('/pay_edit','PayController@edit')->name('g_pay_edit'); //修改兑付

Route::any('/paysubject_add','PaysubjectController@add')->name('g_paysubject_add'); //添加补偿科目
Route::any('/paysubject_info','PaysubjectController@info')->name('g_paysubject_info'); //补偿科目详情
Route::any('/paysubject_edit','PaysubjectController@edit')->name('g_paysubject_edit'); //修改补偿科目
Route::any('/paysubject_recal','PaysubjectController@recal')->name('g_paysubject_recal'); //重新计算补偿

/*---------- 操作控制 ----------*/
Route::any('/itemctrl','ItemctrlController@index')->name('g_itemctrl'); //操作控制
Route::any('/itemctrl_add','ItemctrlController@add')->name('g_itemctrl_add'); //添加操作
Route::any('/itemctrl_edit','ItemctrlController@edit')->name('g_itemctrl_edit'); //修改操作

/*---------- 选房 ----------*/
Route::any('/payhouse_add','PayhouseController@add')->name('g_payhouse_add'); //开始选房
Route::any('/payhouse_cal','PayhouseController@calculate')->name('g_payhouse_cal'); //选房计算

Route::any('/pact','PactController@index')->name('g_pact'); //协议