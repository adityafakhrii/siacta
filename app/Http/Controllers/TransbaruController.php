<?php

namespace App\Http\Controllers;
use App\Models\Akun;
use App\Models\Statuspen;
use App\Models\Jurnalpenyesuaian;
use App\Models\Bukubesarpenyesuaian;
use App\Models\Transbaru;
use App\Models\Bukubesar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class TransbaruController extends Controller
{
    public function create()
    {

        $akuns = Akun::where([
                                ['id_user', '=', Auth::user()->id],
                                ['status', '=','penyesuaian'],
                                ['saldo_normal', '=','debit']
                            ])
        ->orderBy('no_akun','asc')->get();

        $akuns_all = Akun::where([
                                ['id_user', '=', Auth::user()->id],
                                ['status', '=','penyesuaian'],
                            ])
        ->orderBy('no_akun','asc')->get();

        return view('admin.transbaru.transbaru',compact('akuns','akuns_all'));
    }

    public function store(Request $request)
    {
        $trans = new Transbaru;
        $trans->id_akun = $request->id_akun;
        $trans->id_user = $request->id_user;
        $trans->tgl = date('j/m/Y', strtotime('last day of this month', time()));
        $trans->keterangan = $request->keterangan;
        $trans->nominal = $request->nominal;

        if ($trans->save()) {

            $data = array(
                        array(
                            'id_transbaru' => $trans->id,
                            'id_akun' => $request->id_akun_penyesuaian,
                            'tgl' => date('j/m/Y', strtotime('last day of this month', time())),
                            'keterangan' => $request->keterangan,
                            'debit' => $request->nominal,
                            'kredit' => NULL,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ),
                        array(
                            'id_transbaru' => $trans->id,
                            'id_akun' => $request->id_akun,
                            'tgl' => date('j/m/Y', strtotime('last day of this month', time())),
                            'keterangan' => $request->keterangan,
                            'debit' => NULL,
                            'kredit' => $request->nominal,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        )
                    );
            if (Jurnalpenyesuaian::insert($data)) {
                $bbesar1 = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun_penyesuaian)->orderBy('id','DESC')->limit(1)->firstOrFail();
            
                $bbesar2 = Bukubesarpenyesuaian::where('id_akun','=',$request->id_akun)->orderBy('id','DESC')->limit(1)->firstOrFail();

                    if ($bbesar2->akun->saldo_normal == 'debit') {
                            $bb = array(
                                    $bb1 = array(
                                        'id_akun' => $request->id_akun_penyesuaian,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesar1->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ),
                                    $bb2 = array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesar2->saldo - $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ),
                            );
                    }
                    
                    else if($bbesar2->akun->saldo_normal == 'kredit')
                    {
                            $bb = array(
                                    $bb1 = array(
                                        'id_akun' => $request->id_akun_penyesuaian,
                                        'debit' => $request->nominal,
                                        'kredit' => NULL,
                                        'saldo' => $bbesar1->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ),
                                    $bb2 = array(
                                        'id_akun' => $request->id_akun,
                                        'debit' => NULL,
                                        'kredit' => $request->nominal,
                                        'saldo' => $bbesar2->saldo + $request->nominal,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ),
                            );
                    }

                Bukubesarpenyesuaian::insert($bb);
            }

            return redirect('/jasa/jurnal-penyesuaian')->with('success','Transaksi berhasil ditambahkan');
        }
    }
}
