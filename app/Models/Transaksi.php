<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'transaksis';

    protected $fillable = [
        'barang_id', 'jumlah_terjual','tanggal_transaksi','created_at','updated_at'
    ];
}
