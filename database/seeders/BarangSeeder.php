<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenisKonsumsi = JenisBarang::where('nama', 'Konsumsi')->first();
        $jenisPembersih = JenisBarang::where('nama', 'Pembersih')->first();

        DB::table('barangs')->insert([
            ['nama' => 'Kopi', 'stok' => 100, 'jenis_barang_id' => $jenisKonsumsi->id],
            ['nama' => 'Teh', 'stok' => 100, 'jenis_barang_id' => $jenisKonsumsi->id],
            ['nama' => 'Pasta Gigi', 'stok' => 100, 'jenis_barang_id' => $jenisPembersih->id],
            ['nama' => 'Sabun Mandi', 'stok' => 100, 'jenis_barang_id' => $jenisPembersih->id],
            ['nama' => 'Sampo', 'stok' => 100, 'jenis_barang_id' => $jenisPembersih->id],
        ]);
    }
}
