<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pemilik extends Authenticatable
{
    protected $table = 'pemilik_tanaman';

    protected $primaryKey = 'id_pemilik_tanaman';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'email',
        'PASSWORD',
        'ROLE',
        'google_id',
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
