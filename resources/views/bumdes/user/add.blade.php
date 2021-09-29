@extends('layouts.master')

<title>Tambah Pengguna Unit Usaha | SIACTA</title>

@section('content')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                	@if(Session::has('create'))
                    <div class="alert alert-fill-success" role="alert">
                      <i class="mdi mdi-alert-circle"></i>
                      {{Session::get('create')}}
                    </div>
                  @endif
                  <h4 class="card-title">Tambah Pengguna Unit Usaha | SIACTA</h4>
                  	<form action="/store-unit" method="post">
                  	@csrf
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Ketua Unit Usaha</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama" type="text" placeholder="Tulis nama pengguna.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Unit Usaha</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama_unit" type="text" placeholder="Tulis Nama Unit Usaha.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp" type="text" placeholder="Tulis NPWP (Opsional)..">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Pilih Jenis Unit Usaha</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <div class="form-group">
			                    <select class="js-example-basic-single w-100" name="id_akun" required>
			                      <option selected disabled>Pilih Salah Satu</option>
			                      @foreach($jenis as $unit)
			                      	<option value="{{$unit->id}}">{{$unit->jenis}}</option>
			                      @endforeach
			                    </select>
			                  </div>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                   <div class="col-lg-3">
	                      <label class="col-form-label">No. Telfon</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="13" name="no_telfon" type="text" placeholder="Tulis No. Telfon..">
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                   <div class="col-lg-3">
	                      <label class="col-form-label">Email</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="email" type="email" placeholder="Tulis Alamat Email..">
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                   <div class="col-lg-3">
	                      <label class="col-form-label">Password</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="password" type="password" placeholder="Tulis Password..">
	                    </div>
	                  </div>


	                  <div class="form-group row">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/data-unit" class="btn btn-light">Batal</a>
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