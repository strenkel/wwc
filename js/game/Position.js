define(function() {  
  
  "use strict";
  
  var Position = function (x, y) {
    this.x = x; // horizontal direction; associated with width
    this.y = y; // vertical direction; associated with heigh
  };

  Position.prototype.clone = function () {
    return new Position(this.x, this.y);
  };

  return Position;
  
});