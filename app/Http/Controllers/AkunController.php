<?php

namespace App\Http\Controllers;
use App\Models\Akun;
use App\Models\Neracasaldoawal;
use App\Models\Bukubesar;
use App\Models\Bukubesarpenyesuaian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    public function index()
    {
        $akuns = Akun::where('id_user','=',auth()->user()->id)->orderBy('no_akun')->get();
        return view('admin.akun.data-akun',compact('akuns'));
    }

    public function create()
    {
        return view('admin.akun.tambah-akun');
    }

    public function store(Request $request)
    {
        $akuns = Akun::create($request->all());

        $saldo = new Neracasaldoawal;
        $saldo->id_akun = $akuns->id;
        if ($akuns->saldo_normal == 'debit') {
            $saldo->debit = 0;
            $saldo->kredit = NULL;
        }
        else if ($akuns->saldo_normal == 'kredit') {
            $saldo->debit = Null;
            $saldo->kredit = 0;
        }
        $saldo->status = 'belum_final';

        if ($saldo->save()) {
            $bbesar = new Bukubesar;
            $bbesar->id_akun = $akuns->id;
            if ($akuns->saldo_normal == 'debit') {
                $bbesar->debit = 0;
                $bbesar->kredit = NULL;
            }
            else if ($akuns->saldo_normal == 'kredit') {
                $bbesar->debit = Null;
                $bbesar->kredit = 0;
            }
            $bbesar->saldo = 0;
            $bbesar->keterangan = 'Saldo Awal';

            if ($bbesar->save()) {
                $bbesarpen = new Bukubesarpenyesuaian;
                $bbesarpen->id_akun = $akuns->id;
                if ($akuns->saldo_normal == 'debit') {
                    $bbesarpen->debit = NULL;
                    $bbesarpen->kredit = NULL;
                }
                else if ($akuns->saldo_normal == 'kredit') {
                    $bbesarpen->debit = NULL;
                    $bbesarpen->kredit = NULL;
                }
                $bbesarpen->saldo = NULL;
                $bbesarpen->keterangan = 'Saldo Awal';

                $bbesarpen->save();
            }
            
        }

        return redirect('/data-akun')->with('create','Akun berhasil ditambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $akun = Akun::find($id);
        return view('admin.akun.edit-akun',compact('akun'));
    }

    public function update(Request $request, $id)
    {
        $akun = Akun::find($id);
        $akun->update($request->all());
        return redirect('/data-akun')->with('update','Akun berhasil diubah');
    }

    public function destroy($id)
    {
        $akun = Akun::find($id);
        $akun->delete();
        return redirect('/data-akun')->with('delete','Akun berhasil dihapus');
    }
}
