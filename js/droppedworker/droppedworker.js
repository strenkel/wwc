require([
  "jquery",
  "droppedworker/Table"
], function($, Table) {

  "use strict";

  $(document).ready(function() {
    new Table(document.getElementById("wwc-dropped-worker"));
  });
});