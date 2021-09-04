@extends('layouts.master')

<title>Catatan Atas Laporan Keuangan | SIACTA</title>

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
                  <h4 class="card-title text-center">Catatan Atas Laporan Keuangan</h4>
                  <form class="forms-sample" action="/calk-store" method="post">
                    @csrf
                    <div class="form-group">
                      <label for="exampleTextarea1"><strong>1. UMUM</strong></label>
                      <textarea name="umum" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                      <label for="exampleTextarea1"><strong>2. IKHTISAR KEBIJAKAN AKUNTANSI PENTING</strong></label>
                      <p class="card-description">
		                    <strong>a. Pernyataan Kepatuhan</strong>
		                  </p>
                      <textarea name="penyataan_kepatuhan" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <p class="card-description">
		                    <strong>b. Dasar Penyusunan</strong>
		                  </p>
                      <textarea name="dasar_penyusunan" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <p class="card-description">
		                    <strong>c. Piutang Usaha</strong>
		                  </p>
                      <textarea name="piutang_usaha" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <p class="card-description">
                        <strong>d. Akumulasi Penyusutan</strong>
                      </p>
                      <textarea name="akumulasi_penyusutan" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <p class="card-description">
                            <strong>Akumulasi Penyusutan</strong>
                          </p>
                          
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-akumulasi">Tambah Data</a>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-hover">
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
                            @foreach($akumulasis as $akumulasis)
                            <tr>
                              <td>{{$no++}}</td>
                              <td>{{$akumulasis->nama_aset}}</td>
                              <td>Rp{{ number_format($akumulasis->nilai_aset,2,",",".") }}</td>
                              <td>{{$akumulasis->jumlah_unit}}</td>
                              <td>Rp{{ number_format($akumulasis->total_harga,2,",",".") }}</td>

                              <?php $total += $akumulasis->total_harga; ?>
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
                      <p class="card-description">
                        <strong>e. Pengakuan Pendapatan dan Beban</strong>
                      </p>
                      <textarea name="pendapatan_beban" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>3. KAS</strong></label>
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-kas-bank">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($kasbanks as $kas)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$kas->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled name="pendapatan_beban" value="" class="form-control" id="exampleTextarea1" rows="4">{{$kas->keterangan}}</textarea>
                    </div>
                    @endforeach

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>4. INVESTASI JANGKA PENDEK</strong></label>
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-investasi-pendek">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($investasipendek as $investasi)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$investasi->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled name="pendapatan_beban" value="" class="form-control" id="exampleTextarea1" rows="4">{{$investasi->keterangan}}</textarea>
                    </div>
                    @endforeach

                    <hr>

                    <div class="form-group">
                      <label for="exampleTextarea1"><strong>5. PIUTANG USAHA</strong></label>
                      <textarea name="piutang_usaha" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <p class="card-description">
                            <strong>a. Piutang Usaha</strong>
                          </p>
                          
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-piutang">Tambah Data</a>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-hover">
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
                      <p class="card-description">
                        <strong>b. Piutang Desa</strong>
                      </p>
                      <textarea name="piutang_desa" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <p class="card-description">
                        <strong>c. Piutang Usaha Lainnya</strong>
                      </p>
                      <textarea name="piutang_lainnya" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>6. PIUTANG NON USAHA</strong></label>
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-piutang-non">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($nonusaha as $usaha)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$usaha->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$usaha->keterangan}}</textarea>
                    </div>
                    @endforeach

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>7. PERLENGKAPAN</strong></label>
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-perlengkapan">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($perlengkapan as $per)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$per->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$per->keterangan}}</textarea>
                    </div>
                    @endforeach

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>8. PEMBAYARAN DIMUKA</strong></label>
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-pembayaranmuka">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($pembayaran as $pem)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$pem->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$pem->keterangan}}</textarea>
                    </div>
                    @endforeach

                    <hr>

                    <div class="form-group">
                      <label for="exampleTextarea1"><strong>9. RK PUSAT</strong></label>
                      <textarea name="umum" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>10. ASET LANCAR LAINNYA</strong></label>
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-aset-lain">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($asetlain as $aset)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$aset->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$aset->keterangan}}</textarea>
                    </div>
                    @endforeach

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>11. INVESTASI JANGKA PANJANG</strong></label>
                        </div>
                        <div class="col col-lg-2">
                        <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-investasi-panjang">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($investasipanjang as $panjang)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$panjang->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$panjang->keterangan}}</textarea>
                    </div>
                    @endforeach

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>12. ASET TETAP</strong></label>
                        </div>
                        <div class="col col-lg-2">
                        <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-aset-tetap">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($asettetap as $tetap)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$tetap->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$tetap->keterangan}}</textarea>
                    </div>
                    @endforeach
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <p class="card-description">
                            <strong>Harga Perolehan</strong>
                          </p>
                          
                        </div>
                        <div class="col col-lg-2">
                          <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-aset">Tambah Data</a>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-hover">
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

                    <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col col-lg-10">
                          <label for="exampleTextarea1"><strong>13. ASET TETAP LEASING</strong></label>
                        </div>
                        <div class="col col-lg-2">
                        <a class="btn btn-sm btn-primary btn-icon-text float-right" href="/emkm/calk/tambah-aset-leasing">Tambah Data</a>
                        </div>
                      </div>
                    </div>
                    <?php 
                      $letter = 'a';
                      $letterAscii = ord($letter);
                    ?>
                    @foreach($asetleasing as $leasing)
                    <div class="form-group">
                      <p class="card-description">
                        <strong>{{chr($letterAscii++)}}. {{$leasing->akun->nama_akun}}</strong>
                      </p>
                      <textarea disabled value="" class="form-control" id="exampleTextarea1" rows="4">{{$leasing->keterangan}}</textarea>
                    </div>
                    @endforeach


                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
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