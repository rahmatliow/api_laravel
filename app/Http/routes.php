<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function() {
    Route::group(['middleware' => 'api.auth'], function() {
        Route::resource('kategori_motor', 'kategori_motor', array('exept'=>array('post','create', 'edit')));
    });
    
    Route::resource('merk_motor', 'merk_motor', array('exept'=>array('create', 'edit')));
    Route::resource('warna_motor', 'warna_motor', array('exept'=>array('create', 'edit')));
    Route::resource('model_motor', 'model_motor', array('exept'=>array('create', 'edit')));
    Route::resource('post_news', 'post_news', array('exept'=>array('create', 'edit')));
    Route::resource('acc_motor', 'acc_motor', array('exept'=>array('create', 'edit')));
    Route::resource('post_event', 'post_event', array('exept'=>array('create', 'edit')));

    Route::post('login', 'auth@user_login');
    Route::post('logout', 'auth@user_logout');
    Route::get('model_motor/{id}/get_by_kategori', 'model_motor@get_by_kategori');
    Route::get('model_motor/{id}/get_by_warna', 'model_motor@get_by_warna');
    Route::get('model_motor/{id}/get_warna', 'model_motor@get_warna');
    Route::get('model_motor/{id}/get_acc', 'model_motor@get_acc');
});
