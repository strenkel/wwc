define([
  "game/ScheduleSelectOptions",
  "game/TopDownScheduler",
  "game/FileScheduler",
  "game/NewFirstScheduler"
], function (ScheduleSelectOptions, TopDownScheduler, FileScheduler, NewFirstScheduler) {

  "use strict";

  var ScheduleSelection = function(selection0, selection1) {

    this._isValid = true;
    if (arguments.length === 1) {
      this.scheme = selection0;
    } else {
      if (selection0 && selection1) {
        this.file0 = selection0;
        this.file1 = selection1;
      } else {
        this._isValid = false;
      }
    }
  };

  /**
   * @returns {Scheduler}
   */
  ScheduleSelection.prototype.getScheduler = function() {
    if (this.scheme) {
      if (this.scheme === ScheduleSelectOptions.TOP_DOWN) {
        return new TopDownScheduler();
      } else {
        return new NewFirstScheduler();
      }
    } else {
      return new FileScheduler(this.file0, this.file1);
    }
    return null;
  };

  /**
   * @param {ScheduleSelection}
   * @returns {Boolean}
   */
  ScheduleSelection.prototype.equals = function(that) {
    if (that == null) {
      return false;
    }
    return this.hash() === that.hash();
  };

  /**
   * @returns {String}
   */
  ScheduleSelection.prototype.hash = function() {
    if (this.scheme) {
      return this.scheme;
    } else {
      var hash;
      if (typeof this.file0 === 'string') {
        hash = this.file0;
      } else {
        hash = "local:" + this.file0.name;
      }
      if (typeof this.file1 === 'string') {
        hash = hash + ":" + this.file1;
      } else {
        hash = hash + ":local:" + this.file1.name;
      }
      return hash;
    }
  };

  /**
   * @returns {Boolean}
   */
  ScheduleSelection.prototype.isValid = function() {
    return this._isValid;
  };

  return ScheduleSelection;
});