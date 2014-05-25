<?php
  //
  // Return the name of worker at the passed position.
  //
  // @param position {1, 2, ...}
  // @return {String}
  //

  require_once('sql.php');
  connectToDatabase();
  $position = intval($_POST['position']);
  echo selectLastDroppedWorker($position);
?>