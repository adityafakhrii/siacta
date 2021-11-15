<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
	.page-break {
	    page-break-after: always;
	}
	.abu{
		color: #595959;
	}
	td {
	    text-align: center;
	    vertical-align: middle;
	}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
  }

	.table{
		width: 100%;
	    max-width: 100%;
	    margin-bottom: 20px;
		background-color: transparent;
		border-spacing: 0;
		border-collapse: collapse;
	}
</style>
<body style="    
    font-family: 'Montserrat', sans-serif;">

	
	<section id="container">
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="col-lg-12 mt">
          <div class="row content-panel">
            <div class="col-lg-10 col-lg-offset-1">
              <div class="invoice-body">
                <div class="pull-left">
                  <p style="
                    font-size: 1.5rem;
                    font-weight: 700;
                    line-height: 1.1px;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 35px;
                    ">
                    <b>BUMDes Sauyunan</b>
                  </p>
                	<p style="
                  	font-size: 1.3rem;
                  	font-weight: 700;
      					    line-height: 1.1px;
      					    text-align: center;
      					    color: #3b3b3b;
                    margin-bottom: 30px;
      					    ">
                    @if(Auth::user()->role == "unitusaha")
                    <b>Unit Usaha Air PAMDes</b>
                    @endif
      						</p>
                  <p style="
                    font-size: 1.25rem;
                    line-height: 1.1px;
                    font-weight: 500;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Catatan Atas Laporan Keuangan</b>
                  </p>
                  <p style="
                    font-size: 1rem;
                    font-weight: 300;
                    line-height: 1.1px;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}</b>
                  </p>
                </div>
                <!-- /pull-left -->
                
                @foreach($calks as $calk)
                    <form class="forms-sample" action="/emkm/calk/store" method="post">
                      <div class="form-group">
                        <label for="umum"><strong>1. UMUM</strong></label>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->umum}}</textarea>
                      </div>
                      <br>
                      <br>
                      <div class="form-group">
                        <label for="ikhtisar"><strong>2. IKHTISAR KEBIJAKAN AKUNTANSI PENTING</strong></label>
                        <p class="card-description abu abu">
                          <strong>a. Pernyataan Kepatuhan</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->pernyataan_kepatuhan}}</textarea>
                      </div>
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>b. Dasar Penyusunan</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->dasar_penyusunan}}</textarea>
                      </div>
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>c. Akumulasi Penyusutan</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->akum_penyusutan}}</textarea>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <p class="card-description abu">
                              <strong>Akumulasi Penyusutan</strong>
                            </p>
                            
                          </div>
                        </div>
                        <div class="table-responsive">
                          <table border="1" class="table table-hover" style="">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Nama Aset Tetap</th>
                                <th>Nilai Aset Tetap</th>
                                <th>Jumlah Unit</th>
                                <th>Total Harga</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no = 1;
                                $total = 0;
                              ?>
                              @foreach($akumulasis as $akumulasi)
                              <tr>
                                <td>{{$no++}}</td>
                                <td>{{$akumulasi->nama_aset}}</td>
                                <td>Rp{{ number_format($akumulasi->nilai_aset,2,",",".") }}</td>
                                <td>{{$akumulasi->jumlah_unit}}</td>
                                <td>Rp{{ number_format($akumulasi->total_harga,2,",",".") }}</td>

                                <?php $total += $akumulasi->total_harga; ?>
                              </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                              <tr>
                                <td align="center" colspan="4"><strong>Total</strong></td>
                                <td><strong>Rp{{ number_format($total,2,",",".") }}</strong></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>e. Pengakuan Pendapatan dan Beban</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->pendapatan_beban}}</textarea>
                      </div>

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>3. KAS</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($kasbanks as $kas)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$kas->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled name="pendapatan_beban" value="" class="form-control" id="exampleTextarea1" rows="4">{{$kas->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>

                      <div style="page-break-after: always;" class="page-break"></div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>4. INVESTASI JANGKA PENDEK</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($investasipendek as $investasi)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$investasi->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled name="pendapatan_beban" value="" class="form-control" id="exampleTextarea1" rows="4">{{$investasi->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>

                      <div class="form-group">
                        <label for="exampleTextarea1"><strong>5. PIUTANG USAHA</strong></label>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->piutang_usaha}}</textarea>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <p class="card-description abu">
                              <strong>a. Piutang Usaha</strong>
                            </p>
                            
                          </div>
                        </div>
                        <div class="table-responsive">
                          <table border="1" class="table table-hover">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Saldo</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no = 1;
                                $total = 0;
                              ?>
                              @foreach($piutangs as $piutang)
                              <tr>
                                <td>{{$no++}}</td>
                                <td>{{$piutang->akun->nama_akun}}</td>
                                <td>Rp{{ number_format($piutang->saldo,2,",",".") }}</td>

                                <?php $total += $piutang->saldo; ?>
                              </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                              <tr>
                                <td align="center" colspan="2"><strong>Total</strong></td>
                                <td><strong>Rp{{ number_format($total,2,",",".") }}</strong></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>b. Piutang Desa</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->piutang_desa}}</textarea>
                      </div>
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>c. Piutang Usaha Lainnya</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->piutang_lainnya}}</textarea>
                      </div>

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>6. PIUTANG NON USAHA</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($nonusaha as $usaha)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$usaha->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$usaha->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>7. PERLENGKAPAN</strong></label>
                          </div>
                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($perlengkapan as $per)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$per->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$per->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>
                      <div style="page-break-after: always;" class="page-break"></div>


                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>8. PEMBAYARAN DIMUKA</strong></label>
                          </div>
                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($pembayaran as $pem)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$pem->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$pem->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <label for="exampleTextarea1"><strong>9. RK PUSAT</strong></label>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->rk_pusat}}</textarea>
                      </div>

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>10. ASET LANCAR LAINNYA</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($asetlain as $aset)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$aset->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$aset->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>11. INVESTASI JANGKA PANJANG</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($investasipanjang as $panjang)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$panjang->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$panjang->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>12. ASET TETAP</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($asettetap as $tetap)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$tetap->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$tetap->keterangan}}</textarea>
                      </div>
                      @endforeach
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <p class="card-description abu">
                              <strong>Harga Perolehan</strong>
                            </p>
                            
                          </div>
                        </div>
                        <div class="table-responsive">
                          <table border="1" class="table table-hover">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Nama Aset Tetap</th>
                                <th>Nilai Aset Tetap</th>
                                <th>Jumlah Unit</th>
                                <th>Total Harga</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no = 1;
                                $total = 0;
                              ?>
                              @foreach($asets as $aset)
                              <tr>
                                <td>{{$no++}}</td>
                                <td>{{$aset->nama_aset}}</td>
                                <td>Rp{{ number_format($aset->nilai_aset,2,",",".") }}</td>
                                <td>{{$aset->jumlah_unit}}</td>
                                <td>Rp{{ number_format($aset->total_harga,2,",",".") }}</td>

                                <?php $total += $aset->total_harga; ?>
                              </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                              <tr>
                                <td align="center" colspan="4"><strong>Total</strong></td>
                                <td><strong>Rp{{ number_format($total,2,",",".") }}</strong></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>

                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>13. ASET TETAP LEASING</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($asetleasing as $leasing)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$leasing->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$leasing->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>
                      <div style="page-break-after: always;" class="page-break"></div>


                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>14. PROPERTI INVESTASI</strong></label>
                          </div>
                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($properti as $pro)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$pro->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$pro->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <label for="exampleTextarea1"><strong>15. ASET TETAP DALAM PENYELESAIAN</strong></label>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$calk->aset_tetap_penyelesaian}}</textarea>
                      </div>

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>16. ASET TIDAK BERWUJUD</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($asettidakberwujud as $tidak)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$tidak->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$tidak->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>17. KEWAJIBAN JANGKA PENDEK</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($kewajibanpendek as $pendek)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$pendek->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$pendek->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>18. KEWAJIBAN JANGKA PANJANG</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($kewajibanpanjang as $panjang)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$panjang->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$panjang->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>19. KEWAJIBAN LAIN-LAIN</strong></label>
                          </div>

                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($kewajibanlain as $lain)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$lain->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$lain->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <br>
                      <br>

                      <div class="form-group">
                        <div class="row">
                          <div class="col col-lg-10">
                            <label for="exampleTextarea1"><strong>20. EKUITAS</strong></label>
                          </div>
                        </div>
                      </div>
                      <?php 
                        $letter = 'a';
                        $letterAscii = ord($letter);
                      ?>
                      @foreach($ekuitas as $ekui)
                      <div class="form-group">
                        <p class="card-description abu">
                          <strong>{{chr($letterAscii++)}}. {{$ekui->akun->nama_akun}}</strong>
                        </p>
                        <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$ekui->keterangan}}</textarea>
                      </div>
                      @endforeach

                      <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
                    </form>
                  @endforeach
                <br>
                <br>
              </div>
              
      </section>
    </section>
</section>
	
</body>