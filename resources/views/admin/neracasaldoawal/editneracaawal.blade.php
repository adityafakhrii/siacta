@extends('layouts.master')

<title>Tambah Neraca Saldo Awal | SIACTA</title>

@section('content')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Neraca Saldo Awal | SIACTA</h4>
                  	<form action="/update-neracaawal/{{$neraca->id}}" method="post">
                  	@csrf
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Pilih Akun</label>
	                    </div>
	                    <div class="col-lg-8">
		                    <input class="form-control" maxlength="11" name="nominal" id="defaultconfig" type="text" value="{{$neraca->akun->no_akun}} - {{$neraca->akun->nama_akun}}" disabled>
	                    </div>
	                  </div>
	                  <div class="form-group row">
		                    <div class="col-lg-3">
		                      <label class="col-form-label">Nominal</label>
		                    </div>
		                    <div class="col-lg-8">
		                      <input class="form-control" maxlength="11" name="nominal" id="defaultconfig" type="text" placeholder="Masukkan nominal..">
		                    </div>
		                </div>
	                  <div class="form-group row">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/neraca-saldo-awal" class="btn btn-light">Batal</a>
	                  </div>
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