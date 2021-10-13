@extends('layouts.master')
<title>Neraca Saldo Awal | SIACTA</title>
@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                  @if(Session::has('create'))
                    <div class="alert alert-fill-success" role="alert">
                      <i class="mdi mdi-alert-circle"></i>
                      {{Session::get('create')}}
                    </div>
                  @elseif(Session::has('update'))
                    <div class="alert alert-fill-warning" role="alert">
                      <i class="mdi mdi-alert-circle"></i>
                      {{Session::get('update')}}
                    </div>
                  @elseif(Session::has('delete'))
                    <div class="alert alert-fill-danger" role="alert">
                      <i class="mdi mdi-alert-circle"></i>
                      {{Session::get('delete')}}
                    </div>
                  @endif
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
                      Neraca Saldo Awal
                    </h4>
                    <h5 class="card-title h6">
                      Periode tanggal {{ date('d F Y', strtotime('first day of this month', time())) }}
                    </h5>
                  </div>
                  
                  <div class="row float-right">
                    @if(auth()->user()->status_neracaawal == 'belum_final')
                    <form action="/neraca-saldo-awal/konfirmasi" method="post">
                      @csrf
                      <button type="submit" class="btn btn-primary btn-icon-text" onclick="return confirm('Konfirmasi saldo awal? data ini tidak bisa diubah!')">
                        Konfirmasi
                        <i class="mdi mdi-content-save btn-icon-prepend"></i>
                      </button>
                    </form>
                    @else
                    <div class="col">
                      <a href="/neraca-saldo-awal/pdf" class="btn btn-info btn-icon-text">
                        Cetak PDF
                        <i class="mdi mdi-printer btn-icon-append"></i>
                      </a>
                    </div>
                    @endif
                  </div>


                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Nomor Akun</th>
                          <th>Nama Akun</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                          @if(auth()->user()->status_neracaawal == 'belum_final')
                          <th>Aksi</th>
                          @endif
                        </tr>
                      </thead>
                        <tbody>
                          <?php
                           $no = 1; 
                           $total_debit = 0;
                           $total_kredit = 0;
                          ?>
                          @foreach($neracasaldoawal as $awal)
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$awal->akun->no_akun}}</td>
                            <td>{{$awal->akun->nama_akun}}</td>
                            @if($awal->debit != NULL)
                            <td>
                            Rp{{ number_format($awal->debit,2,",",".") }}
                            </td>
                            @else
                            <td>-</td>
                            @endif
                            @if($awal->kredit != NULL)
                            <td>
                            Rp{{ number_format($awal->kredit,2,",",".") }}
                            </td>
                            @else
                            <td>-</td>
                            @endif
                            @if(auth()->user()->status_neracaawal == 'belum_final')
                            <td>
                                @if(($awal->debit == NULL || $awal->debit == 0) && ($awal->kredit == NULL || $awal->kredit == 0))
                                  <a class="btn btn-sm btn-inverse-warning" href="/neraca-saldo-awal/edit/{{$awal->id}}"><i class="mdi mdi-pencil-box-outline btn-icon-prepend"></i>
                                    Tambah Saldo
                                  </a>
                                @else

                                @endif
                            </td>
                            @endif
                          </tr>
                          <?php
                            $total_debit += $awal->debit;
                            $total_kredit += $awal->kredit;
                          ?>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <td align="center" colspan="3"> <h5><strong>Total</strong></h5> </td>
                          <td> <strong>Rp{{ number_format($total_debit,2,",",".") }}</strong></td>
                          <td><strong>Rp{{ number_format($total_kredit,2,",",".") }}</strong></td>
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