@extends('layouts.master')

<title>Tambah Piutang Usaha | SIACTA</title>

@section('content')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Piutang Usaha</h4>
                  <form class="forms-sample" action="/emkm/calk/tambah-piutang/store" method="post">
                    @csrf
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <select class="js-example-basic-single w-100" name="id_akun" required>
                        <option value="" selected disabled>Pilih Akun</option>
                        @foreach($akuns as $akun)

                        <option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="nilai">Saldo</label>
                      <input name="saldo" type="number" class="form-control" id="nilai" placeholder="Masukkan nominal...">
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