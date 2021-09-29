<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $anggotas = 'anggotas';
    protected $fillable = [
        'id_unitusaha',
        'id_user',
        'nama',
        'npwp',
        'nama_unit',
        'no_telfon',
    ]; 

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function unitusaha(){ 
        return $this->belongsTo('App\Models\Unitusaha','id_unitusaha');
    }
}
