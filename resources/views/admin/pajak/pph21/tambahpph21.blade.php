@extends('layouts.master')

<title>Tambah SPT | SIACTA</title>

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
                  <h4 class="card-title">Tambah SPT | SIACTA</h4>
                  <form action="/store-pph21" method="post" name="myform" onkeyup="calculate()">
                  	@csrf
                  	
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Formulir</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="form_pajak" type="text" placeholder="Tulis formulir pajak akun.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Tahun Pajak</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tahun_pajak" type="number" placeholder="Tulis tahun pajak.." required>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>Identitas</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp" id="npwp" type="text" placeholder="Tulis NPWP.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Wajib Pajak </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama_wajib" type="text" placeholder="Tulis nama lengkap.." required>
	                    </div>
	                  </div>
	                  <div class="row">
	                  	<div class="col-md-6">
			                  <div class="form-group row">
                          <label class="col-sm-6 col-form-label">Pekerjaan</label>
                          <div class="col-sm-6">
                            <input class="form-control" name="pekerjaan" type="text" placeholder="Tulis Pekerjaan.." required>
                          </div>
                        </div>
	                  	</div>
	                  	<div class="col-md-6">
			                  <div class="form-group row">
			                    <div class="col-lg-3">
			                      <label class="col-form-label">KLU</label>
			                    </div>
			                    <div class="col-lg-9">
			                      <input class="form-control" name="klu" type="text" placeholder="Tulis KLU..">
			                    </div>
			                  </div>
	                  	</div>
	                  </div>
	                  <div class="row">
	                  	<div class="col-md-6">
			                  <div class="form-group row">
                          <label class="col-sm-6 col-form-label">No. Telepon</label>
                          <div class="col-sm-6">
                            <input class="form-control" maxlength="13" name="no_telepon" id="no_telepon" type="text" placeholder="Tulis No. Telepon.." required>
                          </div>
                        </div>
	                  	</div>
	                  	<div class="col-md-6">
			                  <div class="form-group row">
			                    <div class="col-lg-3">
			                      <label class="col-form-label">No. Faks</label>
			                    </div>
			                    <div class="col-lg-9">
			                      <input class="form-control" name="no_faks" type="text" placeholder="Tulis No. Faks..">
			                    </div>
			                  </div>
	                  	</div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Status Kewajiban Perpajakan Suami-Isteri</label>
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="sk_suami_istri" id="optionsRadios2" value="kk">
		                              KK
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="sk_suami_istri" id="optionsRadios2" value="hb">
		                              HB
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="sk_suami_istri" id="optionsRadios2" value="ph">
		                              PH
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="sk_suami_istri" id="optionsRadios2" value="mt">
		                              MT
		                        </label>
		                    </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP Istri/Suami</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp_suami_istri" id="npwp_suami_istri" type="text" placeholder="Tulis NPWP.." >
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>A. Penghasilan Neto</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">1. Penghasilan Neto Dalam Negeri Sehubungan Dengan Pekerjaan</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="phneto_dn" type="number" placeholder="Nominal (Rupiah)" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">2. Penghasilan Neto Dalam Negeri Lainnya</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="phneto_dn_lain" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">3. Penghasilan Neto Luar Negeri Lainnya</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="phneto_ln" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">4. Jumlah Penghasilan Neto (1+2+3)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jml_peng_neto" type="number" placeholder="Nominal (Rupiah)" required readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">5. Zakat/Sumbangan Keagamaan yang Sifatnya Wajib</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="zakat_sumbang" type="number" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">6. Jumlah Penghasilan Neto Setelah Pengurangan Zakat /Sumbangan Keagamaan yang Sifatnya Wajib</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="total_peng_neto" type="number" placeholder="Nominal (Rupiah)" readonly>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>B. Penghasilan Kena Pajak</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">7. Penghasilan Tidak Kena Pajak</label>
	                    </div>
	                    <div class="col-sm-1">
	                    	<label class="col-form-label"><strong>TK/</strong></label>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tk" type="number" placeholder="TK" max="3" id="input1">
	                    </div>
	                    <div class="col-sm-1">
	                    	<label class="col-form-label"><strong>K/</strong></label>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="k" type="number" placeholder="K" max="3" id="input2">
	                    </div>
	                    <div class="col-sm-1">
	                    	<label class="col-form-label"><strong>K/I/</strong></label>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="ki" type="number" placeholder="KI" max="3" id="input3">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="peng_tidak_pajak" type="number" placeholder="Nominal (Rupiah)" required>
	                    </div>

	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">8. Penghasilan Kena Pajak</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="peng_pajak" type="text" placeholder="Nominal (Rupiah)" required readonly>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>C. PPh Terutang</strong>
                    </h5>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">9. PPh Terutang (Tarif Pasal 17 UU PPH x Angka 8)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph_terutang" type="text" placeholder="Nominal (Rupiah)" required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">10. Pengembalian / Pengurangan PPh Pasal 24 Yang Telah Dikreditkan</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pengem_pph24" type="text" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">11. Jumlah PPh Terutang</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jml_pph_terutang" type="text" placeholder="Nominal (Rupiah)" required readonly>
	                    </div>
	                  </div>

	                  <hr>

	                  <h5 class="card-description">
                      <strong>D. Kredit Pajak</strong>
                    </h5>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">12. PPh Yang Dipotong/Dipungut Pihak Lain/Ditanggung Pemerintah Dan/Atau Kredit Pajak Luar</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph_dipot_ln" type="text" placeholder="Nominal (Rupiah)" value="0">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">13. a. PPh Yang Harus Dibayar Sendiri</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph_dibayar" type="text" placeholder="Nominal (Rupiah)" disabled>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">13. b. PPh Yang Lebih Dipotong/Dipungut</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph_dipungut" type="text" placeholder="Nominal (Rupiah)" disabled>
	                    </div>
	                  </div>
	                  <div class="row">
	                  	<div class="col-md-6">
			                  <div class="form-group row">
                          <label class="col-sm-6 col-form-label">14. PPh yang dibayar sendiri</label>
                          <label class="col-sm-6 col-form-label">a. PPh pasal 25</label>
                        </div>
	                  	</div>
	                  	<div class="col-md-6">
			                  <div class="form-group row">
			                    <div class="col-lg-9">
			                      <input class="form-control" name="pph25" type="text" placeholder="Nominal (Rupiah)">
			                    </div>
			                  </div>
	                  	</div>
	                  </div>
	                  <div class="row">
	                  	<div class="col-md-6">
			                  <div class="form-group row">
                          <label class="col-sm-6 col-form-label"></label>
                          <label class="col-sm-6 col-form-label">b. STP PPh Pasal 25 (Hanya Pokok Pajak)</label>
                        </div>
	                  	</div>
	                  	<div class="col-md-6">
			                  <div class="form-group row">
			                    <div class="col-lg-9">
			                      <input class="form-control" name="stp_pph25" type="text" placeholder="Nominal (Rupiah)">
			                    </div>
			                  </div>
	                  	</div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">15. Jumlah Kredit Pajak</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="jml_kredit_pajak" type="text" placeholder="Nominal (Rupiah)" disabled>
	                    </div>
	                  </div>

	                  <hr>

	                  <h5 class="card-description">
                      <strong>E. PPh Kurang/Lebih Bayar</strong>
                    </h5>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label"><strong>Tanggal Lunas</strong></label>
	                    </div>
	                    <div class="col-lg-9">
	                      <div id="datepicker-popup" class="input-group date datepicker">
	                        <input placeholder="pilih tanggal" type="text" class="form-control" name="tgl_lunas">
	                        <span class="input-group-addon input-group-append border-left">
	                          <span class="mdi mdi-calendar input-group-text"></span>
	                        </span>
	                      </div>
	                    </div>
	                  </div>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">16. a. PPh Yang Kurang Dibayar (PPh Pasal 29)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph29" type="text" placeholder="Nominal (Rupiah)" disabled>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">16. b. PPh Yang Lebih Dibayar (PPh Pasal 28 A)</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="pph28a" type="text" placeholder="Nominal (Rupiah)" disabled>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">17. Permohonan : PPh Lebih Bayar Pada 16b Mohon :</label>
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" id="input17" class="form-check-input" name="permohonan" id="optionsRadios2" value="Direstitusikan">
		                              Direstitusikan
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" id="inputdisabled" class="form-check-input" name="permohonan" id="optionsRadios2" value="Diperhitungkan Dengan Utang Pajak">
		                              Diperhitungkan Dengan Utang Pajak
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" id="inputdisabled2" class="form-check-input" name="permohonan" id="optionsRadios2" value="Dikembalikan Dengan SKPPKP Pasal 17C (WP Dengan Kriteria Tertentu)">
		                              Dikembalikan Dengan SKPPKP Pasal 17C (WP Dengan Kriteria Tertentu)
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" id="inputdisabled3" class="form-check-input" name="permohonan" id="optionsRadios2" value="Dikembalikan Dengan SKKPP Pasal 17D (WP Yang Memenuhi Persyaratan Tertentu)">
		                              Dikembalikan Dengan SKKPP Pasal 17D (WP Yang Memenuhi Persyaratan Tertentu)
		                        </label>
		                    </div>
	                    </div>
	                  </div>

	                  <hr>

	                  <h5 class="card-description">
                      <strong>F. Angsuran PPh Pasal 25 Tahun Pajak Berikutnya</strong>
                    </h5>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">18. Angsuran PPh Pasal 25 Tahun Pajak Berikutnya Sebesar </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="angsuran_pph25" type="text" placeholder="Nominal (Rupiah)">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Dihitung Berdasarkan</label>
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="status_ang_pph25" id="optionsRadios2" value="1/12 x Jumlah Pada Angka 13">
		                              1/12 x Jumlah Pada Angka 13 
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input type="radio" class="form-check-input" name="status_ang_pph25" id="optionsRadios2" value="Penghitungan Dalam Lampiran Tersendiri">
		                              Penghitungan Dalam Lampiran Tersendiri
		                        </label>
		                    </div>
	                    </div>
	                  </div>

	                  <hr>

	                  <h5 class="card-description">
                      <strong>G. Lampiran</strong>
                    </h5>
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      
	                    </div>
	                    <div class="col-lg-9">
	                        <div class="form-check">
                            <label class="form-check-label">
                              <input value="Fotokopi Formulir 1721-A1 atau 1721-A2 atau Bukti Potong PPh Pasal 21" type="checkbox" name="nama_lampiran[]" class="form-check-input">
                              Fotokopi Formulir 1721-A1 atau 1721-A2 atau Bukti Potong PPh Pasal 21
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input value="Surat Setoran Pajak Lembar Ke-3 PPh Pasal 29" type="checkbox" name="nama_lampiran[]" class="form-check-input">
                              Surat Setoran Pajak Lembar Ke-3 PPh Pasal 29
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input value="Surat Kuasa Khusus (Bila dikuasakan)" type="checkbox" name="nama_lampiran[]" class="form-check-input">
                              Surat Kuasa Khusus (Bila dikuasakan)
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input value="Perhitungan PPh Terutang bagi Wajib Pajak dengan status perpajakan PH atau MT" type="checkbox" name="nama_lampiran[]" class="form-check-input">
                              Perhitungan PPh Terutang bagi Wajib Pajak dengan status perpajakan PH atau MT
                            </label>
                          </div>
                          <div class="form-check">
		                        <input class="form-control" name="nama_lampiran[]" type="text" placeholder="Lainnya">
		                    </div>
		                  </div>
		                </div>

	                  <hr>

	                  <h4 class="card-description text-center">
                      <strong>PERNYATAAN</strong>
                    </h4>
                    <p class="card-description text-center">
                    	<strong>Dengan menyadari sepenuhnya akan segala akibatnya termasuk sanksi-sanksi sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, saya menyatakan bahwa yang telah beritahukan diatas beserta lampiran-lampirannya adalah benar, lengkap dan jelas.</strong>
                    </p>
                    <div class="form-group row">
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="pengisi_spt" id="pengisi_spt" value="Wajib Pajak">
                            WAJIB PAJAK
                          <i class="input-helper"></i></label>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="pengisi_spt" id="pengisi_spt" value="Kuasa" required>
                            KUASA
                          <i class="input-helper"></i></label>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div id="datepicker-popup" class="input-group date datepicker">
	                        <input placeholder="pilih tanggal" type="date" class="form-control" name="tgl_pernyataan" required>
	                      </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Lengkap </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama_pem_kerja" type="text" placeholder="Tulis disini..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP </label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp_pem_kerja" id="npwp_pem_kerja" type="text" placeholder="Tulis NPWP.." required>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                  	<input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
	                    <a href="/pph21" class="btn btn-light">Batal</a>
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
