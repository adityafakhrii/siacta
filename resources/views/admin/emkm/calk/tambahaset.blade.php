@extends('layouts.master')

<title>Tambah Aset | SIACTA</title>

@section('content')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Aset</h4>
                  <form class="forms-sample" action="/calk/tambah-aset/store" method="post">
                    @csrf
                    <div class="form-group">
                      <label for="nama">Nama Aset Tetap</label>
                      <input name="nama_aset" type="text" class="form-control" id="nama" placeholder="Masukkan nama...">
                    </div>
                    <div class="form-group">
                      <label for="nilai">Nilai Aset Tetap</label>
                      <input name="nilai_aset" type="number" class="form-control" id="nilai" placeholder="Masukkan nominal...">
                    </div>
                    <div class="form-group">
                      <label for="jumlah">Jumlah Unit</label>
                      <input name="jumlah_unit" type="number" class="form-control" id="jumlah" placeholder="Jumlah Unit...">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ url()->previous() }}" class="btn btn-light">Batal</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        @include('layouts.__footer')
        <!-- partial -->
              </div>
      <!-- main-panel ends -->
      
@endsection