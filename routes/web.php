<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[
	'as'=>'trang-chu',
	'uses'=>'PageController@getIndex'
]);

Route::get('loai-san-pham/{type}',[
	'as'=>'loaisanpham',
	'uses'=>'PageController@getLoaiSp'
]);

Route::get('chi-tiet-san-pham/{id}',[
	'as'=>'chitietsanpham',
	'uses'=>'PageController@getChitiet'
]);

Route::get('lien-he',[
	'as'=>'lienhe',
	'uses'=>'PageController@getLienhe'
]);

Route::get('gioi-thieu',[
	'as'=>'gioithieu',
	'uses'=>'PageController@getgioithieu'
]);

Route::get('add-to-cart/{id}',[
	'as'=> 'themgiohang',
	'uses'=>'PageController@getAddtoCart'
]);

Route::get('del-cart/{id}',[
	'as'=> 'xoagiohang',
	'uses'=> 'PageController@getDelItemCart'

]);

Route::get('dat-hang',[
	'as'=>'dathang',
	'uses'=>'PageController@getDathang'
]);

Route::post('dat-hang',[
	'as'=>'dathang',
	'uses'=>'PageController@postDathang'
]);

Route::get('dang-nhap',[ //duong dan cua route
	'as'=> 'login', //ten route truyen vao trong trang
	'uses'=> 'PageController@getLogin'
]);

Route::post('dang-nhap',[ //duong dan cua route hien tren trinh duyet
	'as'=> 'login', //ten route truyền vao trong pagecontroller phai giong vs ten route truyen vao ..blade.php
	'uses'=> 'PageController@postLogin'
]);

Route::get('dang-ky',[
	'as'=>'register',
	'uses'=> 'PageController@getRegister'
]);

Route::post('dang-ky',[
	'as'=>'register',
	'uses'=> 'PageController@postRegister' // đăng ký và kích hoạt mail
]);

Route::get('dang-xuat',[
	'as'=>'logout',
	'uses'=> 'PageController@postLogout'
]);

Route::get('gui-mail','PageController@sendMail');

Route::get('send-to-mail/{id}/{token}',[
	'as'=> 'sendtomail',
	'uses'=> 'PageController@activeUser'
]);

Route::get('tim-kiem',[
	'as' => 'search',
	'uses'=> 'PageController@getSearch'
]);

Route::get('login/{provider}',[
	'as'=> 'provider_login',
	'uses'=> 'PageController@redirectToProvider'
]);

Route::get('login/{provider}/callback',[
	'as'=> 'provider_login_callback',
	'uses'=> 'PageController@handleProviderCallback'
]);

Route::get('thu', function(){
	return view('admin.product_type.danhsach');
});

							// ADMIN
//duong dan admin http://localhost:8080/banhang/public/admin/product_type/danhsach

Route::group(['prefix'=> 'admin'], function(){
	// PRODUCT TYPE
	// /admin/product_type/danhsach
	Route::group(['prefix'=> 'product_type'], function(){
		Route::get('danhsach','ProdTypeController@getDanhSach');

		Route::get('sua/{id}','ProdTypeController@getSua');
		Route::post('sua/{id}','ProdTypeController@postSua');

		Route::get('them','ProdTypeController@getThem');
		Route::post('them','ProdTypeController@postThem');

		Route::get('xoa/{id}','ProdTypeController@getXoa');

	});
	// PRODUCT
	Route::group(['prefix'=> 'product'], function(){
		Route::get('danhsach','ProductController@getDanhSach');

		Route::get('sua','ProdTypeController@getSua');

		Route::get('them','ProductController@getThem');
		Route::post('them','ProductController@postThem');
	});
	// USER
	Route::group(['prefix'=> 'user'], function(){
		Route::get('danhsach','ProdTypeController@getDanhSach');

		Route::get('sua','ProdTypeController@getSua');

		Route::get('them','ProdTypeController@getThem');
	});

});

