<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_identitas',
        'no_hp',
        'id_wisata',
        'tanggal_kunjungan',
        'dewasa',
        'anak',
        'total_bayar'
    ];

}
