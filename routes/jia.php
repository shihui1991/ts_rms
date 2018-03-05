<?php
/*---------- 征收意见稿 ----------*/
Route::any('/itemdraft','ItemdraftController@index')->name('g_itemdraft');
Route::any('/itemdraft_add','ItemdraftController@add')->name('g_itemdraft_add');
Route::any('/itemdraft_edit','ItemdraftController@edit')->name('g_itemdraft_edit');

/*---------- 听证会意见 ----------*/
Route::any('/itemdraftreport','ItemdraftreportController@index')->name('g_itemdraftreport');
Route::any('/itemdraftreport_add','ItemdraftreportController@add')->name('g_itemdraftreport_add');
Route::any('/itemdraftreport_edit','ItemdraftreportController@edit')->name('g_itemdraftreport_edit');
Route::any('/itemdraftreport_info','ItemdraftreportController@info')->name('g_itemdraftreport_info');

/*---------- 社会风险评估调查话题 ----------*/
Route::any('/itemtopic','ItemtopicController@index')->name('g_itemtopic');
Route::any('/itemtopic_add','ItemtopicController@add')->name('g_itemtopic_add');
Route::any('/itemtopic_info','ItemtopicController@info')->name('g_itemtopic_info');
Route::any('/itemtopic_edit','ItemtopicController@edit')->name('g_itemtopic_edit');

/*---------- 社会风险评估报告 ----------*/
Route::any('/itemriskreport','ItemriskreportController@index')->name('g_itemriskreport');
Route::any('/itemriskreport_add','ItemriskreportController@add')->name('g_itemriskreport_add');
Route::any('/itemriskreport_info','ItemriskreportController@info')->name('g_itemriskreport_info');
Route::any('/itemriskreport_edit','ItemriskreportController@edit')->name('g_itemriskreport_edit');

/*---------- 社会风险评估 ----------*/
Route::any('/itemrisk','ItemriskController@index')->name('g_itemrisk');
Route::any('/itemrisk_info','ItemriskController@info')->name('g_itemrisk_info');
Route::any('/itemrisk_add','ItemriskController@add')->name('g_itemrisk_add');
Route::any('/itemrisk_edit','ItemriskController@edit')->name('g_itemrisk_edit');

/*---------- 特殊人群优惠 ----------*/
Route::any('/itemcrowd','ItemcrowdController@index')->name('g_itemcrowd');
Route::any('/itemcrowd_info','ItemcrowdController@info')->name('g_itemcrowd_info');
Route::any('/itemcrowd_add','ItemcrowdController@add')->name('g_itemcrowd_add');
Route::any('/itemcrowd_edit','ItemcrowdController@edit')->name('g_itemcrowd_edit');

/*---------- 产权调换优惠 ----------*/
Route::any('/itemhouserate','ItemhouserateController@index')->name('g_itemhouserate');
Route::any('/itemhouserate_info','ItemhouserateController@info')->name('g_itemhouserate_info');
Route::any('/itemhouserate_add','ItemhouserateController@add')->name('g_itemhouserate_add');
Route::any('/itemhouserate_edit','ItemhouserateController@edit')->name('g_itemhouserate_edit');