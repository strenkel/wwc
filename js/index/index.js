require([
  "jquery"
], function($) {

  "use strict";

  $(document).ready(function() {
    $('#toggleHeadline').click(toggleText);
    $('#toggleIcon').click(toggleText);
  });

  var toggleText = function() {
    $('#toggleText').toggleClass('hidden');
    if($('#toggleText').hasClass('hidden')) {
      $('.toggleIcon').text('+');
    } else {
      $('.toggleIcon').text('-');
    }
  };

});