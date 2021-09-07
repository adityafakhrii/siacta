@extends('layouts.master')
<title>Jurnal Penutup | SIACTA</title>

@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12 grid-margin grid-margin-lg-0">
                          <div class="text-center">
                            <h4 class="card-title">
                              <strong>BUMDes Sauyunan</strong>
                            </h4>
                            <h4 class="card-title">
                              <strong>Unit Usaha {{Auth::user()->unitusaha->jenis}}</strong>
                            </h4>
                            <h4 class="card-title">
                              Jurnal Penutup
                            </h4>
                            <h5 class="card-title h6">
                              Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}
                            </h5>
                          </div>
                      </div>
                    </div>

                  {{-- @if($jurnalpenutup->count() != 0) --}}
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th><center>Tanggal</center></th>
                          <th><center>Nomor Akun</center></th>
                          <th><center>Nama Akun</center></th>
                          <th><center>Debit</center></th>
                          <th><center>Kredit</center></th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php $renderedTanggal = []; ?>

                        <?php $total_ikhtisar = 0; ?>

                        @foreach($jurnalpenutup91 as $jurnal)
                          <?php $total_ikhtisar += $jurnal->saldo; ?>
                        @endforeach

                        @foreach($ikhtisar as $ikhti)
                        <tr>
                          <td>30/09/2021</td>
                          <td align="center">{{$ikhti->no_akun}}</td>
                          <td>{{$ikhti->nama_akun}}</td>
                          <td align="right"><strong>Rp{{ number_format($total_ikhtisar,2,",",".") }}</strong></td>
                          <td align="center">-</td>
                        </tr>
                        @endforeach

                        @foreach($jurnalpenutup91 as $jurnal)
                        <tr>

                          <td></td>
                          <td><center>{{$jurnal->no_akun}}</center></td>
                          <td>{{$jurnal->nama_akun}}</td>
                          <td><center>-</center></td>

                          @if($jurnal->debit != NULL)
                            <td style="text-align: right">
                            Rp{{ number_format($jurnal->saldo,2,",",".") }}
                            </td>
                          @else
                            <td><center>-</center></td>
                          @endif
                          
                        </tr>
                        @endforeach


                        <?php $total_ikhtisar = 0; ?>
                        @foreach($jurnalpenutup81 as $jurnal)
                        <tr>

                          <td></td>
                          <td><center>{{$jurnal->no_akun}}</center></td>
                          <td>{{$jurnal->nama_akun}}</td>

                          @if($jurnal->kredit != NULL)
                            <td style="text-align: right">
                            Rp{{ number_format($jurnal->saldo,2,",",".") }}
                            </td>
                          @else
                            <td><center>-</center></td>
                          @endif

                          <td><center>-</center></td>

                          <?php $total_ikhtisar += $jurnal->kredit; ?>
                        </tr>
                        @endforeach

                        @foreach($ikhtisar as $ikhti)
                        <tr>
                          <td></td>
                          <td align="center">{{$ikhti->no_akun}}</td>
                          <td>{{$ikhti->nama_akun}}</td>
                          <td align="center">-</td>
                          <td align="right"><strong>Rp{{ number_format($total_ikhtisar,2,",",".") }}</strong></td>
                        </tr>
                        @endforeach

                        @if($total_labarugi < 0)
                            @foreach($modals as $modal)
                            <tr>
                              <td></td>
                              <td align="center">{{$modal->no_akun}}</td>
                              <td>{{$modal->nama_akun}}</td>
                              <td align="right"><strong>Rp{{ number_format(-$total_labarugi,2,",",".") }}</strong></td>
                              <td align="center">-</td>
                            </tr>
                            @endforeach

                            @foreach($saldorugi as $sr)
                            <tr>
                              <td></td>
                              <td align="center">{{$sr->no_akun}}</td>
                              <td>{{$sr->nama_akun}}</td>
                              <td align="center">-</td>
                              <td align="right"><strong>Rp{{ number_format(-$total_labarugi,2,",",".") }}</strong></td>
                            </tr>
                            @endforeach

                        @elseif($total_labarugi > 0)
                            @foreach($saldolaba as $sr)
                            <tr>
                              <td></td>
                              <td align="center">{{$sr->no_akun}}</td>
                              <td>{{$sr->nama_akun}}</td>
                              <td align="right"><strong>Rp{{ number_format($total_labarugi,2,",",".") }}</strong></td>
                              <td align="center">-</td>
                            </tr>
                            @endforeach
                            @foreach($modals as $modal)
                            <tr>
                              <td></td>
                              <td align="center">{{$modal->no_akun}}</td>
                              <td>{{$modal->nama_akun}}</td>
                              <td align="center">-</td>
                              <td align="right"><strong>Rp{{ number_format($total_labarugi,2,",",".") }}</strong></td>
                            </tr>
                            @endforeach

                        @endif


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