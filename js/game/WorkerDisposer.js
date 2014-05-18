/* global Worker */
define(function () {

  "use strict";

  /**
   * Pass a workername (a js file on the server) or a local file.
   *
   * @param file0 {String | File}
   * @param file1 {String | File}
   */
  var WorkerDisposer = function(file0, file1) {
    this.file0 = file0;
    this.file1 = file1;
  };

  /**
   * @returns {[String]}
   */
  WorkerDisposer.prototype.getNames = function() {
    return [getName(this.file0), getName(this.file1)];
  };

  /**
   * @returns {[Worker]}
   */
  WorkerDisposer.prototype.createWorkers = function() {
    return [createWorker(this.file0), createWorker(this.file1)];
  };

  var createWorker = function(file) {
    if (isLocalFile(file)) {
      var objectURL = window.URL.createObjectURL(file);
      var worker = new Worker(objectURL);
      window.URL.revokeObjectURL(objectURL);
      return worker;
    } else {
      return new Worker("worker/" + file);
    }
  };

  var getName = function(file) {
    if (isLocalFile(file)) {
      return file.name;
    } else {
      return file;
    }
  };

  var isLocalFile = function(file) {
    return typeof file !== 'string';
  };

  return WorkerDisposer;
});