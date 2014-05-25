<?php

  /**
   * Returns an array of dropped worker names, e.g. ['w1.js', 'w2.js'].
   * Returns the last n (default=30) dropped workers.
   * Ordered by dropping time:
   * The last dropped worker is the first one, the last but one is the sencond one and so on.
   *
   * @return {[String]}
   */

  header("Content-type: application/json");
  require_once('sql.php');
  connectToDatabase();
  $names = selectDroppedWorkers();
  echo json_encode($names);
?>
