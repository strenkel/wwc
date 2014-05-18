define([
  "util/Dom",
  "util/Ajax"
], function (Dom, Ajax) {

  "use strict";

  var returnFalse = function() {
    return false;
  };

  var returnNull = function() {
    return null;
  };


  /**
   * Manage the super user page.
   *
   * @param passwordElm {Input}
   * @param enterElm {Button}
   * @param uploasResultElm {Checkbox}
   * @param messageElm {Div | Span}
   */
  var SuperUser = function(a) {

    // pass arguments
    this.loginRoot = a.loginRoot;
    this.controlRoot = a.controlRoot;
    this.passwordElm = a.passwordElm;
    this.enterElm = a.enterElm;
    this.messageElm = a.messageElm;
    this.uploadResultElm = a.uploadResultElm;
    this.scheduleSelect = a.scheduleSelect;

    // init
    if (this.hasControls()) {
      this.shouldSaveResult = this.uploadResultIsChecked;
      this.getPassword = this.getPasswordFromElm;
      this.showLogin();
      this.hideControls();
      this.hideMessage();
      this.enterElm.onclick = this.handleLogin.bind(this);
    } else {
      this.shouldSaveResult = returnFalse;
      this.getPassword = returnNull;
    }
  };

  /**
   * @private
   * @returns {Boolean}
   */
  SuperUser.prototype.uploadResultIsChecked = function() {
    return this.uploadResultElm.checked;
  };

  /**
   * @private
   * @returns {String}
   */
  SuperUser.prototype.getPasswordFromElm = function() {
    return this.passwordElm.value;
  };

  /** @private */
  SuperUser.prototype.hasControls = function() {
    return this.loginRoot ? true : false;
  };

  /** @private */
  SuperUser.prototype.handleLogin = function() {
    var password = this.getPassword();
    if (password && password.length > 0) {
      Ajax.checkSuperuser(password).done((function(isLoggedIn) {
        if (isLoggedIn) {
          this.hideLogin();
          this.showControls();
          this.scheduleSelect.addNewFirstScheme();
        } else {
          this.showMessage();
        }
      }).bind(this));
    } else {
      this.showMessage();
    }
  };

  /** @private */
  SuperUser.prototype.hideLogin = function() {
    Dom.hide(this.loginRoot);
  };

  /** @private */
  SuperUser.prototype.showLogin = function() {
    Dom.show(this.loginRoot);
  };

  /** @private */
  SuperUser.prototype.hideControls = function() {
    Dom.hide(this.controlRoot);
  };

  /** @private */
  SuperUser.prototype.showControls = function() {
    Dom.show(this.controlRoot);
  };

  /** @private */
  SuperUser.prototype.hideMessage = function() {
    Dom.popOut(this.messageElm);
  };

  /** @private */
  SuperUser.prototype.showMessage = function() {
    Dom.popInPopOut(this.messageElm);
  };

  return SuperUser;

});