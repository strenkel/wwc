<?php

  /**
   * @param password {String}
   * @return {Boolean}
   */

  header("Content-type: application/json");

  require_once('sql.php');
  connectToDatabase();
  echo json_encode(isSuperuser($_POST['password']));
?>