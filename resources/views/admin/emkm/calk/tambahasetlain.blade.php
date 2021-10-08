@extends('layouts.master')

<title>Tambah Aset Lain | SIACTA</title>
@section('content')
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12"> 
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Aset Lain</h4>
                  <form class="forms-sample" action="/calk/tambah-aset-lain/store" method="post">
                    @csrf
                    <div class="form-group">
                      <label for="nama">Pilih Akun</label>
                      <select class="js-example-basic-single w-100" name="id_akun" required>
                        <option value="" selected disabled>Pilih Akun</option>
                        @foreach($akuns as $akun)

                        <option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="nilai">Keterangan</label>
                      <textarea name="keterangan" class="form-control" id="exampleTextarea1" rows="4"></textarea>
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