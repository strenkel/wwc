define([
  "util/Ajax"
], function (Ajax) {

  "use strict";

  /**
   * @param elements {[Object]}
   */
  var Top3 = function(elements) {
    this.elements = elements;
    this.fillElements();
  };

   /** @private */
  Top3.prototype.fillElements = function() {
    var _this = this;
    Ajax.getTable().done(function(table) {
      var l = Math.min(table.length, 3);
      for (var i=0; i < l; i++) {
        _this.addPositioning(table[i], i);
      }
    });
  };

  Top3.prototype.addPositioning = function(data, position) {
    var element = this.elements[position];
    element.name.innerHTML = data.name;
    element.author.innerHTML = data.author;
    element.points.innerHTML = data.points;
  };

  return Top3;
});