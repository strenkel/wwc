define([
  "jquery"
], function($) {

  "use strict";

  var markActiveHeader = function(selector) {
    $(selector).addClass("active");
  };

  return {
    markActiveHeader: markActiveHeader
  };

});