/* global Blob */
define(["jquery"], function ($) {

  "use strict";

  // Function library for Ajax requests.

  var PHP_ROOT = "php/ajax/"; // don't forget the final slash
  var password = "";

  /**
   * @param {Integer > 0} position
   * @returns {$.Promise(String, ...)}
   */
  var getDroppedWorker = function(position) {
    return post("getDroppedWorker.php", {
      position: position
    });
  };

  /**
   * Returns an array of dropped worker names, e.g. ['w1.js', 'w2.js'].
   * Returns the last n (default=30) dropped workers.
   * Ordered by dropping time:
   * The last dropped worker is the first one, the last but one is the second one and so on.
   *
   * @returns {$.Promise([String], ...)}
   */
  var getDroppedWorkers = function() {
    return post("getDroppedWorkers.php");
  };

  var getDroppedWorkerTable = function() {
    return post("getDroppedWorkerTable.php");
  };

  /**
   * Returns success or error message.
   * @returns {$.Promise(String)}
   */
  var uploadFile = function(file, name, email) {
    var fd = new FormData();
    fd.append('worker', file);
    if (name) {
      fd.append('name', name);
    }
    if (email) {
      fd.append('email', email);
    }
    var xhr = new XMLHttpRequest();
    xhr.open("POST", PHP_ROOT + "saveWorker.php", true);
    var deferred = $.Deferred();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        if (xhr.status === 200) {
          deferred.resolve(xhr.responseText);
        } else {
          deferred.resolve("Error: upload failed!");
        }
      }
    };
    xhr.send(fd);
    return deferred;
  };

  /**
   * @param {String} password
   * @returns {$.Promise(Boolean, ...)}
   */
  var checkSuperuser = function(myPassword) {
    password = myPassword;
    return post("checkSuperuser.php", {
      password: myPassword
    });
  };

  /**
   * @param workerNames {[String]} like ['a.js', 'b.js]
   * @param score {[Number]} like [4321, 6789]
   * @param password {String}
   */
  var saveResult = function(workerNames, score) {
    return post("saveResult.php", {
      workerNames: workerNames,
      score: score,
      password: password
    });
  };

  /**
   * @returns {$.Promise([{name: "name", points: 103}])}
   */
  var getTable = function() {
    return post("getTable.php");
  };

  /**
   * @returns {$.Promise([{name: "name", author: "author"}])}
   */
  var getChallenger = function() {
    return post("getChallenger.php");
  };

  var getNextWorkerPair = function() {
    return post("getNextWorkerPair.php", {
      password: password
    });
  };

  /**
   * @param workerId {Number}
   */
  var removePlayer = function(workerId) {
    return post("removePlayer.php", {
      id: workerId,
      password: password
    });
  };

  /**
   * @param file {String} like 'example.js'
   * @param isDropped {Boolean}
   */
  var getWorkerFile = function(file, isDropped) {
    var http = new XMLHttpRequest();
    http.open("POST", PHP_ROOT + "sendWorker.php", false);
    http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var sendParam = "worker=" + file;
    if (!isDropped) {
      sendParam = sendParam + "&password=" + password;
    }
    http.send(sendParam);
    return new Blob([http.responseText], { type: 'text/javascript' });
  };

  /** @private */
  var post = function(fileName, parameters) {
    return $.post(PHP_ROOT + fileName, parameters);
  };

  return {
    getDroppedWorker: getDroppedWorker,
    getDroppedWorkers: getDroppedWorkers,
    uploadFile: uploadFile,
    checkSuperuser: checkSuperuser,
    saveResult: saveResult,
    getTable: getTable,
    getNextWorkerPair: getNextWorkerPair,
    getChallenger: getChallenger,
    removePlayer: removePlayer,
    getWorkerFile: getWorkerFile,
    getDroppedWorkerTable: getDroppedWorkerTable
  };

});