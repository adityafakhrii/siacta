<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unitusaha extends Model
{
    use HasFactory;
    protected $unitusahas = 'unitusahas';
    protected $fillable = ['id','jenis'];

    public function user(){	
    	return $this->hasMany('App\Models\User','id_unitusaha');
    }
}
