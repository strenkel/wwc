<?php

  /**
   * Move a player from the top30 to droppedworker.
   *
   * @param id {Number}
   */

  require_once('sql.php');
  connectToDatabase();

  $player = intval($_POST['id']);
  $password = $_POST['password'];

  if (isSuperuser($password) && isInChart($player)) {
    removePlayerFromChart($player);
  };

?>