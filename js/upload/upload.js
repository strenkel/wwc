require([
  "jquery",
  "upload/Uploader",
"upload/Top3",
], function($, Uploader, Top3) {

  "use strict";

  $(document).ready(function() {
    new Uploader({
      button: document.getElementById("wwc-upload"),
      file: document.getElementById("uploadBtn"),
      message: document.getElementById("wwc-upload-message"),
      author: document.getElementById("wwc-upload-author"),
      email: document.getElementById("wwc-upload-email"),
      termsOfUse: document.getElementById("wwc_checkbox_termsofuse")
    });

    new Top3([{
      name: document.getElementById("workerPlace1name"),
      author: document.getElementById("workerPlace1Author"),
      points: document.getElementById("workerPlace1Points")
    }, {
      name: document.getElementById("workerPlace2name"),
      author: document.getElementById("workerPlace2Author"),
      points: document.getElementById("workerPlace2Points")
    }, {
      name: document.getElementById("workerPlace3name"),
      author: document.getElementById("workerPlace3Author"),
      points: document.getElementById("workerPlace3Points")
    }]);

  });
});