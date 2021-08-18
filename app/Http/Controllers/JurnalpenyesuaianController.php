<?php
namespace App\Http\Controllers;
use Auth;
use App\Models\Jurnalpenyesuaian;

use Illuminate\Http\Request;

class JurnalpenyesuaianController extends Controller
{
    public function index()
    {
        $jurnalpenyesuaian = Jurnalpenyesuaian::whereHas('transbaru',function ($query){
                $query->where('id_user','=',auth()->user()->id);
            })->orderBy('created_at','DESC')->get();

        return view('admin.jurnalpenyesuaian.jurnal_penyesuaian',compact('jurnalpenyesuaian'));
    }
}
