define([
  "util/Ajax"
], function (Ajax) {

  "use strict";

  var Challenger = function(tableBody) {
    this.tableBody = tableBody;
    this.fillChallenger();
  };

  /** @private */
  Challenger.prototype.fillChallenger = function() {
    var _this = this;
    Ajax.getChallenger().done(function(table) {
      table.forEach(function(rowData) {
        _this.addRow(rowData);
      });
    });
  };

  /** @private */
  Challenger.prototype.addRow = function(data) {
    var tr = document.createElement("tr");
    tr.appendChild(this.createTd(data.name));
    tr.appendChild(this.createTd(data.author));
    this.tableBody.appendChild(tr);
    this.position++;
  };

  /** @private */
  Challenger.prototype.createTd = function(content) {
    var td = document.createElement("td");
    td.innerHTML = content;
    return td;
  };

  return Challenger;
});