<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = "customers";

    protected $primaryKey = 'id_customer';
    
    protected $fillable = ['nama_customer', 'no_ktp', 'no_hp', 'alamat'];
}
