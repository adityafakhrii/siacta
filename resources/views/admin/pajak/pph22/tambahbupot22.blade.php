@extends('layouts.master')

<title>Tambah Bukti Potong PPh 22 | SIACTA</title>

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
                  <h4 class="card-title">Tambah Bukti Potong PPh 22 | SIACTA</h4>
                  <form action="/store-bukti-potongpph22" method="post" name="formbupotpph22" onkeyup="calculatebupotpph22()">
                  	@csrf
                  	
                  	<div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">No. Bukti</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="no_bukti" type="text" placeholder="Tulis No. Bukti.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp" id="npwp" type="text" placeholder="Tulis NPWP..">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama" type="text" placeholder="Tulis nama lengkap.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Alamat</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="alamat" type="text" placeholder="Tulis alamat lengkap.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Jenis Badan Usaha</label>
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="jenis_badan" id="optionsRadios2" value="Jenis Industri" required>
		                              Jenis Industri
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="jenis_badan" id="optionsRadios2" value="Penjualan Barang yang Tergolong Sangat Mewah">
		                              Penjualan Barang yang Tergolong Sangat Mewah
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="jenis_badan" id="optionsRadios2" value="Industri/Eksportir">
		                              Industri/Eksportir
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="jenis_badan" id="optionsRadios2" value="Badan Tertentu Lainnya">
		                              Badan Tertentu Lainnya
		                        </label>
		                    </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Jenis Usaha</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jenis_usaha" type="text" placeholder="Tulis Jenis Usaha.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Harga (Rp)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="harga" type="number" placeholder="Tulis harga.." >
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Tarif Lebih Tinggi 100% (Tidak ber-NPWP)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tarif_lebih" id="tarif_lebih" type="number" placeholder="Tulis tarif lebih tinggi jika tidak ber-NPWP.." value="2" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Tarif (%)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tarif" step=".00001" type="number" placeholder="Tulis tarif.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">PPh yang Dipotong (Rp)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph_dipot" type="number" placeholder="Pph yang dipotong..." readonly>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
                    <div class="form-group row">
                    	<div class="col-lg-3">
	                      <label class="col-form-label">Tempat</label>
	                    </div>
	                    <div class="col-lg-5">
	                      <input class="form-control" name="tempat" type="text" placeholder="Tulis tempat.." required>
	                    </div>
                      <div class="col-sm-4">
                        <div id="datepicker-popup" class="input-group date datepicker">
	                        <input placeholder="Pilih Tanggal" type="text" class="form-control" name="tanggal" required>
	                        <span class="input-group-addon input-group-append border-left">
	                          <span class="mdi mdi-calendar input-group-text"></span>
	                        </span>
	                      </div>
                      </div>
                    </div>

	                  <h4 class="card-description">
                      <strong>Pemungut Pajak</strong>
                    </h4>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP :</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp_pemungut" id="npwp_pemungut" type="text" placeholder="Tulis NPWP.." required>
	                    </div>
	                  </div>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama :</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama_pemungut" type="text" placeholder="Tulis nama lengkap..." required>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                  	<input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/pph22" class="btn btn-light">Batal</a>
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
