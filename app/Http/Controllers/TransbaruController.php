<?php

namespace App\Http\Controllers;
use App\Models\Akun;
use App\Models\Statuspen;
use App\Models\Jurnalpenyesuaian;
use App\Models\Transbaru;
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

            Jurnalpenyesuaian::insert($data);

            return redirect('/jasa/jurnal-penyesuaian')->with('success','Transaksi berhasil ditambahkan');
        }
    }
}
