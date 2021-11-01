@extends('layouts.master')

@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="d-xl-flex justify-content-between align-items-center mb-4 pb-2">
            <div class="text-dark">
              <h2 class="mb-1 font-weight-bold">Selamat datang di Dashboard SIACTA !</h2>
              <p class="text-small mb-0"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-success">
                <div class="card-variant-triangle-success"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">Pendapatan</p>
                      <h4 class="text-dark  font-weight-medium">Rp{{ number_format($total_pendapatan,2,",",".") }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-danger">
                  <div class="card-variant-triangle-danger"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">Beban</p>
                      <h4 class="text-dark  font-weight-medium">Rp{{ number_format($total_beban,2,",",".") }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-info">
                <div class="card-variant-triangle-info"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">Laba Sebelum Pajak</p>
                      <h4 class="text-dark  font-weight-medium">Rp{{ number_format( $total_semua = $total_pendapatan - $total_beban,2,",",".") }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
              if ($total_semua > 0) {
                $pajak = $total_semua * (0.5/100);
              }else{
                $pajak = 0;
              }
              
            ?>
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-warning">
                  <div class="card-variant-triangle-warning"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">Laba Setelah Pajak</p>
                      <h4 class="text-dark  font-weight-medium">Rp{{ number_format( floor($total_semua - $pajak),2,",",".") }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-success">
                <div class="card-variant-triangle-success"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">Piutang</p>
                      <h4 class="text-dark  font-weight-medium">Rp{{ number_format($total_piut,2,",",".") }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-danger">
                  <div class="card-variant-triangle-danger"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">Utang</p>
                      <h4 class="text-dark  font-weight-medium">Rp{{ number_format($total_ut,2,",",".") }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('layouts.__footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->

@endsection