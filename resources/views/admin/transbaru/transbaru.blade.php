@extends('layouts.master')

<title>Transaksi Jurnal Penyesuaian | SIACTA</title>

@section('content')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                	@if(Session::has('success'))
                    <div class="alert alert-fill-success" role="alert">
                      <i class="mdi mdi-alert-circle"></i>
                      {{Session::get('success')}}
                    </div>
                    @endif
                  <h4 class="card-title">Transaksi Jurnal Penyesuaian | SIACTA</h4>
                  	<form action="/jurnal-penyesuaian/store-transaksi" method="post" enctype="multipart/form-data" name="myform" onkeyup="calculate()">
                  	@csrf
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Pilih akun penyesuaian</label>
	                    </div>
	                    <div class="col-lg-8">
	                      <div class="form-group">
			                    <select class="js-example-basic-single w-100" name="id_akun_penyesuaian" required>
			                      <option value="" selected disabled>Pilih akun penyesuaian</option>
			                      @foreach($akuns as $akun)

			                      <option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

			                      @endforeach
			                    </select>
			                    {{-- <input type="hidden" name="saldo_normal" value="{{$akun->saldo_normal}}"> --}}
			                  </div>
		                    <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Nomor Akun</label>
	                    </div>
	                    <div class="col-lg-8">
	                      <div class="form-group">
			                    <select class="js-example-basic-single w-100" name="id_akun" required>
			                      <option value="" selected disabled>Pilih Akun</option>
			                      @foreach($akuns_all as $akun)

			                      <option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

			                      @endforeach
			                    </select>
			                    {{-- <input type="hidden" name="saldo_normal" value="{{$akun->saldo_normal}}"> --}}
			                  </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Keterangan</label>
	                    </div>
	                    <div class="col-lg-8 grid-margin stretch-card">
					              <textarea class="form-control" id="exampleTextarea1" rows="4" name="keterangan" required></textarea>
					            </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Nominal</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <input class="form-control"  name="nominal" required />
		                	</div>
	                  </div>
	                  <div class="form-group row">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/jurnal-penyesuaian" class="btn btn-light">Batal</a>
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