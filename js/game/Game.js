/* global Worker */
define(["jquery"], function ($) {

  "use strict";

  var Game = function(field) {
    this.field = field;
    this.onStopListeners = $.Callbacks();
    field.addOnStopListener(this.onStop.bind(this));
    this.done = [];
  };

  /**
   * @param playerNames {[String]}
   **/
  Game.prototype.startNewGame = function(workerDisposer) {
    this.workers = workerDisposer.createWorkers();
    this.field.startNewGame(this.workers.length);
    this.iAmReady = [false, false];

    var player;
    var playerLength = this.workers.length;
    var _this = this;

    // limiting playing duration
    this.timeoutId = window.setTimeout(function() {
      _this.field.stopGame();
    }, 30000);

    for (player = 0; player < playerLength; player++) {

      // handle first move
      this.workers[player].onmessage = (function (player, event) {
        this.onmessage = null;
        _this.done[player] = _this.field.walk(player, event.data.direction);
        _this.workerIsReady(player);
      }).bind(this.workers[player], player);

      // handle first error
      this.workers[player].onerror = (function (player) {
        this.onerror = null;
        _this.field.error(player);
        _this.workerIsReady(player);
      }).bind(this.workers[player], player);

    }

    // workers make your first move
    for (player = 0; player < playerLength; player++) {
      this.workers[player].postMessage({id: getRandomId()});
    }

  };

  /**
   * Fire, when game is over. Pass the move-array.
   * @param callback {Function(Array)}
   */
  Game.prototype.addOnStopListener = function(callback) {
    this.onStopListeners.add(callback);
  };

  /** @private */
  Game.prototype.workerIsReady = function(player) {
    this.iAmReady[player] = true;
    if (this.iAmReady[0] && this.iAmReady[1]) {
      play(this.workers, this.field, this.done);
    }
  };

  /** @private */
  Game.prototype.onStop = function(moves) {
    window.clearTimeout(this.timeoutId);
    terminateWorkers(this.workers);
    this.onStopListeners.fire(moves);
  };

  /**
   * @param workers {[Worker]}
   * @param field {Field}
   * @param firstDone {[Boolean]}
   */
  var play = function(workers, field, firstDone) {

    var playerLength = workers.length,
      ids = getRandomIds(playerLength),
      idWasNotWrong = [true, true],
      player;

    for (player = 0; player < playerLength; player++) {

      workers[player].onmessage = (function (player, event) {
        if (event.data.id === ids[player] && idWasNotWrong[player]) {
          var done = field.walk(player, event.data.direction);
          ids[player] = getRandomId();
          this.postMessage({
            id: ids[player],
            done: done
          });
        } else {
          idWasNotWrong[player] = false;
        }
      }).bind(workers[player], player);

      workers[player].onerror = (function (player) {
        field.error(player);
      }).bind(workers[player], player);

    }

    // workers go on!
    for (player = 0; player < playerLength; player++) {
      workers[player].postMessage({
        id: ids[player],
        done: firstDone[player]
      });
    }

  };

  var terminateWorkers = function(workers) {
    workers.forEach(function(worker) {
      worker.terminate();
    });
  };

  var getRandomIds = function(length) {
    var ids = [];
    for (var i = 0; i < length; i++) {
      ids.push(getRandomId());
    }
    return ids;
  };

  var getRandomId = Math.random;

  return Game;
});