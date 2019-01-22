<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use App\TheLoai;
Route::get('/','PageController@trangchu');

//dang nhap admin
Route::get('admin/dangnhap','UserController@getDangnhapAdmin');
Route::post('admin/dangnhap','UserController@postDangnhapAdmin');
//end dang nhap
//dang xuat
Route::get('admin/logout','UserController@getDangxuatAdmin');
//end dang xuat
Route::group(['prefix'=>'admin','middleware'=>'adminLogin'], function(){
	Route::group(['prefix'=>'theloai'], function(){
		Route::get('danhsach', 'TheLoaiController@getDanhSach');

		Route::get('them', 'TheLoaiController@getThem');
		Route::post('them','TheLoaiController@postThem');

		Route::get('sua/{id}', 'TheLoaiController@getSua');
		Route::post('sua/{id}','TheLoaiController@postSua');

		Route::get('xoa/{id}','TheLoaiController@getXoa');

	});
	Route::group(['prefix'=>'loaitin'], function(){
		Route::get('danhsach', 'LoaiTinController@getDanhSach');

		Route::get('them', 'LoaiTinController@getThem');
		Route::post('them','LoaiTinController@postThem');

		Route::get('sua/{id}', 'LoaiTinController@getSua');
		Route::post('sua/{id}','LoaiTinController@postSua');

		Route::get('xoa/{id}','LoaiTinController@getXoa');
	});
	Route::group(['prefix'=>'tintuc'], function(){
		Route::get('danhsach', 'TinTucController@getDanhSach');

		Route::get('them', 'TinTucController@getThem');
		Route::post('them', 'TinTucController@postThem');

		Route::get('sua/{id}', 'TinTucController@getSua');
		Route::post('sua/{id}', 'TinTucController@postSua');

		Route::get('xoa/{id}','TinTucController@getXoa');
	});

	Route::group(['prefix'=>'ajax'], function(){
		Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
	});

	Route::group(['prefix'=>'comment'], function(){
		
		Route::get('xoa/{id}/{idTinTuc}','CommentController@getXoa');
	});

	Route::group(['prefix'=>'slide'], function(){
		Route::get('danhsach', 'SlideController@getDanhSach');

		Route::get('them', 'SlideController@getThem');
		Route::post('them', 'SlideController@postThem');

		Route::get('sua/{id}', 'SlideController@getSua');
		Route::post('sua/{id}', 'SlideController@postSua');

		Route::get('xoa/{id}','SlideController@getXoa');
	});

	Route::group(['prefix'=>'user'], function(){
		Route::get('danhsach', 'UserController@getDanhSach');

		Route::get('them', 'UserController@getThem');
		Route::post('them', 'UserController@postThem');

		Route::get('sua/{id}', 'UserController@getSua');
		Route::post('sua/{id}', 'UserController@postSua');

		Route::get('xoa/{id}','UserController@getXoa');
	});
});


Route::get('trangchu','PageController@trangchu');
Route::get('lienhe','PageController@lienhe');
Route::get('loaitin/{id}/{TenKhongDau}.html','PageController@loaitin');
Route::get('tintuc/{id}/{TieuDeKhongDau}.html','PageController@tintuc');
Route::get('dangnhap','PageController@getDangNhap');
Route::post('dangnhap','PageController@postDangNhap');
Route::get('dangxuat','PageController@DangXuat');
Route::post('comment/{id}','CommentController@postComment');

Route::get('nguoidung','PageController@getNguoiDung');
Route::post('nguoidung','PageController@postNguoiDung');

Route::get('dangky','PageController@getDangKy');
Route::post('dangky','PageController@postDangKy');

Route::post('timkiem','PageController@postTimKiem');

Route::get('gioithieu','PageController@gioithieu');
