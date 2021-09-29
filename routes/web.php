<?php

use Illuminate\Support\Facades\Route;


Route::get('/coba',function(){
	return view('admin.coba');
});

Route::get('/', function() {
    if (Auth::check()){
        return redirect('/dashboard');
    }
    else{
        return view('admin.login');
    }
});

Route::get('/registrasi-pengguna','UserController@register');
Route::post('/do_registrasi', 'UserController@do_registrasi');


Route::get('/login', function() {
    if (Auth::check()){
        return redirect('/dashboard');
    }
    else{
        return view('admin.login');
    }
})->name('login');

Route::post('/do_login', 'UserController@do_login');
Route::get('/logout', 'UserController@logout');

Route::group(['middleware' => ['auth','checkRole:unitusaha,bumdes,superadmin']], function() {
	Route::get('/dashboard','UserController@dashboard');
});

Route::group(['middleware' => ['auth','checkRole:superadmin']], function() {
	Route::get('/data-bumdes','UserController@bumdes');
	Route::get('/data-bumdes/tambah','UserController@addBumdes');
	Route::post('/store-bumdes','UserController@storeBumdes');
	Route::get('/data-bumdes/edit/{id}','UserController@editBumdes');
	Route::post('/update-bumdes/{id}','UserController@updateBumdes');
	Route::get('/data-bumdes/hapus/{id}','UserController@destroyBumdes');
});

Route::group(['middleware' => ['auth','checkRole:bumdes']], function() {
	Route::get('/data-unit','UserController@unit');
	Route::get('/data-unit/tambah','UserController@addUnit');
	Route::post('/store-unit','UserController@storeUnit');
	Route::get('/data-unit/edit/{id}','UserController@editUnit');
	Route::post('/update-unit/{id}','UserController@updateUnit');
	Route::get('/data-unit/hapus/{id}','UserController@destroyUnit');
});

Route::group(['middleware' => ['auth','checkRole:unitusaha']], function() {

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
	Route::get('/emkm/calk/pdf','CalkController@calkPDF');

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

	Route::get('/emkm/calk/tambah-aset-tetap','AsettetapController@create');
	Route::post('/emkm/calk/tambah-aset-tetap/store','AsettetapController@store');

	Route::get('/emkm/calk/tambah-aset-leasing','AsetleasingController@create');
	Route::post('/emkm/calk/tambah-aset-leasing/store','AsetleasingController@store');

	Route::get('/emkm/calk/tambah-properti','PropertiController@create');
	Route::post('/emkm/calk/tambah-properti/store','PropertiController@store');

	Route::get('/emkm/calk/tambah-aset-tidakberwujud','AsettidakberwujudController@create');
	Route::post('/emkm/calk/tambah-aset-tidakberwujud/store','AsettidakberwujudController@store');

	Route::get('/emkm/calk/tambah-kewajiban-pendek','KewajibanpendekController@create');
	Route::post('/emkm/calk/tambah-kewajiban-pendek/store','KewajibanpendekController@store');

	Route::get('/emkm/calk/tambah-kewajiban-panjang','KewajibanpanjangController@create');
	Route::post('/emkm/calk/tambah-kewajiban-panjang/store','KewajibanpanjangController@store');

	Route::get('/emkm/calk/tambah-kewajiban-lain','KewajibanlainController@create');
	Route::post('/emkm/calk/tambah-kewajiban-lain/store','KewajibanlainController@store');

	Route::get('/emkm/calk/tambah-ekuitas','EkuitasController@create');
	Route::post('/emkm/calk/tambah-ekuitas/store','EkuitasController@store');

	Route::post('/emkm/calk/store','CalkController@store');


	

	//Dagang	


	//Manufaktur
});

Route::group(['middleware' => ['auth','checkRole:bumdes,unitusaha']], function() {
	Route::get('/data-akun','AkunController@index');
	Route::get('/data-akun/tambah','AkunController@create');
	Route::post('/store-akun','AkunController@store');
	Route::get('/data-akun/edit/{id}','AkunController@edit');
	Route::post('/update-akun/{id}','AkunController@update');
	Route::get('/data-akun/hapus/{id}','AkunController@destroy');

	//Jasa
	Route::get('/bumdes/neraca-saldo-awal','BumdesController@index');
	Route::get('/neraca-saldo-awal/edit/{id}','BumdesController@edit');
	Route::get('/neraca-saldo-awal/hapus/{id}','BumdesController@destroy');
	Route::post('/neraca-saldo-awal/konfirmasi','BumdesController@confirm');
	Route::post('/update-neracaawal/{id}','BumdesController@update');

	Route::get('/bumdes/transaksi','TransaksiController@create');
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



	//PAJAK

	//PPH 21
	Route::get('/pph21','Pph21Controller@index');
	Route::get('/pph21/tambah','Pph21Controller@create');
	Route::post('/store-pph21','Pph21Controller@store');

	//Bukti Potong PPH 21 Tidak Tetap
	Route::get('/pph21/bukti-potong-tidaktetap','Pph21Controller@bupot_tidak');
	Route::get('/pph21/bukti-potong-tidaktetap/tambah','Pph21Controller@create_bupot_tidak');
	Route::post('/store-bukti-potong-tidaktetap','Pph21Controller@store_bupot_tidak');

	//Bukti Potong PPH 21 Tetap
	Route::get('/pph21/bukti-potong-tetap','Pph21Controller@bupot_tetap');
	Route::get('/pph21/bukti-potong-tetap/tambah','Pph21Controller@create_bupot_tetap');
	Route::post('/store-bukti-potong-tetap','Pph21Controller@store_bupot_tetap');

	//PPH 22
	Route::get('/pph22','Pph22Controller@index');
	Route::get('/pph22/tambah','Pph22Controller@create');
	Route::post('/store-pph22','Pph22Controller@store');

	//Bukti Potong PPH 22
	Route::get('/pph22/bukti-potong','Pph22Controller@bupot');
	Route::get('/pph22/bukti-potong/tambah','Pph22Controller@create_bupot');
	Route::post('/store-bukti-potongpph22','Pph22Controller@store_bupot');

	//PPH 23
	Route::get('/pph23','Pph23Controller@index');
	Route::get('/pph23/tambah','Pph23Controller@create');
	Route::post('/store-pph23','Pph23Controller@store');

	//Bukti Potong PPH 23
	Route::get('/pph23/bukti-potong','Pph23Controller@bupot');
	Route::get('/pph23/bukti-potong/tambah','Pph23Controller@create_bupot');
	Route::post('/store-bukti-potongpph23','Pph23Controller@store_bupot');

	//PPH 4 ayat 2
	Route::get('/pph4ayat2','Pph4ayat2Controller@index');
	Route::get('/pph4ayat2/tambah','Pph4ayat2Controller@create');
	Route::post('/store-pph4ayat2','Pph4ayat2Controller@store');
});