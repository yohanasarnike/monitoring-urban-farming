<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaTanaman extends Model
{
    protected $table = 'kriteria_tanaman';
    protected $primaryKey = 'id_tanaman';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [
        'nama_tanaman',
        'usia_panen',
        'pH_min',
        'pH_max',
        'suhu_min',
        'suhu_max',
    ];
}