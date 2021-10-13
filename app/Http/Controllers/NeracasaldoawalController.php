<?php

namespace App\Http\Controllers;
use App\Models\Akun;
use App\Models\User;
use App\Models\Bukubesar;
use App\Models\Bukubesarpenyesuaian;
use Auth;
use PDF;
use App\Models\Neracasaldoawal;
use Illuminate\Http\Request;

class NeracasaldoawalController extends Controller
{

    public function index(){

        if (Auth::user()->status_neracaawal == 'final') {
            $neracasaldoawal = Neracasaldoawal::whereHas('akun',function ($query){
                $query->where('id_user','=',Auth::user()->id);
            })
            ->where('debit','!=','NULL')
            ->orWhere('kredit','!=','NULL')
            ->get();
        }else{
            $neracasaldoawal = Neracasaldoawal::whereHas('akun',function ($query){
                $query->where('id_user','=',Auth::user()->id);
            })
            ->get();
        }

    	return view('admin.neracasaldoawal.index',compact('neracasaldoawal'));
    }

    public function edit($id){
    	// $akuns = Akun::where('id_user','=',auth()->user()->id)->orderBy('no_akun','asc')->get();
        $neraca = Neracasaldoawal::find($id);

    	return view('admin.neracasaldoawal.editneracaawal',compact('neraca'));
    }

    public function update(Request $request,$id)
    {
        $neraca = Neracasaldoawal::find($id);
        if($neraca->akun->saldo_normal == 'debit')
        {
            $neraca->debit = $request->nominal;
        }
        else if($neraca->akun->saldo_normal == 'kredit')
        {
            $neraca->kredit = $request->nominal;
        }
        
        if ($neraca->save()) {
            $bbesar = new Bukubesar;
            $bbesar->id_akun = $neraca->akun->id;
            if ($neraca->akun->saldo_normal == 'debit') {
                $bbesar->debit = $request->nominal;
                $bbesar->kredit = NULL;
            }
            else if ($neraca->akun->saldo_normal == 'kredit') {
                $bbesar->debit = Null;
                $bbesar->kredit = $request->nominal;
            }
            $bbesar->saldo = $request->nominal;
            $bbesar->keterangan = 'Saldo Awal';

            if ($bbesar->save()) {
                $bbesar_pen = new Bukubesarpenyesuaian;
                $bbesar_pen->id_akun = $neraca->akun->id;
                if ($neraca->akun->saldo_normal == 'debit') {
                    $bbesar_pen->debit = $request->nominal;
                    $bbesar_pen->kredit = NULL;
                }
                else if ($neraca->akun->saldo_normal == 'kredit') {
                    $bbesar_pen->debit = Null;
                    $bbesar_pen->kredit = $request->nominal;
                }
                $bbesar_pen->saldo = $request->nominal;
                $bbesar_pen->keterangan = 'Saldo Awal';

                $bbesar_pen->save();
            }
            
        }
        
        return redirect('/neraca-saldo-awal')->with('create','Saldo berhasil ditambahkan');
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

    public function pdf()
    {
        $neracasaldoawal = Neracasaldoawal::whereHas('akun',function ($query){
            $query->where('id_user','=',Auth::user()->id);
        })
        ->where('debit','!=','NULL')
        ->orWhere('kredit','!=','NULL')
        ->get();

        // $pdf = ;

        return PDF::loadView('admin.neracasaldoawal.exportneracaawal',compact('neracasaldoawal'))->stream('Neraca Saldo Awal - SIACTA.pdf');
    }

}
