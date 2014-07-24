define(function () {

  "use strict";

  var DrawingArea = function(c) {

    var canvas = c.canvas;
    var unit = c.unit;
    var context = canvas.getContext("2d");
    canvas.width = unit * c.width; // x direction
    canvas.height = unit * c.height; // y direction

    /**
     * @param position {Position}
     * @param color {css color string} e.g. '#0f0'
     */
    this.draw = function (position, color) {
      context.fillStyle = color;
      context.fillRect(position.x * unit, position.y * unit, unit, unit);
    };

    this.clear = function() {
      context.clearRect(0, 0, canvas.width, canvas.height);
    };

  };

  return DrawingArea;
});