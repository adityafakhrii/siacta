@extends('layouts.master')

<title>Tambah Bukti Potong Tidak Tetap | SIACTA</title>

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
                  <h4 class="card-title">Tambah Bukti Potong Tidak Tetap | SIACTA</h4>
                  <form action="/store-bukti-potong-tidaktetap" method="post" name="formtidaktetap" onkeyup="calculatetidaktetap()">
                  	@csrf
                  	
                  	<div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nomor Formulir</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="no_form" type="text" placeholder="Tulis Nomor formulir..." required>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nomor Bukti</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="17" id="nomor" name="nomor" type="text" placeholder="Tulis Nomor Bukti Potong..." required>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>A. Identitas Penerima Penghasilan Yang Dipotong</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">1. NPWP</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp" id="npwp" type="text" placeholder="Tulis NPWP...">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">2. NIK/No. Paspor </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nik_paspor" type="text" placeholder="Tulis NIK/Paspor..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">3. Nama </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama" type="text" placeholder="Tulis nama lengkap..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">4. Alamat </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="alamat" type="text" placeholder="Tulis alamat lengkap..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">5. Wajib Pajak Luar Negeri</label>
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="wajib_ln" id="wajib_ln" value="Ya" required  onclick="removeDisabledKode()">
		                              Ya 
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="wajib_ln" id="wajib_ln" value="Tidak" onclick="addDisabledKode()">
		                              Tidak
		                        </label>
		                    </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">6. Kode Negara Domisili </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="kode_negara" id="kode_negara" type="text" placeholder="Tulis Kode Negara..." disabled>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>B. PPh Pasal 21 Dan/Atau Pasal 26 Yang Dipotong</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Kode Objek Pajak</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="kode_objek" type="text" placeholder="Tulis Kode Objek Pajak..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Jumlah Penghasilan Bruto (Rp)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jumlah_peng_bruto" type="number" placeholder="Nominal (Rupiah)" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Dasar Pengenaan Pajak (Rp)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="dasar_pajak" type="number" placeholder="Nominal (Rupiah)" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Tarif Lebih Tinggi 20% (Tidak ber-NPWP)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tarif_lebih" id="tarif_lebih" type="number" value="1.2" placeholder="Tarif" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Tarif</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tarif" type="number" value="0.05" placeholder="Tarif" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">PPh Dipotong (Rp)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph_dipotong" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>C. Identitas Pemotong</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">1. NPWP</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="npwp_pemotong" type="text" placeholder="Tulis NPWP Pemotong..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">2. Nama</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama_pemotong" type="text" placeholder="Tulis Nama Pemotong..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label"><strong>3. Tanggal Lunas</strong></label>
	                    </div>
	                    <div class="col-lg-9">
	                      <div id="datepicker-popup" class="input-group date datepicker">
	                        <input placeholder="Pilih Tanggal Lunas" type="text" class="form-control" name="tgl_potong">
	                        <span class="input-group-addon input-group-append border-left">
	                          <span class="mdi mdi-calendar input-group-text"></span>
	                        </span>
	                      </div>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                  	<input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/pph21/bukti-potong-tidaktetap" class="btn btn-light">Batal</a>
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
