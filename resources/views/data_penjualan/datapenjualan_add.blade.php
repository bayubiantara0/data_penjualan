@extends('layouts.master')

@section('content')

<section class="section dashboard" style="font-size: 13px">
    <div class="row">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Tambah Penjualan</h5>

            <!-- Multi Columns Form -->
            <form class="row g-3 needs-validation" action="{{ route('datapenjualan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
              @csrf
              <div class="col-md-6">
                <label for="inputAddress2" class="form-label">Nama Barang</label>
                <select class="form-select" aria-label="Default select example" id="nmbarang" name="nmbarang" style="font-size: 13px" required>
                  <option selected disabled value="">Pilih</option>
                  @foreach ($databarang as $row)
                    <option value="{{$row->id}}">{{$row->nama}}</option>                      
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="inputName5" class="form-label">Sisa Stok</label>
                <input type="number" class="form-control" id="sstok" name="sstok" style="font-size: 13px" required>
              </div>
              <div class="col-md-6">
                <label for="inputName5" class="form-label">Jumlah Terjual</label>
                <input type="number" class="form-control" id="jmjual" name="jmjual" style="font-size: 13px" required>
              </div>
              <div class="col-md-6">
                <label for="inputPassword5" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control" id="tgltrans" name="tgltrans" style="font-size: 13px" required> 
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <button type="reset" class="btn btn-secondary" onclick="history.back(-1)">Batal</button>
              </div>
            </form><!-- End Multi Columns Form -->

          </div>
        </div>
    </div>
</section>
    
<script src="{{asset('components/datapenjualan.js')}}"></script>
@endsection