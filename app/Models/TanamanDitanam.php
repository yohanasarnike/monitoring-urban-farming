<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanamanDitanam extends Model
{
    protected $table = 'tanaman_ditanam';
    protected $primaryKey = 'id_tanaman_ditanam';
    public $timestamps = false;

    protected $fillable = [
        'id_pemilik_tanaman',
        'jenis_bibit',
        'tinggi_awal',
        'jenis_lahan',
        'tanggal_tanam',
        'lokasi_tanam',
    ];

    public function perawatan()
    {
        return $this->hasMany(Perawatan::class, 'id_tanaman_ditanam', 'id_tanaman_ditanam');
    }
}

