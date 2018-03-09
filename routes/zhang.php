<?php
/*=========  【征收管理端】  ==========*/
/*============================================ 【基础资料】 ================================================*/
/*---------- 公房单位 ----------*/
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
/*---------- 特殊人群 ----------*/
Route::get('/crowd','CrowdController@index')->name('g_crowd');
Route::any('/crowd_add','CrowdController@add')->name('g_crowd_add');
Route::get('/crowd_info','CrowdController@info')->name('g_crowd_info');
Route::any('/crowd_edit','CrowdController@edit')->name('g_crowd_edit');
/*---------- 必备附件分类 ----------*/
Route::get('/filecate','FilecateController@index')->name('g_filecate');
Route::any('/filecate_add','FilecateController@add')->name('g_filecate_add');
Route::any('/filecate_edit','FilecateController@edit')->name('g_filecate_edit');
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
/*---------- 其他补偿事项 ----------*/
Route::get('/object','ObjectController@index')->name('g_object');
Route::any('/object_add','ObjectController@add')->name('g_object_add');
Route::get('/object_info','ObjectController@info')->name('g_object_info');
Route::any('/object_edit','ObjectController@edit')->name('g_object_edit');
/*---------- 社会风险评估调查话题 ----------*/
Route::get('/topic','TopicController@index')->name('g_topic');
Route::any('/topic_add','TopicController@add')->name('g_topic_add');
Route::get('/topic_info','TopicController@info')->name('g_topic_info');
Route::any('/topic_edit','TopicController@edit')->name('g_topic_edit');
/*---------- 土地性质 ----------*/
Route::get('/landprop','LandpropController@index')->name('g_landprop');
Route::any('/landprop_add','LandpropController@add')->name('g_landprop_add');
Route::any('/landprop_edit','LandpropController@edit')->name('g_landprop_edit');
/*---------- 土地来源 ----------*/
Route::any('/landsource_add','LandsourceController@add')->name('g_landsource_add');
Route::any('/landsource_edit','LandsourceController@edit')->name('g_landsource_edit');
/*---------- 土地权益状况 ----------*/
Route::any('/landstate_add','LandstateController@add')->name('g_landstate_add');
Route::any('/landstate_edit','LandstateController@edit')->name('g_landstate_edit');
/*============================================ 【房源】 ================================================*/
/*---------- 房源管理机构 ----------*/
Route::get('/housecompany','HousecompanyController@index')->name('g_housecompany');
Route::any('/housecompany_add','HousecompanyController@add')->name('g_housecompany_add');
Route::get('/housecompany_info','HousecompanyController@info')->name('g_housecompany_info');
Route::any('/housecompany_edit','HousecompanyController@edit')->name('g_housecompany_edit');
/*---------- 房源社区 ----------*/
Route::any('/housecommunity','HousecommunityController@index')->name('g_housecommunity');
Route::any('/housecommunity_add','HousecommunityController@add')->name('g_housecommunity_add');
Route::get('/housecommunity_info','HousecommunityController@info')->name('g_housecommunity_info');
Route::any('/housecommunity_edit','HousecommunityController@edit')->name('g_housecommunity_edit');
/*---------- 房源户型图 ----------*/
Route::any('/houselayoutimg','HouselayoutimgController@index')->name('g_houselayoutimg');
Route::any('/houselayoutimg_add','HouselayoutimgController@add')->name('g_houselayoutimg_add');
Route::get('/houselayoutimg_info','HouselayoutimgController@info')->name('g_houselayoutimg_info');
Route::any('/houselayoutimg_edit','HouselayoutimgController@edit')->name('g_houselayoutimg_edit');
/*---------- 房源 ----------*/
Route::any('/house','HouseController@index')->name('g_house');
Route::any('/house_add','HouseController@add')->name('g_house_add');
Route::get('/house_info','HouseController@info')->name('g_house_info');
Route::any('/house_edit','HouseController@edit')->name('g_house_edit');
/*---------- 房源-评估单价 ----------*/
Route::any('/houseprice','HousepriceController@index')->name('g_houseprice');
Route::any('/houseprice_add','HousepriceController@add')->name('g_houseprice_add');
Route::get('/houseprice_info','HousepriceController@info')->name('g_houseprice_info');
Route::any('/houseprice_edit','HousepriceController@edit')->name('g_houseprice_edit');
/*---------- 房源-购置管理费单价 ----------*/
Route::get('/housemanageprice','HousemanagepriceController@index')->name('g_housemanageprice');
Route::any('/housemanageprice_add','HousemanagepriceController@add')->name('g_housemanageprice_add');
Route::get('/housemanageprice_info','HousemanagepriceController@info')->name('g_housemanageprice_info');
Route::any('/housemanageprice_edit','HousemanagepriceController@edit')->name('g_housemanageprice_edit');

/*============================================ 【评估机构】 ================================================*/
/*---------- 评估机构 ----------*/
Route::any('/company','CompanyController@index')->name('g_company');
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

/*============================================ 【项目】 ================================================*/
/*---------- 项目-地块 ----------*/
Route::any('/itemland','ItemlandController@index')->name('g_itemland');
Route::any('/itemland_add','ItemlandController@add')->name('g_itemland_add');
Route::get('/itemland_info','ItemlandController@info')->name('g_itemland_info');
Route::any('/itemland_edit','ItemlandController@edit')->name('g_itemland_edit');
/*---------- 项目-地块楼栋 ----------*/
Route::any('/itembuilding','ItembuildingController@index')->name('g_itembuilding');
Route::any('/itembuilding_add','ItembuildingController@add')->name('g_itembuilding_add');
Route::get('/itembuilding_info','ItembuildingController@info')->name('g_itembuilding_info');
Route::any('/itembuilding_edit','ItembuildingController@edit')->name('g_itembuilding_edit');
/*---------- 项目-公共附属物 ----------*/
Route::any('/itempublic','ItempublicController@index')->name('g_itempublic');
Route::any('/itempublic_add','ItempublicController@add')->name('g_itempublic_add');
Route::get('/itempublic_info','ItempublicController@info')->name('g_itempublic_info');
Route::any('/itempublic_edit','ItempublicController@edit')->name('g_itempublic_edit');



/*---------- 项目-自选社会风险评估调查话题 ----------*/
Route::any('/itemtopic','ItemtopicController@index')->name('g_itemtopic');
Route::any('/itemtopic_add','ItemtopicController@add')->name('g_itemtopic_add');
Route::get('/itemtopic_info','ItemtopicController@info')->name('g_itemtopic_info');
Route::any('/itemtopic_edit','ItemtopicController@edit')->name('g_itemtopic_edit');
/*---------- 项目-其他补偿事项单价 ----------*/
Route::any('/itemobject','ItemobjectController@index')->name('g_itemobject');
Route::any('/itemobject_add','ItemobjectController@add')->name('g_itemobject_add');
Route::get('/itemobject_info','ItemobjectController@info')->name('g_itemobject_info');
Route::any('/itemobject_edit','ItemobjectController@edit')->name('g_itemobject_edit');
/*---------- 项目-补偿科目说明 ----------*/
Route::any('/itemsubject','ItemsubjectController@index')->name('g_itemsubject');
Route::any('/itemsubject_add','ItemsubjectController@add')->name('g_itemsubject_add');
Route::get('/itemsubject_info','ItemsubjectController@info')->name('g_itemsubject_info');
Route::any('/itemsubject_edit','ItemsubjectController@edit')->name('g_itemsubject_edit');


/*---------- 项目-内部通知 ----------*/
Route::any('/itemnotice','ItemnoticeController@index')->name('g_itemnotice');
Route::any('/itemnotice_add','ItemnoticeController@add')->name('g_itemnotice_add');
Route::get('/itemnotice_info','ItemnoticeController@info')->name('g_itemnotice_info');
Route::any('/itemnotice_edit','ItemnoticeController@edit')->name('g_itemnotice_edit');

/*---------- 项目-被征收户账号 ----------*/
Route::any('/household','HouseholdController@index')->name('g_household');
Route::any('/household_add','HouseholdController@add')->name('g_household_add');
Route::get('/household_info','HouseholdController@info')->name('g_household_info');
Route::any('/household_edit','HouseholdController@edit')->name('g_household_edit');
/*---------- 项目-被征收户详细信息 ----------*/
Route::any('/householddetail','HouseholddetailController@index')->name('g_householddetail');
Route::any('/householddetail_add','HouseholddetailController@add')->name('g_householddetail_add');
Route::any('/householddetail_info','HouseholddetailController@info')->name('g_householddetail_info');
Route::any('/householddetail_edit','HouseholddetailController@edit')->name('g_householddetail_edit');
/*---------- 项目-被征户-家庭成员 ----------*/
Route::any('/householdmember','HouseholdmemberController@index')->name('g_householdmember');
Route::any('/householdmember_add','HouseholdmemberController@add')->name('g_householdmember_add');
Route::get('/householdmember_info','HouseholdmemberController@info')->name('g_householdmember_info');
Route::any('/householdmember_edit','HouseholdmemberController@edit')->name('g_householdmember_edit');
/*---------- 项目-被征户-家庭成员（特殊人群） ----------*/
Route::any('/householdmembercrowd_add','HouseholdmembercrowdController@add')->name('g_householdmembercrowd_add');
Route::get('/householdmembercrowd_info','HouseholdmembercrowdController@info')->name('g_householdmembercrowd_info');
Route::any('/householdmembercrowd_edit','HouseholdmembercrowdController@edit')->name('g_householdmembercrowd_edit');
/*---------- 项目-被征户-其他补偿事项 ----------*/
Route::any('/householdobject','HouseholdobjectController@index')->name('g_householdobject');
Route::any('/householdobject_add','HouseholdobjectController@add')->name('g_householdobject_add');
Route::get('/householdobject_info','HouseholdobjectController@info')->name('g_householdobject_info');
Route::any('/householdobject_edit','HouseholdobjectController@edit')->name('g_householdobject_edit');
/*---------- 项目-被征户-房屋建筑 ----------*/
Route::any('/householdbuilding','HouseholdbuildingController@index')->name('g_householdbuilding');
Route::any('/householdbuilding_add','HouseholdbuildingController@add')->name('g_householdbuilding_add');
Route::get('/householdbuilding_info','HouseholdbuildingController@info')->name('g_householdbuilding_info');
Route::any('/householdbuilding_edit','HouseholdbuildingController@edit')->name('g_householdbuilding_edit');

/*---------- 项目-冻结房源 ----------*/
Route::any('/itemhouse','ItemhouseController@index')->name('g_itemhouse');
Route::any('/itemhouse_add','ItemhouseController@add')->name('g_itemhouse_add');

/*---------- 项目-选定评估机构 ----------*/
Route::any('/itemcompany','ItemcompanyController@index')->name('g_itemcompany');
Route::any('/itemcompany_add','ItemcompanyController@add')->name('g_itemcompany_add');
Route::get('/itemcompany_info','ItemcompanyController@info')->name('g_itemcompany_info');
Route::any('/itemcompany_edit','ItemcompanyController@edit')->name('g_itemcompany_edit');

