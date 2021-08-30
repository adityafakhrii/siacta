<?php

use Illuminate\Support\Facades\Route;


Route::get('/coba',function(){
	return view('admin.coba');
});
Route::get('/','UserController@login');

Route::get('/registrasi-pengguna','UserController@register');
Route::post('/do_registrasi', 'UserController@do_registrasi');


Route::get('login', function() {
    if (Auth::check()){
        return redirect('/dashboard');
    }
    else{
        return view('admin.login');
    }
})->name('login');

Route::post('/do_login', 'UserController@do_login');
Route::get('/logout', 'UserController@logout');

Route::group(['middleware' => ['auth','checkRole:unitusaha']], function() {
	Route::get('/dashboard','UserController@dashboard');
	Route::get('/data-akun','AkunController@index');
	Route::get('/data-akun/tambah','AkunController@create');
	Route::post('/store-akun','AkunController@store');
	Route::get('/data-akun/edit/{id}','AkunController@edit');
	Route::post('/update-akun/{id}','AkunController@update');
	Route::get('/data-akun/hapus/{id}','AkunController@destroy');


	//Jasa
	Route::get('/neraca-saldo-awal','NeracasaldoawalController@index');
	Route::get('/neraca-saldo-awal/edit/{id}','NeracasaldoawalController@edit');
	Route::get('/neraca-saldo-awal/hapus/{id}','NeracasaldoawalController@destroy');
	Route::post('/neraca-saldo-awal/konfirmasi','NeracasaldoawalController@confirm');
	Route::post('/update-neracaawal/{id}','NeracasaldoawalController@update');

	Route::get('/transaksi','TransaksiController@create');
	Route::post('/store-transaksi','TransaksiController@store');

	Route::get('/jurnal-umum','JurnalumumController@index');

	Route::get('/buku-besar','BukubesarController@index');
	Route::get('/buku-besar/akun','BukubesarController@akun');

	Route::get('/jasa/neraca-saldo','NeracasaldoController@index');

	Route::get('/jasa/jurnal-penyesuaian','JurnalpenyesuaianController@index');

	Route::get('/jasa/jurnal-penyesuaian/transaksi','TransbaruController@create');
	Route::post('/jurnal-penyesuaian/store-transaksi','TransbaruController@store');

	Route::get('/jasa/neraca-saldo/setelah-disesuaikan','NeracasaldosetelahpenController@index');

	

	//Dagang


	//Manufaktur



});