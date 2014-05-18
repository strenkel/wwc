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

    //this.resetMaxMoveLength();
  };

  /**
   * Start a (new) game.
   * Each player will get a random start point.
   * @param length {Integer}
   */
  Field.prototype.startNewGame = function(length) {

    //this.resetMaxMoveLength();

    this.playerLength = length;
    this.moves = [];
    this.actualPosition = [];
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

    //this.calcMaxMoveLength(player);

    this.moveLength++;
    if (this.moveLength <= this.maxMoveLength) {
      var newPosition = this.getNewPosition(player, direction);
      if (this.isAllowedPositionForPlayer(player, newPosition)) {
        this.walkToPosition(player, newPosition);
        return true;
      }
      return false;
    } else { // game is over

      //alert(this._maxMoveLength.length + " " + this._maxMoveLength[0]);

      this.moves.push(-1);
      this.onStopListeners.fire(this.moves);
      return null;
    }
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




  //Field.prototype.calcMaxMoveLength = function(player) {
  //  if (this._lastPlayer == null) {
  //    this._lastPlayer = player;
  //    this._moveLength++;
  //  } else if (this._lastPlayer == player) {
  //    this._moveLength++;
  //  } else {
  //    if (this._moveLength > 50) {
  //      this._maxMoveLength.push(this._moveLength);
  //    }
  //    this._moveLength = 0;
  //    this._lastPlayer = player;
  //  }
  //};

  //Field.prototype.resetMaxMoveLength = function() {
  //  this._maxMoveLength = [];
  //  this._moveLength = 0;
  //  this._lastPlayer = null;
  //};



  return Field;

});