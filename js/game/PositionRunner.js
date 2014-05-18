define(function () {

  "use strict";

  var PositionRunner = function() {

    // -- members --

    var position1;
    var position2;
    var returnMatch;

    // -- public methods --

    /**
     * @returns {[Number, Number]}
     */
    this.getNext = function() {
      if (returnMatch) {
        returnMatch = false;
        return [position1, position2];
      } else {
        returnMatch = true;
        position2++;
        if (position1 === position2) {
          position1++;
          position2 = 1;
        }
        return [position2, position1];
      }
    };

    this.reset = function() {
      position1 = 1;
      position2 = 0;
      returnMatch = false;
    };

    // -- constructur code --

    this.reset();
  };

  return PositionRunner;
});