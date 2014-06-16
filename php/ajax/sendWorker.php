<?php

  /**
   * @param worker {String} like 'example.js'
   * @param password {String} optional
   */

  header('Content-Type: application/javascript');
  require_once('sql.php');
  connectToDatabase();

  $workerDir = "../../";
  if (isset($_GET["password"])) {
    if (isSuperuser($_GET["password"])) {
      $workerDir = $workerDir."worker/";
    } else {
      die('Invalid password!');
    }
  } else {
    $workerDir = $workerDir."droppedworker/";
  }

  $worker = pathinfo($_GET["worker"], PATHINFO_BASENAME); // prevent hacks
  readfile($workerDir.$worker);
?>
