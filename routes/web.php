<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('trangchu', ['as'=>'trang-chu', 'uses'=>'PagesController@getIndex']);
Route::get('loaisanpham/{id}', ['as'=>'loai-san-pham','uses'=>'PagesController@getLoaisp']);
Route::get('sanpham/{id}', ['as'=>'san-pham','uses'=>'PagesController@getSanpham']);
Route::get('lienhe',['as'=>'lien-he','uses'=>'PagesController@getLienhe']);
Route::get('gioithieu', ['as'=>'gioi-thieu','uses'=>'PagesController@getGt']);

Route::get('add-to-cart/{id}', ['as'=>'themgiohang', 'uses'=>'PagesController@getAddtoCart']);
Route::get('del-to-cart/{id}', ['as'=>'xoagiohang', 'uses'=>'PagesController@getDeltoCart']);

Route::get('dat-hang', ['as'=> 'dathang', 'uses'=>'PagesController@getDathang']);
Route::post('dat-hang', ['as'=> 'dathang', 'uses'=>'PagesController@postDathang']);

Route::get('dang-nhap', ['as' => 'login', 'uses'=>'PagesController@getDangnhap']);
Route::post('dang-nhap', ['as' => 'login', 'uses'=>'PagesController@postDangnhap']);

Route::get('dang-ki', ['as'=>'signup', 'uses'=>'PagesController@getDangki']);
Route::post('dang-ki', ['as'=>'signup', 'uses'=>'PagesController@postDangki']);

Route::get('dang-xuat', ['as'=>'logout', 'uses'=>'PagesController@postDangxuat']);

Route::get('slide', ['as'=>'slide', 'uses'=>'PagesController@getSlide']);
Route::post('slide', ['as'=>'slide', 'uses'=>'PagesController@addSlide']);

Route::get('timkiem', ['as'=>'timkiem', 'uses'=>'PagesController@Search']);
//Phần phụ
Route::get('upload', ['as'=>'upload','uses'=>'PagesController@upload']);
Route::post('upload', ['as'=>'upload','uses'=>'PagesController@postUpload']);
