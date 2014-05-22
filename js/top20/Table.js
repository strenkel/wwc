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
    tr.appendChild(this.createTd(this.position + ".", true));
    var nameElm = this.createTd(data.name);
    nameElm.title = "Author: " + data.author;
    tr.appendChild(nameElm);
    tr.appendChild(this.createTd(data.points, true));
    tr.appendChild(this.createTd(data.wins + " : " + data.defeats, true));
    this.tableBody.appendChild(tr);
    this.position++;
  };

  /** @private */
  Table.prototype.createTd = function(content, alignRight) {
    var td = document.createElement("td");
    td.innerHTML = content;
    if (alignRight) {
      td.className = "text-align-right";
    }
    return td;
  };

  return Table;
});