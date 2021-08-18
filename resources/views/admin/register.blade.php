<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registrasi Pengguna Unit Usaha | SIACTA</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../../images/favicon.png" />
</head>

<body class="sidebar-mini">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <!-- <img src="../../../../images/logo-dark.svg" alt="logo"> -->
                <h2>SIACTA</h2>
              </div>
              <h4>Registrasi Pengguna Baru Unit Usaha</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" action="/do_registrasi" method="post">
                @csrf
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Nama" name="nama">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="id_unitusaha">
                    <option disabled selected>Pilih Jenis Unit Usaha</option>
                    @foreach($unitusaha as $unit)
                    <option value="{{$unit->id}}">{{$unit->jenis}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Registrasi</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  
                </div>
              </form>
              @if(Session::has('succes'))
              <div class="alert alert-success" role="alert">
                    Registrasi berhasil dengan nama pengguna <strong>{{Session::get('nama')}}</strong>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../../../js/off-canvas.js"></script>
  <script src="../../../../js/hoverable-collapse.js"></script>
  <script src="../../../../js/template.js"></script>
  <script src="../../../../js/settings.js"></script>
  <script src="../../../../js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
