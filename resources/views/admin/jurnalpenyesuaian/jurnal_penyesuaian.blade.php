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
                    <div class="col-lg-12 grid-margin grid-margin-lg-0">
                        <h4 class="card-title text-center">Jurnal Penyesuaian</h4>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-8">
                      <a href="/jasa/jurnal-penyesuaian/transaksi" class="btn btn-sm btn-primary btn-icon-text">
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