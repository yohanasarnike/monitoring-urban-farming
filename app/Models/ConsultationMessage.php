<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';
    protected $primaryKey = 'id_konsultasi';
    public $timestamps = false; // Karena menggunakan kolom waktu_konsultasi manual

    protected $fillable = [
        'id_pemilik_tanaman',
        'pertanyaan_konsultasi',
        'jawaban_konsultasi',
        'waktu_konsultasi',
        'status',
    ];
}