<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customers::create([
            'nama_customer' => 'Budi Santoso',
            'no_ktp' => '3372012203973',
            'no_hp' => '085123456781',
            'alamat' => 'Jl.Slamet Riyadi'
        ]);
    }
}
