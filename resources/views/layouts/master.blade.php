<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SIACTA</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../../../vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../../../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../../../../vendors/jquery-toast-plugin/jquery.toast.min.css">
  <link rel="stylesheet" href="../../../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="../../../../vendors/dropify/dropify.min.css">
  <link rel="stylesheet" href="../../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">

  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body class="sidebar-mini">
  <div class="container-scroller">

    @include('layouts.__navbar')
    
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="mdi mdi-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close mdi mdi-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options selected" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles light"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>

      @include('layouts.__sidebar')

      @yield('content')

    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  
  <!-- base:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
 <!-- plugin js for this page -->
 <script src="../../../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
 <script src="../../../../vendors/select2/select2.min.js"></script>
 <script src="../../vendors/progressbar.js/progressbar.min.js"></script>
 <script src="../../vendors/flot/jquery.flot.js"></script>
 <script src="../../vendors/flot/jquery.flot.resize.js"></script>
 <script src="../../vendors/chart.js/Chart.min.js"></script>
 <script src="../../../../vendors/jquery-validation/jquery.validate.min.js"></script>
 <script src="../../../../vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
 <script src="../../../../js/form-validation.js"></script>
 <script src="../../../../js/bt-maxLength.js"></script>
 <script src="../../../../vendors/sweetalert/sweetalert.min.js"></script>
 <script src="../../../../vendors/jquery.avgrund/jquery.avgrund.min.js"></script>
 <script src="../../../../vendors/dropify/dropify.min.js"></script>
 <script src="../../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
 <script src="../../../../vendors/inputmask/jquery.inputmask.bundle.js"></script>

 <!-- End plugin js for this page -->
 <!-- Custom js for this page-->
 <script src="../../../../js/typeahead.js"></script>
 <script src="../../../../js/select2.js"></script>
 <script src="../../js/chart.flot.sampledata.js"></script>
 <script src="../../js/dashboard.sampledata.js"></script>
 <script src="../../vendors/patternomaly/patternomaly.js"></script>
 <script src="../../js/dashboard.js"></script> 
 <script src="../../../../js/file-upload.js"></script>
 <script src="../../../../js/iCheck.js"></script>
 <script src="../../../../js/alerts.js"></script>
 <script src="../../../../js/avgrund.js"></script>
 <script src="../../../../js/dropify.js"></script>
 <script src="../../../../js/formpickers.js"></script>
 <script src="../../../../js/inputmask.js"></script>

 <!-- End custom js for this page-->

{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"> </script>  --}}

<script>
  var form = document.forms.myform,
      nominal = form.nominal,
      nilai_sisa = form.nilai_sisa,
      umur_ekonomis = form.umur_ekonomis,
      output = form.beban_penyusutan;

  window.calculate = function () {
      var q = parseFloat(nominal.value, 10) || 0,
          c = parseFloat(nilai_sisa.value) || 0;
          d = parseFloat(umur_ekonomis.value) || 0;

      var result = ((q-c)/d);

      if (result == Number.POSITIVE_INFINITY || result == Number.NEGATIVE_INFINITY) {
        output.value = 0;
      }else{
        output.value = result;
      }
  };

  function removeDisabled() {
    document.getElementById("pph22").disabled = false;
    document.getElementById("pph23").disabled = false;
  }

  function addDisabled() {
    document.getElementById("pph22").disabled = true;
    document.getElementById("pph23").disabled = true;
  }


  function removeDisabledRadio() {
    document.getElementById("radio_jenis1").disabled = false;
    document.getElementById("radio_jenis2").disabled = false;
    document.getElementById("radio_jenis3").disabled = false;
    document.getElementById("nominal_dp").disabled = false;
    document.getElementById("diskon").disabled = false;
    document.getElementById("nominal_ppn").disabled = false;
  }

  function addDisabledRadio() {
    document.getElementById("radio_jenis1").disabled = true;
    document.getElementById("radio_jenis2").disabled = true;
    document.getElementById("radio_jenis3").disabled = true;
    document.getElementById("nominal_dp").disabled = true;
    document.getElementById("diskon").disabled = true;
    document.getElementById("nominal_ppn").disabled = true;
  }

  function addDisabledDP() {
    document.getElementById("radio_jenis3").disabled = true;
    document.getElementById("nominal_dp").disabled = true;
    document.getElementById("diskon").disabled = true;
  }

    function removeDisabledDP() {
    document.getElementById("radio_jenis3").disabled = false;
    document.getElementById("nominal_dp").disabled = false;
    document.getElementById("diskon").disabled = false;
  }

</script>



{{-- <script type = "text/javascript">  
  function calculate() {
     if(isNaN(document.forms["myform"]["nominal"].value) || document.forms["myform"]["nominal"].value=="") {   
      var text1 = 0;   
     } else {
      var text1 = parseFloat(document.forms["myform"]["nominal"].value);   
     }

     if(isNaN(document.forms["myform"]["umur_ekonomis"].value) || document.forms["myform"]["umur_ekonomis"].value=="") {   
      var text2 = 0;   
     } else {   
      var text2 = parseFloat(document.forms["myform"]["umur_ekonomis"].value);   
     }

     if(isNaN(document.forms["myform"]["nilai_sisa"].value) || document.forms["myform"]["nilai_sisa"].value=="") {   
      var text3 = 0;   
     } else {   
      var text3 = parseFloat(document.forms["myform"]["nilai_sisa"].value);   
     }

    document.forms["myform"]["beban_penyusutan"].value = (text1-text3/text2);   
   }  
</script> --}}

</body>

</html>

