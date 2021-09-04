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
	Route::get('/jasa/neraca-saldo-awal','NeracasaldoawalController@index');
	Route::get('/neraca-saldo-awal/edit/{id}','NeracasaldoawalController@edit');
	Route::get('/neraca-saldo-awal/hapus/{id}','NeracasaldoawalController@destroy');
	Route::post('/neraca-saldo-awal/konfirmasi','NeracasaldoawalController@confirm');
	Route::post('/update-neracaawal/{id}','NeracasaldoawalController@update');

	Route::get('/jasa/transaksi','TransaksiController@create');
	Route::post('/store-transaksi','TransaksiController@store');

	Route::get('/jasa/jurnal-umum','JurnalumumController@index');

	Route::get('/jasa/buku-besar','BukubesarController@index');
	Route::get('/buku-besar/akun','BukubesarController@akun');

	Route::get('/jasa/neraca-saldo','NeracasaldoController@index');

	Route::get('/jasa/jurnal-penyesuaian','JurnalpenyesuaianController@index');

	Route::get('/jasa/jurnal-penyesuaian/transaksi','TransbaruController@create');
	Route::post('/jurnal-penyesuaian/store-transaksi','TransbaruController@store');

	Route::get('/jasa/neraca-saldo/setelah-disesuaikan','NeracasaldosetelahpenController@index');

	Route::get('/jasa/jurnal-penutup','JurnalpenutupController@index');

	Route::get('/jasa/neraca-penutup','NeracapenutupController@index');


	//LAPORAN EMKM
		//laba rugi
		Route::get('/emkm/laba-rugi','EMKMlabarugiController@index');

		//posisi keuangan
		Route::get('/emkm/posisi-keuangan','EMKMposisikeuanganController@index');

		//CALK
		Route::get('/emkm/calk','CalkController@index');

		Route::get('/emkm/calk/tambah-aset','AsetController@create');
		Route::post('/emkm/calk/tambah-aset/store','AsetController@store');

		Route::get('/emkm/calk/tambah-akumulasi','AkumulasiController@create');
		Route::post('/emkm/calk/tambah-akumulasi/store','AkumulasiController@store');

		Route::get('/emkm/calk/tambah-piutang','PiutangController@create');
		Route::post('/emkm/calk/tambah-piutang/store','PiutangController@store');

		Route::get('/emkm/calk/tambah-kas-bank','KasbankController@create');
		Route::post('/emkm/calk/tambah-kas-bank/store','KasbankController@store');

		Route::get('/emkm/calk/tambah-investasi-pendek','InvestasipendekController@create');
		Route::post('/emkm/calk/tambah-investasi-pendek/store','InvestasipendekController@store');

		Route::get('/emkm/calk/tambah-piutang-non','PiutangnonController@create');
		Route::post('/emkm/calk/tambah-piutang-non/store','PiutangnonController@store');
		
		Route::get('/emkm/calk/tambah-perlengkapan','PerlengkapanController@create');
		Route::post('/emkm/calk/tambah-perlengkapan/store','PerlengkapanController@store');

		Route::get('/emkm/calk/tambah-pembayaranmuka','PembayaranmukaController@create');
		Route::post('/emkm/calk/tambah-pembayaranmuka/store','PembayaranmukaController@store');

		Route::get('/emkm/calk/tambah-aset-lain','AsetlainController@create');
		Route::post('/emkm/calk/tambah-aset-lain/store','AsetlainController@store');

		Route::get('/emkm/calk/tambah-investasi-panjang','InvestasipanjangController@create');
		Route::post('/emkm/calk/tambah-investasi-panjang/store','InvestasipanjangController@store');


	//Dagang


	//Manufaktur



});