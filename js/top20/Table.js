define([
  "util/Ajax"
], function (Ajax) {

  "use strict";

  var Table = function(tableBody) {
    this.tableBody = tableBody;
    this.position = 1;
    this.fillTable();
  };

  /** @private */
  Table.prototype.fillTable = function() {
    var _this = this;
    Ajax.getTable().done(function(table) {
      this.position = 1;
      table.forEach(function(rowData) {
        _this.addRow(rowData);
      });
    });
  };

  /** @private */
  Table.prototype.addRow = function(data) {
    var tr = document.createElement("tr");
    tr.appendChild(this.createTd(this.position + "."));
    tr.appendChild(this.createTd(data.name));
    tr.appendChild(this.createTd(data.points));
    tr.appendChild(this.createTd(data.wins));
    tr.appendChild(this.createTd(data.defeats));
    this.tableBody.appendChild(tr);
    this.position++;
  };

  /** @private */
  Table.prototype.createTd = function(content) {
    var td = document.createElement("td");
    td.innerHTML = content;
    return td;
  };

  return Table;
});