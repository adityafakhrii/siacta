@extends('layouts.master')

<title>Tambah SPT PPh 23 | SIACTA</title>

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
                  <h4 class="card-title">Tambah SPT PPh 23 | SIACTA</h4>
                  <form action="/store-pph23" id="pph23" method="post" name="formsptpph23" onkeyup="calculatesptpph23()">
                  	@csrf
                  	
                    <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">Masa Pajak</label>
	                    </div>
	                    <div class="col-lg-10">
	                      <input class="form-control" name="masa_pajak" type="text" placeholder="Tulis Bulan/Tahun.." required>
	                    </div>
	                  </div>
	                  
	                  <hr>

	                  <h5 class="card-description">
                      <strong>A. Identitas Pemotong Pajak/Wajib Pajak</strong>
                    </h5>
	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">NPWP</label>
	                    </div>
	                    <div class="col-lg-10">
	                      <input class="form-control" maxlength="20" name="npwp" id="npwp" type="text" placeholder="Tulis NPWP.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">Nama</label>
	                    </div>
	                    <div class="col-lg-10">
	                      <input class="form-control" name="nama" type="text" placeholder="Tulis nama lengkap.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">Alamat</label>
	                    </div>
	                    <div class="col-lg-10">
	                      <input class="form-control" name="alamat" type="text" placeholder="Tulis alamat lengkap.." required>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>B. Objek Pajak</strong>
                    </h5>

                    <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label"><strong>Uraian</strong></label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<label class="col-form-label"><strong>NPWP</strong></label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<label class="col-form-label"><strong>KAP/KJS</strong></label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<label class="col-form-label"><strong>Jumlah Penghasilan Bruto</strong></label>
	                    </div>
	                    <div class="col-lg-1">
	                    	<label class="col-form-label"><strong>Tarif Lebih Tinggi 100% (Tdk ber-NPWP)</strong></label>
	                    </div>
	                    <div class="col-lg-1">
	                    	<label class="col-form-label"><strong>Tarif (%)</strong></label>
	                    </div>
	                    <div class="col-lg-2">
	                      <label class="col-form-label"><strong>PPh yang Dipotong (Rp)</strong></label>
	                    </div>
	                  </div>

	                  <div class="parent">
	                    <div class="spt form-group row">
		                    <div class="col-lg-2">
		                      <input class="form-control" name="uraian[]" type="text" placeholder="Uraian..">
		                    </div>
		                    <div class="col-lg-2">
		                    	<input class="form-control" maxlength="20" name="npwp_pph23[]" type="text" placeholder="NPWP..">
		                    </div>
		                    <div class="col-lg-2">
		                    	<input class="form-control" name="kap_kjs[]" type="text" placeholder="KAP/KJS..">
		                    </div>
		                    <div class="col-lg-2">
		                    	<input class="form-control jumlah_peng_bruto" name="jumlah_peng_bruto[]" id="jumlah_peng_bruto" type="number" placeholder="Jumlah Penghasilan Bruto (Rp)">
		                    </div>
		                    <div class="col-lg-1">
		                    	<input class="form-control" name="tl_pph23[]" type="number" value="2" readonly>
		                    </div>
		                    <div class="col-lg-1">
		                    	<input class="form-control" name="t_pph23[]" type="number" placeholder="T(%)" step=".00001">
		                    </div>
		                    <div class="col-lg-2">
		                      <input class="form-control" name="pph_dipot23[]" jAutoCalc="{jumlah_peng_bruto} * {tl_pph23}" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
		                    </div>
		                  </div>
	                  </div>
	                  <div id="new_chq"></div>

	                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	                 	<div class="row">
		                  <button type="button" class="add row-add btn btn-primary mr-2"><i class="mdi mdi-note-plus btn-icon-prepend"></i> Tambah Objek Pajak</button>
	                 		<button type="button" class="remove btn btn-primary mr-2"><i class="mdi mdi-note-plus btn-icon-prepend"></i> Hapus Objek Pajak</button>
	                 	</div>

										<input type="hidden" value="1" id="total_chq">

	                  <hr>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label"><h4><strong>Total Penghasilan Bruto</strong></h4></label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="total_peng_bruto" type="text" placeholder="Total Penghasilan Bruto" id="total_peng_bruto" readonly>
	                    </div>
	                    <div class="col-lg-3 text-center">
	                      <label class="col-form-label"><h4><strong>Total PPh</strong></h4></label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="total_pph" type="text" placeholder="Jumlah PPh yang dipungut" readonly>
	                    </div>
	                  </div>	                  
	                  
	                  <hr>

	                  <h5 class="card-description">
                      <strong>C. Lampiran</strong>
                    </h5>
                    <div class="form-group row">
	                    <div class="col-lg-8">
	                      <div class="form-check">
                          <label class="form-check-label">
                            <input value="1. Surat Setoran Pajak" type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            1. Surat Setoran Pajak :
                          </label>
                        </div>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="lembar_setoran" type="number" placeholder="Lembar">
	                    </div>
	                    <div class="col-lg-2">
	                    	<label class="col-form-label">Lembar</label>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="2. Daftar Bukti Pemotongan PPh Pasal 23 dan/atau Pasal 26." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            2. Daftar Bukti Pemotongan PPh Pasal 23 dan/atau Pasal 26.
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-8">
	                      <div class="form-check">
                          <label class="form-check-label">
                            <input value="3. Bukti Pemotongan PPh Pasal 23 dan/atau Pasal 26" type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            3. Bukti Pemotongan PPh Pasal 23 dan/atau Pasal 26 :
                          </label>
                        </div>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="lembar_bukti" type="number" placeholder="Lembar">
	                    </div>
	                    <div class="col-lg-2">
	                    	<label class="col-form-label">Lembar</label>
	                    </div>
	                  </div>

                    <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="4. Surat Kuasa Khusus." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            4. Surat Kuasa Khusus.
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="Legalisasi fotocopy Surat Keterangan Domisili yang masih berlaku, dalam hal PPh Pasal 26 dihitung berdasarkan tarif Perjanjian Penghindaran Pajak Berganda (P3B)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            Legalisasi fotocopy Surat Keterangan Domisili yang masih berlaku, dalam hal PPh Pasal 26 dihitung berdasarkan tarif Perjanjian Penghindaran Pajak Berganda (P3B).
                          </label>
                        </div>
                      </div>
                    </div>

	                  <hr>

	                  <h4 class="card-description">
                      <strong>D. Pernyataan</strong>
                    </h4>
                    <p class="card-description text-center">
                    	<strong>Dengan menyadari sepenuhnya akan segala akibatnya termasuk sanksi-sanksi sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, saya menyatakan bahwa apa yang telah saya beritahukan di atas beserta lampiran-lampirannya adalah benar, lengkap dan jelas.</strong>
                    </p>
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="pengisi_spt" id="pengisi_spt" value="Pemotong Pajak/Pimpinan" required>
                            PEMOTONG PAJAK/PIMPINAN
                          <i class="input-helper"></i></label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="pengisi_spt" id="pengisi_spt" value="Kuasa Wajib Pajak">
                            KUASA WAJIB PAJAK
                          <i class="input-helper"></i></label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Nama Lengkap</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama_pengisi" type="text" placeholder="Tulis nama disini..." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">NPWP</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" maxlength="20" name="npwp_pengisi" id="npwp_pengisi" type="text" placeholder="Tulis NPWP.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Tanggal</label>
	                    </div>
	                    <div class="col-sm-9">
                        <div id="datepicker-popup" class="input-group date datepicker">
	                        <input placeholder="Pilih Tanggal" type="text" class="form-control" name="tanggal" required>
	                        <span class="input-group-addon input-group-append border-left">
	                          <span class="mdi mdi-calendar input-group-text"></span>
	                        </span>
	                      </div>
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

      <script>
      	$(function() {

	      function autoCalcSetup() {
	        $('form#pph23').jAutoCalc('destroy');
	        $('form#pph23 div.spt').jAutoCalc({keyEventsFire: true, decimalPlaces: 5, emptyAsZero: true});
	        $('form#pph23').jAutoCalc({decimalPlaces: 5});
	      }
	      autoCalcSetup();


	      $('button.row-remove').on("click", function(e) {
	        e.preventDefault();

	        var form = $(this).parents('form')
	        $(this).parents('tr').remove();
	        autoCalcSetup();

	      });

	      $('button.row-add').on("click", function(e) {
	        e.preventDefault();

	        var $table = $(this).parents('div.parent');
	        var $top = $table.find('div.spt').first();
	        var $new = $top.clone(true);

	        $new.jAutoCalc('destroy');
	        $new.insertBefore($top);
	        $new.find('input[type=text]').val('');
	        autoCalcSetup();

	      });

	    });
      </script>
      <!-- main-panel ends -->
      
@endsection
