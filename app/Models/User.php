<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pemilik_tanaman';          // Nama tabel di database
    protected $primaryKey = 'id_pemilik_tanaman';  // Primary key custom
    
    public $timestamps = false;                    // Jika tabel tidak punya kolom created_at/updated_at

    protected $fillable = [
        'username',
        'email',
        'PASSWORD',
        'ROLE',
    ];

    protected $hidden = [
        'PASSWORD',
    ];

    // Mengubah default nama kolom password bawaan Laravel (password) menjadi uppercase ('PASSWORD')
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }
}