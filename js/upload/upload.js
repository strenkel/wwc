require([
  "jquery",
  "upload/Uploader"
], function($, Uploader) {

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
  });
});