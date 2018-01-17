var myRangeValue; // your javascript variable that will store the value of the slider

$(document).ready(function() {
 $("#slider-range").range({
   range: true,
   min: 0,
   max: 500,
   values: [ 75, 300 ],
   slide: function( event, ui ) {
     $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
   }
   //onChange: function(val) { myRangeValue = val; } // assigning the callback argument to your variable each time the value changes
 });

 $('#range-3').range({
     min: 0,
     max: 10,
     start: 5,
     onChange: function(value) {
       $('#display-3').html(value);
     }
   });

});
