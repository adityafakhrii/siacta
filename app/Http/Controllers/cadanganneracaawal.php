<?php

namespace App\Http\Controllers;
use App\Models\Akun;
use App\Models\User;
use App\Models\Bukubesar;
use Auth;
use App\Models\Neracasaldoawal;
use Illuminate\Http\Request;

class NeracasaldoawalController extends Controller
{

    public function index(){

        $neracasaldoawal = Neracasaldoawal::whereHas('akun',function ($query){
            $query->where('id_user','=',Auth::user()->id);
        })
        ->where('debit','!=',0)
        ->orWhere('kredit','!=',0)
        ->orderBy('id_akun','asc')->get();

    	return view('admin.neracasaldoawal.index',compact('neracasaldoawal'));
    }

    public function create(){
    	$akuns = Akun::where('id_user','=',auth()->user()->id)->orderBy('no_akun','asc')->get();

    	return view('admin.neracasaldoawal.tambahneracaawal',compact('akuns'));
    }

    public function store(Request $request)
    {
        $akun = $request->id_akun;
        $cek = Neracasaldoawal::where('id_akun',$akun)->count();
        if ($cek > 0) {
            echo '<script language="javascript">
              alert ("No Akun telah terisi saldo, pilih Akun lain!");
              window.location="/neraca-saldo-awal/tambah";
              </script>';
            exit();
        }
        else{
            $neraca = new Neracasaldoawal;
            $neraca->id_akun = $request->id_akun;

            // if ($request->nominal == 0) {
            //     $neraca->debit = 0;
            //     $neraca->kredit = 0;
            // }

            if ($neraca->akun->saldo_normal == 'debit') {
                $neraca->debit = $request->nominal;
                $neraca->kredit = NULL;
            }elseif ($neraca->akun->saldo_normal == 'kredit') {
                $neraca->debit = NULL;
                $neraca->kredit = $request->nominal;
            }

            $neraca->status = 'belum_final';


            if ($neraca->save()) {

                if ($neraca->akun->status == 'tidak_pen') {
                    $bbesar = new Bukubesar;
                    $bbesar->id_akun = $request->id_akun;
                    if ($neraca->akun->saldo_normal == 'debit') {
                        $bbesar->debit = $request->nominal;
                        $bbesar->kredit = NULL;
                    }
                     elseif ($neraca->akun->saldo_normal == 'kredit') {
                        $bbesar->debit = NULL;
                        $bbesar->kredit = $request->nominal;
                    }
                    $bbesar->saldo = $request->nominal;
                    $bbesar->keterangan = 'Saldo Awal';

                    $bbesar->save(); 
                }

                else if($neraca->akun->status == 'penyesuaian')
                {
                    $bbesar = new Bukubesar;
                    $bbesar->id_akun = $request->id_akun;
                    if ($neraca->akun->saldo_normal == 'debit') {
                        $bbesar->debit = $request->nominal;
                        $bbesar->kredit = NULL;
                    }
                     elseif ($neraca->akun->saldo_normal == 'kredit') {
                        $bbesar->debit = NULL;
                        $bbesar->kredit = $request->nominal;
                    }
                    $bbesar->saldo = $request->nominal;
                    $bbesar->keterangan = 'Saldo Awal';

                    $bbesar->save(); 
                }
                
             };

            $user = User::where('id','=',auth()->user()->id)
                        ->where('status_neracaawal','=',NULL)
                        ->update([
                            'status_neracaawal'=>'belum_final'
            ]);

        }
        
        return redirect('/neraca-saldo-awal')->with('create','Neraca saldo awal berhasil ditambahkan');
    }

    public function confirm(){
        $final = Neracasaldoawal::where('status','belum_final')
        ->update(['status'=>'final']);

        $user = User::where('status_neracaawal','belum_final')
        ->where('id',auth()->user()->id)
        ->update(['status_neracaawal'=>'final']);


        return redirect('/neraca-saldo-awal');
    }

    public function destroy($id){
        $saldoawal = Neracasaldoawal::find($id);
        $saldoawal->delete();
        return redirect('/neraca-saldo-awal')->with('delete','Akun berhasil dihapus');
    }
}
