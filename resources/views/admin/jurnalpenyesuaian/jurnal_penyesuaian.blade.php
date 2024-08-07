@extends('layouts.master')
<title>Jurnal Penyesuaian | SIACTA</title>

@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
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
                          Jurnal Penyesuaian
                        </h4>
                        <h5 class="card-title h6">
                          Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-10 grid-margin grid-margin-lg-0">

                    </div>
                    <div class="col-lg-2 grid-margin grid-margin-lg-0">
                      <a href="/jurnal-penyesuaian/transaksi" class="btn btn-sm btn-primary btn-icon-text">
                        <i class="mdi mdi-database-plus btn-icon-prepend"></i>
                              Tambah Transaksi
                      </a>
                    </div>
                  </div>

                  @if($jurnalpenyesuaian->count() != 0)
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

                        @foreach($jurnalpenyesuaian as $jurnal)
                        <tr>
                          @if (!in_array($jurnal->id_transbaru, $renderedTanggal))

                              <?php $renderedTanggal[] = $jurnal->id_transbaru ?>
                              <td rowspan="{{count((array)$jurnal->id_transbaru)}}">
                                <center>{{$jurnal->transbaru->tgl}}</center>
                              </td>

                          @else
                            <td></td>
                          @endif

                          <td><center>{{$jurnal->akun->no_akun}}</center></td>
                          <td>{{$jurnal->akun->nama_akun}}</td>

                          @if($jurnal->debit != NULL)
                            <td style="text-align: right">
                            Rp{{ number_format($jurnal->debit,2,",",".") }}
                            </td>
                          @else
                            <td><center>-</center></td>
                          @endif

                          @if($jurnal->kredit != NULL)
                            <td style="text-align: right">
                            Rp{{ number_format($jurnal->kredit,2,",",".") }}
                            </td>
                          @else
                            <td><center>-</center></td>
                          @endif

                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  @else
                    <h4 class="text-center">Tidak ada transaksi hari ini</h4>
                  @endif
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