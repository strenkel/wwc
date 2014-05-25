define([
  "jquery",
  "game/PositionRunner",
  "game/WorkerDisposer",
  "util/Ajax"
], function ($, PositionRunner, WorkerDisposer, Ajax) {

  "use strict";

  var TopDownScheduler = function() {
    this.workerName0 = null;
    this.workerName1 = null;
  };

  /**
   * Promise pass a WorkerDisposer.
   * @returns {$.Promise}
   */
  TopDownScheduler.prototype.getWorkerNames = function() {
    var deferred = $.Deferred();
    this.fetchWorkerNames().done((function() {
      deferred.resolve(new WorkerDisposer(this.workerName0, this.workerName1, true));
    }).bind(this));
    return deferred.promise();
  };

  /** @private */
  TopDownScheduler.prototype.fetchWorkerNames = function() {
    var deferred = $.Deferred();
    if (this.workerAreLoaded()) {
      deferred.resolve();
    } else {
      $.when(
        Ajax.getDroppedWorker(1),
        Ajax.getDroppedWorker(2)
      ).done((function(response0, response1) {
        var workerName0 = response0[0];
        var workerName1 = response1[0];
        if (workerName0 !== "" && workerName1 !== "") {
          this.workerName0 = workerName0;
          this.workerName1 = workerName1;
        }
        deferred.resolve();
      }).bind(this));
    }
    return deferred.promise();
  };

   /** @private */
  TopDownScheduler.prototype.workerAreLoaded = function() {
    return this.workerName0 !== null && this.workerName1 !== null;
  };

  return TopDownScheduler;
});