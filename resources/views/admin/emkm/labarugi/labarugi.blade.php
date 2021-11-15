@extends('layouts.master')
<title>Laporan Laba Rugi | SIACTA</title>
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
                      Laporan Laba Rugi
                    </h4>
                    <h5 class="card-title h6">
                      Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}
                    </h5>
                  </div>

                  <div class="row float-right">
                    <div class="col">
                      <a href="/laba-rugi/pdflogin" class="btn btn-primary btn-icon-text">
                        Cetak PDF
                        <i class="mdi mdi-printer btn-icon-append"></i>
                      </a>
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-hover">

                      <tbody>

                        <tr>
                          <td colspan="3"><h5><strong>Pendapatan</strong></h5></td>
                        </tr>
                        <?php $total_pendapatan = 0; ?>
                      	@foreach($labarugi_pendapatan as $lr)
                        <tr>
                          <td>{{$lr->nama_akun}}</td>
                          <td>Rp{{ number_format($lr->saldo,2,",",".") }}</td>
                          <?php 
                            $total_pendapatan += $lr->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr>
                          <td colspan="2"><strong>Total Pendapatan</strong></td>
                          <td><strong>Rp{{ number_format($total_pendapatan,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"><h5><strong>Beban</strong></h5></td>
                        </tr>
                        <?php $total_beban = 0; ?>
                        @foreach($labarugi_beban as $lb)
                        <tr>
                          <td>{{$lb->nama_akun}}</td>
                          <td colspan="2">Rp{{ number_format($lb->saldo,2,",",".") }}</td>
                          <?php 
                            $total_beban += $lb->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr style="background-color: #EAEAF1;">
                          <td colspan="2"><strong>Total Beban</strong></td>
                          <td><strong>Rp{{ number_format($total_beban,2,",",".") }}</strong></td>
                        </tr>

                        <tr style="background-color: #e8e6ff;">
                          <td colspan="2"><h5><strong>Laba (Rugi) bersih sebelum pajak</strong></h5></td>
                          <td><strong>Rp{{ number_format( $total_semua = $total_pendapatan - $total_beban,2,",",".") }}</strong></td>
                        </tr>

                        
                        <tr>
                          <td colspan="2">Pajak</td>
                          <?php 
                              $pajak = $total_pendapatan * (0.5/100);
                          ?>
                            <td>Rp{{ number_format(floor($pajak),2,",",".") }}</td>
                        </tr>

                        <tr>
                          <td colspan="2"><h5><strong>Laba (Rugi) bersih setelah pajak</strong></h5></td>
                          <td><strong>Rp{{ number_format( floor($total_semua - $pajak),2,",",".") }}</strong></td>
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