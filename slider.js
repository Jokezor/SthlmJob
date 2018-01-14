var myRangeValue; // your javascript variable that will store the value of the slider

$(document).ready(function() {
 $('#rangers').range({
   range: true,
   min: 0,
   max: 500,
   values: [ 75, 300 ],
   slide: function( event, ui ) {
     $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
   }
   //onChange: function(val) { myRangeValue = val; } // assigning the callback argument to your variable each time the value changes
 });
 $( "#amount" ).val( "$" + $( "#rangers" ).slider( "values", 0 ) +
      " - $" + $( "#rangers" ).slider( "values", 1 ) );
});
