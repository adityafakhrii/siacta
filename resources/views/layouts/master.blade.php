<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SIACTA | System Information Accounting & Tax</title>
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

    {{-- Logika JS SPT PPH 23 --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jautocalc@1.3.1/dist/jautocalc.js"></script>
    <style>
      .saldoawal{
        text-transform: uppercase;
      }
    </style>
    
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
   <script src="../../../../js/spt.js"></script>

   <!-- End custom js for this page-->

  <script>
    var formtrans = document.forms.formtrans,
        nominal = formtrans.nominal,
        nilai_sisa = formtrans.nilai_sisa,
        umur_ekonomis = formtrans.umur_ekonomis,
        outputtrans = formtrans.beban_penyusutan;

    window.calculatetrans = function () {
        var qq = parseFloat(nominal.value, 10) || 0,
            cc = parseFloat(nilai_sisa.value) || 0;
            dd = parseFloat(umur_ekonomis.value) || 0;

        var resulttrans = Math.round((qq-cc)/dd);

        if (resulttrans == Number.POSITIVE_INFINITY || resulttrans == Number.NEGATIVE_INFINITY) {
          outputtrans.value = 0;
        }else{
          outputtrans.value =  resulttrans;
        }
    };
  </script>

  <script>
    function removeDisabledKode() {
      document.getElementById("kode_negara").disabled = false;
    }

    function addDisabledKode() {
      document.getElementById("kode_negara").disabled = true;
    }
  </script>



  <script>
    function removeDisabled() {
      document.getElementById("wajib_ln").disabled = false;
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

    var myform = document.forms.myform,
        phneto_dn = myform.phneto_dn,
        phneto_dn_lain = myform.phneto_dn_lain,
        phneto_ln = myform.phneto_ln,
        output = myform.jml_peng_neto,
        zakat_sumbang = myform.zakat_sumbang,
        outputakhir = myform.total_peng_neto,

        //Penghasilan kena pajak
        peng_tidak_pajak = myform.peng_tidak_pajak,
        outputkenapajak = myform.peng_pajak,


        //PPh Terutang
        pph_terutang = myform.pph_terutang,
        pengem_pph24 = myform.pengem_pph24,
        outputpphterutang = myform.jml_pph_terutang,

        //Kredit Pajak
        pph_dipot_ln = myform.pph_dipot_ln,
        outputdibayar = myform.pph_dibayar,
        outputdipungut = myform.pph_dipungut,

        // 14. PPh Dibayar sendiri
        pph25 = myform.pph25,
        stp_pph25 = myform.stp_pph25,
        outputkreditpajak = myform.jml_kredit_pajak,

        // 16. PPh Kurang/Lebih bayar
        outputpph29 = myform.pph29,
        outputpph28a = myform.pph28a;

    window.calculate = function () {
        var a = parseFloat(phneto_dn.value, 10) || 0;
            b = parseFloat(phneto_dn_lain.value) || 0;
            c = parseFloat(phneto_ln.value) || 0;
            d = parseFloat(zakat_sumbang.value) || 0;
            e = parseFloat(pph_terutang.value) || 0;
            f = parseFloat(pengem_pph24.value) || 0;
            g = parseFloat(peng_tidak_pajak.value) || 0;
            h = parseFloat(pph_dipot_ln.value) || 0;
            i = parseFloat(pph25.value) || 0;
            j = parseFloat(stp_pph25.value) || 0;
        
        //Penghasilan Neto
        var resultneto = Math.round(a+b+c);

        if (resultneto == Number.POSITIVE_INFINITY || resultneto == Number.NEGATIVE_INFINITY) {
          output.value = 0;
        }else{
          output.value = resultneto;
        }
        
        var resultakhir = Math.round(resultneto-d);

        if (resultakhir == Number.POSITIVE_INFINITY || resultakhir == Number.NEGATIVE_INFINITY) {
          outputakhir.value = 0;
        }else{
          outputakhir.value = resultakhir;
        }


        //Penghasilan Kena Pajak
        var resultkenapajak = Math.floor((resultakhir-g)/1000)*1000;

        if (resultkenapajak == Number.POSITIVE_INFINITY || resultkenapajak == Number.NEGATIVE_INFINITY) {
          outputkenapajak.value = 0;
        }else{
          outputkenapajak.value = resultkenapajak;
        }


        //PPh Terutang
        var resultpphterutang = Math.round(e+f);

        if (resultpphterutang == Number.POSITIVE_INFINITY || resultpphterutang == Number.NEGATIVE_INFINITY) {
          outputpphterutang.value = 0;
        }else{
          outputpphterutang.value = resultpphterutang;
        }


        //Kredit Pajak
        var resultkreditpajak = Math.round(resultpphterutang-h);
        if (resultkreditpajak == Number.POSITIVE_INFINITY || resultkreditpajak == Number.NEGATIVE_INFINITY) {
          if (resultpphterutang > h) {
            outputdibayar.value = 0  
          } else if(h > resultpphterutang) {
            outputdipungut.value = 0
          }
        }
        else if(resultkreditpajak == 0){
            outputdibayar.value = resultkreditpajak;
            outputdipungut.value = "";  
        }
        else{
          if (resultpphterutang > h) {
            outputdibayar.value = resultkreditpajak;
            outputdipungut.value = "";  
          } else if(h > resultpphterutang) {
            outputdipungut.value = -(resultkreditpajak);
            outputdibayar.value = "";
          }
        }

        //14. PPh yang dibayar sendiri
        var resultpphsendiri = Math.round(i+j);

        if (resultpphsendiri == Number.POSITIVE_INFINITY || resultpphsendiri == Number.NEGATIVE_INFINITY) {
          outputkreditpajak.value = 0;
        }else{
          outputkreditpajak.value = resultpphsendiri;
        }

        //16. PPh kurang/lebih dibayar
        var resultkuranglebih = Math.round(resultkreditpajak-resultpphsendiri);
        if (resultkuranglebih == Number.POSITIVE_INFINITY || resultkuranglebih == Number.NEGATIVE_INFINITY) {
          if (resultkreditpajak > resultpphsendiri) {
            outputpph29.value = 0  
          } else if(resultpphsendiri > resultkreditpajak) {
            outputpph28a.value = 0
          }
        }
        else if(resultkuranglebih == 0){
            outputpph29.value = resultkuranglebih;
            outputpph28a.value = "";  
        }
        else{
          if (resultkreditpajak > resultpphsendiri) {
            outputpph29.value = resultkuranglebih;
            outputpph28a.value = "";  
          } else if(resultpphsendiri > resultkreditpajak) {
            outputpph28a.value = -(resultkuranglebih);
            outputpph29.value = "";
          }
        }

        //Penghasilan tidak kena pajak 
        var inp1 = document.getElementById("input1");
        var inp2 = document.getElementById("input2");
        var inp3 = document.getElementById("input3");
        inp1.addEventListener("input", function () {
            document.getElementById("input2").disabled = this.value != "";
            document.getElementById("input3").disabled = this.value != "";
        });

        inp2.addEventListener("input", function () {
            document.getElementById("input1").disabled = this.value != "";
            document.getElementById("input3").disabled = this.value != "";
        });

        inp3.addEventListener("input", function () {
            document.getElementById("input1").disabled = this.value != "";
            document.getElementById("input2").disabled = this.value != "";
        });


        if ((outputpph29.value != 0 || outputpph29.value != "") && (outputpph28a.value == 0 || outputpph28a.value == "")) {
            document.getElementById("inputdisabled").disabled = true;
            document.getElementById("inputdisabled2").disabled = true;
            document.getElementById("inputdisabled3").disabled = true;
            document.getElementById("input17").disabled = true;
            document.getElementById("input17").required = false;
        } 
        else if ((outputpph28a.value != 0 || outputpph28a.value != "") && (outputpph29.value == 0 || outputpph29.value == "")) {
            document.getElementById("input17").disabled = false;
            document.getElementById("inputdisabled").disabled = false;
            document.getElementById("inputdisabled2").disabled = false;
            document.getElementById("inputdisabled3").disabled = false;
            document.getElementById("input17").required = true;
        }
    };
  </script>

  {{-- Bukti Potong PPh 21 tidak tetap --}}
  <script>
    var formtidaktetap = document.forms.formtidaktetap,
    
        // PPh21 bukti potong tidak tetap
        dasar_pajak = formtidaktetap.dasar_pajak,
        npwp = formtidaktetap.npwp,
        outputdipotongtidak = formtidaktetap.pph_dipotong;

    window.calculatetidaktetap = function () {
        var zz = parseFloat(dasar_pajak.value) || 0,
            nn = parseFloat(npwp.value) || 0;

        if (nn == 0 || nn == "") {
          var resultpotongtidak = Math.round(zz*0.05*1.2);
        }else{
          var resultpotongtidak = Math.round(zz*0.05);
        }

        if (resultpotongtidak == Number.POSITIVE_INFINITY || resultpotongtidak == Number.NEGATIVE_INFINITY) {
          outputdipotongtidak.value = 0;
        }else{
          outputdipotongtidak.value =  resultpotongtidak;
        }
    };
  </script>

  {{-- Penghasilan tidak kena pajak  --}}
  <script>
    var st1 = document.getElementById("status1");
    var st2 = document.getElementById("status2");
    var st3 = document.getElementById("status3");
    st1.addEventListener("input", function () {
        document.getElementById("status2").disabled = this.value != "";
        document.getElementById("status3").disabled = this.value != "";
    });

    st2.addEventListener("input", function () {
        document.getElementById("status1").disabled = this.value != "";
        document.getElementById("status3").disabled = this.value != "";
    });

    st3.addEventListener("input", function () {
        document.getElementById("status1").disabled = this.value != "";
        document.getElementById("status2").disabled = this.value != "";
    });

    // Bukti potong tetap
    var formtetap = document.forms.formtetap,
        gaji_pensiun = formtetap.gaji_pensiun,
        tunjangan_pph = formtetap.tunjangan_pph,
        tunjangan_lain = formtetap.tunjangan_lain,
        honorarium = formtetap.honorarium,
        premi_asuransi = formtetap.premi_asuransi,
        natura = formtetap.natura,
        tantiem = formtetap.tantiem,

        biaya_jabatan = formtetap.biaya_jabatan,
        iuran_pensiun = formtetap.iuran_pensiun,

        ptkp = formtetap.ptkp,

        persen_pajak = formtetap.persen_pajak,

        outputbruto = formtetap.jumlah_peng_bruto,
        outputpengurang = formtetap.jumlah_pengurangan,
        outputneto = formtetap.jumlah_peng_neto,
        outputpengsebulan = formtetap.pkp,
        outputpkp = formtetap.pph21_pkp,
        outputterutang = formtetap.pph21_terutang,
        outputpph26 = formtetap.pph21_pph26;

    window.calculatetetap = function () {
        var bt1 = parseFloat(gaji_pensiun.value, 10) || 0,
            bt2 = parseFloat(tunjangan_pph.value) || 0,
            bt3 = parseFloat(tunjangan_lain.value) || 0,
            bt4 = parseFloat(honorarium.value) || 0,
            bt5 = parseFloat(premi_asuransi.value) || 0,
            bt6 = parseFloat(natura.value) || 0,
            bt7 = parseFloat(tantiem.value) || 0,

            peng1 = parseFloat(biaya_jabatan.value) || 0,
            peng2 = parseFloat(iuran_pensiun.value) || 0,

            ptkp1 = parseFloat(ptkp.value) || 0,

            persenpj = parseFloat(persen_pajak.value) || 0;

        var resultbruto = Math.round(bt1+bt2+bt3+bt4+bt5+bt6+bt7);
        if (resultbruto == Number.POSITIVE_INFINITY || resultbruto == Number.NEGATIVE_INFINITY) {
          outputbruto.value = 0;
        }else{
          outputbruto.value =  resultbruto;
        }

        var resultpeng = Math.round(peng1+peng2);
        if (resultpeng == Number.POSITIVE_INFINITY || resultpeng == Number.NEGATIVE_INFINITY) {
          outputpengurang.value = 0;
        }else{
          outputpengurang.value =  resultpeng;
        }

        var resultneto = Math.round(resultbruto-resultpeng);
        if (resultneto == Number.POSITIVE_INFINITY || resultneto == Number.NEGATIVE_INFINITY) {
          outputneto.value = 0;
        }else{
          outputneto.value =  resultneto;
        }

        var resultpengsebulan = Math.floor((resultneto-ptkp1)/1000)*1000;
        if (resultpengsebulan < 0) {
          resultpengsebulan = 0;
        }

        if (resultpengsebulan == Number.POSITIVE_INFINITY || resultpengsebulan == Number.NEGATIVE_INFINITY) {
          outputpengsebulan.value = 0;
        }else{
          outputpengsebulan.value =  resultpengsebulan;
        }

        var resultpph21 = Math.round(resultpengsebulan*persenpj);
        if (resultpph21 == Number.POSITIVE_INFINITY || resultpph21 == Number.NEGATIVE_INFINITY) {
          outputpkp.value = 0;
          outputterutang.value = 0;
          outputpph26.value = 0;
        }else{
          outputpkp.value =  resultpph21;
          outputterutang.value =  resultpph21;
          outputpph26.value =  resultpph21;
        }

    };
  </script>

  {{-- Bukti Potong PPh 22 --}}
  <script>
    var formbupotpph22 = document.forms.formbupotpph22,
    
        // PPh21 bukti potong tidak tetap
        harga = formbupotpph22.harga,
        tarif_lebih = formbupotpph22.tarif_lebih,
        tarif = formbupotpph22.tarif,
        npwp = formbupotpph22.npwp,
        outputbupot22 = formbupotpph22.pph_dipot;

    window.calculatebupotpph22 = function () {
        var harga1 = parseFloat(harga.value) || 0,
            lebih1 = parseFloat(tarif_lebih.value) || 0,
            tarif1 = parseFloat(tarif.value) || 0,
            npwp_bupot1 = parseFloat(npwp.value) || 0;

        if (npwp_bupot1 == 0 || npwp_bupot1 == "") {
          var resultbupot22 = Math.round(harga1*lebih1*tarif1);
        }else{
          var resultbupot22 = Math.round(harga1*tarif1);
        }

        if (resultbupot22 == Number.POSITIVE_INFINITY || resultbupot22 == Number.NEGATIVE_INFINITY) {
          outputbupot22.value = 0;
        }else{
          outputbupot22.value =  resultbupot22;
        }
    };
  </script>

  {{-- SPT PPh 22 --}}
  <script>
    var formsptpph22 = document.forms.formsptpph22,
    
        // PPh21 bukti potong tidak tetap
        nop_badan_usaha = formsptpph22.nop_badan_usaha,
        tl_badan_usaha = formsptpph22.tl_badan_usaha,
        t_badan_usaha = formsptpph22.t_badan_usaha,
        npwp_badan_usaha = formsptpph22.npwp_badan_usaha,
        output1 = formsptpph22.pph_badan_usaha,

        nop_penj_barang = formsptpph22.nop_penj_barang,
        tl_penj_barang = formsptpph22.tl_penj_barang,
        t_penj_barang = formsptpph22.t_penj_barang,
        npwp_penj_barang = formsptpph22.npwp_penj_barang,
        output2 = formsptpph22.pph_penj_barang,

        nop_pembelian_bend = formsptpph22.nop_pembelian_bend,
        tl_pembelian_bend = formsptpph22.tl_pembelian_bend,
        t_pembelian_bend = formsptpph22.t_pembelian_bend,
        npwp_pembelian_bend = formsptpph22.npwp_pembelian_bend,
        output3 = formsptpph22.pph_pembelian_bend,

        nop_api = formsptpph22.nop_api,
        tl_api = formsptpph22.tl_api,
        t_api = formsptpph22.t_api,
        npwp_api = formsptpph22.npwp_api,
        output4 = formsptpph22.pph_api,

        nop_non_api = formsptpph22.nop_non_api,
        tl_non_api = formsptpph22.tl_non_api,
        t_non_api = formsptpph22.t_non_api,
        npwp_non_api = formsptpph22.npwp_non_api,
        output5 = formsptpph22.pph_non_api,

        nop_hasil_lelang = formsptpph22.nop_hasil_lelang,
        tl_hasil_lelang = formsptpph22.tl_hasil_lelang,
        t_hasil_lelang = formsptpph22.t_hasil_lelang,
        npwp_hasil_lelang = formsptpph22.npwp_hasil_lelang,
        output6 = formsptpph22.pph_hasil_lelang,

        nop_spbu = formsptpph22.nop_spbu,
        tl_spbu = formsptpph22.tl_spbu,
        t_spbu = formsptpph22.t_spbu,
        npwp_spbu = formsptpph22.npwp_spbu,
        output7 = formsptpph22.pph_spbu,

        nop_pihak_lain = formsptpph22.nop_pihak_lain,
        tl_pihak_lain = formsptpph22.tl_pihak_lain,
        t_pihak_lain = formsptpph22.t_pihak_lain,
        npwp_pihak_lain = formsptpph22.npwp_pihak_lain,
        output8 = formsptpph22.pph_pihak_lain,

        nop_bumn = formsptpph22.nop_bumn,
        tl_bumn = formsptpph22.tl_bumn,
        t_bumn = formsptpph22.t_bumn,
        npwp_bumn = formsptpph22.npwp_bumn,
        output9 = formsptpph22.pph_bumn,

        nop_penj_hasil = formsptpph22.nop_penj_hasil,
        tl_penj_hasil = formsptpph22.tl_penj_hasil,
        t_penj_hasil = formsptpph22.t_penj_hasil,
        npwp_penj_hasil = formsptpph22.npwp_penj_hasil,
        output10 = formsptpph22.pph_penj_hasil,

        nop_penj_ken = formsptpph22.nop_penj_ken,
        tl_penj_ken = formsptpph22.tl_penj_ken,
        t_penj_ken = formsptpph22.t_penj_ken,
        npwp_penj_ken = formsptpph22.npwp_penj_ken,
        output11 = formsptpph22.pph_penj_ken,

        nop_pemb_batu = formsptpph22.nop_pemb_batu,
        tl_pemb_batu = formsptpph22.tl_pemb_batu,
        t_pemb_batu = formsptpph22.t_pemb_batu,
        npwp_pemb_batu = formsptpph22.npwp_pemb_batu,
        output12 = formsptpph22.pph_pemb_batu,

        nop_penj_emas = formsptpph22.nop_penj_emas,
        tl_penj_emas = formsptpph22.tl_penj_emas,
        t_penj_emas = formsptpph22.t_penj_emas,
        npwp_penj_emas = formsptpph22.npwp_penj_emas,
        output13 = formsptpph22.pph_penj_emas,

        outputsptpph22 = formsptpph22.jumlah_nop,
        outputpph22 = formsptpph22.jumlah_pph;

    window.calculatesptpph22 = function () {
        
        // Result 1
        var nop_badan_usaha1 = parseFloat(nop_badan_usaha.value) || 0,
            tl1 = parseFloat(tl_badan_usaha.value) || 0,
            t1 = parseFloat(t_badan_usaha.value) || 0,
            npwp1 = parseFloat(npwp_badan_usaha.value) || 0;

        if (npwp1 == 0 || npwp1 == "") {
          var result1 = Math.round(nop_badan_usaha1*tl1*t1);
        }else{
          var result1 = Math.round(nop_badan_usaha1*t1);
        }

        if (result1 == Number.POSITIVE_INFINITY || result1 == Number.NEGATIVE_INFINITY) {
          output1.value = 0;
        }else{
          output1.value =  result1;
        }


        // Result 2
        var nop_penj_barang1 = parseFloat(nop_penj_barang.value) || 0,
            tl2 = parseFloat(tl_penj_barang.value) || 0,
            t2 = parseFloat(t_penj_barang.value) || 0,
            npwp2 = parseFloat(npwp_penj_barang.value) || 0;

        if (npwp2 == 0 || npwp2 == "") {
          var result2 = Math.round(nop_penj_barang1*tl2*t2);
        }else{
          var result2 = Math.round(nop_penj_barang1*t2);
        }

        if (result2 == Number.POSITIVE_INFINITY || result2 == Number.NEGATIVE_INFINITY) {
          output2.value = 0;
        }else{
          output2.value =  result2;
        }


        // Result 3
        var nop_pembelian_bend1 = parseFloat(nop_pembelian_bend.value) || 0,
            tl3 = parseFloat(tl_pembelian_bend.value) || 0,
            t3 = parseFloat(t_pembelian_bend.value) || 0,
            npwp3 = parseFloat(npwp_pembelian_bend.value) || 0;

        if (npwp3 == 0 || npwp3 == "") {
          var result3 = Math.round(nop_pembelian_bend1*tl3*t3);
        }else{
          var result3 = Math.round(nop_pembelian_bend1*t3);
        }

        if (result3 == Number.POSITIVE_INFINITY || result3 == Number.NEGATIVE_INFINITY) {
          output3.value = 0;
        }else{
          output3.value =  result3;
        }


        // Result 4
        var nop_api1 = parseFloat(nop_api.value) || 0,
            tl4 = parseFloat(tl_api.value) || 0,
            t4 = parseFloat(t_api.value) || 0,
            npwp4 = parseFloat(npwp_api.value) || 0;

        if (npwp4 == 0 || npwp4 == "") {
          var result4 = Math.round(nop_api1*tl4*t4);
        }else{
          var result4 = Math.round(nop_api1*t4);
        }

        if (result4 == Number.POSITIVE_INFINITY || result4 == Number.NEGATIVE_INFINITY) {
          output4.value = 0;
        }else{
          output4.value =  result4;
        }


        // Result 5
        var nop_non_api1 = parseFloat(nop_non_api.value) || 0,
            tl5 = parseFloat(tl_non_api.value) || 0,
            t5 = parseFloat(t_non_api.value) || 0,
            npwp5 = parseFloat(npwp_non_api.value) || 0;

        if (npwp5 == 0 || npwp5 == "") {
          var result5 = Math.round(nop_non_api1*tl5*t5);
        }else{
          var result5 = Math.round(nop_non_api1*t5);
        }

        if (result5 == Number.POSITIVE_INFINITY || result5 == Number.NEGATIVE_INFINITY) {
          output5.value = 0;
        }else{
          output5.value =  result5;
        }


        // Result 6
        var nop_hasil_lelang1 = parseFloat(nop_hasil_lelang.value) || 0,
            tl6 = parseFloat(tl_hasil_lelang.value) || 0,
            t6 = parseFloat(t_hasil_lelang.value) || 0,
            npwp6 = parseFloat(npwp_hasil_lelang.value) || 0;

        if (npwp6 == 0 || npwp6 == "") {
          var result6 = Math.round(nop_hasil_lelang1*tl6*t6);
        }else{
          var result6 = Math.round(nop_hasil_lelang1*t6);
        }

        if (result6 == Number.POSITIVE_INFINITY || result6 == Number.NEGATIVE_INFINITY) {
          output6.value = 0;
        }else{
          output6.value =  result6;
        }


        // Result 7
        var nop_spbu1 = parseFloat(nop_spbu.value) || 0,
            tl7 = parseFloat(tl_spbu.value) || 0,
            t7 = parseFloat(t_spbu.value) || 0,
            npwp7 = parseFloat(npwp_spbu.value) || 0;

        if (npwp7 == 0 || npwp7 == "") {
          var result7 = Math.round(nop_spbu1*tl7*t7);
        }else{
          var result7 = Math.round(nop_spbu1*t7);
        }

        if (result7 == Number.POSITIVE_INFINITY || result7 == Number.NEGATIVE_INFINITY) {
          output7.value = 0;
        }else{
          output7.value =  result7;
        }


        // Result 8
        var nop_pihak_lain1 = parseFloat(nop_pihak_lain.value) || 0,
            tl8 = parseFloat(tl_pihak_lain.value) || 0,
            t8 = parseFloat(t_pihak_lain.value) || 0,
            npwp8 = parseFloat(npwp_pihak_lain.value) || 0;

        if (npwp8 == 0 || npwp8 == "") {
          var result8 = Math.round(nop_pihak_lain1*tl8*t8);
        }else{
          var result8 = Math.round(nop_pihak_lain1*t8);
        }

        if (result8 == Number.POSITIVE_INFINITY || result8 == Number.NEGATIVE_INFINITY) {
          output8.value = 0;
        }else{
          output8.value =  result8;
        }


        // Result 9
        var nop_bumn1 = parseFloat(nop_bumn.value) || 0,
            tl9 = parseFloat(tl_bumn.value) || 0,
            t9 = parseFloat(t_bumn.value) || 0,
            npwp9 = parseFloat(npwp_bumn.value) || 0;

        if (npwp9 == 0 || npwp9 == "") {
          var result9 = Math.round(nop_bumn1*tl9*t9);
        }else{
          var result9 = Math.round(nop_bumn1*t9);
        }

        if (result9 == Number.POSITIVE_INFINITY || result9 == Number.NEGATIVE_INFINITY) {
          output9.value = 0;
        }else{
          output9.value =  result9;
        }


        // Result 10
        var nop_penj_hasil1 = parseFloat(nop_penj_hasil.value) || 0,
            tl10 = parseFloat(tl_penj_hasil.value) || 0,
            t10 = parseFloat(t_penj_hasil.value) || 0,
            npwp10 = parseFloat(npwp_penj_hasil.value) || 0;

        if (npwp10 == 0 || npwp10 == "") {
          var result10 = Math.round(nop_penj_hasil1*tl10*t10);
        }else{
          var result10 = Math.round(nop_penj_hasil1*t10);
        }

        if (result10 == Number.POSITIVE_INFINITY || result10 == Number.NEGATIVE_INFINITY) {
          output10.value = 0;
        }else{
          output10.value =  result10;
        }


        // Result 11
        var nop_penj_ken1 = parseFloat(nop_penj_ken.value) || 0,
            tl11 = parseFloat(tl_penj_ken.value) || 0,
            t11 = parseFloat(t_penj_ken.value) || 0,
            npwp11 = parseFloat(npwp_penj_ken.value) || 0;

        if (npwp11 == 0 || npwp11 == "") {
          var result11 = Math.round(nop_penj_ken1*tl11*t11);
        }else{
          var result11 = Math.round(nop_penj_ken1*t11);
        }

        if (result11 == Number.POSITIVE_INFINITY || result11 == Number.NEGATIVE_INFINITY) {
          output11.value = 0;
        }else{
          output11.value =  result11;
        }


        // Result 12
        var nop_pemb_batu1 = parseFloat(nop_pemb_batu.value) || 0,
            tl12 = parseFloat(tl_pemb_batu.value) || 0,
            t12 = parseFloat(t_pemb_batu.value) || 0,
            npwp12 = parseFloat(npwp_pemb_batu.value) || 0;

        if (npwp12 == 0 || npwp12 == "") {
          var result12 = Math.round(nop_pemb_batu1*tl12*t12);
        }else{
          var result12 = Math.round(nop_pemb_batu1*t12);
        }

        if (result12 == Number.POSITIVE_INFINITY || result12 == Number.NEGATIVE_INFINITY) {
          output12.value = 0;
        }else{
          output12.value =  result12;
        }


        // Result 13
        var nop_penj_emas1 = parseFloat(nop_penj_emas.value) || 0,
            tl13 = parseFloat(tl_penj_emas.value) || 0,
            t13 = parseFloat(t_penj_emas.value) || 0,
            npwp13 = parseFloat(npwp_penj_emas.value) || 0;

        if (npwp13 == 0 || npwp13 == "") {
          var result13 = Math.round(nop_penj_emas1*tl13*t13);
        }else{
          var result13 = Math.round(nop_penj_emas1*t13);
        }

        if (result13 == Number.POSITIVE_INFINITY || result13 == Number.NEGATIVE_INFINITY) {
          output13.value = 0;
        }else{
          output13.value =  result13;
        }


        // Result Jumlah NOP
        var resultnoppph22 =  Math.round(
                                nop_badan_usaha1+
                                nop_penj_barang1+
                                nop_pembelian_bend1+
                                nop_api1+
                                nop_non_api1+
                                nop_hasil_lelang1+
                                nop_spbu1+
                                nop_pihak_lain1+
                                nop_bumn1+
                                nop_penj_hasil1+
                                nop_penj_ken1+
                                nop_pemb_batu1+
                                nop_penj_emas1
                              );

        

        if (resultnoppph22 == Number.POSITIVE_INFINITY || resultnoppph22 == Number.NEGATIVE_INFINITY) {
          outputsptpph22.value = 0;
        }else{
          outputsptpph22.value = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(resultnoppph22);
        }


        // Result Jumlah PPh
        var resultpph22 =  Math.round(
                                result1+
                                result2+
                                result3+
                                result4+
                                result5+
                                result6+
                                result7+
                                result8+
                                result9+
                                result10+
                                result11+
                                result12+
                                result13
                              );

        if (resultpph22 == Number.POSITIVE_INFINITY || resultpph22 == Number.NEGATIVE_INFINITY) {
          outputpph22.value = 0;
        }else{
          outputpph22.value = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(resultpph22);
        }
    };
  </script>


  {{-- Bukti Potong PPh 23 --}}
  <script>
    var formbupotpph23 = document.forms.formbupotpph23,
        jumlah_peng_bruto = formbupotpph23.jumlah_peng_bruto,
        tarif_lebih = formbupotpph23.tarif_lebih,
        tarif = formbupotpph23.tarif,
        npwp = formbupotpph23.npwp,
        outputbupot23 = formbupotpph23.pph_dipot;

    window.calculatebupotpph23 = function () {
        var jumlah_peng_bruto1 = parseFloat(jumlah_peng_bruto.value) || 0,
            lebih1 = parseFloat(tarif_lebih.value) || 0,
            tarif1 = parseFloat(tarif.value) || 0,
            npwp_bupot1 = parseFloat(npwp.value) || 0;

        if (npwp_bupot1 == 0 || npwp_bupot1 == "") {
          var resultbupot23 = Math.round(jumlah_peng_bruto1*lebih1*tarif1);
        }else{
          var resultbupot23 = Math.round(jumlah_peng_bruto1*tarif1);
        }

        if (resultbupot23 == Number.POSITIVE_INFINITY || resultbupot23 == Number.NEGATIVE_INFINITY) {
          outputbupot23.value = 0;
        }else{
          outputbupot23.value =  resultbupot23;
        }
    };

    function removeDisabledJasa() {
      document.getElementById("jenis_jasa").disabled = false;
    }

    function addDisabledJasa() {
      document.getElementById("jenis_jasa").disabled = true;
    }
  </script>


  </body>

</html>

