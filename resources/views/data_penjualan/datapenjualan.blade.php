@extends('layouts.master')

@section('content')

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Penjualan</h5>

              @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif


              <a href="/datapenjualan/add"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Penjualan</button></a>

              <div class="row mt-2 mb-2">
                <div class="col-4 d-flex align-items-end">
                    <form class="search-form d-flex align-items-center" action="{{ route('datapenjualan.index') }}" method="GET">
                        <div class="col-sm-10 px-2">
                            <input type="text" class="form-control" name="search" placeholder="Cari Nama Barang / Tanggal" value="{{ request('search') }}">
                        </div>
                      <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                  </form>
                </div>
                <div class="col-8">
                    <form action="{{ route('datapenjualan.index') }}" method="GET">
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="start_date">Mulai Tanggal:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-sm-5">
                                <label for="end_date">Sampai Tanggal:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-sm-2 d-flex align-items-end">
                                <button class="btn btn-primary btn-sm" type="submit">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
  
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>
                            <a href="{{ route('datapenjualan.index', ['sort_by' => 'namabarang', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
                                Nama Barang
                            </a>
                        </th>
                        <th>Stok</th>
                        <th>Jumlah Terjual</th>
                        <th>
                            <a href="{{ route('datapenjualan.index', ['sort_by' => 'tanggal_transaksi', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
                                Tanggal Transaksi
                            </a>
                        </th>
                        <th>Jenis Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datapenjualan as $row)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $row->namabarang }}</td>
                            <td>{{ $row->sisa_stok }}</td>
                            <td>{{ $row->jumlah_terjual }}</td>
                            <td>{{ $row->tanggal_transaksi }}</td>
                            <td>{{ $row->jenisbarang }}</td>
                            <td>
                                <span class="badge bg-light text-dark" onclick="viewdata({{$row->id}})" style="font-size: 13px;cursor:pointer"><i class="bi bi-eye-fill me-1"></i></span>
                                <a href="{{ route('datapenjualan.edit',$row->id)}}"><span class="badge bg-warning text-dark" style="font-size: 13px;cursor:pointer"><i class="bi bi-pencil-square me-1"></i></span></a>
                                <span class="badge bg-danger text-white" onclick="deletepenjualan({{$row->id}})" style="font-size: 13px;cursor:pointer"><i class="bi bi-trash-fill me-1"></i></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                    <div class="card-body">
                        <h5 class="card-title">Transaksi Terbanyak</h5>

                        <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                                @if($transaksiTerbanyak)
                                    <h6>
                                    {{ $transaksiTerbanyak->jumlah_terjual }}
                                    </h6>
                                    <span class="text-success small pt-1 fw-bold">{{ $transaksiTerbanyak->namabarang }}</span>
                                @else
                                    <h6>
                                        Tidak ada data transaksi.
                                    </h6>
                                @endif
                        </div>
                        </div>
                    </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                    <div class="card-body">
                        <h5 class="card-title">Transaksi Terendah</span></h5>

                        <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            @if($transaksiTerendah)
                                <h6>
                                {{ $transaksiTerendah->jumlah_terjual }}
                                </h6>
                                <span class="text-success small pt-1 fw-bold">{{ $transaksiTerendah->namabarang }}</span>
                            @else
                                <h6>
                                    Tidak ada data transaksi.
                                </h6>
                            @endif

                        </div>
                        </div>
                    </div>

                    </div>
                </div><!-- End Revenue Card -->

                </div>
            </div><!-- End Left side columns -->


            </div>
          </div>

        </div>
    </div>
</section>

<div class="modal fade" id="modalview" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size: 13px;">View Data Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 label " style="font-size: 13px;">Nama Barang</div>
                    <div class="col-lg-1 col-md-4 label " style="font-size: 13px;">:</div>
                    <div class="col-lg-7 col-md-8" name="nmbarang" style="font-size: 13px;"></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 label " style="font-size: 13px;">Sisa Stok</div>
                    <div class="col-lg-1 col-md-4 label " style="font-size: 13px;">:</div>
                    <div class="col-lg-7 col-md-8" name="ssstok" style="font-size: 13px;"></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 label " style="font-size: 13px;">Jumlah Terjual</div>
                    <div class="col-lg-1 col-md-4 label " style="font-size: 13px;">:</div>
                    <div class="col-lg-7 col-md-8" name="jmterjual" style="font-size: 13px;"></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 label " style="font-size: 13px;">Tanggal Transaksi</div>
                    <div class="col-lg-1 col-md-4 label " style="font-size: 13px;">:</div>
                    <div class="col-lg-7 col-md-8" name="tgtransaksi" style="font-size: 13px;"></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 label " style="font-size: 13px;">Jenis Barang</div>
                    <div class="col-lg-1 col-md-4 label " style="font-size: 13px;">:</div>
                    <div class="col-lg-7 col-md-8" name="jnsbrg" style="font-size: 13px;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 13px;">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

    
<script src="{{asset('components/datapenjualan.js')}}"></script>
@endsection