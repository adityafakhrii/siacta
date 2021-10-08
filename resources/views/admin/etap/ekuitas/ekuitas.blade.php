@extends('layouts.master')
<title>Laporan Perubahan Ekuitas | SIACTA</title>
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
                      Laporan Perubahan Ekuitas
                    </h4>
                    <h5 class="card-title h6">
                      Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}
                    </h5>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover">

                      <tbody>

                        <?php $total_ma = 0; ?>
                        @foreach($modal_awal as $ma)
                        <tr>
                          <td>{{$ma->nama_akun}}</td>
                          <td></td>
                          <td>Rp{{ number_format($ma->saldo,2,",",".") }}</td>
                          <?php 
                            $total_ma += $ma->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <?php $total_tm = 0; ?>
                      	@foreach($tambahan_modal as $tm)
                        <tr>
                          <td>{{$tm->nama_akun}}</td>
                          <td></td>
                          <td>Rp{{ number_format($tm->saldo,2,",",".") }}</td>
                          <?php 
                            $total_tm += $tm->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr>
                          <td colspan="2">Total Tambahan Modal</td>
                          <td>Rp{{ number_format($total_tm,2,",",".") }}</td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Perubahan Modal</strong></td>
                          <td><strong>Rp{{ number_format($perubahan = $total_tm + $total_ma ,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td>Laba (Rugi) Bersih</td>
                          <td>Rp{{ number_format($total_labarugi,2,",",".") }}</td>
                          <td></td>
                        </tr>

                        <?php $total_prive = 0; ?>
                        @foreach($prive as $p)
                        <tr>
                          <td>{{$p->nama_akun}}</td>
                          <td>Rp{{ number_format($p->saldo,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_prive += $p->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr>
                          <td><h5><strong>Kenaikan (penurunan) modal</strong></h5></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($kenaikan = $total_labarugi - $total_prive,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td><h5><strong>Modal Akhir</strong></h5></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($perubahan + $kenaikan,2,",",".") }}</strong></td>
                        </tr>
                      </tbody>
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