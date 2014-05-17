require.config({
    baseUrl: 'js',
    paths: {
      jquery: 'libs/jquery'
    }
});

require([
  "jquery",
  "util"
], function($, util) {

  "use strict";

  $(document).ready(function() {
    $('#toggleHeadline').click(toggleText);
    $('#toggleIcon').click(toggleText);
    util.markActiveHeader("#indexPhp");
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