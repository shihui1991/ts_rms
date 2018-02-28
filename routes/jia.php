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