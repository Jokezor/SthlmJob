var myRangeValue; // your javascript variable that will store the value of the slider

$(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: new Date('2018.01.01').getTime() / 1000,
      max: new Date('2019.01.01').getTime() / 1000,
      step: 86400,
      values: [ new Date('2018.01.01').getTime() / 1000, new Date('2019.01.01').getTime() / 1000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( (new Date(ui.values[ 0 ] *1000).toDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toDateString() );
      }
    });
    $( "#amount" ).val( (new Date($( "#slider-range" ).slider( "values", 0 )*1000).toDateString()) +
      " - " + (new Date($( "#slider-range" ).slider( "values", 1 )*1000)).toDateString());
  });


$(document).ready(function() {
 $("#slider-range").range({
   range: true,
   min: 20000,
   max: 100000,
   values: [ 75, 300 ],
   slide: function( event, ui ) {
     $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
   }
   //onChange: function(val) { myRangeValue = val; } // assigning the callback argument to your variable each time the value changes
 });

 $('#range-3').range({
     min: 20000,
     max: 100000,
     start: 20000,
     step: 1000,
     onChange: function(value) {
       $('#display-3').html(value);
     }
   });

   $('#range-4').range({
       min: 20000,
       max: 100000,
       start: 100000,
       step: 1000,
       onChange: function(value) {
         $('#display-4').html(value);
       }
     });
     $('#range-5').range({
         min: 20,
         max: 75,
         start: 20,
         step: 1,
         onChange: function(value) {
           $('#display-5').html(value);
         }
       });
       $('#range-6').range({
           min: 20,
           max: 75,
           start: 75,
           step: 1,
           onChange: function(value) {
             $('#display-6').html(value);
           }
         });
         $('#range-7').range({
             min: 0,
             max: 50,
             start: 0,
             step: 1,
             onChange: function(value) {
               $('#display-7').html(value);
             }
           });
           $('#range-8').range({
               min: 0,
               max: 50,
               start: 50,
               step: 1,
               onChange: function(value) {
                 $('#display-8').html(value);
               }
             });
             $('#range-9').range({

                 min: 0,
                 max: 12,
                 start: 0,
                 step: 1,
                 onChange: function(value) {
                   $('#display-9').html(value);
                 }
               });
               $('#range-10').range({
                   min: 0,
                   max: 12,
                   start: 12,
                   step: 1,
                   onChange: function(value) {
                     $('#display-10').html(value);
                   }
                 });
                 $('#range-11').range({
                     min: 0,
                     max: 12,
                     start: 0,
                     step: 1,
                     onChange: function(value) {
                       $('#display-11').html(value);
                     }
                   });
                   $('#range-12').range({
                       min: 0,
                       max: 12,
                       start: 12,
                       step: 1,
                       onChange: function(value) {
                         $('#display-12').html(value);
                       }
                     });


});
