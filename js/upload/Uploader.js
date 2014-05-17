define([
  "util/Ajax",
  "util/Dom"
], function (Ajax, Dom) {

  "use strict";

  /**
   * @param button {Button}
   * @param file {FileInput}
   * @param message {Div}
   * @param author {Input}
   * @param email {Input}
   * @param acceptTerm {Checkbox}
   */
  var Uploader = function(a) {
    a.button.onclick = this.upload.bind(this);
    this.fileElm = a.file;
    this.messageElm = a.message;
    this.authorElm = a.author;
    this.emailElm = a.email;
    this.termsOfUseElm = a.termsOfUse;
  };

  /** @private */
  Uploader.prototype.upload = function() {
    if (!this.fileIsSelected()) {
      this.showMessage("Error: No file selected.");
      return;
    }
    if (!this.termsOfUseIsAccepted()) {
      this.showMessage("Error: Teilnahmebedingungen nicht akzeptiert.");
      return;
    }
    Ajax.uploadFile(this.fileElm.files[0], this.authorElm.value, this.emailElm.value).
      done(this.showMessage.bind(this));
  };

  /** @private */
  Uploader.prototype.showMessage = function(message) {
    this.messageElm.innerHTML = message;
    Dom.popInPopOut(this.messageElm);
  };

  /** @private */
  Uploader.prototype.fileIsSelected = function() {
    return this.fileElm.files.length === 1;
  };

  /** @private */
  Uploader.prototype.termsOfUseIsAccepted = function() {
    return this.termsOfUseElm.checked;
  };


  return Uploader;

});