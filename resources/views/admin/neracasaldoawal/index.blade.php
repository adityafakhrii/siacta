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
                    @if(auth()->user()->role == 'unitusaha')
                    <h4 class="card-title">
                      <strong>Unit Usaha {{Auth::user()->unitusaha->jenis}}</strong>
                    </h4>
                    @endif
                    <h4 class="card-title">
                      Neraca Saldo Awal
                    </h4>
                    <h5 class="card-title h6">
                      Periode tanggal {{ date('d F Y', strtotime('first day of this month', time())) }}
                    </h5>
                  </div>
                  
                  @if(auth()->user()->status_neracaawal == 'belum_final')
                               
                  <form action="/neraca-saldo-awal/konfirmasi" method="post">
                    @csrf
                  <button onclick="return confirm('Konfirmasi saldo awal? data ini tidak bisa diubah!')" type="submit" href="/neraca-saldo-awal/konfirmasi" class="float-right btn btn-sm btn-primary btn-icon-text">
                    <i class="mdi mdi-content-save btn-icon-prepend"></i>
                          Konfirmasi
                  </button>
                  @endif
                    
                  </form>

                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nomor Akun</th>
                          <th>Nama Akun</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1; ?>
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
                          <td>
                            @if(auth()->user()->status_neracaawal == 'belum_final')
                              @if(($awal->debit == NULL || $awal->debit == 0) && ($awal->kredit == NULL || $awal->kredit == 0))
                                <a class="btn btn-sm btn-inverse-warning" href="/neraca-saldo-awal/edit/{{$awal->id}}"><i class="mdi mdi-pencil-box-outline btn-icon-prepend"></i>
                                  Tambah Saldo
                                </a>
                              @else

                              @endif
                            @endif

                            <a class="btn btn-sm btn-inverse-danger" href="/neraca-saldo-awal/hapus/{{$awal->id}}" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-delete-forever btn-icon-prepend"></i>
                            Hapus</a>
                          </td>
                        </tr>
                        @endforeach
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