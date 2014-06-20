<?php

  /**
   * Returns an array of dropped worker, e.g. [{name: 'name', author: 'author', date: '31.05.2014'}]].
   * Ordered by name.
   *
   * @return {[Object]}
   */

  header("Content-type: application/json");
  require_once('sql.php');
  connectToDatabase();
  $table = getDroppedWorkerTable();
  echo json_encode($table);
?>