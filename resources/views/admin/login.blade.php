<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Masuk | SIACTA</title>
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
                {{-- <img src="../../../../images/logo-dark.svg" alt="logo"> --}}
                <center><h2>SIACTA | Login</h2></center>
              </div>
              <center>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
              </center>
              <form class="pt-3" action="/do_login" method="post">
                @csrf
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                  </div>
                  <a href="/" class="auth-link text-black">Kembali ke menu utama</a>
                </div>
              </form>
              @if(Session::has('fail'))
              <div class="alert alert-danger" role="alert">
                    Email atau Password yang anda masukkan salah.
                    Silahkan coba lagi!
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
