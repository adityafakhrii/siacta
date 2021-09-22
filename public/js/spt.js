var myform = document.forms.myform,
      phneto_dn = myform.phneto_dn,
      phneto_dn_lain = myform.phneto_dn_lain,
      phneto_ln = myform.phneto_ln,
      output = myform.jml_peng_neto;

  window.calculate = function () {
      var a = parseFloat(phneto_dn.value, 10) || 0,
          b = parseFloat(phneto_dn_lain.value) || 0;
          c = parseFloat(phneto_ln.value) || 0;

      var result = Math.round(a+b+c);

      if (result == Number.POSITIVE_INFINITY || result == Number.NEGATIVE_INFINITY) {
        output.value = 0;
      }else{
        output.value =  result;
      }
  };