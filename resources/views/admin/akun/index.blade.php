@extends('layouts.master')

@section('content')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="d-xl-flex justify-content-between align-items-center mb-4 pb-2">
            <div class="text-dark">
              <h2 class="mb-1 font-weight-bold">Here’s todays activity dashboard !</h2>
              <p class="text-small mb-0">Saturday 10 Aug 2019</p>
            </div>
            <div class="statistics d-lg-flex text-dark mt-3 mt-sm-0">
              <div class="mr-0 mr-lg-4 mb-3 mb-lg-0">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="mr-3">
                      <p class="font-weight-medium mb-0">Monthly Statistics</p>
                      <p class="text-small mb-0"><i class="mdi mdi-arrow-top-right mr-0 mr-lg-2 text-success"></i>Increase 2.4%</p>
                    </div>
                    <div>
                      <span class="statistics-increase text-white">3</span>
                      <span class="statistics-increase text-white">5</span>
                      <span class="statistics-increase text-white">0</span>
                      <span class="statistics-increase text-white">2</span>
                      <span class="statistics-increase text-white">3</span>
                    </div>
                  </div>
              </div>
              <div>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="mr-3">
                    <p class="font-weight-medium mb-0">Daily Statistics</p>
                    <p class="text-small mb-0"><i class="mdi mdi-arrow-bottom-right mr-2 text-danger"></i>decrease 2.4%</p>
                  </div>
                  <div>
                    <span class="statistics-decrease text-white">1</span>
                    <span class="statistics-decrease text-white">2</span>
                    <span class="statistics-decrease text-white">4</span>
                    <span class="statistics-decrease text-white">5</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-danger">
                <div class="card-variant-triangle-danger"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">REVENUE</p>
                      <h4 class="text-dark  font-weight-medium">$25763</h4>
                      <p class="text-muted text-small mb-0">(5.32% in last 30 days)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-dark">
                  <div class="card-variant-triangle-dark"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">SALES</p>
                      <h4 class="text-dark  font-weight-medium">$22,500</h4>
                      <p class="text-muted text-small mb-0">(5.32% in last 30 days)</p>
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
                      <p class="text-dark font-weight-medium">LIKES</p>
                      <h4 class="text-dark  font-weight-medium">421,215</h4>
                      <p class="text-muted text-small mb-0">(5.32% in last 30 days)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 grid-margin stretch-card">
              <div class="card card-variant-border-warning">
                  <div class="card-variant-triangle-warning"></div>
                <div class="card-body">
                  <div class="d-xl-flex d-lg-block d-sm-block  d-flex align-items-center">
                    <i class="mdi mdi-arrow-top-right large-icons text-success mr-3"></i>
                    <div>
                      <p class="text-dark font-weight-medium">VISITS</p>
                      <h4 class="text-dark  font-weight-medium">21,215</h4>
                      <p class="text-muted text-small mb-0">(5.32% in last 30 days)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title mb-3">Sales Reports</h3>
                        <div class="dropdown">
                          <a class="btn p-0" href="#" data-toggle="dropdown" id="saleswidgetDropdown">
                              <i class="mdi mdi-dots-horizontal"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="saleswidgetDropdown">
                            <a class="dropdown-item">
                              <i class="mdi mdi-pencil text-primary"></i>
                              Edit
                            </a>
                            <a class="dropdown-item">
                              <i class="mdi mdi-delete  text-primary"></i>
                              Delete
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <p>Sales Performance for Online and Offline Revenue</p>
                      <div class="row pt-3 mt-md-4 mb-4">
                        <div class="col-6 grid-margin">
                          <div class="d-flex align-items-center">
                              <div id="circleProgress1" class="mr-3 mt-2 mt-lg-0 circle-progress-dimension"></div>
                              <div>
                                <h5 class="font-weight-medium text-dark">3456</h5>
                                <p class="font-weight-medium  mb-0">Opportunities</p>
                              </div>
                          </div>
                        </div>
                        <div class="col-5 grid-margin">
                          <div class="d-flex align-items-center">
                              <div id="circleProgress2" class="mr-3 mt-2 mt-lg-0 circle-progress-dimension"></div>
                              <div>
                                <h5 class="font-weight-medium text-dark">865</h5>
                                <p class="font-weight-medium  mb-0">Proposal</p>
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="row pt-3 mt-md-2 mb-2">
                        <div class="col">
                          <h3 class="text-dark font-weight-bold mb-2">110,000</h3>
                          <p>Number of sales</p>
                        </div>
                        <div class="col">
                          <h3 class="text-dark font-weight-bold mb-2">$753,098</h3>
                          <p>Total sales</p>
                        </div>
                      </div>
                      <div class="row pt-3 mt-md-2 mb-0">
                        <div class="col">
                          <h3 class="text-dark font-weight-bold mb-2">$523,200</h3>
                          <p>Average Sale</p>
                        </div>
                        <div class="col">
                          <h3 class="text-dark font-weight-bold mb-2">$331,886</h3>
                          <p>Finangel Free</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="d-lg-flex align-items-center mt-3 mt-lg-0">
                        <div class="d-flex align-items-center mr-0 mr-lg-5 mb-3 mb-lg-0">
                          <span class="legend-label bg-primary mr-2"></span>
                          <p class="mb-0">Total Sales</p>
                        </div>
                        <div class="d-flex align-items-center mb-3 mb-lg-0">
                            <span class="legend-label bg-info mr-2"></span>
                            <p class="mb-0">Number of sales</p>
                          </div>
                      </div>
                      <div class="flot-chart-wrapper mt-2">
                        <div id="flotChart" class="flot-chart"></div>
                      </div>
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