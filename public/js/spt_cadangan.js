$('.add').on('click', add);
$('.remove').on('click', remove);

function add() {
  var new_chq_no = parseInt($('#total_chq').val()) + 1;
  var new_input = "<div class='form-group row' id='new_" + new_chq_no + "'><div class='col-lg-2'><input class='form-control' name='uraian_" + new_chq_no + "' type='text' placeholder='Uraian..'></div><div class='col-lg-2'><input class='form-control' maxlength='20' type='text' placeholder='NPWP..' name='npwp_pph23_" + new_chq_no + "'></div><div class='col-lg-2'><input class='form-control' name='kap_kjs_" + new_chq_no + "' type='text' placeholder='KAP/KJS..'></div><div class='col-lg-2'><input class='form-control jumlah_peng_bruto' name='jumlah_peng_bruto[]' id='jumlah_peng_bruto' type='number' placeholder='Jumlah Penghasilan Bruto (Rp)'></div><div class='col-lg-1'><input class='form-control' type='number' value='2' name='tl_pph23[]' readonly></div><div class='col-lg-1'><input class='form-control' type='number' placeholder='T(%)' step='.00001' name='t_pph23_" + new_chq_no + "'></div><div class='col-lg-2'><input class='form-control' type='number' placeholder='PPh yang Dipungut (Rp)' name='pph_dipot23_" + new_chq_no + "' readonly></div></div>";

  $('#new_chq').append(new_input);

  $('#total_chq').val(new_chq_no);
}

function remove() {
  var last_chq_no = $('#total_chq').val();

  if (last_chq_no > 1) {
    $('#new_' + last_chq_no).remove();
    $('#total_chq').val(last_chq_no - 1);
  }
}

$(document).on('keyup', ".jumlah_peng_bruto",function () {
  var total = 0;
  
  $('.jumlah_peng_bruto').each(function(){
    total += parseFloat($(this).val());
  })  
  document.getElementById("total_peng_bruto").value = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(total);
})



// var jml_row = parseInt($('#total_chq').val()); 

// for (let i = 0; i < jml_row; i++) {
//   var jumlah_peng_bruto = formsptpph23.jumlah_peng_bruto,
//       tl_pph23 = formsptpph23.tl_pph23,
//       t_pph23 = formsptpph23.t_pph23,
//       npwp_pph23 = formsptpph23.npwp_pph23,
//       outputpph23 = formsptpph23.pph_dipot23,
//       outputtotalbruto = formsptpph23.total_peng_bruto;

//   window.calculatesptpph23 = function () {
//     // Result 1
//     var npwp23 = parseFloat(document.forms.formsptpph23.npwp_pph23+i.value) || 0,
//         j1 = parseFloat(document.forms.formsptpph23.jumlah_peng_bruto+i.value) || 0,
//         tl_badan = parseFloat(document.forms.formsptpph23.tl_pph23+i.value) || 0,
//         t_badan = parseFloat(document.forms.formsptpph23.t_pph23+i.value) || 0;

//     if (npwp23 == 0 || npwp23 == "") {
//       var resultpph23 = Math.round(j1*tl_badan*t_badan);
//     }else{
//       var resultpph23 = Math.round(j1*t_badan);
//     }

//     if (resultpph23 == Number.POSITIVE_INFINITY || resultpph23 == Number.NEGATIVE_INFINITY) {
//       document.forms.formsptpph23.pph_dipot23+1.value = 0;
//     }else{
//       document.forms.formsptpph23.pph_dipot23+1.value = resultpph23;
//     } 
//   }

// }