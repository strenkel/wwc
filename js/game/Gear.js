define(["jquery"], function ($) {

  "use strict";

  /**
   * @param playElement {HTMLElement}
   * @param stopElement {HTMLElement}
   * @param stepElement {HTMLElement}
   * @param nextElement {HTMLElement}
   * @param refreshElement {HTMLElement}
   */
  var Gear = function(c) {
    this.playElement = c.playElement;
    this.stopElement = c.stopElement;
    this.stepElement = c.stepElement;
    this.nextElement = c.nextElement;
    this.refreshElement = c.refreshElement;

    // init listeners
    this.onPlayListeners = $.Callbacks();
    this.onStopListeners = $.Callbacks();
    this.onStepListeners = $.Callbacks();
    this.onNextListeners = $.Callbacks();
    this.onRefreshListeners = $.Callbacks();

    // init display
    this.showPlay();

    // init control
    this.playElement.onclick = this.play.bind(this);
    this.stopElement.onclick = this.stop.bind(this);
    this.stepElement.onclick = this.step.bind(this);
    this.nextElement.onclick = this.next.bind(this);
    this.refreshElement.onclick = this.refresh.bind(this);
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

  Gear.prototype.addOnNextListener = function(callback) {
    this.onNextListeners.add(callback);
  };

  Gear.prototype.addOnRefreshListener = function(callback) {
    this.onRefreshListeners.add(callback);
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
  Gear.prototype.next = function() {
    if (this.playIsShown) {
      this.onNextListeners.fire();
    }
  };

  /** @private */
  Gear.prototype.refresh = function() {
    this.showPlay();
    this.onRefreshListeners.fire();
  };

  /** @private */
  Gear.prototype.showPlay = function() {
    this.playIsShown = true;
    this.showPlayElement();
    this.showStepElement();
    this.showNextElement();
    this.hideStopElement();
  };

  /** @private */
  Gear.prototype.showStop = function() {
    this.playIsShown = false;
    this.hidePlayElement();
    this.hideStepElement();
    this.hideNextElement();
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
  Gear.prototype.showNextElement = function() {
    enable(this.nextElement);
  };

  /** @private */
  Gear.prototype.hideNextElement = function() {
    disable(this.nextElement);
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