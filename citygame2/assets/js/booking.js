jQuery(document).ready(function() {

  var dateArray = new Array();
  var bookingsString = $("#datepicker").attr('bookings') ;
  var bookingsArray = JSON.parse("[" + bookingsString + "]");

  for (var i = 0; i < bookingsArray.length; i++) {
    var temp = new Date(bookingsArray[i]*1000);
    temp.setHours(0, 0, 0, 0);
    dateArray.push(temp);
  }
  //console.log( dateArray);
  $(function () {
    $("#datepicker").datepicker({
      minDate: 1,
      dateFormat: 'yy-mm-dd',
      beforeShowDay: function (date) {
        for (var i = 0; i < dateArray.length; i++) {

          if (date.getTime() == dateArray[i].getTime()) {
            return [false, 'redday', ''];
          }
        }

        if (date.getTime() == 0) {
          return [false, 'redday', ''];
        }
        else {
          return [true, '', ''];
        }
      }
    })
  });
});
