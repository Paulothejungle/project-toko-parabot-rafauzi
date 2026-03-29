<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'pesanan_id',
        'tanggal_transaksi',
        'total_harga',
        'status_transaksi',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
