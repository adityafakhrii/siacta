<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'id_unitusaha'
    ];

    public function unitusaha(){ 
        return $this->belongsTo('App\Models\Unitusaha','id_unitusaha');
    }

    public function neracasaldoawal(){ 
        return $this->hasMany('App\Models\Neracasaldoawal','id_user');
    }

    public function transbaru(){ 
        return $this->hasMany('App\Models\Transbaru','id_user');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
