<?php
  //
  // Return all worker names ordered by position as an array
  //

  header("Content-type: application/json");
  require_once('sql.php');
  connectToDatabase();
  $names = selectLastDroppedWorkers();
  echo json_encode($names);
?>
