@extends('layouts.master')

<title>Tambah SPT PPh 22 | SIACTA</title>

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
                  <h4 class="card-title">Tambah SPT PPh 22 | SIACTA</h4>
                  <form action="/store-pph22" method="post" name="formsptpph22" onkeyup="calculatesptpph22()">
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
	                      <label class="col-form-label">1. Badan Usaha Industri/Eksportir</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_badan_usaha" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_badan_usaha" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_badan_usaha" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_badan_usaha" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_badan_usaha" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_badan_usaha" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">2. Penjualan Barang yang tergolong Sangat Mewah</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_penj_barang" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_penj_barang" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_penj_barang" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_penj_barang" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_penj_barang" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_penj_barang" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">3. Pembelian Barang Oleh Bendaharawan/Badan Tertentu Yang Ditunjuk</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_pembelian_bend" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_pembelian_bend" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_pembelian_bend" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_pembelian_bend" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_pembelian_bend" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_pembelian_bend" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <p class="card-description">
                    	4. Nilai Impor Bank Devisa/Ditjen Bea dan Cukai*	
                    </p>
	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">a. API</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_api" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_api" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_api" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_api" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_api" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_api" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">b. NON API</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_non_api" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_non_api" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_non_api" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_non_api" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_non_api" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_non_api" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">5. Hasil Lelang (Ditjen Bea dan Cukai)</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_hasil_lelang" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_hasil_lelang" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_hasil_lelang" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_hasil_lelang" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_hasil_lelang" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_hasil_lelang" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <p class="card-description">
                    	6. Penjualan Migas Oleh Pertamina / Badan Usaha Selain Pertamina
                    </p>
	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">a. SPBU/Agen/Penyalur (Final)</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_spbu" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_spbu" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_spbu" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_spbu" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_spbu" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_spbu" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">b. Pihak lain (Tidak Final)</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_pihak_lain" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_pihak_lain" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_pihak_lain" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_pihak_lain" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_pihak_lain" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_pihak_lain" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">7. Pembelian barang dan/atau bahan-bahan untuk keperluan kegiatan oleh Badan usaha tertentu meliputi BUMN dan badan usaha tertentu yang dimiliki secara langsung (PT Pupuk Sriwidjaja Palembang, dan yang lainnya.</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_bumn" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_bumn" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_bumn" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_bumn" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_bumn" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_bumn" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">8. Penjualan hasil produksi kepada distributor di dalam negeri oleh badan usaha yang bergerak di dalam bidang tertentu.</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_penj_hasil" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_penj_hasil" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_penj_hasil" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_penj_hasil" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_penj_hasil" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_penj_hasil" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">9. Penjualan kendaraan bermotor di dalam negeri oleh ATPM, APM, dan importir umum kendaraan bermotor, tidak termasuk alat berat.</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_penj_ken" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_penj_ken" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_penj_ken" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_penj_ken" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_penj_ken" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_penj_ken" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">10. Pembelian batubara, mineral logam, dari badan atau orang pribadi pemegang izin usaha pertambangan.</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_pemb_batu" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_pemb_batu" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_pemb_batu" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_pemb_batu" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_pemb_batu" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_pemb_batu" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-2">
	                      <label class="col-form-label">11. Penjualan emas batangan oleh badan usaha yang melakukan penjualan emas batangan di dalam negri.</label>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" maxlength="20" name="npwp_penj_emas" type="text" placeholder="NPWP">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="kap_penj_emas" type="text" placeholder="KAP/KJS">
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="nop_penj_emas" type="number" placeholder="Nilai Objek Pajak (Rp)">
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="tl_penj_emas" type="number" value="2" readonly>
	                    </div>
	                    <div class="col-lg-1">
	                    	<input class="form-control" name="t_penj_emas" type="number" placeholder="T(%)" step=".00001">
	                    </div>
	                    <div class="col-lg-2">
	                      <input class="form-control" name="pph_penj_emas" type="number" placeholder="PPh yang Dipungut (Rp)" readonly>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-3 text-center">
	                      <label class="col-form-label"><h4><strong>Jumlah NOP</strong></h4></label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="jumlah_nop" type="text" placeholder="Jumlah NOP" readonly>
	                    </div>
	                    <div class="col-lg-3 text-center">
	                      <label class="col-form-label"><h4><strong>Jumlah PPh</strong></h4></label>
	                    </div>
	                    <div class="col-lg-3">
	                    	<input class="form-control" name="jumlah_pph" type="text" placeholder="Jumlah PPh yang dipungut" readonly>
	                    </div>
	                  </div>	                  
	                  
	                  <hr>

	                  <h5 class="card-description">
                      <strong>C. Lampiran</strong>
                    </h5>
                    <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="1. Daftar Surat Setoran Pajak PPh Pasal 22 (Khusus untuk Bank Devisa, Bendaharawan/Badan Tertentu Yang Ditunjuk dan Pertamina/Badan Usaha selain Pertamina)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            1. Daftar Surat Setoran Pajak PPh Pasal 22 (Khusus untuk Bank Devisa, Bendaharawan/Badan Tertentu Yang Ditunjuk dan Pertamina/Badan Usaha selain Pertamina).
                          </label>
                        </div>
                      </div>
                    </div>

	                  <div class="form-group row">
	                    <div class="col-lg-8">
	                      <div class="form-check">
                          <label class="form-check-label">
                            <input value="2. Surat Setoran Pajak (SSP) yang disetor oleh importir atau Pembeli Barang sebanyak: (Khusus untuk Bank Devisa, Bendaharawan/Badan Tertentu Yang Ditunjuk dan Pertamina/Badan Usaha Selain Pertamina)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            2. Surat Setoran Pajak (SSP) yang disetor oleh importir atau Pembeli Barang sebanyak: (Khusus untuk Bank Devisa, Bendaharawan/Badan Tertentu Yang Ditunjuk dan Pertamina/Badan Usaha Selain Pertamina).
                          </label>
                        </div>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="lembar_importir" type="number" placeholder="Lembar">
	                    </div>
	                    <div class="col-lg-2">
	                    	<label class="col-form-label">Lembar</label>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-8">
	                      <div class="form-check">
                          <label class="form-check-label">
                            <input value="3. SSP yang disetor oleh Pemungut Pajak sebanyak : (Khusus untuk Badan Usaha Industri/Eksportir Tertentu, Ditjen Bea dan Cukai)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            3. SSP yang disetor oleh Pemungut Pajak sebanyak : (Khusus untuk Badan Usaha Industri/Eksportir Tertentu, Ditjen Bea dan Cukai).
                          </label>
                        </div>
	                    </div>
	                    <div class="col-lg-2">
	                    	<input class="form-control" name="lembar_pemungut" type="number" placeholder="Lembar">
	                    </div>
	                    <div class="col-lg-2">
	                    	<label class="col-form-label">Lembar</label>
	                    </div>
	                  </div>

	                  <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="4. Daftar Bukti Pemungutan PPh Pasal 22 (Khusus untuk Badan Usaha Industri/Importir Tertentu dan Ditjen Bea dan Cukai)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            4. Daftar Bukti Pemungutan PPh Pasal 22 (Khusus untuk Badan Usaha Industri/Importir Tertentu dan Ditjen Bea dan Cukai).
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="5. Bukti Pemungutan PPh Pasal 22 (Khusus untuk Badan Usaha Industri/Eksportir Tertentu dan Ditjen Bea dan Cukai)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            5. Bukti Pemungutan PPh Pasal 22 (Khusus untuk Badan Usaha Industri/Eksportir Tertentu dan Ditjen Bea dan Cukai).
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="6. Daftar rincian penjualan dan retur penjualan (dalam hal ada penjualan retur)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            6. Daftar rincian penjualan dan retur penjualan (dalam hal ada penjualan retur).
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="7. Risalah lelang (dalam hal pelaksanaan lelang)." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            7. Risalah lelang (dalam hal pelaksanaan lelang).
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
	                    <div class="col-lg-12">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input value="8. Surat Kuasa Khusus." type="checkbox" name="nama_lampiran[]" class="form-check-input">
                            8. Surat Kuasa Khusus.
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
                            <input type="radio" class="form-check-input" name="pengisi_spt" id="pengisi_spt" value="Pemungut Pajak/Pimpinan" required>
                            PEMUNGUT PAJAK/PIMPINAN
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
      <!-- main-panel ends -->
      
@endsection
