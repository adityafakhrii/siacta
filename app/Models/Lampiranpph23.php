<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiranpph23 extends Model
{
    use HasFactory;
    protected $lampiranpph23s = 'lampiranpph23s';
    protected $fillable = ['id','id_user','id_pph23','nama_lampiran','lembar_setoran','lembar_bukti'];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function pph23(){ 
        return $this->belongsTo('App\Models\Pph23','id_pph23');
    }
}
