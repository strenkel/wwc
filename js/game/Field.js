define([
  "jquery",
  "game/Position"
], function ($, Position) {

  "use strict";

  /**
   * The playing field for n player.
   * Configurate the field with the constructor,
   * start a (new) game with 'startNewGame' and do a move with 'walk'.
   * Register an onStop-Handler with addOnStopListener.
   * The registered callbacks receives the move-array when game is over.
   */
  var Field = function(c) {
    this.width = c.width; // {Integer} width <=> x
    this.height = c.height; // {Integer} height <=> y
    this.maxMoveLength = c.maxMoveLength; // {Integer}
    this.onStopListeners = $.Callbacks();
  };

  /**
   * Start a (new) game.
   * Each player will get a random start point.
   * @param length {Integer}
   */
  Field.prototype.startNewGame = function(length) {
    this.playerLength = length;
    this.moves = [];
    this.actualPosition = [];
    this.workerError= [false, false];
    this.moveLength = 0;
    this.initGrid();
    this.initPlayers();
  };

  /**
   * Call back when game is over. Pass the move-array.
   * @param callback {Function}
   */
  Field.prototype.addOnStopListener = function(callback) {
    this.onStopListeners.add(callback);
  };

  /**
   * Do a move for a player.
   * Return true if the move change the location, e.g. if the walk is successful.
   * Return null, if game is over.
   *
   * @param player {Integer} 0 <= player < playerLength
   * @param direction {'up' | 'down' | 'left' | 'right'}
   * @return {Boolean | null}
   */
  Field.prototype.walk = function (player, direction) {
    this.moveLength++;
    if (this.moveLength <= this.maxMoveLength) {
      var newPosition = this.getNewPosition(player, direction);
      if (this.isAllowedPositionForPlayer(player, newPosition)) {
        this.walkToPosition(player, newPosition);
        return true;
      }
      return false;
    } else {
      this.stopGame();
      return null;
    }
  };

  /** public */
  Field.prototype.error = function(player) {
    this.workerError[player] = true;
    if (this.workerError[0] && this.workerError[1]) {
      this.stopGame();
    }
  };

  /** @private */
  Field.prototype.stopGame = function() {
    this.moves.push(-1);
    this.onStopListeners.fire(this.moves);
  };

  /** @private */
  Field.prototype.getNewPosition = function(player, direction) {
    var newPosition = this.actualPosition[player].clone();
    switch(direction) {
      case "up":
        newPosition.y--;
        break;
      case "down":
        newPosition.y++;
        break;
      case "left":
        newPosition.x--;
        break;
      case "right":
        newPosition.x++;
        break;
    }
    return newPosition;
  };

  /** @private */
  Field.prototype.isAllowedPositionForPlayer = function (player, position) {
    if (!this.isValidPosition(position)) {
      return false;
    }
    var playerAtPosition = this.grid[position.x][position.y];
    return playerAtPosition === undefined || playerAtPosition === player;
  };

  /** @private */
  Field.prototype.initGrid = function () {
    this.grid = new Array(this.width);
    for (var i = 0; i < this.width; i++) {
      this.grid[i] = new Array(this.height);
    }
  };

  /** @private */
  Field.prototype.initPlayers = function () {
    for (var player = 0; player < this.playerLength; player++) {
      this.walkToPosition(player, this.getFreeRandomPosition());
    }
  };

  /** @private */
  Field.prototype.walkToPosition = function (player, position) {
    var isNew = false;
    this.actualPosition[player] = position;

    if (this.isFreePosition(position)) {
      isNew = true;
      this.grid[position.x][position.y] = player;
    }

    this.moves.push({
      player: player,
      position: position,
      isNew: isNew
    });

  };

  /** @private */
  Field.prototype.getFreeRandomPosition = function () {
    var position;
    do {
      position = this.getRandomPosition();
    } while (!this.isFreePosition(position));
    return position;
  };

  /** @private */
  Field.prototype.getRandomPosition = function () {
    var position = new Position();
    position.x = Math.floor(Math.random() * this.width);
    position.y = Math.floor(Math.random() * this.height);
    return position;
  };

  /** @private */
  Field.prototype.isFreePosition = function (position) {
    return this.grid[position.x][position.y] === undefined;
  };

  /** @private */
  Field.prototype.isValidPosition = function (position) {
    var x = position.x;
    var y = position.y;
    return x >= 0 && x < this.width && y >= 0 && y < this.height;
  };

  return Field;

});