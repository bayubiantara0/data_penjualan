@extends('layouts.master')

@section('content')

<section class="section" style="font-size: 13px">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <div class="row card-title">
            <div class="col-md-1 col-lg-1 col-xl-1" style="margin-top:-6px">
              <span class="badge bg-light text-dark" onclick="history.back(-1)" style="font-size: 13px;cursor:pointer"><i class="bi bi-arrow-left-circle-fill me-1"></i></span>
            </div>
            <div class="col-md-8 col-lg-8 col-xl-8">
              <h6 style="font-weight: bold">Edit Serikat</h6>
            </div>
          </div>
          <!-- Multi Columns Form -->
          <!-- Multi Columns Form -->
          <form class="row g-3 needs-validation" action="{{ route('datapenjualan.update') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <input hidden type="text" id="edt_id" name="edt_id" value="{{Request::Segment(3)}}">
            <div class="col-md-6">
              <label for="inputAddress2" class="form-label">Nama Barang</label>
              <select class="form-select" aria-label="Default select example" id="edt_nmbarang" name="edt_nmbarang" value="{{$datapnj->barang_id}}" style="font-size: 13px" required>
                <option selected disabled value="">Pilih</option>
                @foreach ($databarang as $row)
                  <option value="{{$row->id}}" {{ $datapnj->barang_id == $row->id ? 'selected' : '' }}>{{$row->nama}}</option>                      
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="inputName5" class="form-label">Sisa Stok</label>
              <input type="number" class="form-control" id="edt_sstok" name="edt_sstok" value="{{$datapnj->sisa_stok}}" style="font-size: 13px" required>
            </div>
            <div class="col-md-6">
              <label for="inputName5" class="form-label">Jumlah Terjual</label>
              <input type="number" class="form-control" id="edt_jmjual" name="edt_jmjual" value="{{$datapnj->jumlah_terjual}}" style="font-size: 13px" required>
            </div>
            <div class="col-md-6">
              <label for="inputPassword5" class="form-label">Tanggal Transaksi</label>
              <input type="date" class="form-control" id="edt_tgltrans" name="edt_tgltrans" value="{{$datapnj->tanggal_transaksi}}" style="font-size: 13px" required> 
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Ubah</button>
              <button type="reset" class="btn btn-secondary" onclick="history.back(-1)">Batal</button>
            </div>
          </form><!-- End Multi Columns Form -->
        </div>
      </div>

    </div>
  </div>
</section>
    
@endsection