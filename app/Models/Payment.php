<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'rental_id',
        'total',
        'tgl_pembayaran',
        'status'
    ];

    public function rental() {
        return $this->belongsTo(Rentals::class, 'rental_id', 'id_rental');
    }
}
