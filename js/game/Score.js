define([
  "util/Ajax"
], function (Ajax) {

  "use strict";

  /**
   * Designed for scoring two players aka workers.
   * So all arrays have length 2.
   * The overall results of all games will be stored in this.points.
   *
   * @param playerElements {[HTMLElement]}
   * @param scoreElements {[HTMLElement]}
   * @param pointElements {[HTMLElement]}
   */
  var Score = function(c) {

    // pass parameters
    this.playerElements = c.playerElements;
    this.scoreElements = c.scoreElements;
    this.pointElements = c.pointElements;
    this.superUser = c.superUser;

    // init further members
    this.score = [];
    this.points = {};
  };

  /**
   * @param playerNames {[String]}
   * @param positions {[Number]}
   */
  Score.prototype.startNewScore = function (workerDisposer) {

    // init members
    this.playerNames = workerDisposer.getNames();
    this.playerLength = this.playerNames.length;

    // reset/init data
    this.resetScore();
    this.initPoints();

    // view data
    this.viewPlayerNames();
    this.viewScore();
    this.viewPoints();
  };

  /**
   * @param player {0, 1, ...}
   */
  Score.prototype.increase = function(player) {
    this.score[player] += 1;
    this.viewScore();
  };

  Score.prototype.updatePoints = function() {
    if (!this.playerAreEquals()) {
      if (this.score[0] > this.score[1]) {
        this.points[this.playerNames[0]]++;
      } else if (this.score[1] > this.score[0]) {
        this.points[this.playerNames[1]]++;
      }
    }
    this.viewPoints();
    this.saveResult();
  };

  /** @public */
  Score.prototype.resetPoints = function() {
    this.points = {};
  };

  /** @private */
  Score.prototype.saveResult = function() {
    if (this.superUser.shouldSaveResult()) {
      Ajax.saveResult(this.playerNames, this.score);
    }
  };

  /** @private */
  Score.prototype.viewPlayerNames = function() {
    for (var i = 0, l = this.playerLength; i < l; i++) {
      this.playerElements[i].innerHTML = this.playerNames[i];
    }
  };

  /** @private */
  Score.prototype.viewScore = function() {
    for (var i = 0, l = this.playerLength; i < l; i++) {
      this.scoreElements[i].innerHTML = this.score[i];
    }
  };

  /** @private */
  Score.prototype.viewPoints = function() {
    var i;
    var l = this.playerLength;
    if (this.playerAreEquals()) {
      for (i = 0; i < l; i++) {
        this.pointElements[i].innerHTML = "same workers";
      }
    } else {
      for (i = 0; i < l; i++) {
        this.pointElements[i].innerHTML = this.points[this.playerNames[i]];
      }
    }
  };

  /** @private */
  Score.prototype.playerAreEquals = function() {
    return this.playerNames[0] === this.playerNames[1];
  };

  /** @private */
  Score.prototype.resetScore = function() {
    for (var i = 0, l = this.playerLength; i < l; i++) {
      this.score[i] = 0;
    }
  };

  /** @private */
  Score.prototype.initPoints = function() {
    for (var i = 0, l = this.playerLength; i < l; i++) {
      if (this.points[this.playerNames[i]] == null) {
        this.points[this.playerNames[i]] = 0;
      }
    }
  };

  return Score;

});