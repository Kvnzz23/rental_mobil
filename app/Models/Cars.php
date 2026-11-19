<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $table = 'cars';

    protected $primaryKey = 'id_cars';

    protected $fillable = [
        'nama_mobil',
        'merk',
        'tipe',
        'tahun',
        'plat_nomor',
        'harga_sewa',
        'status',
    ];
}
