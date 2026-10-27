<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    protected $table = 'perawatan';
    protected $primaryKey = 'id_jadwal';
    protected $guarded = [];
    public $timestamps = false;

    protected $fillable = [
        'id_pemilik_tanaman',
        'id_tanaman_ditanam',
        'tanggal_perawatan',
        'waktu_perawatan',
        'suhu',
        'pH_tanaman',
        'jenis_pupuk',
        'kondisi',
        'tinggi_tanaman',
        'kelembapan',
        'keterangan',
    ];
    public function tanaman(){
        return $this->belongsTo(TanamanDitanam::class, 'id_tanaman_ditanam', 'id_tanaman_ditanam');
    }
}