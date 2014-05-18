define(function () {

  "use strict";

  /**
   * @param scheduleSelect {ScheduleSelect}
   */
  var Scheduler = function(scheduleSelect) {

    // pass parameter
    this.scheduleSelect = scheduleSelect;

    // further members
    this.scheduleSelection = this.scheduleSelect.getSelection(); // {ScheduleSelection}
    this.scheduler = this.scheduleSelection.getScheduler(); // {Scheduler}
  };

  /**
   * Promise pass a WorkerDisposer.
   * @returns {$.Promise}
   */
  Scheduler.prototype.getWorkerNames = function() {
    this.determineScheduler();
    return this.scheduler.getWorkerNames();
  };

  /** @private */
  Scheduler.prototype.determineScheduler = function() {
    var actualScheduleSelection = this.scheduleSelect.getSelection();
    if (actualScheduleSelection.isValid() && !actualScheduleSelection.equals(this.scheduleSelection)) {
      this.scheduleSelection = actualScheduleSelection;
      this.scheduler = this.scheduleSelection.getScheduler();
    }
  };

  return Scheduler;
});