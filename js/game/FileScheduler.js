define([
  "jquery",
  "game/WorkerDisposer"
],function ($, WorkerDisposer) {

  "use strict";

  /**
   * @param file0 {String | File}
   * @param file1 {String | File}
   */
  var FileScheduler = function(file0, file1) {
    this.file0 = file0;
    this.file1 = file1;
    this.returnMatch = false;
  };

  /**
   * Promise pass a WorkerDisposer.
   * @returns {$.Promise}
   */
  FileScheduler.prototype.getWorkerNames = function() {
    var deferred = $.Deferred();
    if (this.returnMatch) {
      this.returnMatch = false;
      deferred.resolve(new WorkerDisposer(this.file1, this.file0));
    } else {
      this.returnMatch = true;
      deferred.resolve(new WorkerDisposer(this.file0, this.file1));
    }
    return deferred;
  };

  return FileScheduler;
});