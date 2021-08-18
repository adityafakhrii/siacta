@extends('layouts.master')
<title>Neraca Saldo | SIACTA</title>
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
                  <h4 class="card-title">Neraca Saldo</h4>
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
                      	<?php $no = 1; ?>
                      	@foreach($neracasaldo as $neraca)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$neraca->no_akun}}</td>
                          <td>{{$neraca->nama_akun}}</td>
                          @if($neraca->saldo_normal == 'debit')
                            <td>Rp{{ number_format($neraca->saldo,2,",",".") }}</td>
                            <td>-</td>
                          @elseif($neraca->saldo_normal == 'kredit')
                            <td>-</td>
                            <td>Rp{{ number_format($neraca->saldo,2,",",".") }}</td>

                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3" align="center"><h4>Total</h4></td>
                          <td><strong>Rp{{ number_format(preg_replace('/\D/', '', $total_debit),2,",",".") }}</strong></td>
                          <td><strong>Rp{{ number_format(preg_replace('/\D/', '', $total_kredit),2,",",".") }}</strong></td>
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