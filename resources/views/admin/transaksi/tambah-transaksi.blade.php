@extends('layouts.master')

<title>Transaksi | SIACTA</title>

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
                  <h4 class="card-title">Transaksi | SIACTA</h4>
                  	<form action="/store-transaksi" method="post" enctype="multipart/form-data" name="myform" onkeyup="calculate()">
                  	@csrf

	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Status Transaksi</label>
	                    </div>
	                    <div class="col-lg-8">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input onclick="removeDisabled();removeDisabledRadio();removeDisabledDP();" type="radio" class="form-check-input" name="status" id="optionsRadios3" value="pembelian" required>
		                              Pembelian
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input onclick="addDisabled();removeDisabledRadio();removeDisabledDP();" type="radio" class="form-check-input penjualan" name="status" id="optionsRadios3" value="penjualan">
		                              Penjualan
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input onclick="addDisabled();addDisabledRadio();" type="radio" class="form-check-input" name="status" id="optionsRadios3" value="penerimaan_kas">
		                              Penerimaan Kas
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input onclick="addDisabled();addDisabledRadio();" type="radio" class="form-check-input" name="status" id="optionsRadios3" value="pengeluaran_kas">
		                              Pengeluaran Kas
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input onclick="addDisabled();removeDisabledRadio();addDisabledDP();" type="radio" class="form-check-input" name="status" id="optionsRadios3" value="retur_penjualan">
		                              Retur Penjualan
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input onclick="addDisabled();removeDisabledRadio();addDisabledDP()" type="radio" class="form-check-input" name="status" id="optionsRadios3" value="retur_pembelian">
		                              Retur Pembelian
		                        </label>
		                    </div>
		                    <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Jenis Pembayaran</label>
	                    </div>
	                    <div class="col-lg-8">
	                        <div class="form-check">
		                        <label class="form-check-label">
		                              <input id="radio_jenis1" type="radio" class="form-check-input" name="jenis_pembayaran" id="optionsRadios2" value="tunai" required disabled>
		                              Tunai
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input id="radio_jenis2" type="radio" class="form-check-input" name="jenis_pembayaran" id="optionsRadios2" value="kredit" disabled>
		                              Kredit
		                        </label>
		                    </div>
		                    <div class="form-check">
		                        <label class="form-check-label">
		                              <input id="radio_jenis3" type="radio" class="form-check-input" name="jenis_pembayaran" id="optionsRadios2" value="dp" disabled>
		                              DP (Uang Muka)
		                        </label>
		                    </div>
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
			                      @foreach($akuns as $akun)

			                      <option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

			                      @endforeach
			                    </select>
			                    <input type="hidden" name="saldo_normal" value="{{$akun->saldo_normal}}">
			                  </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Bukti Transaksi (PDF/JPG)</label>
	                    </div>
	                    <div class="col-lg-8 grid-margin stretch-card">
			                <input type="file" class="dropify" name="bukti" required/>
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
	                      <label class="col-form-label">Tanggal Transaksi</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <div id="datepicker-popup" class="input-group date datepicker">
		                        <input type="text" class="form-control" name="tgl" required autocomplete="off">
		                        <span class="input-group-addon input-group-append border-left">
		                          <span class="mdi mdi-calendar input-group-text"></span>
		                        </span>
		                      </div>
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
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Nominal DP (Jika jenis DP)</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <input id="nominal_dp" name="nominal_dp" class="form-control" value="0" />
		                </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Diskon (Potongan)</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <input id="diskon" name="diskon" class="form-control" value="0" />
		                </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Nominal PPN (Jika ada)</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <input id="nominal_ppn" name="nominal_ppn" class="form-control" value="0" />
		                </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Nominal PPh 22 (Jika ada)</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <input id="pph22" name="nominal_pph22" class="form-control" value="0" disabled />
		                </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Nominal PPh 23 (Jika ada)</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <input id="pph23" name="nominal_pph23" class="form-control" value="0" disabled />
		                </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Umur Ekonomis</label>
	                    </div>
	                    <div class="col-lg-8">
	                    	<div id="datepicker-popup" class="input-group date datepicker">
		                        <input class="form-control" maxlength="5" name="umur_ekonomis" id="defaultconfig-2" type="number" placeholder="Tulis Umur Ekonomis.." min="0" max="999999999" value="0">
		                        <span class="input-group-addon input-group-append border-left">
		                          <span class="input-group-text">Hari</span>
		                        </span>
		                    </div>
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Nilai sisa</label>
	                    </div>
	                    <div class="col-8 grid-margin stretch-card">
		                      <input name="nilai_sisa" class="form-control" value="0"/>
		                </div>
	                  </div>
	                  <div class="form-group row">
	                    <div class="col-lg-4">
	                      <label class="col-form-label">Beban Penyusutan</label>
	                    </div>
	                    <div class="col-3 grid-margin stretch-card">
		                      <select class="js-example-basic-single w-100" name="id_akun_debit">
			                      <option value="" selected disabled>Pilih Akun Debit</option>
				                      @foreach($akundebit as $akun)

				                      	<option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

				                      @endforeach
			                    </select>
		                	</div>
		                	<div class="col-3 grid-margin stretch-card">
		                      <select class="js-example-basic-single w-100" name="id_akun_kredit">
			                      <option value="" selected disabled>Pilih Akun Kredit</option>
				                      @foreach($akunkredit as $akun)

				                      	<option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

				                      @endforeach
			                    </select>
		                	</div>
		                	<div class="col-2 grid-margin stretch-card">
		                      <input name="beban_penyusutan" class="form-control" type="text" readonly />
		                	</div>
	                  </div>
	                  <div class="form-group row">
	                    <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-file-check btn-icon-prepend"></i> Submit</button>
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