<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Akun;
use App\Models\Jurnalumum;
use App\Models\Neracasaldoawal;
use App\Models\Neracasaldo;
use App\Models\Bukubesar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class TransaksiController extends Controller
{
    public function index(){

    	$transaksi = Transaksi::all();

    	return view('admin.transaksi.transaksi');
    }

    public function create(){

    	$akuns = Akun::where('id_user','=',Auth::user()->id)
        ->orderBy('no_akun','asc')->get();

    	return view('admin.transaksi.tambah-transaksi',compact('akuns'));
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
                                $ns = array(
                                        array(
                                            'id_akun' => 1,
                                            'debit' => $bbkas->saldo + $request->nominal,
                                            'kredit' => NULL,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                        ),
                                        array(
                                            'id_akun' => $request->id_akun,
                                            'debit' => NULL,
                                            'kredit' => $bbesar->saldo - $request->nominal,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                        ),
                                );
                            Neracasaldo::insert($ns);
                        }

                        // Bukubesar::insert($bb);
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
                                    'id_akun' => 349,
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

                        $bbdiskon = Bukubesar::where('id_akun','=',349)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 349,
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

                        Bukubesar::insert($bb);
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
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 349,
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

                        $bbdiskon = Bukubesar::where('id_akun','=',349)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 349,
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
                                    'id_akun' => 9,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );

                        Bukubesar::insert($bb);
                }
            }

            // Penjualan Kredit
            else if ($trans->status == 'penjualan' && $trans->jenis_pembayaran == 'kredit') {

                // Jika tidak ada PAJAK dan tidak ada diskon
                if ($trans->nominal_ppn == 0 && $request->diskon == 0) {
                    $data = array(
                                $piutang_usaha = array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 12,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 12,
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
                        Bukubesar::insert($bb);
                }

                // Jika tidak ada PAJAK dan ada diskon
                else if($trans->nominal_ppn == 0 && $request->diskon != 0){
                        $data = array(
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 12,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 349,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',349)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 12,
                                    'debit' => $request->nominal - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + ($request->nominal - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 349,
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
                        Bukubesar::insert($bb);
                }

                // Jika ada PAJAK dan tidak ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon == 0){
                        $data = array(
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 12,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 12,
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
                                    'id_akun' => 9,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
                }

                // Jika ada PAJAK dan ada diskon
                else if($trans->nominal_ppn != 0 && $request->diskon != 0){
                        $data = array(
                                    $piutang_usaha = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 12,
                                    'kredit' => NULL,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 349,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',349)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 12,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 349,
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
                                    'id_akun' => 9,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                'id_akun' => 12,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 12,
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
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 12,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal - $request->nominal_dp - $request->diskon,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 349,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',349)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 12,
                                    'debit' => $request->nominal_dp - $request->diskon,
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + ($request->nominal_dp - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 349,
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
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 12,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 12,
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
                                    'id_akun' => 9,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 12,
                                    'kredit' => NULL,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon),
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_penjualan = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 349,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',349)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',9)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 12,
                                    'debit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon),
                                    'kredit' => NULL,
                                    'saldo' => $bbpiutangusaha->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp+$request->diskon)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 349,
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
                                    'id_akun' => 9,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 15,
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

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();


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
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();


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
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 14,
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

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();


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
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 350,
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
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

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
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 350,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
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
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
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
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 14,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);

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
                                    'id_akun' => 13,
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
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbkas = Bukubesar::where('id_akun','=',1)->orderBy('id','DESC')->limit(1)->firstOrFail(); 
                        
                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
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
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 15,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'saldo' => $bbkas->saldo - (($request->nominal + $request->nominal_ppn) - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => $request->nominal - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->nominal_pph23,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph23,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->diskon - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => $request->nominal - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->nominal_pph22,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon - $request->nominal_pph22,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->diskon - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal - $request->diskon),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal - $request->diskon,
                                    'saldo' => $bbutang->saldo + ($request->nominal - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbutang->saldo + $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->diskon,
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - $request->diskon),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 16,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'saldo' => $bbutang->saldo + ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph22)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph22,
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - $request->nominal_pph22),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->diskon + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
                                    'kredit' => NULL,
                                    'debit' => $request->nominal_ppn,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $utang_usaha =  array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail(); 

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - $request->nominal_pph23,
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - $request->nominal_pph23),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
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
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22)),
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
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph22),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph22 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 14,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph22 = Bukubesar::where('id_akun','=',14)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
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
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 14,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph22,
                                    'saldo' => $bbpph22->saldo + $request->nominal_pph22,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
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
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->nominal_pph23)),
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
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23)),
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
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
                                    'kredit' => $request->diskon,
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $pph23 = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 15,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
                        $bbpph23 = Bukubesar::where('id_akun','=',15)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon + $request->nominal_pph23)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 15,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_pph23,
                                    'saldo' => $bbpph23->saldo + $request->nominal_pph23,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
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
                                    'id_akun' => 16,
                                    'debit' => NULL,
                                    'kredit' => ($request->nominal) - ($request->nominal_dp + $request->diskon),
                                    'saldo' => $bbutang->saldo + (($request->nominal) - ($request->nominal_dp + $request->diskon)),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 16,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 16,
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
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 16,
                                    'kredit' => ($request->nominal + $request->nominal_ppn) - ($request->nominal_dp + $request->diskon),
                                    'debit' => NULL,
                                    'tgl' => $request->tgl,
                                    'keterangan' => $request->keterangan,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => null,
                                    ),
                                    $potongan_pembelian = array(
                                    'id_transaksi' => $trans->id,
                                    'id_akun' => 350,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbdiskon = Bukubesar::where('id_akun','=',350)->orderBy('id','DESC')->limit(1)->firstOrFail();
                        
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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
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
                                    'id_akun' => 350,
                                    'debit' => NULL,
                                    'kredit' => $request->diskon,
                                    'saldo' => $bbdiskon->saldo + $request->diskon,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                    'id_akun' => 13,
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
                                    'id_akun' => 16,
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

                        $bbutang = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => $request->nominal_ppn,
                                    'kredit' => NULL,
                                    'saldo' => $bbppn->saldo + $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                array(
                                    'id_akun' => 16,
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
                        Bukubesar::insert($bb);
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
                        Bukubesar::insert($bb);
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

                        $bb = array(
                                array(
                                    'id_akun' => $request->id_akun,
                                    'debit' => $request->nominal,
                                    'kredit' => NULL,
                                    'saldo' => $bbesar->saldo - $request->nominal,
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
                        Bukubesar::insert($bb);
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
                        Bukubesar::insert($bb);

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
                        Bukubesar::insert($bb);   
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
                                'id_akun' => 12,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 12,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal + $request->nominal_ppn,
                                    'saldo' => $bbpiutangusaha->saldo - ($request->nominal + $request->nominal_ppn),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);

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
                                'id_akun' => 12,
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

                        $bbpiutangusaha = Bukubesar::where('id_akun','=',12)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 12,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal,
                                    'saldo' => $bbpiutangusaha->saldo - $request->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                                'id_akun' => 13,
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

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

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
                                    'id_akun' => 13,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo - $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                        );
                        Bukubesar::insert($bb);
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
                        Bukubesar::insert($bb);  
                }    
            }

            // Retur Pembelian Kredit
            else if ($trans->status == 'retur_pembelian' && $trans->jenis_pembayaran == 'kredit') {

                // Ada Pajak
                if ($trans->nominal_ppn != 0) {
                    $data = array(
                                $utang_usaha =  array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 16,
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
                                'id_akun' => 13,
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

                        $bbutangusaha = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bbppn = Bukubesar::where('id_akun','=',13)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 16,
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
                                    'id_akun' => 13,
                                    'debit' => NULL,
                                    'kredit' => $request->nominal_ppn,
                                    'saldo' => $bbppn->saldo - $request->nominal_ppn,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                    'keterangan' => $request->status,
                                ),
                                
                        );
                        Bukubesar::insert($bb);
                }

                // Tidak Ada Pajak
                if ($trans->nominal_ppn == 0) {
                    $data = array(
                                $utang_usaha =  array(
                                'id_transaksi' => $trans->id,
                                'id_akun' => 16,
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

                        $bbutangusaha = Bukubesar::where('id_akun','=',16)->orderBy('id','DESC')->limit(1)->firstOrFail();

                        $bb = array(
                                array(
                                    'id_akun' => 16,
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
                        Bukubesar::insert($bb);
                }    
            }
        }

        if (Jurnalumum::insert($data)) {
            
        }

       	return redirect('/jurnal-umum')->with('success','Transaksi berhasil ditambahkan');
        
    }
}