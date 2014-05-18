define([
  "jquery",
  "game/WorkerDisposer",
  "util/Ajax"
], function ($, WorkerDisposer, Ajax) {

  "use strict";

  var NewFirstScheduler = function() {
  };

  /**
   * Promise pass a WorkerDisposer.
   * @returns {$.Promise}
   */
  NewFirstScheduler.prototype.getWorkerNames = function() {
    var deferred = $.Deferred();
    Ajax.getNextWorkerPair().done(function(workerPair) {
      var workerName0 = workerPair[0];
      var workerName1 = workerPair[1];
      if (workerName0 && workerName1) {
        deferred.resolve(new WorkerDisposer(workerName0, workerName1));
      } else {
        deferred.resolve(null);
      }
    }).fail(function() {
      deferred.resolve(null);
    });
    return deferred.promise();
  };

  return NewFirstScheduler;
});