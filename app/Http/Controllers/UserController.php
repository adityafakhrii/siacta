<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Unitusaha;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use DB;
use Session;

class UserController extends Controller
{
    public function landing(){
        return view('landing.index');
    }

    public function login(){
    	return view('admin.login');
    }

    public function do_login(Request $request){
    	if (Auth::attempt($request->only('email','password'))) {
    		return redirect('/dashboard');
    	}else{
    		return redirect('/login')->with('fail','gagal');
    	}
    }

    public function logout(){
    	Auth::logout();

    	return redirect('/login');
    }

    public function dashboard(){

        $labarugi_pendapatan = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','8%')
                        ->where(function($query){
                            $query->where('no_akun','!=','81.06.00');
                            $query->orWhere('no_akun','!=','81.07.00');
                            $query->orWhere('no_akun','!=','81.05.00');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();

        $labarugi_beban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','9%')
                        ->Where(function($query){
                            $query->where('no_akun','!=','91.01.02');
                            $query->orWhere('no_akun','!=','91.01.03');
                            $query->orWhere('no_akun','!=','91.01.04');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();

        $pajaks = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','92.14.00')
                        ->get();
        
        $total_pendapatan = 0;
        foreach ($labarugi_pendapatan as $lr) {
            $total_pendapatan += $lr->saldo;
        }

        $total_beban = 0;
        foreach ($labarugi_beban as $lb) {
            $total_beban += $lb->saldo;
        }

    	return view('admin.akun.index',compact('total_pendapatan','total_beban','pajaks'));
    }

    public function register(){
    	$unitusaha = Unitusaha::all();
    	return view('admin.register',compact('unitusaha'));
    }

    public function do_registrasi(Request $request){
    	$user = new User;
    	$user->nama = $request->nama;
    	$user->email = $request->email;
    	$user->password = Hash::make($request->password);
    	$user->role = 'unitusaha';
    	$user->id_unitusaha = $request->id_unitusaha;
    	$user->save();

    	Session::put('nama',$user->nama);
    	return redirect('/registrasi-pengguna')->with('succes','');
    }


    //BUMDES
    public function unit(){

        $unit = Anggota::whereHas('user',function($query){
            $query->where('role','=','unitusaha');
        })->get();

        return view('bumdes.user.userunit',compact('unit'));
    }

    public function addUnit(){
        $jenis = Unitusaha::all();
        return view('bumdes.user.add',compact('jenis'));
    }

    public function storeUnit(Request $request){

        $user = new User;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'unitusaha';
        $user->id_unitusaha = $request->id_unitusaha;
        $user->status_neracaawal = 'belum_final';
        $user->status_calk = 'null';
        

        if ($user->save()) {
            $anggota = new Anggota;
            $anggota->id_user = $user->id;
            $anggota->id_unitusaha = $request->id_unitusaha;
            $anggota->nama = $request->nama;
            $anggota->npwp = $request->npwp;
            $anggota->nama_unit = $request->nama_unit;
            $anggota->no_telfon = $request->no_telfon;

            $anggota->save();
        }

        Session::put('nama',$user->nama);
        return redirect('/data-unit')->with('succes','');
    }





    //SUPER ADMIN
    public function bumdes(){

        $bumdes = Anggota::whereHas('user',function($query){
            $query->where('role','=','bumdes');
        })->get();

        return view('superadmin.userbumdes',compact('bumdes'));
    }

    public function addBumdes(){
        return view('superadmin.add');
    }

    public function storeBumdes(Request $request){

        $user = new User;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'bumdes';
        $user->id_unitusaha = NULL;
        $user->status_neracaawal = NULL;
        $user->status_calk = NULL;
        

        if ($user->save()) {
            $anggota = new Anggota;
            $anggota->id_user = $user->id;
            $anggota->id_unitusaha = NULL;
            $anggota->nama = $request->nama;
            $anggota->npwp = $request->npwp;
            $anggota->nama_unit = $request->nama_unit;
            $anggota->no_telfon = $request->no_telfon;

            $anggota->save();
        }

        Session::put('nama',$user->nama);
        return redirect('/data-bumdes')->with('succes','');
    }

}
