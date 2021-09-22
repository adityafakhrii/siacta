<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiranpph22 extends Model
{
    use HasFactory;
    protected $lampiranpph22s = 'lampiranpph22s';
    protected $fillable = ['id','id_user','id_pph22','keterangan'];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function pph21(){ 
        return $this->belongsTo('App\Models\Pph21','id_pph21');
    }
}
