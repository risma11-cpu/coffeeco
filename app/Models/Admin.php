<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        // Password otomatis di-hash saat disimpan
        return ['password' => 'hashed'];
    }

    /**
     * Tabel admins tidak punya kolom remember_token,
     * jadi fitur "ingat saya" dimatikan.
     */
    public function getRememberTokenName()
    {
        return '';
    }
}