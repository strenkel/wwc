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
   */
  var SuperUser = function(a) {

    // pass arguments
    this.loginRoot = a.loginRoot; // {Element}
    this.controlRoot = a.controlRoot; // {Element}
    this.passwordElm = a.passwordElm; // {Input}
    this.enterElm = a.enterElm; // {Button}
    this.messageElm = a.messageElm; // {Div | Span}
    this.uploadResultElm = a.uploadResultElm; // {Checkbox}
    this.removePlayerInput = a.removePlayerInput; // {Input}
    this.removePlayerButton = a.removePlayerButton; // {Button}
    this.scheduleSelect = a.scheduleSelect; // {ScheduleSelect}

    // init
    if (this.hasControls()) {
      this.shouldSaveResult = this.uploadResultIsChecked;
      this.getPassword = this.getPasswordFromElm;
      this.showLogin();
      this.hideControls();
      this.hideMessage();
      this.enterElm.onclick = this.handleLogin.bind(this);
      this.removePlayerButton.onclick = this.removePlayer.bind(this);
    } else {
      this.shouldSaveResult = returnFalse;
      this.getPassword = returnNull;
    }
  };

  /** @private */
  SuperUser.prototype.removePlayer = function() {
    var playerId = parseInt(this.removePlayerInput.value, 10);
    Ajax.removePlayer(playerId);
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