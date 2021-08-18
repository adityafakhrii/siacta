@extends('layouts.master')

<title>Tambah Akun | SIACTA</title>

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
                  <h4 class="card-title">Tambah Akun | SIACTA</h4>
                  	<form action="/store-akun" method="post">
                  	@csrf
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nomor Akun</label>
	                    </div>
	                    <div class="col-lg-8">
	                      <input class="form-control" maxlength="9" name="no_akun" id="defaultconfig" type="text" placeholder="Tulis nomor akun.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Akun</label>
	                    </div>
	                    <div class="col-lg-8">
	                      <input class="form-control" maxlength="255" name="nama_akun" id="defaultconfig-2" type="text" placeholder="Tulis nama akun.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Saldo Normal</label>
	                    </div>
	                    <div class="col-lg-8">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="saldo_normal" id="optionsRadios2" value="debit" required>
		                              Debit
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="saldo_normal" id="optionsRadios2" value="kredit">
		                              Kredit
		                        </label>
		                    </div>
		                    <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Akun Penyesuaian</label>
	                    </div>
	                    <div class="col-lg-8">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="status" id="optionsRadios2" value="penyesuaian" required>
		                              Ya
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="status" id="optionsRadios2" value="tidak_pen">
		                              Tidak
		                        </label>
		                    </div>
		                    <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/data-akun" class="btn btn-light">Batal</a>
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