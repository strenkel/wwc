<?php

  /**
   * @param playerNames {[String]}
   * @param score {[Number]}
   * @param password {String}
   */

  require_once('sql.php');
  connectToDatabase();

  $workerNames = $_POST['workerNames'];
  $score[0] = intval($_POST['score'][0]);
  $score[1] = intval($_POST['score'][1]);
  $password = $_POST['password'];

  if (isSuperuser($password)) {
    saveResult($workerNames, $score);
  };

?>