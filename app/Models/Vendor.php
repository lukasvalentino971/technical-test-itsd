<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use Notifiable;

    protected $table = 'vendors'; // pastikan sesuai nama tabel

    protected $fillable = [
        'name', 'email', 'password', // sesuaikan dengan kolom di tabel vendors
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

