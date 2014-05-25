define(["jquery"], function ($) {

  "use strict";

  var MAX_SPEED = 20000;

  /**
   * @param drawingArea {DrawingArea}
   * @param score {Score}
   */
  var Plotter = function(c) {

    // pass parameters
    this.drawingArea = c.drawingArea;
    this.score = c.score;
    this.superUser = c.superUser;

    // private members
    this.onStopListeners = $.Callbacks();
    this.bodyColors = ["#68a289", "#a46868"];
    this.headColors = ["#005000", "#500000"];
    this.speed = 5;
    this.isPlotting = false;
    this.doPlot = true;
  };

  /**
   * @param workerDisposer {[String]}
   * @param positions {[Number]}
   */
  Plotter.prototype.startNewPlot = function(workerDisposer) {
    this.isPlotting = false;
    this.score.startNewScore(workerDisposer);
    this.drawingArea.clear();
    this.lastPositions = [];
  };

  /**
   * @param moves {Array}
   */
  Plotter.prototype.passMoves = function(moves) {
    this.moves = moves;
  };

  Plotter.prototype.plot = function() {
    if (this.moves && !this.isPlotting) {
      this.isPlotting = true;
      this.plotMoves();
    }
  };

  Plotter.prototype.stop = function() {
    if (this.moves && this.isPlotting) {
      this.isPlotting = false;
      clearInterval(this.intervalId);
    }
  };

  Plotter.prototype.stepForward = function() {
    if (this.moves && !this.isPlotting) {
      this.plotNextMove();
    }
  };

  Plotter.prototype.resetPoints = function() {
    this.score.resetPoints();
  };

  /**
   * @param callback {Function()}
   **/
  Plotter.prototype.addOnStopListener = function(callback) {
    this.onStopListeners.add(callback);
  };

  /** @private */
  Plotter.prototype.plotMoves = function() {
    var _this = this;
    var speed = this.speed;
    this.doPlot = true;
    if (this.superUser.shouldSaveResult()) {
      speed = MAX_SPEED;
      this.doPlot = false;
    }
    var done = true;
    this.intervalId = setInterval(function () {
      for (var i = 0; i < speed && done; i++) {
        done = _this.plotNextMove();
      }
    }, 0);
  };

  /** @private */
  Plotter.prototype.plotNextMove = function() {
    var move = this.moves.shift();
    if (move === -1) {
      this.stopPlotting();
      return false;
    } else {
      if (this.doPlot) {
        this.plotMove(move);
      }
      this.scoreMove(move);
      return true;
    }
  };

  /** @private */
  Plotter.prototype.stopPlotting = function() {
    this.moves = null;
    clearInterval(this.intervalId);
    this.score.updatePoints();
    this.onStopListeners.fire();
  };

  Plotter.prototype.scoreMove = function(move) {
    if (move.isNew) {
      this.score.increase(move.player);
    }
  };

  /** @private */
  Plotter.prototype.plotMove = function(move) {
    var player = move.player;
    var position = move.position;
    var lastPosition = this.lastPositions[player];
    if (lastPosition) {
      this.drawingArea.draw(lastPosition, this.bodyColors[player]);
    }
    this.drawingArea.draw(position, this.headColors[player]);
    this.lastPositions[player] = position;
  };

  return Plotter;
});