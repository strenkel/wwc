define(["jquery"], function ($) {

  "use strict";

  var DEFAULT_GAME_DELAY = 1000;

  var GameController = function(c) {

    // pass parameter
    this.game = c.game;
    this.plotter = c.plotter;
    this.scheduler = c.scheduler;
    this.superUser = c.superUser;

    // register onStop listeners
    this.game.addOnStopListener(this.onGameStop.bind(this));
    this.plotter.addOnStopListener(this.onPlotterStop.bind(this));

    // private members
    this.gameDelay = DEFAULT_GAME_DELAY;
    this.gameIsActive = false;
    this.isPlaying = false;
    this.plotIsActive = false;
  };

  GameController.prototype.initNewGame = function() {
    this.gameIsActive = true;
    this.plotIsActive = false;
    this.scheduler.getWorkerNames().done((function(workerDisposer) {
      if (workerDisposer) {
        this.plotter.startNewPlot(workerDisposer);
        this.game.startNewGame(workerDisposer);
      } else {
        this.gameIsActive = false;
      }
    }).bind(this));
  };

  GameController.prototype.play = function() {
    if (!this.isPlaying) {
      this.isPlaying = true;
      if (this.plotIsActive) {
        this.plotter.plot();
      } else if (!this.gameIsActive) {
        clearTimeout(this.newGameTimer);
        this.initNewGame();
      }
    }
  };

  GameController.prototype.pause = function() {
    if (this.isPlaying) {
      this.isPlaying = false;
      if (this.plotIsActive) {
        this.plotter.stop();
      }
    }
  };

  GameController.prototype.stepForward = function() {
    if (!this.isPlaying) {
      if (this.plotIsActive) {
        this.plotter.stepForward();
      } else if (!this.gameIsActive) {
        clearTimeout(this.newGameTimer);
        this.initNewGame();
      }
    }
  };

  GameController.prototype.refresh = function() {
    this.pause();
    this.plotter.resetPoints();
    this.next();
  };

  GameController.prototype.next = function() {
    if (!this.isPlaying && !this.gameIsActive) {
      this.initNewGame();
    }
  };

  GameController.prototype.adjustGameDelay = function() {
    if (this.superUser.shouldSaveResult()) {
      this.gameDelay = 0;
    } else {
      this.gameDelay = DEFAULT_GAME_DELAY;
    }
  };

  /** @private */
  GameController.prototype.onGameStop = function(moves) {
    this.plotter.passMoves(moves);
    this.gameIsActive = false;
    this.plotIsActive = true;
    if (this.isPlaying) {
      this.plotter.plot();
    }
  };

  /** @private */
  GameController.prototype.onPlotterStop = function() {
    this.plotIsActive = false;
    this.newGameTimer = setTimeout((function() {
      if (this.isPlaying) {
        this.initNewGame();
      }
    }).bind(this), this.gameDelay);
  };

  return GameController;
});