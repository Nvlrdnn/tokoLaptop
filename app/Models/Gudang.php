<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_laptop', 'spesifikasi', 'stok', 'harga'];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}