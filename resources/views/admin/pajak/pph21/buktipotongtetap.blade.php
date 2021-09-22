@extends('layouts.master')
<title>Bukti Potong PPh 21 Tetap | SIACTA</title>
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

                  <h4 class="card-title">Bukti Potong PPH 21 Tetap</h4>
                  <a href="/pph21/bukti-potong-tetap/tambah" class="btn btn-sm btn-primary btn-icon-text">
                    <i class="mdi mdi-database-plus btn-icon-prepend"></i>
                          Tambah Bukti Potong
                  </a>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Nama Wajib Pajak</th>
                          <th>NPWP</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php $no = 1; ?>
                        @foreach($bupot as $bp)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$bp->nama}}</td>
                          <td>{{$bp->npwp}}</td>
                          <td>
                            <a class="btn btn-sm btn-inverse-danger" href="/data-akun/lihat/"><i class="mdi mdi-delete-forever btn-icon-prepend"></i>
                            Lihat</a>
                            <a class="btn btn-sm btn-inverse-success" href="/data-akun/unduh/"><i class="mdi mdi-delete-forever btn-icon-prepend"></i>
                            Unduh</a>
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