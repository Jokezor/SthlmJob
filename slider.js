var myRangeValue; // your javascript variable that will store the value of the slider

$(document).ready(function() {
 $('#range').range({
   min: 0,
   max: 10,
   start: 5
   //onChange: function(val) { myRangeValue = val; } // assigning the callback argument to your variable each time the value changes
 });
 $('#range').range('set value', 17); // Sets slider with id 'range' to value 17
});
