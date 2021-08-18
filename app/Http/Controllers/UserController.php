<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Unitusaha;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Session;

class UserController extends Controller
{
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
    	return view('admin.akun.index');
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

}
