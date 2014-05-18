define([
  "util/Dom",
  "util/Ajax",
  "game/ScheduleSelection",
  "game/ScheduleSelectOptions"
], function (Dom, Ajax, ScheduleSelection, ScheduleSelectOptions) {

  "use strict";

  /**
   * @param select0, select1 {HTMLSelect}
   * @param file0, file1 {HTMLFileInput}
   */
  var ScheduleSelect = function(c) {

    // -- members --

    this.select0 = c.select0;
    this.select1 = c.select1;
    this.file0 = c.file0;
    this.file1 = c.file1;

    this.select0LocalFileIndex = 1;
    this.select1LocalFileIndex = 0;


    // --constructor code --

    this.fillSelects();
    this.fixControlState();
    this.manageControlState();
  };

  /**
   * @returns {ScheduleSelection}
   */
  ScheduleSelect.prototype.getSelection = function() {
    if (this.schemeIsSelected()) {
      return new ScheduleSelection(this.getSelection0());
    } else {
      return new ScheduleSelection(this.getSelection0(), this.getSelection1());
    }
  };

  /** @public */
  ScheduleSelect.prototype.addNewFirstScheme = function() {
    this.select0.insertBefore(new Option(ScheduleSelectOptions.NEW_FIRST), this.select0.firstChild);
    this.select0LocalFileIndex++;
  };

  /** @private */
  ScheduleSelect.prototype.getSelection0 = function() {
    if (this.localFileIsSelectedBySelect0()) {
      return this.file0.files[0]; // can be undefined!
    } else {
      return Dom.getSelectedOption(this.select0).label;
    }
  };

  /** @private */
  ScheduleSelect.prototype.getSelection1 = function() {
    if (this.localFileIsSelectedBySelect1()) {
      return this.file1.files[0]; // can be undefined!
    } else {
      return Dom.getSelectedOption(this.select1).label;
    }
  };

  /** @private */
  ScheduleSelect.prototype.fillSelects = function() {

    this.select0.add(new Option(ScheduleSelectOptions.TOP_DOWN));
    this.select0.add(new Option(ScheduleSelectOptions.LOCAL_FILE));
    this.select1.add(new Option(ScheduleSelectOptions.LOCAL_FILE));

    var _this = this;
    Ajax.getWorkerNamesOrderedByPosition().done(function(workerNames) {
      workerNames.forEach(function(name) {
        _this.select0.add(new Option(name));
        _this.select1.add(new Option(name));
      });
    });
  };

  /** @private */
  ScheduleSelect.prototype.manageControlState = function() {
    this.select0.addEventListener("change", this.fixControlState.bind(this));
    this.select1.addEventListener("change", this.fixControlState.bind(this));
  };

  /** @private */
  ScheduleSelect.prototype.fixControlState = function() {
    if (this.schemeIsSelected() ) {
      hideAndDisable(this.select1);
      hideAndDisable(this.file0);
      hideAndDisable(this.file1);
    } else {
      showAndEnable(this.select1);
      if (this.localFileIsSelectedBySelect0()) {
        showAndEnable(this.file0);
      } else {
        hideAndDisable(this.file0);
      }
      if (this.localFileIsSelectedBySelect1()) {
        showAndEnable(this.file1);
      } else {
        hideAndDisable(this.file1);
      }
    }
  };

  /** @private */
  ScheduleSelect.prototype.schemeIsSelected = function() {
    return this.select0.selectedIndex < this.select0LocalFileIndex;
  };

  /** @private */
  ScheduleSelect.prototype.localFileIsSelectedBySelect0 = function() {
    return this.select0.selectedIndex === this.select0LocalFileIndex;
  };

  /** @private */
  ScheduleSelect.prototype.localFileIsSelectedBySelect1 = function() {
    return this.select1.selectedIndex === this.select1LocalFileIndex;
  };

  var enable = function(elm) {
    elm.disabled = false;
  };

  var disable = function(elm) {
    elm.disabled = true;
  };

  var hideAndDisable = function(elm) {
    disable(elm);
    elm.style.visibility = "hidden";
  };

  var showAndEnable = function(elm) {
    enable(elm);
    elm.style.visibility = "visible";
  };


  return ScheduleSelect;
});