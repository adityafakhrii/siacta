@extends('layouts.master')
<title>Buku Besar | SIACTA</title>

@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                  @if(Session::has('success'))
                    <div class="alert alert-fill-success" role="alert">
                      <i class="mdi mdi-alert-circle"></i>
                      {{Session::get('success')}}
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

                    <div class="row">
                      <div class="col-lg-12 grid-margin grid-margin-lg-0">
                          <h4 class="card-title text-center">Buku Besar</h4>
                      </div>
                    </div>
                    <br>
                    <form action="/buku-besar/akun/" method="get">
                      {{-- @csrf --}}
                      <div class="form-group row">
                        <div class="col-lg-2">
                          <label class="col-form-label">Pilih Nomor Akun</label>
                        </div>
                        <div class="col-lg-9">
                          <div class="form-group">
                            <select class="js-example-basic-single w-100" name="id_akun" required>
                              <option value="" selected disabled>Pilih Akun</option>
                              @foreach($akun_cari as $akun)

                              <option value="{{$akun->id}}">{{$akun->no_akun}} - {{$akun->nama_akun}}</option>

                              @endforeach
                            </select>
                            <input type="hidden" name="saldo_normal" value="{{$akun->saldo_normal}}">
                          </div>
                        </div>
                        <div class="col-lg-1">
                          <button class="btn btn-primary">Lihat </button>
                        </div>  
                      </div>
                    </form>

                  @if($bukubesar->count() != 0)
                      <?php $count = 0; ?>
                      
                      <div class="row">
                        <div class="col-lg-6">
                          <h5 style="color: #000">{{$akuns->akun->nama_akun}}</h5>
                        </div>
                        <div class="col-lg-6 text-right">
                          <h5 style="color: #000">{{$akuns->akun->no_akun}}</h5>
                        </div>
                      </div>
                      
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th><center>Tanggal</center></th>
                          <th><center>Keterangan</center></th>
                          <th><center>Debit</center></th>
                          <th><center>Kredit</center></th>
                          <th><center>Saldo</center></th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach($bukubesar as $bb)
                        <tr>

                          <td><center>{{$bb->created_at->format('d/m/Y')}}</center></td>
                          <td class="text-center">{{$bb->keterangan}}</td>

                          @if($bb->debit != NULL)
                            <td class="text-center">
                            Rp{{ number_format($bb->debit,2,",",".") }}
                            </td>
                          @else
                            <td><center>-</center></td>
                          @endif

                          @if($bb->kredit != NULL)
                            <td class="text-center">
                            Rp{{ number_format($bb->kredit,2,",",".") }}
                            </td>
                          @else
                            <td><center>-</center></td>
                          @endif

                          <td class="text-center">
                            Rp{{ number_format($bb->saldo,2,",",".") }}
                            </td>

                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                  <br><br><br><br>
                  @else
                    <h4 class="text-center">Belum ada transaksi</h4>
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