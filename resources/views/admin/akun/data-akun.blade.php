@extends('layouts.master')
<title>Data Akun | SIACTA</title>
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
                  <h4 class="card-title">Data Akun</h4>
                  <a href="/data-akun/tambah" class="btn btn-sm btn-primary btn-icon-text">
                    <i class="mdi mdi-database-plus btn-icon-prepend"></i>
                          Tambah Akun
                  </a>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nomor Akun</th>
                          <th>Nama Akun</th>
                          <th>Saldo Normal</th>
                          <th>Tanggal dibuat</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php $no = 1; ?>
                      	@foreach($akuns as $akun)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$akun->no_akun}}</td>
                          <td>{{$akun->nama_akun}}</td>
                          <td>{{$akun->saldo_normal}}</td>
                          <td>{{$akun->created_at}}</td>
                          <td>
                            <a class="btn btn-sm btn-inverse-danger" href="/data-akun/hapus/{{$akun->id}}" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-delete-forever btn-icon-prepend"></i>
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