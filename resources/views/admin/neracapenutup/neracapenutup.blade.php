@extends('layouts.master')
<title>Neraca Penutup | SIACTA</title>
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
                    @endif
                    <h4 class="card-title">
                      Neraca Penutup
                    </h4>
                    <h5 class="card-title h6">
                      Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}
                    </h5>
                  </div>

                  <div class="row float-right">
                    <div class="col">
                      <a href="/neraca-penutup/pdf" class="btn btn-info btn-icon-text">
                        Cetak PDF
                        <i class="mdi mdi-printer btn-icon-append"></i>
                      </a>
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nomor Akun</th>
                          <th>Nama Akun</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php

                          $no = 1;
                          $total_debit = 0;
                          $total_kredit = 0;

                        ?>
                      	@foreach($neracapenutup as $neraca)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$neraca->no_akun}}</td>
                          <td>{{$neraca->nama_akun}}</td>
                          @if($neraca->saldo_normal == 'debit')
                            <td>Rp{{ number_format($neraca->saldo,2,",",".") }}</td>
                            <td>-</td>  
                            <?php 
                              $total_debit += $neraca->saldo;
                            ?>
                          @elseif($neraca->saldo_normal == 'kredit')
                            <td>-</td>
                            <td>Rp{{ number_format($neraca->saldo,2,",",".") }}</td>
                            <?php 
                              $total_kredit += $neraca->saldo;
                            ?>
                          @endif
                        </tr>
                        @endforeach

                        @foreach($modals as $modals)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$modals->no_akun}}</td>
                          <td>{{$modals->nama_akun}}</td>
                          <td>-</td>
                          <td>Rp{{ number_format($total_labarugi,2,",",".") }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3" align="center"><h4>Total</h4></td>
                          <td><strong>Rp{{ number_format($total_debit,2,",",".") }}</strong></td>

                          @if($total_labarugi > 0)
                            <td><strong>Rp{{ number_format($total_kredit+$total_labarugi,2,",",".") }}</strong></td>
                          @elseif($total_labarugi < 0)
                            <td><strong>Rp{{ number_format($total_kredit-$total_labarugi,2,",",".") }}</strong></td>
                          @endif
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