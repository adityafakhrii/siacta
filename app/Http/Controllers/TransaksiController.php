<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Transbaru;
use App\Models\Jurnalpenyesuaian;
use App\Models\Akun;
use App\Models\Jurnalumum;
use App\Models\Neracasaldoawal;
use App\Models\Neracasaldo;
use App\Models\Bukubesar;
use App\Models\Bukubesarpenyesuaian;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;

class TransaksiController extends Controller
{
    public function index(){

    	$transaksi = Transaksi::all();

    	return view('admin.transaksi.transaksi');
    }

    public function create(){

    	$akuns = Akun::where('id_user','=',Auth::user()->id)
        ->orderBy('no_akun','asc')->get();

        $akundebit = DB::table('akuns')
                    ->where('no_akun', 'like', '91%')
                    ->get(); 

        $akunkredit = DB::table('akuns')
                    ->where('no_akun', 'like', '31%')
                    ->get();

    	return view('admin.transaksi.tambah-transaksi',compact('akuns','akundebit','akunkredit'));
    }

    public function store(Request $request){
        
        $akun = Akun::all();

    	$trans = new Transaksi;
        $trans->id_akun = $request->id_akun;
        $trans->id_user = $request->id_user;

        $bukti = '';
        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti');
            $nama = $bukti->getClientOriginalName();
            $bukti->move(public_path().'/bukti/',$nama);
            $bukti = '/bukti/'.$nama;
        }

        $trans->dok_bukti = $bukti;
        $trans->jenis_pembayaran = $request->jenis_pembayaran;
        $trans->keterangan = $request->keterangan;
        $trans->tgl = $request->tgl;
        $trans->nominal = $request->nominal;
        $trans->nominal_dp = $request->nominal_dp;
        $trans->nominal_ppn = $request->nominal_ppn;
        $trans->nominal_pph22 = $request->nominal_pph22;
        $trans->nominal_pph23 = $request->nominal_pph23;
        $trans->umur_ekonomis = $request->umur_ekonomis;
        $trans->nilai_sisa = $request->nilai_sisa;
        $trans->beban_penyusutan = $request->beban_penyusutan;
        $trans->status = $request->status;

        if ($request->status == 'pembelian' || $request->status == 'pengeluaran_kas' || $request->status == 'retur_pembelian') {
            $trans->potongan_pembelian = $request->diskon;
            $trans->potongan_penjualan = 0;
        }
        else if($request->status == 'penjualan' || $request->status == 'penerimaan_kas' || $request->status == 'retur_penjualan'){
            $trans->potongan_penjualan = $request->diskon;
            $trans->potongan_pembelian = 0;
        }

        // Untuk menyimpan transaksi lalu mengisi Jurnal Umum
        if ($trans->save()) {

            // Penjualan tunai
            if ($trans->status == 'penjualan' && $trans->jenis_pembayaran == 'tunai') {

                // Jika tidak ada PAJAK dan tidak ada diskon
                if ($trans->nominal_ppn == 0 && $request->diskon == 0) {
                    $data = array(
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => NULL,
                                'debit' => $request->nominal - $request->diskon,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                $bb1 = array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                $bb2 = array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    $bb1 = array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    $bb2 = array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon
                else if($trans->nominal_ppn == 0 && $request->diskon != 0){
                        $data = array(
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 2,
                                    'kredit' => NULL,
                                    'debit' => $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + ($request->nominal - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 2,
                                    'debit' => $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal - $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + ($request->nominal - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 2,
                                        'debit' => $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon == 0){
                        $data = array(
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal + $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_keluaran = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 8,
                                    'kredit' => $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal + $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 8,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal + $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + ($request->nominal + $request->nominal_ppn),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 8,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_ppn,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon != 0){
                        $data = array(
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => NULL,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 2,
                                    'kredit' => NULL,
                                    'debit' => $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_keluaran = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 8,
                                    'kredit' => $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 2,
                                    'debit' => $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 8,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 2,
                                        'debit' => $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 8,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_ppn,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }
            }

            // Penjualan Kredit
            else if ($trans->status == 'penjualan' && $trans->jenis_pembayaran == 'kredit') {

                // Jika tidak ada PAJAK dan tidak ada diskon
                if ($trans->nominal_ppn == 0 && $request->diskon == 0) {
                    $data = array(
                                $piutang_usaha = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 3,
                                'kredit' => NULL,
                                'debit' => $request->nominal - $request->diskon,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 3,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 3,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon
                else if($trans->nominal_ppn == 0 && $request->diskon != 0){
                        $data = array(
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 3,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 2,
                                    'kredit' => NULL,
                                    'debit' => $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 3,
                                    'debit' => $request->nominal - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + ($request->nominal - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 2,
                                    'debit' => $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 3,
                                        'debit' => $request->nominal - $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + ($request->nominal - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 2,
                                        'debit' => $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon == 0){
                        $data = array(
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 3,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal + $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_keluaran = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 8,
                                    'kredit' => $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 3,
                                    'debit' => $request->nominal + $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 8,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 3,
                                        'debit' => $request->nominal + $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + ($request->nominal + $request->nominal_ppn),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 8,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_ppn,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon != 0){
                        $data = array(
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 3,
                                    'kredit' => NULL,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 2,
                                    'kredit' => NULL,
                                    'debit' => $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),                                    
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_keluaran = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 8,
                                    'kredit' => $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 3,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 2,
                                    'debit' => $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 8,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 3,
                                        'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 2,
                                        'debit' => $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 8,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_ppn,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }
            }

            // Penjualan DP
            else if ($trans->status == 'penjualan' && $trans->jenis_pembayaran == 'dp') {

                // Jika tidak ada PAJAK dan tidak ada diskon
                if ($trans->nominal_ppn == 0 && $request->diskon == 0) {
                    $data = array(
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => NULL,
                                'debit' => $request->nominal_dp,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $piutang_usaha = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 3,
                                'kredit' => NULL,
                                'debit' => $request->nominal - $request->nominal_dp,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal_dp,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 3,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + ($request->nominal - $request->nominal_dp),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal_dp,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 3,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + ($request->nominal - $request->nominal_dp),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon
                else if($trans->nominal_ppn == 0 && $request->diskon != 0){
                        $data = array(
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_dp,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 3,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal - $request->nominal_dp - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 2,
                                    'kredit' => NULL,
                                    'debit' => $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal_dp,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 3,
                                    'debit' => $request->nominal_dp - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + ($request->nominal_dp - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 2,
                                    'debit' => $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal_dp,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 3,
                                        'debit' => $request->nominal_dp - $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + ($request->nominal_dp - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 2,
                                        'debit' => $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon == 0){
                        $data = array(
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_dp,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 3,
                                    'kredit' => NULL,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_dp,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_keluaran = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 8,
                                    'kredit' => $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal_dp,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 3,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_dp,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + (($request->nominal + $request->nominal_ppn) - $request->nominal_dp),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 8,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal_dp,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 3,
                                        'debit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_dp,
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + (($request->nominal + $request->nominal_ppn) - $request->nominal_dp),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 8,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_ppn,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon != 0){
                        $data = array(
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_dp,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 3,
                                    'kredit' => NULL,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon),
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 2,
                                    'kredit' => NULL,
                                    'debit' => $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_keluaran = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 8,
                                    'kredit' => $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal_dp,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 3,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon),
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 2,
                                    'debit' => $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 8,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',2)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',8)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal_dp,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 3,
                                        'debit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon),
                                        'kredit' => NULL,
                                        'saldo' => $bbpiutangusahapen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 2,
                                        'debit' => $request->diskon,
                                        'kredit' => NULL,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 8,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_ppn,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }
            }

            // Pembelian Tunai
            else if ($trans->status == 'pembelian' && $trans->jenis_pembayaran == 'tunai') {
                
                // Jika tidak ada PAJAK dan tidak ada diskon dan ada pph23 tidak ada pph22
                if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();


                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->nominal_pph23,
                                    'saldo' => $bbkas->saldo - ($request->nominal - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();


                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->nominal_pph23,
                                        'saldo' => $bbkaspen->saldo - ($request->nominal - $request->nominal_pph23),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan ada pph23 tidak ada pph22
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();


                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                    'saldo' => $bbkas->saldo - ($request->nominal - $request->diskon - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                            
                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();


                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                        'saldo' => $bbkaspen->saldo - ($request->nominal - $request->diskon - $request->nominal_pph23),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan tidak ada diskon dan ada pph22 tidak ada pph23
                else if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->nominal_pph22,
                                    'saldo' => $bbkas->saldo - ($request->nominal - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->nominal_pph22,
                                        'saldo' => $bbkaspen->saldo - ($request->nominal - $request->nominal_pph22),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan ada pph22 tidak ada pph23
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();


                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                    'saldo' => $bbkas->saldo - ($request->nominal - $request->diskon - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                            
                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();


                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                        'saldo' => $bbkaspen->saldo - ($request->nominal - $request->diskon - $request->nominal_pph22),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => ($request->nominal - $request->diskon),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon,
                                    'saldo' => $bbkas->saldo - ($request->nominal - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                            
                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->diskon,
                                        'saldo' => $bbkaspen->saldo - ($request->nominal - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan tidak ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();


                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbkas->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();


                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbkas->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => N9L,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                            
                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => N9L,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                        'saldo' => $bbkaspen->saldo - (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'saldo' => $bbkas->saldo - ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->s9tus,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal + $request->nominal_ppn,
                                        'saldo' => $bbkaspen->saldo - ($request->nominal + $request->nominal_ppn),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->s9tus,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan ada pph22 dan tidak ada pph23
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                            
                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bb = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                        'saldo' => $bbkaspen->saldo - (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan ada pph22 dan tidak ada pph23
                else if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - $request->nominal9ph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                        'saldo' => $bbkaspen->saldo - (($request->nominal + $request->nominal_ppn) - $request->nominal9ph22),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }

                }

                // Jika ada PAJAK dan ada diskon dan ada pph23 dan tidak ada pph22
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph23 != 0 && $request->nominal_pph22 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                            
                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                        'saldo' => $bbkaspen->saldo - (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan ada pph23 dan tidak ada pph22
                else if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );
                        
                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - $request->nominal9ph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                        'saldo' => $bbkaspen->saldo - (($request->nominal + $request->nominal_ppn) - $request->nominal9ph23),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }
            }

            // Pembelian Kredit
            else if ($trans->status == 'pembelian' && $trans->jenis_pembayaran == 'kredit') {
                
                // Jika tidak ada PAJAK dan tidak ada diskon dan ada pph23 tidak ada pph22
                if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => $request->nominal - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->nominal_pph23,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->nominal_pph23,
                                        'saldo' => $bbutangpen->saldo + ($request->nominal - $request->nominal_pph23),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan ada pph23 tidak ada pph22
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->diskon - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                        'saldo' => $bbutangpen->saldo + ($request->nominal - $request->diskon - $request->nominal_pph23),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan tidak ada diskon dan ada pph22 tidak ada pph23
                else if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => $request->nominal - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->nominal_pph22,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->nominal_pph22,
                                        'saldo' => $bbutangpen->saldo + ($request->nominal - $request->nominal_pph22),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan ada pph22 tidak ada pph23
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->diskon - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                        'saldo' => $bbutangpen->saldo + ($request->nominal - $request->diskon - $request->nominal_pph22),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal - $request->diskon),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal - $request->diskon,
                                        'saldo' => $bbutangpen->saldo + ($request->nominal - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan tidak ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => $request->nominal,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );
                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbutang->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbutangpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'saldo' => $bbutang->saldo + ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->s9tus,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal + $request->nominal_ppn,
                                        'saldo' => $bbutangpen->saldo + ($request->nominal + $request->nominal_ppn),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->s9tus,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan ada pph22 dan tidak ada pph23
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan ada pph22 dan tidak ada pph23
                else if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - $request->nomin9_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - $request->nomin9_pph22),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan ada pph23 dan tidak ada pph22
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph23 != 0 && $request->nominal_pph22 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan ada pph23 dan tidak ada pph22
                else if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - $request->nomin9_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - $request->nomin9_pph23),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }
            }

            // Pembelian DP
            else if ($trans->status == 'pembelian' && $trans->jenis_pembayaran == 'dp') {     
                
                // Jika ada PAJAK dan tidak ada diskon dan ada pph22 dan tidak ada pph23
                if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph22),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph22)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph22),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph22)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan tidak ada diskon dan ada pph22 tidak ada pph23
                else if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph22),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->nominal_pph22)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph22),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal) - ($request->nominal_dp + $request->nominal_pph22)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan ada pph22 dan tidak ada pph23
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpen = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => N9L,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                            
                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => N9L,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan ada pph22 tidak ada pph23
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 != 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 6,
                                    'kredit' => $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph22 = Bukubesar::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 6,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                            
                            $bbpph22pen = Bukubesarpenyesuaian::where('id_akun','=',6)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 6,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph22,
                                        'saldo' => $bbpph22pen->saldo + $request->nominal_pph22,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan ada pph23 dan tidak ada pph22
                if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph23),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph23)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan tidak ada diskon dan ada pph23 tidak ada pph22
                else if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => $request->nominal,
                                            'kredit' => NULL,
                                            'saldo' => $bbesarpen->saldo + $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 1,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal_dp,
                                            'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 4,
                                            'debit' => NULL,
                                            'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph23),
                                            'saldo' => $bbutangpen->saldo + (($request->nominal) - ($request->nominal_dp + $request->nominal_pph23)),
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 5,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal_pph23,
                                            'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan ada pph23 dan tidak ada pph22
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => N9L,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                            
                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => N9L,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }
                
                // Jika tidak ada PAJAK dan ada diskon dan ada pph23 tidak ada pph22
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 != 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 5,
                                    'kredit' => $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph23 = Bukubesar::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->st7s,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 5,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                            
                            $bbpph23pen = Bukubesarpenyesuaian::where('id_akun','=',5)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->st7s,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 5,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_pph23,
                                        'saldo' => $bbpph23pen->saldo + $request->nominal_pph23,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn == 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                            
                            $bb = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika tidak ada PAJAK dan tidak ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn == 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => $request->nominal,
                                            'kredit' => NULL,
                                            'saldo' => $bbesarpen->saldo + $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 4,
                                            'debit' => NULL,
                                            'kredit' => ($request->nominal) - ($request->nominal_dp),
                                            'saldo' => $bbutangpen->saldo + (($request->nominal) - ($request->nominal_dp)),
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 1,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal_dp,
                                            'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn != 0 && $request->diskon != 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 7,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 7,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbdiskonpen = Bukubesarpenyesuaian::where('id_akun','=',7)->orderBy('id','DESC')->limit(1)->firstOrFail();
                            
                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 7,
                                        'debit' => NULL,
                                        'kredit' => $request->diskon,
                                        'saldo' => $bbdiskonpen->saldo + $request->diskon,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Jika ada PAJAK dan tidak ada diskon dan tidak ada pph22 maupun pph23
                else if($trans->nominal_ppn != 0 && $request->diskon == 0 && $request->nominal_pph22 == 0 && $request->nominal_pph23 == 0){
                        $data = array(
                                    $akun_bb = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => $request->id_akun,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $ppn_masukan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 9,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $kas = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 1,
                                    'kredit' => $request->nominal_dp,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 4,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                        );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->s9tus,
                                ),
                                array(
                                    'id_akun' => 4,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_dp,
                                    'saldo' => $bbkas->saldo - $request->nominal_dp,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangpen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo + $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->s9tus,
                                    ),
                                    array(
                                        'id_akun' => 4,
                                        'debit' => NULL,
                                        'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp),
                                        'saldo' => $bbutangpen->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp)),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_dp,
                                        'saldo' => $bbkaspen->saldo - $request->nominal_dp,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }
            }

            // Penerimaan Kas
            else if ($trans->status == 'penerimaan_kas') {
                    $data = array(
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        if ($bbesar->akun->saldo_normal == 'debit') {
                            $penerimaan = $bbesar->saldo - $request->nominal;
                        }

                        else if ($bbesar->akun->saldo_normal == 'kredit') {
                            $penerimaan = $bbesar->saldo + $request->nominal;
                        }

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $penerimaan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            if ($bbesarpen->akun->saldo_normal == 'debit') {
                            $penerimaanpen = $bbesarpen->saldo - $request->nominal;
                            }
                            
                            else if ($bbesarpen->akun->saldo_normal == 'kredit') {
                                $penerimaanpen = $bbesarpen->saldo + $request->nominal;
                            }

                            $bbpen = array(
                                    array(
                                        'id_akun' => 1,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbkaspen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $penerimaanpen,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
            }

            // Pengeluaaran Kas
            else if ($trans->status == 'pengeluaran_kas') {
                    $data = array(
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        if ($bbesar->akun->saldo_normal == 'debit') {
                            $pengeluaran = $bbesar->saldo + $request->nominal;
                        }

                        else if ($bbesar->akun->saldo_normal == 'kredit') {
                            $pengeluaran = $bbesar->saldo - $request->nominal;
                        }

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $pengeluaran,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbkas->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();
                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            if ($bbesarpen->akun->saldo_normal == 'debit') {
                            $pengeluaranpen = $bbesarpen->saldo + $request->nominal;
                            }
                            
                            else if ($bbesarpen->akun->saldo_normal == 'kredit') {
                                $pengeluaranpen = $bbesarpen->saldo - $request->nominal;
                            }

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $pengeluaranpen,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbkaspen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
            }

            // Retur Penjualan Tunai
            else if ($trans->status == 'retur_penjualan' && $trans->jenis_pembayaran == 'tunai') {

                // Ada Pajak
                if ($trans->nominal_ppn != 0) {
                    $data = array(
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $ppn_keluaran = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 9,
                                'kredit' => NULL,
                                'debit' => $request->nominal_ppn,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => $request->nominal + $request->nominal_ppn,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );   

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo - $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'saldo' => $bbkas->saldo - ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbppnpen->saldo - $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal + $request->nominal_ppn,
                                        'saldo' => $bbkaspen->saldo - ($request->nominal + $request->nominal_ppn),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Tidak Ada Pajak
                if ($trans->nominal_ppn == 0) {
                    $data = array(
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 1,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbkas->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesarpen->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => 1,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbkaspen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }  
                }    
            }

            // Retur Penjualan Kredit
            else if ($trans->status == 'retur_penjualan' && $trans->jenis_pembayaran == 'kredit') {

                // Ada Pajak
                if ($trans->nominal_ppn != 0) {
                    $data = array(
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $ppn_keluaran = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 9,
                                'kredit' => NULL,
                                'debit' => $request->nominal_ppn,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $piutang_usaha = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 3,
                                'kredit' => $request->nominal + $request->nominal_ppn,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo - $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 3,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'saldo' => $bbpiutangusaha->saldo - ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => $request->nominal,
                                            'kredit' => NULL,
                                            'saldo' => $bbesarpen->saldo + $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 9,
                                            'debit' => $request->nominal_ppn,
                                            'kredit' => NULL,
                                            'saldo' => $bbppnpen->saldo - $request->nominal_ppn,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 3,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal + $request->nominal_ppn,
                                            'saldo' => $bbpiutangusahapen->saldo - ($request->nominal + $request->nominal_ppn),
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                            );
                            Bukubesarpenyesuaian::insert($bbpen);
                        }

                }

                // Tidak Ada Pajak
                if ($trans->nominal_ppn == 0) {
                    $data = array(
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $piutang_usaha = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 3,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 3,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbpiutangusaha->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpiutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',3)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => $request->nominal,
                                            'kredit' => NULL,
                                            'saldo' => $bbesarpen->saldo + $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 3,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal,
                                            'saldo' => $bbpiutangusahapen->saldo - $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }    
            }

            // Retur Pembelian Tunai
            else if ($trans->status == 'retur_pembelian' && $trans->jenis_pembayaran == 'tunai') {

                // Ada Pajak
                if ($trans->nominal_ppn != 0) {
                    $data = array(
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => NULL,
                                'debit' => $request->nominal + $request->nominal_ppn,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $ppn_masukan = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 9,
                                'kredit' => $request->nominal_ppn,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );    

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal + $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo - $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();


                            $bbpen = array(
                                        array(
                                            'id_akun' => 1,
                                            'debit' => $request->nominal + $request->nominal_ppn,
                                            'kredit' => NULL,
                                            'saldo' => $bbkaspen->saldo + ($request->nominal + $request->nominal_ppn),
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal,
                                            'saldo' => $bbesarpen->saldo - $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => 9,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal_ppn,
                                            'saldo' => $bbppnpen->saldo - $request->nominal_ppn,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Tidak Ada Pajak
                if ($trans->nominal_ppn == 0) {
                    $data = array(
                                $kas = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 1,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    ); 

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 1,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbkas->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbkaspen = Bukubesarpenyesuaian::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                        array(
                                            'id_akun' => 1,
                                            'debit' => $request->nominal,
                                            'kredit' => NULL,
                                            'saldo' => $bbkaspen->saldo + $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal,
                                            'saldo' => $bbesarpen->saldo - $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        } 
                }    
            }

            // Retur Pembelian Kredit
            else if ($trans->status == 'retur_pembelian' && $trans->jenis_pembayaran == 'kredit') {

                // Ada Pajak
                if ($trans->nominal_ppn != 0) {
                    $data = array(
                                $utang_usaha =  array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 4,
                                'kredit' => NULL,
                                'debit' => $request->nominal + $request->nominal_ppn,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $ppn_masukan = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 9,
                                'kredit' => $request->nominal_ppn,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutangusaha = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 4,
                                    'debit' => $request->nominal + $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbutangusaha->saldo + ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                               ),
                                array(
                                    'id_akun' => 9,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo - $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbppnpen = Bukubesarpenyesuaian::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                        array(
                                        'id_akun' => 4,
                                        'debit' => $request->nominal + $request->nominal_ppn,
                                        'kredit' => NULL,
                                        'saldo' => $bbutangusahapen->saldo + ($request->nominal + $request->nominal_ppn),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                                    array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesarpen->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                   ),
                                    array(
                                        'id_akun' => 9,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal_ppn,
                                        'saldo' => $bbppnpen->saldo - $request->nominal_ppn,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'keterangan' => $request->status,
                                    ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }

                // Tidak Ada Pajak
                if ($trans->nominal_ppn == 0) {
                    $data = array(
                                $utang_usaha =  array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 4,
                                'kredit' => NULL,
                                'debit' => $request->nominal,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                                $akun_bb = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => $request->id_akun,
                                'kredit' => $request->nominal,
                                'debit' => NULL,
                                'tgl' => $request->tgl,
                                'keterangan' => $request->keterangan,
                                'created_at' => Carbon::now(),
                                'updated_at' => null,
                                ),
                    );

                        // MASUKKAN KE BUKU BESAR
                        $bbesar = Bukubesar::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutangusaha = Bukubesar::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 4,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbutangusaha->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbesar->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        if (Bukubesar::insert($bb)) {

                            $bbesarpen = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbutangusahapen = Bukubesarpenyesuaian::where('id_akun','=',4)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            $bbpen = array(
                                        array(
                                            'id_akun' => 4,
                                            'debit' => $request->nominal,
                                            'kredit' => NULL,
                                            'saldo' => $bbutangusahapen->saldo + $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => NULL,
                                            'kredit' => $request->nominal,
                                            'saldo' => $bbesarpen->saldo - $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                            'keterangan' => $request->status,
                                        ),
                            );

                            Bukubesarpenyesuaian::insert($bbpen);
                        }
                }    
            }
        }

        if (Jurnalumum::insert($data)) {
            if ($request->umur_ekonomis != 0) {
                $transpenyusutan = new Transbaru;
                $transpenyusutan->id_akun = $request->id_akun;
                $transpenyusutan->id_user = $request->id_user;
                $transpenyusutan->tgl = date('j/m/Y', strtotime('last day of this month', time()));
                $transpenyusutan->keterangan = $request->keterangan;
                $transpenyusutan->nominal = $request->beban_penyusutan;

                if ($transpenyusutan->save()) {

                    $datapenyusutan = array(
                                array(
                                    'id_transbaru' => $transpenyusutan->id,
                                    'id_akun' => $request->id_akun_debit,
                                    'tgl' => date('j/m/Y', strtotime('last day of this month', time())),
                                    'keterangan' => $request->keterangan,
                                    'debit' => $request->beban_penyusutan,
                                    'kredit' => NULL,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ),
                                array(
                                    'id_transbaru' => $transpenyusutan->id,
                                    'id_akun' => $request->id_akun_kredit,
                                    'tgl' => date('j/m/Y', strtotime('last day of this month', time())),
                                    'keterangan' => $request->keterangan,
                                    'debit' => NULL,
                                    'kredit' => $request->beban_penyusutan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                )
                    );
                    
                    if (Jurnalpenyesuaian::insert($datapenyusutan)) {
                        $bbesar1 = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun_debit)->orderBy('id','DESC')->limit(1)->firstOrFail();
                    
                        $bbesar2 = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun_kredit)->orderBy('id','DESC')->limit(1)->firstOrFail();

                            if ($bbesar2->akun->saldo_normal == 'debit') {
                                    $bbpenyusutan = array(
                                            $bb1 = array(
                                                'id_akun' => $request->id_akun_debit,
                                                'debit' => $request->beban_penyusutan,
                                                'kredit' => NULL,
                                                'saldo' => $bbesar1->saldo + $request->beban_penyusutan,
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ),
                                            $bb2 = array(
                                                'id_akun' => $request->id_akun_kredit,
                                                'debit' => $request->beban_penyusutan,
                                                'kredit' => NULL,
                                                'saldo' => $bbesar2->saldo - $request->beban_penyusutan,
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ),
                                    );
                            }
                            
                            else if($bbesar2->akun->saldo_normal == 'kredit')
                            {
                                    $bbpenyusutan = array(
                                            $bb1 = array(
                                                'id_akun' => $request->id_akun_debit,
                                                'debit' => $request->beban_penyusutan,
                                                'kredit' => NULL,
                                                'saldo' => $bbesar1->saldo + $request->beban_penyusutan,
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ),
                                            $bb2 = array(
                                                'id_akun' => $request->id_akun_kredit,
                                                'debit' => NULL,
                                                'kredit' => $request->beban_penyusutan,
                                                'saldo' => $bbesar2->saldo + $request->beban_penyusutan,
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ),
                                    );
                            }

                        Bukubesarpenyesuaian::insert($bbpenyusutan);
                    }
                }
            }
        }

       	return redirect('/jasa/jurnal-umum')->with('success','Transaksi berhasil ditambahkan');
        
    }
}