@extends('layouts.master')

<title>Tambah SPT PPh Pasal 4 Ayat 2 | SIACTA</title>

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
                  <h4 class="card-title">Tambah SPT PPh Pasal 4 Ayat 2 | SIACTA</h4>
                  <form action="/store-pph4ayat2" method="post" name="formsptpph4ayat2" onkeyup="calculatesptpph4ayat2()">
                  	@csrf
                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Tahun Pajak</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="tahun_pajak" type="text" placeholder="Tulis Tahun.." required>
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
	                      <label class="col-form-label">Nama Wajib Pajak</label>
	                    </div>
	                    <div class="col-lg-9">
	                      <input class="form-control" name="nama" type="text" placeholder="Tulis nama lengkap.." required>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">Periode Pembukuan</label>
	                    </div>
	                    <div class="col-lg-4">
	                      <input class="form-control" name="periode1" type="text" placeholder="Tulis bulan dan tahun.." required>
	                    </div>
	                    <div class="col-lg-1 text-center">
	                      <label class="col-form-label">s.d.</label>
	                    </div>
	                    <div class="col-lg-4">
	                      <input class="form-control" name="periode2" type="text" placeholder="Tulis bulan dan tahun.." required>
	                    </div>
	                  </div>
	                  
	                  <hr>
	                  
	                  <h5 class="card-description">
                      <strong>BAGIAN A : PPh FINAL</strong>
                    </h5>

                    <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">1. Bunga Deposito / Tabungan, dan Diskonto SBI / SBN</label>
	                    </div>
	                    
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_deposito" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_deposito" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_deposito" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">2. Bunga / Diskonto Obligasi</label>
	                    </div>
	                    
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_diskonto" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_diskonto" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_diskonto" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">3. Penghasilan Penjualan Saham yang Diperdagangkan di Bursa Efek</label>
	                    </div>
	                    
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_bursaefek" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_bursaefek" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_bursaefek" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">4. Penghasilan Penjualan Saham Milik Perusahaan Modal Ventura</label>
	                    </div>
	                    
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_ventura" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_ventura" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_ventura" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">5. Penghasilan Usaha Penyalur / Dealer / Agen Produk BBM</label>
	                    </div>
	                    
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_bbm" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_bbm" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_bbm" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">6. Penghasilan Pengalihan Hak Atas Tanah / Bangunan</label>
	                    </div>
	                    
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_haktanah" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_haktanah" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_haktanah" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">7. Penghasilan Persewaan Atas Tanah / Bangunan</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_sewa" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_sewa" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_sewa" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

                    <div class="form-group row">
	                    <div class="col-lg-12">
	                      <label class="col-form-label">8. Imbalan Jasa Konstruksi</label>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">a. Pelaksana Konstruksi</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_pelkonstruksi" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_pelkonstruksi" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_pelkonstruksi" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">b. Perencana Konstruksi</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_perenkonstruksi" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_perenkonstruksi" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_perenkonstruksi" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">c. Pengawas Konstruksi</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_pengkonstruksi" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_pengkonstruksi" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_pengkonstruksi" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">9. Perwakilan Dagang Asing</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_dagang" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_dagang" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_dagang" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">10. Pelayaran / Penerbangan Asing</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_penerbangan" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_penerbangan" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_penerbangan" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">11. Pelayaran Dalam Negeri</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_pelayaran" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_pelayaran" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_pelayaran" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">12. Penilaian Kembali Aktiva Tetap</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_aktiva" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_aktiva" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_aktiva" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">13. Transaksi Derivatif yang Diperdagangkan di Bursa</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_derivatif" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_derivatif" type="number" placeholder="Tarif (%)" step=".00001">
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_derivatif" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3">
	                      <label class="col-form-label">14. Penghasilan Usaha Wajib Pajak Dengan Peredaran Bruto Tertentu</label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="dpp_peredaran" type="number" placeholder="Dasar Pengenaan Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="tarif_peredaran" type="number" value="0.005" placeholder="Tarif (%)" step=".00001" readonly>
	                    </div>
	                    <div class="col-lg-3">
	                      <input class="form-control" name="pph_peredaran" type="number" placeholder="PPh Terutang (Rp)" readonly>
	                    </div>
	                  </div>


	                  <div class="form-group row">
	                    <div class="col-lg-6 text-center">
	                      <label class="col-form-label"><h4><strong>Jumlah Bagian A</strong></h4></label>
	                    </div>
	                    <div class="col-lg-3 text-center">
	                      <label class="col-form-label"><h4><strong>JBA</strong></h4></label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" id="mytext" name="jumlah_jba" type="text" placeholder="Jumlah PPh Terutang" readonly>
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
		    var formsptpph4ayat2 = document.forms.formsptpph4ayat2,
		    
		        dpp_deposito = formsptpph4ayat2.dpp_deposito,
		        tarif_deposito = formsptpph4ayat2.tarif_deposito,
		        output1 = formsptpph4ayat2.pph_deposito,

		        dpp_diskonto = formsptpph4ayat2.dpp_diskonto,
		        tarif_diskonto = formsptpph4ayat2.tarif_diskonto,
		        output2 = formsptpph4ayat2.pph_diskonto,

		        dpp_bursaefek = formsptpph4ayat2.dpp_bursaefek,
		        tarif_bursaefek = formsptpph4ayat2.tarif_bursaefek,
		        output3 = formsptpph4ayat2.pph_bursaefek,

		        dpp_ventura = formsptpph4ayat2.dpp_ventura,
		        tarif_ventura = formsptpph4ayat2.tarif_ventura,
		        output4 = formsptpph4ayat2.pph_ventura,

		        dpp_bbm = formsptpph4ayat2.dpp_bbm,
		        tarif_bbm = formsptpph4ayat2.tarif_bbm,
		        output5 = formsptpph4ayat2.pph_bbm,

		        dpp_haktanah = formsptpph4ayat2.dpp_haktanah,
		        tarif_haktanah = formsptpph4ayat2.tarif_haktanah,
		        output6 = formsptpph4ayat2.pph_haktanah,

		        dpp_sewa = formsptpph4ayat2.dpp_sewa,
		        tarif_sewa = formsptpph4ayat2.tarif_sewa,
		        output7 = formsptpph4ayat2.pph_sewa,

		        dpp_pelkonstruksi = formsptpph4ayat2.dpp_pelkonstruksi,
		        tarif_pelkonstruksi = formsptpph4ayat2.tarif_pelkonstruksi,
		        output8 = formsptpph4ayat2.pph_pelkonstruksi,

		        dpp_perenkonstruksi = formsptpph4ayat2.dpp_perenkonstruksi,
		        tarif_perenkonstruksi = formsptpph4ayat2.tarif_perenkonstruksi,
		        output9 = formsptpph4ayat2.pph_perenkonstruksi,

		        dpp_pengkonstruksi = formsptpph4ayat2.dpp_pengkonstruksi,
		        tarif_pengkonstruksi = formsptpph4ayat2.tarif_pengkonstruksi,
		        output10 = formsptpph4ayat2.pph_pengkonstruksi,

		        dpp_dagang = formsptpph4ayat2.dpp_dagang,
		        tarif_dagang = formsptpph4ayat2.tarif_dagang,
		        output11 = formsptpph4ayat2.pph_dagang,

		        dpp_penerbangan = formsptpph4ayat2.dpp_penerbangan,
		        tarif_penerbangan = formsptpph4ayat2.tarif_penerbangan,
		        output12 = formsptpph4ayat2.pph_penerbangan,

		        dpp_pelayaran = formsptpph4ayat2.dpp_pelayaran,
		        tarif_pelayaran = formsptpph4ayat2.tarif_pelayaran,
		        output13 = formsptpph4ayat2.pph_pelayaran,

		        dpp_aktiva = formsptpph4ayat2.dpp_aktiva,
		        tarif_aktiva = formsptpph4ayat2.tarif_aktiva,
		        output14 = formsptpph4ayat2.pph_aktiva,

		        dpp_derivatif = formsptpph4ayat2.dpp_derivatif,
		        tarif_derivatif = formsptpph4ayat2.tarif_derivatif,
		        output15 = formsptpph4ayat2.pph_derivatif,

		        dpp_peredaran = formsptpph4ayat2.dpp_peredaran,
		        tarif_peredaran = formsptpph4ayat2.tarif_peredaran,
		        output16 = formsptpph4ayat2.pph_peredaran,

		        outputpph4ayat2 = formsptpph4ayat2.jumlah_jba;

		    window.calculatesptpph4ayat2 = function () {
		        
		        // Result 1
		        var dpp_deposito1 = parseFloat(dpp_deposito.value) || 0,
		            tarif_deposito1 = parseFloat(tarif_deposito.value) || 0;

		        var result1 = Math.round(dpp_deposito1*tarif_deposito1);
		        
		        if (result1 == Number.POSITIVE_INFINITY || result1 == Number.NEGATIVE_INFINITY) {
		          output1.value = 0;
		        }else{
		          output1.value =  result1;
		        }


		        // Result 2
		        var dpp_diskonto1 = parseFloat(dpp_diskonto.value) || 0,
		            tarif_diskonto1 = parseFloat(tarif_diskonto.value) || 0;

		        var result2 = Math.round(dpp_diskonto1*tarif_diskonto1);
		        
		        if (result2 == Number.POSITIVE_INFINITY || result2 == Number.NEGATIVE_INFINITY) {
		          output2.value = 0;
		        }else{
		          output2.value =  result2;
		        }

		        // Result 3
		        var dpp_bursaefek1 = parseFloat(dpp_bursaefek.value) || 0,
		            tarif_bursaefek1 = parseFloat(tarif_bursaefek.value) || 0;

		        var result3 = Math.round(dpp_bursaefek1*tarif_bursaefek1);
		        
		        if (result3 == Number.POSITIVE_INFINITY || result3 == Number.NEGATIVE_INFINITY) {
		          output3.value = 0;
		        }else{
		          output3.value =  result3;
		        }

		        // Result 4
		        var dpp_ventura1 = parseFloat(dpp_ventura.value) || 0,
		            tarif_ventura1 = parseFloat(tarif_ventura.value) || 0;

		        var result4 = Math.round(dpp_ventura1*tarif_ventura1);
		        
		        if (result4 == Number.POSITIVE_INFINITY || result4 == Number.NEGATIVE_INFINITY) {
		          output4.value = 0;
		        }else{
		          output4.value =  result4;
		        }

		        // Result 5
		        var dpp_bbm1 = parseFloat(dpp_bbm.value) || 0,
		            tarif_bbm1 = parseFloat(tarif_bbm.value) || 0;

		        var result5 = Math.round(dpp_bbm1*tarif_bbm1);
		        
		        if (result5 == Number.POSITIVE_INFINITY || result5 == Number.NEGATIVE_INFINITY) {
		          output5.value = 0;
		        }else{
		          output5.value =  result5;
		        }

		        // Result 6
		        var dpp_haktanah1 = parseFloat(dpp_haktanah.value) || 0,
		            tarif_haktanah1 = parseFloat(tarif_haktanah.value) || 0;

		        var result6 = Math.round(dpp_haktanah1*tarif_haktanah1);
		        
		        if (result6 == Number.POSITIVE_INFINITY || result6 == Number.NEGATIVE_INFINITY) {
		          output6.value = 0;
		        }else{
		          output6.value =  result6;
		        }

		        // Result 7
		        var dpp_sewa1 = parseFloat(dpp_sewa.value) || 0,
		            tarif_sewa1 = parseFloat(tarif_sewa.value) || 0;

		        var result7 = Math.round(dpp_sewa1*tarif_sewa1);
		        
		        if (result7 == Number.POSITIVE_INFINITY || result7 == Number.NEGATIVE_INFINITY) {
		          output7.value = 0;
		        }else{
		          output7.value =  result7;
		        }

		        // Result 8
		        var dpp_pelkonstruksi1 = parseFloat(dpp_pelkonstruksi.value) || 0,
		            tarif_pelkonstruksi1 = parseFloat(tarif_pelkonstruksi.value) || 0;

		        var result8 = Math.round(dpp_pelkonstruksi1*tarif_pelkonstruksi1);
		        
		        if (result8 == Number.POSITIVE_INFINITY || result8 == Number.NEGATIVE_INFINITY) {
		          output8.value = 0;
		        }else{
		          output8.value =  result8;
		        }

		        // Result 9
		        var dpp_perenkonstruksi1 = parseFloat(dpp_perenkonstruksi.value) || 0,
		            tarif_perenkonstruksi1 = parseFloat(tarif_perenkonstruksi.value) || 0;

		        var result9 = Math.round(dpp_perenkonstruksi1*tarif_perenkonstruksi1);
		        
		        if (result9 == Number.POSITIVE_INFINITY || result9 == Number.NEGATIVE_INFINITY) {
		          output9.value = 0;
		        }else{
		          output9.value =  result9;
		        }

		        // Result 10
		        var dpp_pengkonstruksi1 = parseFloat(dpp_pengkonstruksi.value) || 0,
		            tarif_pengkonstruksi1 = parseFloat(tarif_pengkonstruksi.value) || 0;

		        var result10 = Math.round(dpp_pengkonstruksi1*tarif_pengkonstruksi1);
		        
		        if (result10 == Number.POSITIVE_INFINITY || result10 == Number.NEGATIVE_INFINITY) {
		          output10.value = 0;
		        }else{
		          output10.value =  result10;
		        }

		        // Result 11
		        var dpp_dagang1 = parseFloat(dpp_dagang.value) || 0,
		            tarif_dagang1 = parseFloat(tarif_dagang.value) || 0;

		        var result11 = Math.round(dpp_dagang1*tarif_dagang1);
		        
		        if (result11 == Number.POSITIVE_INFINITY || result11 == Number.NEGATIVE_INFINITY) {
		          output11.value = 0;
		        }else{
		          output11.value =  result11;
		        }

		        // Result 12
		        var dpp_penerbangan1 = parseFloat(dpp_penerbangan.value) || 0,
		            tarif_penerbangan1 = parseFloat(tarif_penerbangan.value) || 0;

		        var result12 = Math.round(dpp_penerbangan1*tarif_penerbangan1);
		        
		        if (result12 == Number.POSITIVE_INFINITY || result12 == Number.NEGATIVE_INFINITY) {
		          output12.value = 0;
		        }else{
		          output12.value =  result12;
		        }

		        // Result 13
		        var dpp_pelayaran1 = parseFloat(dpp_pelayaran.value) || 0,
		            tarif_pelayaran1 = parseFloat(tarif_pelayaran.value) || 0;

		        var result13 = Math.round(dpp_pelayaran1*tarif_pelayaran1);
		        
		        if (result13 == Number.POSITIVE_INFINITY || result13 == Number.NEGATIVE_INFINITY) {
		          output13.value = 0;
		        }else{
		          output13.value =  result13;
		        }

		        // Result 14
		        var dpp_aktiva1 = parseFloat(dpp_aktiva.value) || 0,
		            tarif_aktiva1 = parseFloat(tarif_aktiva.value) || 0;

		        var result14 = Math.round(dpp_aktiva1*tarif_aktiva1);
		        
		        if (result14 == Number.POSITIVE_INFINITY || result14 == Number.NEGATIVE_INFINITY) {
		          output14.value = 0;
		        }else{
		          output14.value =  result14;
		        }

		        // Result 15
		        var dpp_derivatif1 = parseFloat(dpp_derivatif.value) || 0,
		            tarif_derivatif1 = parseFloat(tarif_derivatif.value) || 0;

		        var result15 = Math.round(dpp_derivatif1*tarif_derivatif1);
		        
		        if (result15 == Number.POSITIVE_INFINITY || result15 == Number.NEGATIVE_INFINITY) {
		          output15.value = 0;
		        }else{
		          output15.value =  result15;
		        }

		        // Result 16
		        var dpp_peredaran1 = parseFloat(dpp_peredaran.value) || 0,
		            tarif_peredaran1 = parseFloat(tarif_peredaran.value) || 0;

		        var result16 = Math.round(dpp_peredaran1*tarif_peredaran1);
		        
		        if (result16 == Number.POSITIVE_INFINITY || result16 == Number.NEGATIVE_INFINITY) {
		          output16.value = 0;
		        }else{
		          output16.value =  result16;
		        }



		        // Result Jumlah PPh
		        var resultpph4ayat2 =  Math.round(
		                                result1+
		                                result2+
		                                result3+
		                                result4+
		                                result5+
		                                result6+
		                                result7+
		                                result8+
		                                result9+
		                                result10+
		                                result11+
		                                result12+
		                                result13+
		                                result14+
		                                result15+
		                                result16
		                              );

		        if (resultpph4ayat2 == Number.POSITIVE_INFINITY || resultpph4ayat2 == Number.NEGATIVE_INFINITY) {
		          outputpph4ayat2.value = 0;
		        }else{
		          outputpph4ayat2.value = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(resultpph4ayat2);
		        }
		    };
		  </script>
      <!-- main-panel ends -->
      
@endsection
