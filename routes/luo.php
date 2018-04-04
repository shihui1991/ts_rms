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
Route::any('/ready_funds','ItemprocessController@ready_funds')->name('g_ready_funds'); //项目准备 -  项目资金
Route::any('/ready_house','ItemprocessController@ready_house')->name('g_ready_house'); //项目准备 -  项目房源
Route::any('/ready_prepare_check','ItemprocessController@ready_prepare_check')->name('g_ready_prepare_check'); //项目准备 -  项目筹备审查
Route::any('/ready_range_check','ItemprocessController@ready_range_check')->name('g_ready_range_check'); //项目准备 -  征收范围公告审查

Route::any('/survey','ItemprocessController@survey')->name('g_survey'); //调查建档 -  调查统计
Route::any('/survey_check','ItemprocessController@survey_check')->name('g_survey_check'); //调查建档 -  入户调查数据审查

Route::any('/draft_check','ItemprocessController@draft_check')->name('g_draft_check'); //征收决定 -  征收意见稿审查
Route::any('/draft_notice_add','NewsController@draft_notice_add')->name('g_draft_notice_add'); //征收决定 -  发布征收意见稿公告
Route::any('/draft_notice_edit','NewsController@draft_notice_edit')->name('g_draft_notice_edit'); //征收决定 -  修改征收意见稿公告
Route::any('/riskreport_check','ItemprocessController@riskreport_check')->name('g_riskreport_check'); //征收决定 -  风险评估报告审查
Route::any('/program_to_check','ItemprocessController@program_to_check')->name('g_program_to_check'); //征收决定 -  正式征收方案提交审查
Route::any('/program_check','ItemprocessController@program_check')->name('g_program_check'); //征收决定 -  正式征收方案审查
Route::any('/program_notice_add','NewsController@program_notice_add')->name('g_program_notice_add'); //征收决定 -  发布征收决定公告
Route::any('/program_notice_edit','NewsController@program_notice_edit')->name('g_program_notice_edit'); //征收决定 -  修改征收决定公告

Route::any('/pay_start','ItemprocessController@pay_start')->name('g_pay_start'); //项目实施 -  项目开始实施
Route::any('/pact_check','PactController@check')->name('g_pact_check'); //项目实施 -  协议审查
Route::any('/pay_end','ItemprocessController@pay_end')->name('g_pay_end'); //项目实施 -  项目实施完成

Route::any('/item_end','ItemprocessController@item_end')->name('g_item_end'); //项目审计 -  项目结束

/*---------- 初步预算 ----------*/
Route::any('/initbudget','InitbudgetController@index')->name('g_initbudget'); //初步预算
Route::any('/initbudget_add','InitbudgetController@add')->name('g_initbudget_add'); //添加初步预算
Route::any('/initbudget_edit','InitbudgetController@edit')->name('g_initbudget_edit'); //修改初步预算

/*---------- 产权调换房的签约奖励 ----------*/
Route::any('/itemreward','ItemrewardController@index')->name('g_itemreward'); //产权调换房的签约奖励
Route::any('/itemreward_add','ItemrewardController@add')->name('g_itemreward_add'); //产权调换房的签约奖励
Route::any('/itemreward_edit','ItemrewardController@edit')->name('g_itemreward_edit'); //产权调换房的签约奖励

/*---------- 资金管理 ----------*/
Route::any('/funds','FundsController@index')->name('g_funds'); //项目资金
Route::any('/funds_add','FundsController@add')->name('g_funds_add'); //录入资金
Route::any('/funds_info','FundsController@info')->name('g_funds_info'); //转账详情
Route::any('/funds_household','FundsController@household')->name('g_funds_household'); //被征收户
Route::any('/funds_household_info','FundsController@household_info')->name('g_funds_household_info'); //被征收户-补偿详情
Route::any('/funds_pay_total','FundsController@pay_total')->name('g_funds_pay_total'); //被征收户-生成支付总单
Route::any('/funds_pay_total_funds','FundsController@pay_total_funds')->name('g_funds_pay_total_funds'); //支付总单- 支付
Route::any('/funds_unit','FundsController@unit')->name('g_funds_unit'); //公房单位
Route::any('/funds_unit_info','FundsController@unit_info')->name('g_funds_unit_info'); //公房单位 - 补偿详情
Route::any('/funds_unit_total','FundsController@unit_total')->name('g_funds_unit_total'); //公房单位 - 支付总单
Route::any('/funds_out','FundsController@out')->name('g_funds_out'); //项目支出

/*---------- 通知公告 ----------*/
Route::any('/news','NewsController@index')->name('g_news'); //政务公告
Route::any('/news_add','NewsController@add')->name('g_news_add'); //添加范围公告
Route::any('/news_edit','NewsController@edit')->name('g_news_edit'); //修改范围公告
Route::any('/news_info','NewsController@info')->name('g_news_info'); //公告详情
Route::any('/assess_report_add','NewsController@assess_report_add')->name('g_assess_report_add'); //添加评估报告
Route::any('/assess_report_edit','NewsController@assess_report_edit')->name('g_assess_report_edit'); //添加评估报告
Route::any('/news_other_add','NewsController@other_add')->name('g_news_other_add'); //添加公告
Route::any('/news_other_edit','NewsController@other_edit')->name('g_news_other_edit'); //修改公告

/*---------- 评估机构投票 ----------*/
Route::any('/companyvote','CompanyvoteController@index')->name('g_companyvote'); //评估机构投票
Route::any('/companyvote_info','CompanyvoteController@info')->name('g_companyvote_info'); //评估机构投票详情

/*---------- 兑付 ----------*/
Route::any('/pay','PayController@index')->name('g_pay'); //兑付
Route::any('/pay_add','PayController@add')->name('g_pay_add'); //补偿决定
Route::any('/pay_info','PayController@info')->name('g_pay_info'); //兑付详情
Route::any('/pay_edit','PayController@edit')->name('g_pay_edit'); //修改兑付

Route::any('/payunit','PayunitController@index')->name('g_payunit'); //公房单位
Route::any('/payunit_info','PayunitController@info')->name('g_payunit_info'); //公房单位 - 补偿详情

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
Route::any('/pact_add','PactController@add')->name('g_pact_add'); //被征收户 - 生成补偿安置协议
Route::any('/pact_reset_pact','PactController@reset_pact')->name('g_pact_reset_pact'); //被征收户 - 补偿安置协议 - 重新生成
Route::any('/pact_info','PactController@info')->name('g_pact_info'); //协议详情

/*---------- 腾空搬迁 ----------*/
Route::any('/move','MoveController@index')->name('g_move'); //腾空搬迁
Route::any('/move_edit','MoveController@edit')->name('g_move_edit'); //腾空搬迁 - 已搬迁

/*---------- 监督拆除 ----------*/
Route::any('/tear','TearController@index')->name('g_tear'); //监督拆除
Route::any('/tear_add','TearController@add')->name('g_tear_add'); //拆除委托
Route::any('/tear_edit','TearController@edit')->name('g_tear_edit'); //修改委托
Route::any('/tear_detail_add','TearController@detail_add')->name('g_tear_detail_add'); //添加拆除记录

/*---------- 项目审查 ----------*/
Route::any('/audit','AuditController@index')->name('g_audit'); //审计报告
Route::any('/audit_add','AuditController@add')->name('g_audit_add'); //添加审计报告

/*---------- 安置 ----------*/
Route::any('/transit','TransitController@index')->name('g_transit'); //临时周转
Route::any('/transit_info','TransitController@info')->name('g_transit_info'); //临时周转详情
Route::any('/transit_add','TransitController@add')->name('g_transit_add'); //开始过渡
Route::any('/transit_edit','TransitController@edit')->name('g_transit_edit'); //修改过渡

Route::any('/resettle','ResettleController@index')->name('g_resettle'); //产权调换
Route::any('/resettle_info','ResettleController@info')->name('g_resettle_info'); //产权调换详情
Route::any('/resettle_add','ResettleController@add')->name('g_resettle_add'); //开始安置
Route::any('/resettle_edit','ResettleController@edit')->name('g_resettle_edit'); //更新
Route::any('/resettle_notice_add','ResettleController@notice_add')->name('g_resettle_notice_add'); // 添加入住通知
Route::any('/resettle_notice_info','ResettleController@notice_info')->name('g_resettle_notice_info'); // 入住通知详情

/*---------- 房源管理费 ----------*/
Route::any('/housemanagefee','HousemanagefeeController@index')->name('g_housemanagefee'); // 房源管理费
Route::any('/housemanagefee_add','HousemanagefeeController@add')->name('g_housemanagefee_add'); // 房源管理费 - 计算


Route::any('/itemcompany_pic','ItemcompanyController@pic')->name('g_itemcompany_pic'); //评估委托书
Route::any('/assess','AssessController@index')->name('g_assess'); //评估报告
Route::any('/assess_info','AssessController@info')->name('g_assess_info'); //分户评估报告
