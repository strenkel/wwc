define([
  "util/Ajax"
], function (Ajax) {

  "use strict";

  var Table = function(tableBody) {
    this.tableBody = tableBody;
    this.fillTable();
  };

  /** @private */
  Table.prototype.fillTable = function() {
    var _this = this;
    Ajax.getDroppedWorkerTable().done(function(table) {
      table.forEach(function(rowData) {
        _this.addRow(rowData);
      });
    });
  };

  /** @private */
  Table.prototype.addRow = function(data) {
    var tr = document.createElement("tr");
    tr.appendChild(this.createTd("<a href='droppedworker/" + data.name + "'>" + data.name + "</a>"));
    tr.appendChild(this.createTd(data.author));
    tr.appendChild(this.createTd(data.date));
    this.tableBody.appendChild(tr);
  };

  /** @private */
  Table.prototype.createTd = function(content) {
    var td = document.createElement("td");
    td.innerHTML = content;
    return td;
  };

  return Table;
});