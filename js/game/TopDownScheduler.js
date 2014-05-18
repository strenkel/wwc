define([
  "jquery",
  "game/PositionRunner",
  "game/WorkerDisposer",
  "util/Ajax"
], function ($, PositionRunner, WorkerDisposer, Ajax) {

  "use strict";

  var TopDownScheduler = function() {
    this.positionRunner = new PositionRunner();
  };

  /**
   * Promise pass a WorkerDisposer.
   * @returns {$.Promise}
   */
  TopDownScheduler.prototype.getWorkerNames = function() {
    var deferred = $.Deferred();
    var positions = this.positionRunner.getNext();
    var _this = this;
    $.when(
      Ajax.getWorkerNameByPosition(positions[0]),
      Ajax.getWorkerNameByPosition(positions[1])
    ).done(function(response0, response1) {
      var workerName0 = response0[0];
      var workerName1 = response1[0];
      if (workerName0 !== "" && workerName1 !== "") {
        deferred.resolve(new WorkerDisposer(workerName0, workerName1));
      } else if (positions[0] === 1 && positions[1] === 2) {
        deferred.resolve(null); // not enough workers in database
      } else {
        _this.positionRunner.reset();
        _this.getWorkerNames().done(deferred.resolve);
      }
    });
    return deferred.promise();
  };

  return TopDownScheduler;
});