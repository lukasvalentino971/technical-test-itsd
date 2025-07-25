<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use Notifiable;

    protected $table = 'vendors'; // pastikan sesuai nama tabel

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role'// sesuaikan dengan kolom di tabel vendors
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}

