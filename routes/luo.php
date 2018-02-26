<?php
/*---------- 项目进度与流程 ----------*/
Route::any('/itemprocess','ItemprocessController@index')->name('g_itemprocess'); //项目进度与流程
Route::any('/itemprocess_c2dc','ItemprocessController@check_to_dept_check')->name('g_itemprocess_c2dc'); //项目审查 -  提交部门审查
Route::any('/itemprocess_cdc','ItemprocessController@check_dept_check')->name('g_itemprocess_cdc'); //项目审查 -  部门审查
Route::any('/itemprocess_crb','ItemprocessController@check_roll_back')->name('g_itemprocess_crb'); //项目审查 -  审查驳回处理
Route::any('/itemprocess_retry','ItemprocessController@check_iteminfo_retry')->name('g_itemprocess_retry'); //项目审查 -  重新提交审查资料
Route::any('/itemprocess_stop','ItemprocessController@check_item_stop')->name('g_itemprocess_stop'); //项目审查 -  不予受理
Route::any('/itemprocess_c2gc','ItemprocessController@check_to_gov_check')->name('g_itemprocess_c2gc'); //项目审查 -  提交区政府审查
