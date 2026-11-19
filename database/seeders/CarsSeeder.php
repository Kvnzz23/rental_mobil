<?php

namespace Database\Seeders;

use App\Models\Cars;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cars::create([
            'nama_mobil' => 'Avanza',
            'merk' => 'Toyota',
            'tipe' => 'MPV',
            'tahun' => '2023',
            'plat_nomor' => 'AD 1234 AC',
            'harga_sewa' => 350000,
            'status' => 'tersedia'
        ]);
    }
}
