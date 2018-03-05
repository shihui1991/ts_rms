<?php
/*
|--------------------------------------------------------------------------
| 征收管理端 限制登录路由
|--------------------------------------------------------------------------
*/
/*---------- 首页 ----------*/
Route::any('/home','HomeController@index')->name('h_home');


/*---------- 社会稳定性风险评估 ----------*/
Route::any('/itemrisk_info','ItemriskController@info')->name('h_itemrisk_info');
Route::any('/itemrisk_add','ItemriskController@add')->name('h_itemrisk_add');
Route::any('/itemrisk_edit','ItemriskController@edit')->name('h_itemrisk_edit');

/*---------- 评估公司投票 ----------*/
Route::any('/itemcompanyvote_info','CompanyvoteController@info')->name('h_itemcompanyvote_info');
Route::any('/itemcompanyvote_add','CompanyvoteController@add')->name('h_itemcompanyvote_add');
Route::any('/itemcompanyvote_edit','CompanyvoteController@edit')->name('h_itemcompanyvote_edit');