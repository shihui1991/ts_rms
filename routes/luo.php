<?php
/*---------- 项目进度与流程 ----------*/
Route::any('/itemprocess','ItemprocessController@index')->name('g_itemprocess'); //项目进度与流程
Route::any('/itemprocess_c2dc','ItemprocessController@check_to_dept_check')->name('g_itemprocess_c2dc'); //项目审查 -  提交部门审查

Route::any('/itemprocess_retry','ItemprocessController@check_iteminfo_retry')->name('g_itemprocess_retry'); //项目审查 -  重新提交审查资料