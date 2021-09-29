@extends('layouts.master')
<title>Data Pengguna Unit Usaha | SIACTA</title>
@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                  @if(Session::has('create'))
                    <div class="alert alert-success" role="alert">
                          Registrasi berhasil dengan nama pengguna <strong>{{Session::get('nama')}}</strong>
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
                  <h4 class="card-title">Data Pengguna Unit Usaha</h4>
                  <a href="/data-unit/tambah" class="btn btn-sm btn-primary btn-icon-text">
                    <i class="mdi mdi-database-plus btn-icon-prepend"></i>
                          Tambah Pengguna
                  </a>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No. </th>
                          <th>Nama Pengguna</th>
                          <th>Nama Unit Usaha</th>
                          <th>NPWP</th>
                          <th>Email</th>
                          <th>No. Telfon</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php $no = 1; ?>
                      	@foreach($unit as $akun)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$akun->nama}}</td>
                          <td>{{$akun->nama_unit}}</td>
                          <td>{{$akun->npwp}}</td>
                          <td>{{$akun->user->email}}</td>
                          <td>{{$akun->no_telfon}}</td>
                          <td>
                            <a class="btn btn-sm btn-inverse-danger" href="/data-unit/hapus/{{$akun->id}}" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-delete-forever btn-icon-prepend"></i>
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