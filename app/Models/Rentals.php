<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
    protected $table = 'rentals';

    protected $primaryKey = 'id_rental';

    protected $fillable = [
        'customer_id',
        'car_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status',
    ];

    public function customer() {
        return $this->belongsTo(Customers::class, 'customer_id', 'id_customer');
    }

    public function car() {
        return $this->belongsTo(Cars::class, 'car_id', 'id_cars');
    }

    public function payment() {
        return $this->hasOne(Payment::class, 'rental_id', 'id_rental');
    }
}
