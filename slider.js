var myRangeValue; // your javascript variable that will store the value of the slider

/*
$(function()) {
  var startDate = new Date();
  // Do your operations
  var endDate   = new Date();
  var seconds = (endDate.getTime() - startDate.getTime()) / 1000;
}
*/


$(function() {
    $( "#slider-range1" ).slider({
      range: true,
      min: new Date('2018.01.01').getTime() / 1000,
      max: new Date('2019.01.01').getTime() / 1000,
      step: 86400,
      values: [ new Date('2018.01.01').getTime() / 1000, new Date('2019.01.01').getTime() / 1000 ],
      slide: function( event, ui ) {
        $( "#amount1" ).val( (new Date(ui.values[ 0 ] *1000).toDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toDateString() );
      }
    });
    $( "#amount1" ).val( (new Date($( "#slider-range1" ).slider( "values", 0 )*1000).toDateString()) +
      " - " + (new Date($( "#slider-range1" ).slider( "values", 1 )*1000)).toDateString());
  });

  $(function() {
      $( "#slider-range2" ).slider({
        range: true,
        min: 0,
        max: 50,
        start: 0,
        step: 1,
        values: [0,50],
        slide: function( event, ui ) {
          $( "#amount2" ).val( ((ui.values[ 0 ] *1000).toDateString() ) + " - " + ((ui.values[ 1 ] *1000)).toDateString() );
        }
      });
      $( "#amount2" ).val( (($( "#slider-range2" ).slider( "values", 0 )*1000).toDateString()) +
        " - " + (($( "#slider-range2" ).slider( "values", 1 )*1000)).toDateString());
    });


$(document).ready(function() {
 $('#range-3').range({
     min: 20000,
     max: 100000,
     start: 20000,
     step: 1000,
     onChange: function(value) {
       $('#display-3').html(value);
       $('#minsalary').val(value);
     }
   });

   $('#range-4').range({
       min: 20000,
       max: 100000,
       start: 100000,
       step: 1000,
       onChange: function(value) {
         $('#display-4').html(value);
         $('#maxsalary').val(value);
       }
     });
     $('#range-5').range({
         min: 20,
         max: 75,
         start: 20,
         step: 1,
         onChange: function(value) {
           $('#display-5').html(value);
            $('#minage').val(value);
         }
       });
       $('#range-6').range({
           min: 20,
           max: 75,
           start: 75,
           step: 1,
           onChange: function(value) {
             $('#display-6').html(value);
              $('#maxage').val(value);
           }
         });
         $('#range-7').range({
             min: 0,
             max: 50,
             start: 0,
             step: 1,
             onChange: function(value) {
               $('#display-7').html(value);
                $('#minexp').val(value);
             }
           });
           $('#range-8').range({
               min: 0,
               max: 50,
               start: 50,
               step: 1,
               onChange: function(value) {
                 $('#display-8').html(value);
                  $('#maxexp').val(value);
               }
             });
             $('#range-9').range({
                 min: 0,
                 max: 12,
                 start: 0,
                 step: 1,
                 onChange: function(value) {
                   $('#display-9').html(value);
                    $('#minleave').val(value);
                 }
               });
               $('#range-10').range({
                   min: 0,
                   max: 12,
                   start: 12,
                   step: 1,
                   onChange: function(value) {
                     $('#display-10').html(value);
                      $('#maxleave').val(value);
                   }
                 });

});
