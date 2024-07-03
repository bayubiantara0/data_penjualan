<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kopi = Barang::where('nama', 'Kopi')->first();
        $teh = Barang::where('nama', 'Teh')->first();
        $pastaGigi = Barang::where('nama', 'Pasta Gigi')->first();
        $sabunMandi = Barang::where('nama', 'Sabun Mandi')->first();
        $sampo = Barang::where('nama', 'Sampo')->first();
    
        DB::table('transaksis')->insert([
            ['barang_id' => $kopi->id, 'jumlah_terjual' => 10, 'tanggal_transaksi' => '2021-05-01'],
            ['barang_id' => $teh->id, 'jumlah_terjual' => 19, 'tanggal_transaksi' => '2021-05-05'],
            ['barang_id' => $kopi->id, 'jumlah_terjual' => 15, 'tanggal_transaksi' => '2021-05-10'],
            ['barang_id' => $pastaGigi->id, 'jumlah_terjual' => 20, 'tanggal_transaksi' => '2021-05-11'],
            ['barang_id' => $sabunMandi->id, 'jumlah_terjual' => 30, 'tanggal_transaksi' => '2021-05-11'],
            ['barang_id' => $sampo->id, 'jumlah_terjual' => 25, 'tanggal_transaksi' => '2021-05-12'],
            ['barang_id' => $teh->id, 'jumlah_terjual' => 5, 'tanggal_transaksi' => '2021-05-12'],
        ]);
    }
}
