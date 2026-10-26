<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pemilik extends Authenticatable
{
    protected $table = 'pemilik_tanaman';

    protected $primaryKey = 'id_pemilik_tanaman';

    protected $fillable = [
        'username',
        'email',
        'PASSWORD',
        'ROLE',
    ];

    protected $hidden = [
        'PASSWORD',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }
}
