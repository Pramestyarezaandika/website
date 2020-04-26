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
    return redirect('login');
});

Route::get('/login', 'Admin\AuthController@index')->name('login');
Route::post('/login', 'Admin\AuthController@login')->name('auth.login');

Route::group(['middleware' => 'auth.firebase'], function () {
    Route::post('/dashboard', 'Admin\AuthController@logout')->name('auth.logout');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/table/pegawai', 'Admin\PegawaiController@dataTable')->name('table.pegawai');
    Route::resource('/pegawai', 'Admin\PegawaiController');
    Route::get('/table/lokasi', 'Admin\LokasiController@dataTable')->name('table.lokasi');
    Route::resource('/lokasi', 'Admin\LokasiController');
});

