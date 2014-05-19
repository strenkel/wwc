<?php

  // Constants
  $MAX_CHART_SIZE = 20; // default 20
  $MIN_GAME_SIZE_PER_FIXTURE = 10; // default 10
  $W2C_START_DATE = new DateTime('2014-05-31');

  function connectToDatabase() {

    // read mysql user, password, db and server from ini file
    $configPath = "../../../../config/";
    $config = parse_ini_file($configPath."w2c.ini");
    $mysqlUser = $config["mysqlUser"];
    $mysqlPassword = $config["mysqlPassword"];
    $mysqlDb = $config["mysqlDb"];
    $mysqlServer = $config["mysqlServer"];

    mysql_connect($mysqlServer, $mysqlUser, $mysqlPassword) or die(mysql_error());
    mysql_select_db($mysqlDb) or die(mysql_error());
  }

  /**
   * Returns empty String when no worker exist for inquired position.
   *
   * @param $position {1, 2, 3, ...}
   * @return {String}
   */
  function selectWorkerByPosition($position) {
    $names = selectWorkersOrderByPosition();
    if (sizeof($names) >= $position) {
      return $names[$position - 1];
    } else {
      return '';
    }
  }

  /**
   * @param $name {String}
   * @return {Boolean}
   */
  function isNewWorker($name) {
    $data = mysql_query("SELECT name FROM worker WHERE name='$name'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if ($row) {
      return false;
    }
    return true;
  }

  /**
   * @return {[String]}
   */
  function selectWorkersOrderByPosition() {
    $data = mysql_query("SELECT name FROM worker w, chart c WHERE w.id = c.player ORDER BY c.points DESC")
      or die(mysql_error());
    $names = array();
    while($row = mysql_fetch_array($data)) {
      $names[] = $row['name'];
    }
    return $names;
  }

  /**
   * @param $name {String}
   * @return {Integer}
   */
  function getWorkerId($name) {
    $data = mysql_query("SELECT id FROM worker WHERE name='$name'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    return intval($row["id"]);
  }

  /**
   * @param $name {Integer}
   * @return {String}
   */
  function getWorkerName($id) {
    $data = mysql_query("SELECT name FROM worker WHERE id=$id") or die(mysql_error());
    $row = mysql_fetch_array($data);
    return $row["name"];
  }

  /**
   * @param $name {String}
   * @param $author {String}
   * @param $email {String}
   * @param $comment {String}
   */
  function insertNewWorker($name, $author, $email) {
    $sql = "INSERT INTO worker (name, author, email) VALUES ('$name', '$author', '$email')";
    mysql_query($sql) or die(mysql_error());
    $id = getWorkerId($name);
    mysql_query("INSERT INTO challenger VALUES ($id)") or die(mysql_error());
  }

  function isSuperuser($password) {
    $data = mysql_query("SELECT login FROM superuser WHERE login='superuser' AND password='$password'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if ($row) {
      return true;
    }
    return false;
  }

  function saveResult($workerNames, $score) {

    // workerIds
    $id[0] = getWorkerId($workerNames[0]);
    $id[1] = getWorkerId($workerNames[1]);

    // insert into Game
    $sql = "INSERT INTO game (player1, player2, points1, points2) ".
      "VALUES ($id[0], $id[1], $score[0], $score[1])";
    mysql_query($sql) or die(mysql_error());

    // determine points
    $points[0] = 0;
    $points[1] = 0;
    if ($score[0] > $score[1]) {
      $points[0] = 1;
    } else if ($score[1] > $score[0]) {
      $points[1] = 1;
    } else {
      return true; // tie
    }

    // insert into or update Score
    if (hasScore($id)) {
      $sql = "UPDATE score SET points1 = points1 + $points[0], ".
        "points2 = points2 + $points[1] WHERE player1 = $id[0] AND player2 = $id[1]";
    } else {
      $sql = "INSERT INTO score (player1, player2, points1, points2) VALUES".
        "($id[0], $id[1], $points[0], $points[1])";
    }
    mysql_query($sql) or die(mysql_error());

    // update chart
    $chart[0] = 0;
    $chart[1] = 0;
    $totalScore = getTotalScoreByIds($id);
    if ($totalScore[0] == $totalScore[1]) {
      $chart[0] = -$points[1];
      $chart[1] = -$points[0];
    } else if ($totalScore[0] - $points[0] == $totalScore[1] - $points[1]) {
      $chart[0] = $points[0];
      $chart[1] = $points[1];
    }

    updateChart($id[0], $chart[0], $points[0], $points[1]);
    updateChart($id[1], $chart[1], $points[1], $points[0]);

    for ($i = 0; $i < 2; $i++) {
      if ($chart[$i] != 0) {
        updateChart($id[$i], $chart[$i]);
      }
    }
  }

  function updateChart($id, $points, $wins, $defeats) {
    $sql = "UPDATE chart SET points = points + $points, wins = wins + $wins, defeats = defeats + $defeats WHERE player = $id";
    mysql_query($sql) or die(mysql_error());
  }

  function hasScore($ids) {
    $sql = "SELECT player1 FROM score WHERE player1 = $ids[0] AND player2 = $ids[1]";
    return queryHasResult($sql);
  }

  /**
   * @param $ids {[Integer]}
   * @return {[Integer]}
   */
  function getTotalScoreByIds($ids) {
    return getTotalScore($ids[0], $ids[1]);
  }

  /**
   * @param $id0 {Integer}
   * @param $id1 {Integer}
   * @return {[Integer]}
   */
  function getTotalScore($id0, $id1) {
    $score0 = getScore($id0, $id1);
    $score1 = getScore($id1, $id0);
    $totalScore[0] = $score0[0] + $score1[1];
    $totalScore[1] = $score0[1] + $score1[0];
    return $totalScore;
  }

  /**
   * @param $id0 {Integer}
   * @param $id1 {Integer}
   * @return {[Integer]}
   */
  function getScore($id0, $id1) {
    $score[0] = 0;
    $score[1] = 0;
    $sql = "SELECT points1, points2 FROM score WHERE player1 = $id0 AND player2 = $id1";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    if ($row) {
      $score[0] = intval($row["points1"]);
      $score[1] = intval($row["points2"]);
    }
    return $score;
  }

  function getTable() {
    $sql = "SELECT w.name, c.points, c.wins, c.defeats FROM worker w, chart c WHERE w.Id = c.player ORDER BY c.points DESC";
    $data = mysql_query($sql) or die(mysql_error());
    $table = array();
    while($rowData = mysql_fetch_array($data)) {
      $row = new stdClass;
      $row->name = $rowData['name'];
      $row->points = intval($rowData['points']);
      $row->wins = intval($rowData['wins']);
      $row->defeats = intval($rowData['defeats']);
      $table[] = $row;
    }
    return $table;
  }

  /**
   * @return {Integer | null}
   */
  function getActiveChallenger() {
    $sql = "SELECT player FROM activechallenger";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    if ($row) {
      return intval($row["player"]);
    } else {
      return null;
    }
  }

  function chartHasData() {
    $sql = "SELECT player FROM chart";
    return queryHasResult($sql);
  }

  function getTableSize($table) {
    $sql = "SELECT COUNT(*) as size FROM $table";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    return intval($row["size"]);
  }

  function scoreHasEnoughGames() {
    global $MIN_GAME_SIZE_PER_FIXTURE;
    $sql = "SELECT player1 FROM score WHERE points1 + points2 < $MIN_GAME_SIZE_PER_FIXTURE";
    return !queryHasResult($sql);
  }

  function playerHasEnoughGames($player) {
    global $MIN_GAME_SIZE_PER_FIXTURE;
    $sql = "SELECT player1 FROM score WHERE points1 + points2 < $MIN_GAME_SIZE_PER_FIXTURE ".
      "AND (player1 = $player OR player2 = $player)";
    return !queryHasResult($sql);
  }

  /**
   * @return {[Integer]}
   */
  function nextChartGame() {
    $sql = "SELECT player1, player2 FROM score ORDER BY (points1 + points2) ASC";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    $players = array();
    if ($row) {
      $players[0] = intval($row["player1"]);
      $players[1] = intval($row["player2"]);
    }
    return $players;
  }

  function nextChartGameFor($player) {
    $sql = "SELECT player1, player2 FROM score WHERE (player1 = $player OR player2 = $player) ".
      "ORDER BY (points1 + points2) ASC";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    $players = array();
    if ($row) {
      $players[0] = intval($row["player1"]);
      $players[1] = intval($row["player2"]);
    }
    return $players;
  }

  function chartHasTooMuchPlayers() {
    global $MAX_CHART_SIZE;
    return getTableSize("chart") > $MAX_CHART_SIZE;
  };

  function removeLastPlayerFromChart() {
    $bottomOfChart = getBottomOfChart();
    removePlayerFromChart($bottomOfChart);
  };

  function removePlayerFromChart($player) {
    removeFromChart($player);
    removeChartPoints($player);
    removeFromScore($player);
  }

  /**
   * @return {Integer | null}
   */
  function getBottomOfChart() {
    $sql = "SELECT player FROM chart WHERE points = (SELECT MIN(points) FROM chart)";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    if ($row) {
      return intval($row["player"]);
    } else {
      return null;
    }
  }

  /**
   * @param {Integer}
   */
  function removeFromChart($player) {
    $sql = "DELETE FROM chart WHERE player = $player";
    mysql_query($sql) or die(mysql_error());
  }

  /**
   * @param {Integer}
   */
  function removeFromScore($player) {
    $sql = "DELETE FROM score WHERE player1 = $player OR player2 = $player";
    mysql_query($sql) or die(mysql_error());
  }

  /**
   * Remove relegated player from chart before removing his chart points!
   * Viz.: Call removeFromChart before removeChartPoints!
   *
   * @param {Integer}
   */
  function removeChartPoints($relegatedPlayer) {
    $sql = "SELECT player FROM chart";
    $data = mysql_query($sql) or die(mysql_error());
    while($row = mysql_fetch_array($data)) {
      $player = $row["player"];
      $score = getTotalScore($player, $relegatedPlayer);
      $points = 0;
      if ($score[0] > $score[1]) {
        $points = -1;
      }
      updateChart($player, $points, -$score[0], -$score[1]);
    }
  }

  function isWinner($player0, $player1) {
    $score = getTotalScore($player0, $player1);
    return $score[0] > $score[1];
  }

  /**
   * @return {Integer | null}
   */
  function nextChallenger() {
    $nextWinnerDate = getNextWinnerDate();
    $nextWinnerDateString = $nextWinnerDate->format('Y-m-d');
    $sql = "SELECT player FROM challenger c JOIN worker w ON c.player = w.id ".
      "WHERE DATE(w.ts) <= '$nextWinnerDateString' ORDER BY w.ts ASC";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    if ($row) {
      return intval($row["player"]);
    } else {
      return null;
    }
  }

  /**
   * return {Date}
   */
  function getNextWinnerDate() {
    global $W2C_START_DATE;
    $lastWinnerDate = getLastWinnerDate();
    if ($lastWinnerDate) {
      $lastWinnerDate->modify('+1 day');
      return $lastWinnerDate;
    } else {
      return $W2C_START_DATE;
    }
  };

  /**
   * return {Date | null}
   */
  function getLastWinnerDate() {
    $sql = "SELECT MAX(daystamp) as lastdate FROM winner";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    $lastDate = null;
    if ($row["lastdate"]) {
      $lastDate = new DateTime($row["lastdate"]);
    }
    return $lastDate;
  }

  /**
   * @param $challenger {Integer}
   */
  function deleteFromChallenger($challenger) {
    $sql = "DELETE FROM challenger WHERE player = $challenger";
    mysql_query($sql) or die(mysql_error());
  }

  function clearActiveChallenger() {
    $sql = "DELETE FROM activechallenger";
    mysql_query($sql) or die(mysql_error());
  }

  function insertIntoChart($player) {
    $sql = "INSERT INTO chart VALUES ($player, 0, 0, 0)";
    mysql_query($sql) or die(mysql_error());
  }

  function insertIntoActiveChallenger($challenger) {
    $sql = "INSERT INTO activechallenger VALUES ($challenger)";
    mysql_query($sql) or die(mysql_error());
  }

  function getPoints($player) {
    $sql = "SELECT points FROM chart WHERE player = $player";
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    return intval($row["points"]);
  }

  function fillUpMissingFixtures($player) {
    $sql = "SELECT player FROM chart WHERE player != $player";
    $data = mysql_query($sql) or die(mysql_error());
    while($row = mysql_fetch_array($data)) {
      $rival = $row["player"];
      if (!hasFixture($player, $rival)) {
        insertIntoScore($player, $rival);
      }
      if (!hasFixture($rival, $player)) {
        insertIntoScore($rival, $player);
      }
    }
  }

  function insertIntoScore($player1, $player2) {
    $sql = "INSERT INTO score VALUES ($player1, $player2, 0, 0)";
    mysql_query($sql) or die(mysql_error());
  }

  function hasFixture($player1, $player2) {
    $sql = "SELECT player1 FROM score WHERE player1 = $player1 AND player2 = $player2";
    return queryHasResult($sql);
  }

  function getChallenger() {
    $sql = "SELECT w.name, w.author FROM worker w JOIN challenger c ON w.Id = c.player ORDER BY w.ts ASC LIMIT 100";
    $data = mysql_query($sql) or die(mysql_error());
    $table = array();
    while($rowData = mysql_fetch_array($data)) {
      $row = new stdClass;
      $row->name = $rowData['name'];
      $row->author = $rowData['author'];
      $table[] = $row;
    }
    return $table;
  }

  // --- private ---

  function queryHasResult($sql) {
    $data = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($data);
    if ($row) {
      return true;
    }
    return false;
  }

  function logToFile($message, $myVar) {
      error_log($message." = ".json_encode($myVar)."\n", 3, 'log.txt');
  }

?>
