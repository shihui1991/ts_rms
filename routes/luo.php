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
