<?php
  header("Content-type: application/json");
  require_once('sql.php');
  connectToDatabase();
  echo json_encode(getTable());
?>