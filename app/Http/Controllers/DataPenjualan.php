<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPenjualan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Menggunakan query builder sebelum dieksekusi
        $query = Barang::join('transaksis', function (JoinClause $join) {
            $join->on('transaksis.barang_id', '=', 'barangs.id');
        })
        ->join('jenis_barangs', function (JoinClause $join) {
            $join->on('jenis_barangs.id', '=', 'barangs.jenis_barang_id');
        })
        ->select(
            'barangs.nama as namabarang',
            'transaksis.sisa_stok',
            'transaksis.jumlah_terjual',
            'transaksis.tanggal_transaksi',
            'jenis_barangs.nama as jenisbarang',
            'transaksis.id',
        );

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('barangs.nama', 'like', '%' . $request->search . '%')
                  ->orWhere('transaksis.tanggal_transaksi', 'like', '%' . $request->search . '%');
            });
        }

        // Fitur Pengurutan
        if ($request->filled('sort_by')) {
            $query->orderBy($request->sort_by, $request->sort_order ?? 'asc');
        } else {
            $query->orderBy('transaksis.tanggal_transaksi', 'asc');
        }

        // Filter Rentang Waktu
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaksis.tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        $datapenjualan = $query->get();
        $no = 1;

        // Data Transaksi Terbanyak dengan Filter Tanggal
        $queryTerbanyak = Barang::join('transaksis', function (JoinClause $join) {
            $join->on('transaksis.barang_id', '=', 'barangs.id');
        });

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $queryTerbanyak->whereBetween('transaksis.tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        $transaksiTerbanyak = $queryTerbanyak->select(
            'barangs.nama as namabarang',
            'transaksis.jumlah_terjual'
        )
        ->orderBy('transaksis.jumlah_terjual', 'desc')
        ->first();

        // Data Transaksi Terendah dengan Filter Tanggal
        $queryTerendah = Barang::join('transaksis', function (JoinClause $join) {
                $join->on('transaksis.barang_id', '=', 'barangs.id');
            });

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $queryTerendah->whereBetween('transaksis.tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        $transaksiTerendah = $queryTerendah->select(
            'barangs.nama as namabarang',
            'transaksis.jumlah_terjual'
        )
        ->orderBy('transaksis.jumlah_terjual', 'asc')
        ->first();

        return view('data_penjualan.datapenjualan', compact('datapenjualan', 'no', 'transaksiTerbanyak', 'transaksiTerendah'));

    }

    public function index_add()
    {
        $databarang = Barang::orderBy('id','asc')->get();
        return view('data_penjualan.datapenjualan_add',
        [
            'title' => 'Serikat',
            'databarang' => $databarang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nmbarang' => 'required',
            'sstok' => 'required',
            'jmjual' => 'required',
            'tgltrans' => 'required',
        ]);

        $masterundangundang = new Transaksi();
        $masterundangundang->barang_id = $request->nmbarang;
        $masterundangundang->jumlah_terjual = $request->jmjual;
        $masterundangundang->sisa_stok = $request->sstok;
        $masterundangundang->tanggal_transaksi = $request->tgltrans;
        $masterundangundang->created_at = date('Y-m-d');
        $masterundangundang->save();
             
        return redirect()->route('datapenjualan.index')
                        ->with('success','Sukses tambah data penjualan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Barang::join('transaksis', function (JoinClause $join) {
            $join->on('transaksis.barang_id', '=', 'barangs.id');
            })
            ->join('jenis_barangs', function (JoinClause $join) {
                $join->on('jenis_barangs.id', '=', 'barangs.jenis_barang_id');
            })
            ->select(
                'barangs.nama as namabarang',
                'transaksis.sisa_stok',
                'transaksis.jumlah_terjual',
                'transaksis.tanggal_transaksi',
                'jenis_barangs.nama as jenisbarang',
                'transaksis.id',
            )
            ->where('transaksis.id', $id)
            ->first();

        // $data = Transaksi::find($id);
        
        echo json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transaksi::find($id);
        $databarang = Barang::orderBy('id','asc')->get();
        return view('data_penjualan.datapenjualan_edit',
        [
            'datapnj' => $data,
            'databarang' => $databarang
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->edt_id;

        $data = [
            'barang_id' => $request->edt_nmbarang,
            'sisa_stok' => $request->edt_sstok,
            'jumlah_terjual' => $request->edt_jmjual,
            'tanggal_transaksi' => $request->edt_tgltrans,
            'updated_at' => date('Y-m-d'),
        ];

        Transaksi::where('id', $id)->update($data);
        return redirect()->route('datapenjualan.index')
                        ->with('success','Sukses ubah data penjualan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaksi::where('id',$id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data penjualan Berhasil Dihapus!.',
        ]); 

        // $penjualan = Transaksi::findOrFail($id);
        // $penjualan->delete();

        // return redirect()->route('datapenjualan.index')->with('success', 'Data penjualan berhasil dihapus');
    }
}
