// $(function() {

//       function autoCalcSetup() {
//         $('form#pph23').jAutoCalc('destroy');
//         $('form#pph23 div.spt').jAutoCalc({keyEventsFire: true, decimalPlaces: 5, emptyAsZero: true});
//         $('form#pph23').jAutoCalc({decimalPlaces: 5});
//       }
//       autoCalcSetup();


//       $('button.row-remove').on("click", function(e) {
//         e.preventDefault();

//         var form = $(this).parents('form')
//         $(this).parents('tr').remove();
//         autoCalcSetup();

//       });

//       $('button.row-add').on("click", function(e) {
//         e.preventDefault();

//         var $table = $(this).parents('div.parent');
//         var $top = $table.find('div.spt').first();
//         var $new = $top.clone(true);

//         $new.jAutoCalc('destroy');
//         $new.insertBefore($top);
//         $new.find('input[type=text]').val('');
//         autoCalcSetup();

//       });

//     });