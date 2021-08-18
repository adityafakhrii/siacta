@extends('layouts.master')

<title>Edit Akun {{$akun->no_akun}} | SIACTA</title>



@section('content')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Akun {{$akun->no_akun}} | SIACTA</h4>
                  	<form action="/update-akun/{{$akun->id}}" method="post">
                  	@csrf
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nomor Akun</label>
	                    </div>
	                    <div class="col-lg-8">
	                      <input class="form-control" maxlength="8" name="no_akun" id="defaultconfig" type="text" placeholder="Tulis nomor akun.." value="{{$akun->no_akun}}" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Akun</label>
	                    </div>
	                    <div class="col-lg-8">
	                      <input class="form-control" maxlength="255" name="nama_akun" id="defaultconfig-2" type="text" placeholder="Tulis nama akun.." value="{{$akun->nama_akun}}" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Saldo Normal</label>
	                    </div>
	                    <div class="col-lg-8">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="saldo_normal" id="optionsRadios2" value="debit"
		                              @if($akun->saldo_normal == 'debit')
		                              checked 
		                              @endif
		                              >
		                              Debit
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="saldo_normal" id="optionsRadios2" value="kredit"
		                              @if($akun->saldo_normal == 'kredit')
		                              checked 
		                              @endif
		                              >
		                              Credit
		                        </label>
		                    </div>
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