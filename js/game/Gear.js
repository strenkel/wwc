define(["jquery"], function ($) {

  "use strict";

  /**
   * @param playElement {HTMLElement}
   * @param stopElement {HTMLElement}
   * @param stepElement {HTMLElement}
   * @param resetElement {HTMLElement}
   */
  var Gear = function(c) {
    this.playElement = c.playElement;
    this.stopElement = c.stopElement;
    this.stepElement = c.stepElement;
    this.resetElement = c.resetElement;
    this.refreshElement = c.refreshElement;

    // init listeners
    this.onPlayListeners = $.Callbacks();
    this.onStopListeners = $.Callbacks();
    this.onStepListeners = $.Callbacks();
    this.onResetListeners = $.Callbacks();

    // init display
    this.showPlay();

    // init control
    this.playElement.onclick = this.play.bind(this);
    this.stopElement.onclick = this.stop.bind(this);
    this.stepElement.onclick = this.step.bind(this);
    this.resetElement.onclick = this.reset.bind(this);
    this.refreshElement.onclick = this.reset.bind(this);
  };

  Gear.prototype.addOnPlayListener = function(callback) {
    this.onPlayListeners.add(callback);
  };

  Gear.prototype.addOnStopListener = function(callback) {
    this.onStopListeners.add(callback);
  };

  Gear.prototype.addOnStepListener = function(callback) {
    this.onStepListeners.add(callback);
  };

  Gear.prototype.addOnResetListener = function(callback) {
    this.onResetListeners.add(callback);
  };

  /** @private */
  Gear.prototype.play = function() {
    this.showStop();
    this.onPlayListeners.fire();
  };

  /** @private */
  Gear.prototype.stop = function() {
    this.showPlay();
    this.onStopListeners.fire();
  };

  /** @private */
  Gear.prototype.step = function() {
    if (this.playIsShown) {
      this.onStepListeners.fire();
    }
  };

  /** @private */
  Gear.prototype.reset = function() {
    if (this.playIsShown) {
      this.onResetListeners.fire();
    }
  };

  /** @private */
  Gear.prototype.showPlay = function() {
    this.playIsShown = true;
    this.showPlayElement();
    this.showStepElement();
    this.showResetElement();
    this.hideStopElement();
  };

  /** @private */
  Gear.prototype.showStop = function() {
    this.playIsShown = false;
    this.hidePlayElement();
    this.hideStepElement();
    this.hideResetElement();
    this.showStopElement();
  };

  /** @private */
  Gear.prototype.showPlayElement = function() {
    show(this.playElement);
  };

  /** @private */
  Gear.prototype.hidePlayElement = function() {
    hide(this.playElement);
  };

  /** @private */
  Gear.prototype.showStopElement = function() {
    show(this.stopElement);
  };

  /** @private */
  Gear.prototype.hideStopElement = function() {
    hide(this.stopElement);
  };

  /** @private */
  Gear.prototype.showResetElement = function() {
    enable(this.resetElement);
  };

  /** @private */
  Gear.prototype.hideResetElement = function() {
    disable(this.resetElement);
  };

 /** @private */
  Gear.prototype.showStepElement = function() {
    enable(this.stepElement);
  };

  /** @private */
  Gear.prototype.hideStepElement = function() {
    disable(this.stepElement);
  };

  var show = function(elm) {
    elm.style.display = "inline-block";
  };

  var hide = function(elm) {
    elm.style.display = "none";
  };

  var disable = function(elm) {
    elm.classList.add("disabled");
  };

  var enable = function(elm) {
    elm.classList.remove("disabled");
  };

  return Gear;
});