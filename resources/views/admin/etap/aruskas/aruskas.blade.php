@extends('layouts.master')
<title>Laporan Arus Kas | SIACTA</title>
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
                      Laporan Arus Kas
                    </h4>
                    <h5 class="card-title h6">
                      Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}
                    </h5>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover">

                      <tbody>

                        <tr>
                          <td colspan="2"><h5><strong>Aktivitas Operasional</strong></h5></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Pendapatan Operasional</strong></td>
                          <td></td>
                        </tr>

                        <?php $total_po = 0; ?>
                        @foreach($operasional as $po)
                        <tr>
                          <td>{{$po->no_akun}}</td>

                          <td>{{$po->nama_akun}}</td>
                          <td>Rp{{ number_format($po->saldo,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_po += $po->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td><strong>Total Pendapatan Operasional</strong></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($total_po,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="2"><strong>Beban Operasional</strong></td>
                          <td></td>
                        </tr>
                        <?php $total_bo = 0; ?>
                        @foreach($beban as $bo)
                        <tr>
                          <td>{{$bo->no_akun}}</td>
                          <td>{{$bo->nama_akun}}</td>
                          <td>Rp{{ number_format($bo->saldo,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_bo += $bo->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td><strong>Total Beban Operasional</strong></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($total_bo,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td><h5><strong>Arus Kas dari Aktivitas Operasional</strong></h5></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($total_po-$total_bo,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="2"><h5><strong>Aktivitas Investasi</strong></h5></td>
                          <td></td>
                        </tr>

                        <tr>
                          <td colspan="2"><strong>Pendapatan Investasi</strong></td>
                          <td></td>
                        </tr>
                        <?php $total_intambah = 0; ?>
                        @foreach($investtambah as $in)
                        <tr>
                          <td>{{$in->no_akun}}</td>
                          <td>{{$in->nama_akun}}</td>
                          <td>Rp{{ number_format($in->kredit,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_intambah += $in->kredit;
                          ?>
                        </tr>
                        @endforeach
                        <?php $total_intambah2 = 0; ?>
                        @foreach($investtambah2 as $in)
                        <tr>
                          <td>{{$in->no_akun}}</td>
                          <td>{{$in->nama_akun}}</td>
                          <td>Rp{{ number_format($in->saldo,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_intambah2 += $in->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <?php $total_tambah = $total_intambah+$total_intambah2 ?>

                        <tr>
                          <td><strong>Total Pendapatan Investasi</strong></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($total_intambah+$total_intambah2,2,",",".") }}</strong></td>
                        </tr>


                        <tr>
                          <td colspan="2"><strong>Beban Investasi</strong></td>
                          <td></td>
                        </tr>

                        <?php $total_inkurang = 0; ?>
                        @foreach($investkurang as $in)
                        <tr>
                          <td>{{$in->no_akun}}</td>
                          <td>{{$in->nama_akun}}</td>
                          <td>Rp{{ number_format($in->debit,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_inkurang += $in->debit;
                          ?>
                        </tr>
                        @endforeach

                        <?php $total_inkurang2 = 0; ?>
                        @foreach($investkurang2 as $in)
                        <tr>
                          <td>{{$in->no_akun}}</td>
                          <td>{{$in->nama_akun}}</td>
                          <td>Rp{{ number_format($in->saldo,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_inkurang2 += $in->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td><strong>Total Beban Investasi</strong></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($total_inkurang+$total_inkurang2,2,",",".") }}</strong></td>
                        </tr>

                        <?php $total_kurang = $total_inkurang+$total_inkurang2 ?>

                        <tr>
                          <td><h5><strong>Arus Kas dari Aktivitas Investasi</strong></h5></td>
                          <td></td>
                          <td><strong>Rp{{ number_format($total_tambah-$total_kurang,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="2"><h5><strong>Aktivitas Pendanaan</strong></h5></td>
                          <td></td>
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