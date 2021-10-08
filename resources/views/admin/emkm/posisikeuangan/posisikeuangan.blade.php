@extends('layouts.master')
<title>Laporan Posisi Keuangan | SIACTA</title>
@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="text-center">
                    <h4 class="card-title">
                      <strong>BUMDes Sauyunan</strong>
                    </h4>
                    @if(Auth::user()->role == "unitusaha")
                    <h4 class="card-title">
                      <strong>Unit Usaha Air PAMDes</strong>
                    </h4>
                    <h4 class="card-title">
                      Laporan Posisi Keuangan
                    </h4>
                    @else
                    <h4 class="card-title">
                      Laporan Neraca
                    </h4>
                    @endif
                    <h5 class="card-title h6">
                      Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}
                    </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <td align="center" colspan="3"> <strong>ASET</strong> </td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>Aset Lancar</strong> </td>
                        </tr>
                      	<?php $total_aslan = 0; ?>
                      	@foreach($asetlancar as $aslan)
                        <tr>
                          <td>{{$aslan->no_akun}}</td>
                          <td>{{$aslan->nama_akun}}</td>
                          <td>Rp{{ number_format($aslan->saldo,2,",",".") }}</td>
                          <?php 
                            $total_aslan += $aslan->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="2"> <strong>Total Aset Lancar</strong> </td>
                          <td><strong>Rp{{ number_format($total_aslan,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>Aset Tetap</strong> </td>
                        </tr>
                        <?php $total_astetdeb = 0; ?>
                        @foreach($asettetapdebit as $astetdeb)
                        <tr>
                          <td>{{$astetdeb->no_akun}}</td>
                          <td>{{$astetdeb->nama_akun}}</td>
                          <td>Rp{{ number_format($astetdeb->saldo,2,",",".") }}</td>
                          <?php 
                            $total_astetdeb += $astetdeb->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <?php $total_astetkre = 0; ?>
                        @foreach($asettetapkredit as $astetkre)
                        <tr>
                          <td>{{$astetkre->no_akun}}</td>
                          <td>{{$astetkre->nama_akun}}</td>
                          <td>Rp{{ number_format($astetkre->saldo,2,",",".") }}</td>
                          <?php 
                            $total_astetkre += $astetkre->saldo;
                          ?>
                        </tr>
                        @endforeach


                        <tr>
                          <td colspan="2"> <strong>Total Aset Tetap</strong> </td>
                          <td><strong>Rp{{ number_format($total_astet = $total_astetdeb-$total_astetkre,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>Aset Tidak Berwujud</strong> </td>
                        </tr>
                        <?php $total_astiber = 0; ?>
                        @foreach($asettidakberwujud as $astiber)
                        <tr>
                          <td>{{$astiber->no_akun}}</td>
                          <td>{{$astiber->nama_akun}}</td>
                          <td>Rp{{ number_format($astiber->saldo,2,",",".") }}</td>
                          <?php
                            $total_astiber += $astiber->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="2"> <strong>Total Aset Tidak Berwujud</strong> </td>
                          <td><strong>Rp{{ number_format($total_astiber,2,",",".") }}</strong></td>
                        </tr>

                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2" align="center"><strong>TOTAL ASET</strong></td>
                          <td><strong>Rp{{ number_format($total1 = $total_aslan+$total_astet+$total_astiber,2,",",".") }}</strong></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <td align="center" colspan="3"> <strong>KEWAJIBAN & EKUITAS</strong> </td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>KEWAJIBAN</strong> </td>
                        </tr>
                        <?php $total_kew = 0; ?>
                        @foreach($kewajiban as $kew)
                        <tr>
                          <td>{{$kew->no_akun}}</td>
                          <td>{{$kew->nama_akun}}</td>
                          <td>Rp{{ number_format($kew->saldo,2,",",".") }}</td>
                          <?php 
                            $total_kew += $kew->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="2"> <strong>Total Kewajiban</strong> </td>
                          <td><strong>Rp{{ number_format($total_kew,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>EKUITAS</strong> </td>
                        </tr>
                        <?php $total_ekui = 0; ?>
                        @foreach($ekuitas as $ekui)
                        <tr>
                          <td>{{$ekui->no_akun}}</td>
                          <td>{{$ekui->nama_akun}}</td>
                          <td>Rp{{ number_format($ekui->saldo,2,",",".") }}</td>
                          <?php 
                            $total_ekui += $ekui->saldo;
                          ?>
                        </tr>
                        @endforeach

                        @if($total_labarugi < 0)
                          @foreach ($saldorugi as $sr)
                          <tr>
                            <td>{{$sr->no_akun}}</td>
                            <td>{{$sr->nama_akun}}</td>
                            <td><strong>Rp{{ number_format($total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                            
                          @endforeach
                          <tr>
                            <td colspan="2"> <strong>Total Ekuitas</strong> </td>
                            <td><strong>Rp{{ number_format($total_ekuitas = $total_ekui+$total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                        @elseif($total_labarugi > 0)
                          @foreach ($saldolaba as $sl)
                          <tr>
                            <td>{{$sl->no_akun}}</td>
                            <td>{{$sl->nama_akun}}</td>
                            <td><strong>Rp{{ number_format($total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                            
                          @endforeach
                          <tr>
                            <td colspan="2"> <strong>Total Ekuitas</strong> </td>
                            <td><strong>Rp{{ number_format($total_ekuitas = $total_ekui+$total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                        @else
                          <tr>
                            <td colspan="2"> <strong>Total Ekuitas</strong> </td>
                            <td><strong>Rp{{ number_format($total_ekuitas = $total_ekui+0,2,",",".") }}</strong></td>
                          </tr>
                        @endif

                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2" align="center"><strong>TOTAL KEWAJIBAN & EKUITAS</strong></td>
                          <td><strong>Rp{{ number_format($total2 = $total_kew+$total_ekuitas,2,",",".") }}</strong></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
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