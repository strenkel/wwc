/* global Worker */
define(["jquery"], function ($) {

  "use strict";

  var Game = function(field) {
    this.field = field;
    this.onStopListeners = $.Callbacks();
    field.addOnStopListener(this.onStop.bind(this));
  };

  /**
   * @param playerNames {[String]}
   **/
  Game.prototype.startNewGame = function(workerDisposer) {
    this.workers = workerDisposer.createWorkers();
    this.field.startNewGame(this.workers.length);
    var _this = this;
    window.setTimeout(function() {
      _this.timeoutId = play(_this.workers, _this.field);
    }, 300);
  };

  /**
   * Fire, when game is over. Pass the move-array.
   * @param callback {Function(Array)}
   */
  Game.prototype.addOnStopListener = function(callback) {
    this.onStopListeners.add(callback);
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
   */
  var play = function(workers, field) {

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

    var timeoutId = window.setTimeout(function() {
      field.stopGame();
    }, 30000);

    // workers go on!
    for (player = 0; player < playerLength; player++) {
      workers[player].postMessage({id: ids[player]});
    }

    return timeoutId;
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