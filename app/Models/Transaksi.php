<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'total_harga',
        'bayar',
        'kembali'
    ];

    // TAMBAHKAN RELASI INI
    public function gudangs()
    {
        return $this->belongsToMany(Gudang::class, 'penjualans')
                    ->withPivot('jumlah', 'subtotal')
                    ->withTimestamps();
    }
}