<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'tanggal_pesanan',
        'status_pesanan',
        'alamat_pengiriman',
        'metode_pembayaran',
        'jasa_pengiriman',
        'bukti_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
