<?php

  /**
   * @param worker {String} like 'example.js'
   * @param password {String} optional
   */

  header('Content-Type: application/javascript');
  require_once('sql.php');
  connectToDatabase();

  $workerDir = "../../";
  if (isset($_POST["password"])) {
    if (isSuperuser($_POST["password"])) {
      $workerDir = $workerDir."worker/";
    } else {
      die('Invalid password!');
    }
  } else {
    $workerDir = $workerDir."droppedworker/";
  }

  $worker = pathinfo($_POST["worker"], PATHINFO_BASENAME); // prevent hacks
  readfile($workerDir.$worker);
?>
