require([
  "jquery",
  "top20/Table",
  "top20/Challenger"
], function($, Table, Challenger) {

  "use strict";

  $(document).ready(function() {
    new Table(document.getElementById("wwc-table-body"));
    new Challenger(document.getElementById("wwc-challenger-body"));
  });
});