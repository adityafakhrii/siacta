@extends('layouts.master')

<title>Tambah Akumulasi | SIACTA</title>

@section('content')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Akumulasi</h4>
                  <form class="forms-sample" action="/emkm/calk/tambah-akumulasi/store" method="post">
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
                      <input name="jumlah_unit" type="number" class="form-control" id="jumlah" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
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