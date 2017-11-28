<?php

Route::group(['prefix' => 'admin'], function () {
    Route::post('super/password', 'Admin\SuperController@password');    //修改密码
    Route::get('/menu/get', 'Admin\MenuController@get_menu');
    Route::group(['prefix' => 'weixin'], function () {
        Route::post("/config/set", 'Admin\WeixinController@set_config');
        Route::post("/config/get", 'Admin\WeixinController@get_config');

        Route::post("/template/set", 'Admin\WeixinController@set_wx_template');
        Route::post("/template/get", 'Admin\WeixinController@get_wx_template');

        Route::post("/reply/get", 'Admin\WeixinController@get_reply');
        Route::post("/reply/set", 'Admin\WeixinController@set_reply');
        Route::post("/follow/set", 'Admin\WeixinController@set_follow');
        Route::post("/news/set", 'Admin\WeixinController@set_news');

        Route::post("/reply/create", 'Admin\WeixinController@create_reply');
        Route::post("/reply/delete/{id}", 'Admin\WeixinController@delete_reply');

        Route::post("/industry", 'Admin\WeixinController@set_industry');
        Route::post("/update", 'Admin\WeixinController@add_template');
        Route::post("/auto_update", 'Admin\WeixinController@get_private_templates');
        Route::post("/menu/get", 'Admin\WeixinController@get_menu');
        Route::post("/menu/set", 'Admin\WeixinController@set_menu');

        Route::get('/group/get', 'Admin\WeixinController@get_wx_group');
        Route::get('/group/set', 'Admin\WeixinController@set_wx_group');
        Route::get('/group/move', 'Admin\WeixinController@move_wx_group');
        Route::get('/group/del', 'Admin\WeixinController@del_wx_group');
        Route::get('/group/menu/a/set', 'Admin\WeixinController@set_wx_group_menu_a');
        Route::get('/group/menu/b/set', 'Admin\WeixinController@set_wx_group_menu_b');
        Route::get('/menu/get', 'Admin\WeixinController@get_wx_menu');
        Route::get('/user/menu/get', 'Admin\WeixinController@get_wx_user_mennu');
    });

    Route::post('/log/get_list','Admin\LogController@index');
    Route::post('/employee/list','Admin\EmployeeController@get_data');
    Route::get('/employee/get_info','Admin\EmployeeController@get_info');
    Route::post('/employee/img','Admin\EmployeeController@upload_img');
    Route::post('/employee/edit','Admin\EmployeeController@edit');
    Route::post('/employee/del','Admin\EmployeeController@del');
    Route::post('/employee/reset','Admin\EmployeeController@reset');
    Route::post('/employee/add','Admin\EmployeeController@add');

    Route::group(['prefix' => 'dealer'], function () {
        Route::post('/get_data','Admin\DealerController@get_data');
        Route::post('/add','Admin\DealerController@add');
        Route::post('/edit','Admin\DealerController@edit');
        Route::post('/del','Admin\DealerController@del');
        Route::post('/get_info','Admin\DealerController@get_info');
    });

    Route::group(['prefix'=>'goods'],function(){
        Route::post('/type/get_data','Admin\GoodsController@get_type_data');
        Route::post('/type/add_type','Admin\GoodsController@add_type');
        Route::post('/type/edit_type','Admin\GoodsController@edit_type');
        Route::post('/type/del_type','Admin\GoodsController@del_type');
        Route::post('/type/_id_get_data','Admin\GoodsController@_id_get_data');
        Route::post('/purchase/get_data','Admin\GoodsController@get_dealer_data');
    });

});
/*Route::group(['prefix' => 'weixin'], function () {
    Route::post("/config/set", 'Admin\WeixinController@set_config');
    Route::post("/config/get", 'Admin\WeixinController@get_config');

    Route::post("/template/set", 'Admin\WeixinController@set_wx_template');
    Route::post("/template/get", 'Admin\WeixinController@get_wx_template');

    Route::post("/reply/get", 'Admin\WeixinController@get_reply');
    Route::post("/reply/set", 'Admin\WeixinController@set_reply');
    Route::post("/follow/set", 'Admin\WeixinController@set_follow');
    Route::post("/news/set", 'Admin\WeixinController@set_news');

    Route::post("/reply/create", 'Admin\WeixinController@create_reply');
    Route::post("/reply/delete/{id}", 'Admin\WeixinController@delete_reply');

    Route::post("/industry", 'Admin\WeixinController@set_industry');
    Route::post("/update", 'Admin\WeixinController@add_template');
    Route::post("/auto_update", 'Admin\WeixinController@get_private_templates');
    Route::post("/menu/get", 'Admin\WeixinController@get_menu');
    Route::post("/menu/set", 'Admin\WeixinController@set_menu');

    Route::get('/group/get', 'Admin\WeixinController@get_wx_group');
    Route::get('/group/set', 'Admin\WeixinController@set_wx_group');
    Route::get('/group/move', 'Admin\WeixinController@move_wx_group');
    Route::get('/group/del', 'Admin\WeixinController@del_wx_group');
    Route::get('/group/menu/a/set', 'Admin\WeixinController@set_wx_group_menu_a');
    Route::get('/group/menu/b/set', 'Admin\WeixinController@set_wx_group_menu_b');
    Route::get('/menu/get', 'Admin\WeixinController@get_wx_menu');
    Route::get('/user/menu/get', 'Admin\WeixinController@get_wx_user_mennu');
});*/