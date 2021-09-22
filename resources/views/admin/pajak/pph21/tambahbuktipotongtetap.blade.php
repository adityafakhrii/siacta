@extends('layouts.master')

<title>Tambah Bukti Potong Tetap | SIACTA</title>

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
                  <h4 class="card-title">Tambah Bukti Potong  Tetap | SIACTA</h4>
                  <form action="/store-bukti-potong-tetap" method="post" name="formtetap" onkeyup="calculatetetap()">
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

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP Pemotong</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" id="nomor" name="npwp_pemotong" type="text" placeholder="Tulis Nomor NPWP Pemotong..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Pemotong</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" id="nomor" name="nama_pemotong" type="text" placeholder="Tulis Nama Pemotong..." required>
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
	                      <label class="col-form-label">5. Jenis Kelamin</label>
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="jenis_kelamin" value="Laki-laki" required>
		                              Laki-laki
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="jenis_kelamin" value="Perempuan">
		                              Perempuan
		                        </label>
		                    </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">6. Status /Jumlah Tanggungan Keluarga Untuk PTKP</label>
	                    </div>
	                    <div class="col-sm-1">
	                    	<label class="col-form-label">K/</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="k" type="number" placeholder="K" max="3" id="status1">
	                    </div>
	                    <div class="col-sm-1">
	                    	<label class="col-form-label">TK/</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="tk" type="number" placeholder="TK" max="3" id="status2">
	                    </div>
	                    <div class="col-sm-1">
	                    	<label class="col-form-label">HB/</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="hb" type="number" placeholder="HB" max="3" id="status3">
	                    </div>
	                  </div>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">7. Nama Jabatan</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jabatan" type="text" placeholder="Tulis Nama Jabatan..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">8. Karyawan Asing</label>
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="kar_asing" id="wajib_ln" value="Ya" required onclick="removeDisabledKode()">
		                              Ya 
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="kar_asing" id="wajib_ln" value="Tidak" onclick="addDisabledKode()">
		                              Tidak
		                        </label>
		                    </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">9. Kode Negara Domisili </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="kode_negara" id="kode_negara" type="text" placeholder="Tulis Kode Negara..." disabled>
	                    </div>
	                  </div>

	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>B. Rincian Penghasilan dan Penghitungan PPh Pasal 21</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label"><strong>Kode Objek Pajak</strong></label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="kode_objek" value="21-100-01" type="text" placeholder="Tulis Kode Objek Pajak..." readonly>
	                    </div>
	                  </div>
	                  <h6 class="card-description">
                      <strong>Penghasilan Bruto</strong>
                    </h6>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">1. Gaji/Pensiun Atau THT/JHT</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="gaji_pensiun" type="number" placeholder="Nominal (Rupiah)" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">2. Tunjangan PPh</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tunjangan_pph" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">3. Tunjangan Lainnya, Uang Lembur dan Sebagainya</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tunjangan_lain" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">4. Honorarium dan Imbalan Lain Sejenisnya</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="honorarium" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">5. Premi Asuransi Yang Dibayar Pemberi Kerja</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="premi_asuransi" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">6. Penerimaan Dalam Bentuk Natura dan Kenikmatan Lainnya Yang Dikenakan Pemotongan PPh Pasal 21</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="natura" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">7. Tantiem, Bonus, Gratifikasi, Jasa Produksi dan THR</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tantiem" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">8. Jumlah Penghasilan Bruto (1 S.D. 7)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jumlah_peng_bruto" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  <h6 class="card-description">
                      <strong>Pengurangan</strong>
                    </h6>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">9. Biaya Jabatan/Biaya Pensiun</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="biaya_jabatan" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">10. Iuran Pensiun Atau Iuran THT/JHT</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="iuran_pensiun" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">11. Jumlah Pengurangan (9 S.D. 10)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jumlah_pengurangan" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  <h6 class="card-description">
                      <strong>Penghitungan PPh Pasal 21</strong>
                    </h6>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">12. Jumlah Penghasilan Neto (8-11)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jumlah_peng_neto" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">13. Penghasilan Tidak Kena Pajak (PTKP)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="ptkp" type="number" placeholder="Nominal (Rupiah)" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">14. Penghasilan Kena Pajak Sebulan/Disebulankan (12 - 13)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pkp" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">15. Persentase Pajak (Desimal)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="persen_pajak" type="number" placeholder="Nominal (Rupiah)" step=".01" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">16. PPh Pasal 21 Atas Penghasilan Kena Pajak Sebulan/Disebulankan</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph21_pkp" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">17. PPh Pasal 21 Yang Telah Dipotong Masa Sebelumnya</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph21_dipotong" type="number" placeholder="Nominal (Rupiah)" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">18. PPh Pasal 21 Terutang</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph21_terutang" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">19. PPh Pasal 21 Dan PPh Pasal 26 Yang Telah Dipotong dan Dilunasi</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph21_pph26" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>

	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>C. Identitas Pemotong</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">20. NPWP</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="npwp_id_pemotong" type="text" placeholder="Tulis NPWP Pemotong..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">21. Nama</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama_id_pemotong" type="text" placeholder="Tulis Nama Pemotong..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label"><strong>22. Tanggal Lunas</strong></label>
	                    </div>
	                    <div class="col-lg-9">
	                      <div id="datepicker-popup" class="input-group date datepicker">
	                        <input placeholder="Pilih Tanggal Lunas" type="text" class="form-control" name="tgl_pemotong">
	                        <span class="input-group-addon input-group-append border-left">
	                          <span class="mdi mdi-calendar input-group-text"></span>
	                        </span>
	                      </div>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                  	<input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/pph21/bukti-potong-tetap" class="btn btn-light">Batal</a>
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
