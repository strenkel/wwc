<?php

  // Constants
  $MAX_CHART_SIZE = 20; // default 20
  $MIN_GAME_SIZE_PER_FIXTURE = 10; // default 10
  $W2C_START_DATE = new DateTime('2014-05-28'); // default 2014-05-28
  $WORKER_DIR = '../../worker/';
  $DROPPED_WORKER_DIR = '../../droppedworker/';
  $db;

  function connectToDatabase() {

    global $db;

    // read mysql user, password, db and server from ini files
    $configPathPassword = "../../../../config/";
    $configPassword = parse_ini_file($configPathPassword."wwc-password.ini");
    $configPath = "../../config/";
    $configWwc = parse_ini_file($configPath."wwc.ini");

    $mysqlUser = $configWwc["mysqlUser"];
    $mysqlDb = $configWwc["mysqlDb"];
    $mysqlServer = $configWwc["mysqlServer"];
    $mysqlPassword = $configPassword["mysqlPassword_".$mysqlDb];

    $db = new mysqli($mysqlServer, $mysqlUser, $mysqlPassword, $mysqlDb);
    if (mysqli_connect_error()) {
      die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
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
    $sql = "SELECT name FROM worker WHERE name=?";
    $stmt = prepare($sql);
    $stmt->bind_param("s", $name);
    return !statementHasResult($stmt);
  }

  /**
   * @return {[String]}
   */
  function selectWorkersOrderByPosition() {
    $sql = "SELECT name FROM worker w, chart c WHERE w.id = c.player ORDER BY c.points DESC, w.ts ASC";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($name);
    $names = array();
    while ($stmt->fetch()) {
      $names[] = $name;
    }
    $stmt->close();
    return $names;
  }

  /**
   * @param $name {String}
   * @return {Integer}
   */
  function getWorkerId($name) {
    $sql = "SELECT id FROM worker WHERE name=?";
    $stmt = prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    return intval($id);
  }

  /**
   * @param $id {Integer}
   * @return {String}
   */
  function getWorkerName($id) {
    $sql = "SELECT name FROM worker WHERE id=?";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
    return $name;
  }

  /**
   * @param $name {String}
   * @param $author {String}
   * @param $email {String}
   * @param $comment {String}
   */
  function insertNewWorker($name, $author, $email) {

    // Insert worker into table worker.
    $sql = "INSERT INTO worker (name, author, email) VALUES (?, ?, ?)";
    $stmt = prepare($sql);
    $stmt->bind_param("sss", $name, $author, $email);
    $stmt->execute();
    $stmt->close();

    // Register as challenger
    $id = getWorkerId($name);
    $sql = "INSERT INTO challenger VALUES (?)";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
  }

  function isSuperuser($password) {
    $sql = "SELECT login FROM superuser WHERE login='superuser' AND password=md5(?)";
    $stmt = prepare($sql);
    $stmt->bind_param("s", $password);
    return statementHasResult($stmt);
  }

  function saveResult($workerNames, $score) {

    // workerIds
    $id[0] = getWorkerId($workerNames[0]);
    $id[1] = getWorkerId($workerNames[1]);

    // insert into Game
    $sql = "INSERT INTO game (player1, player2, points1, points2) ".
      "VALUES (?, ?, ?, ?)";
    $stmt = prepare($sql);
    $stmt->bind_param("iiii", $id[0], $id[1], $score[0], $score[1]);
    $stmt->execute();
    $stmt->close();

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
    $stmt;
    if (hasScore($id)) {
      $sql = "UPDATE score SET points1 = points1 + ?, points2 = points2 + ? WHERE player1 = ? AND player2 = ?";
      $stmt = prepare($sql);
      $stmt->bind_param("iiii", $points[0], $points[1], $id[0], $id[1]);
    } else {
      $sql = "INSERT INTO score (player1, player2, points1, points2) VALUES (?, ?, ?, ?)";
      $stmt = prepare($sql);
      $stmt->bind_param("iiii", $id[0], $id[1], $points[0], $points[1]);
    }
    $stmt->execute();
    $stmt->close();

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
  }

  function updateChart($id, $points, $wins, $defeats) {
    $sql = "UPDATE chart SET points = points + ?, wins = wins + ?, defeats = defeats + ? WHERE player = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("iiii", $points, $wins, $defeats, $id);
    $stmt->execute();
    $stmt->close();
  }

  function hasScore($ids) {
    $sql = "SELECT player1 FROM score WHERE player1 = ? AND player2 = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("ii", $ids[0], $ids[1]);
    return statementHasResult($stmt);
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
    $sql = "SELECT points1, points2 FROM score WHERE player1 = ? AND player2 = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("ii", $id0, $id1);
    $stmt->execute();
    $stmt->bind_result($points1, $points2);
    if ($stmt->fetch()) {
      $score[0] = intval($points1);
      $score[1] = intval($points2);
    }
    $stmt->close();
    return $score;
  }

  function getTable() {
    $table = array();
    $sql = "SELECT w.name, w.author, c.points, c.wins, c.defeats FROM worker w, chart c WHERE w.Id = c.player ORDER BY c.points DESC, w.ts ASC";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($name, $author, $points, $wins, $defeats);
    while ($stmt->fetch()) {
      $row = new stdClass;
      $row->name = $name;
      $row->author = $author;
      $row->points = intval($points);
      $row->wins = intval($wins);
      $row->defeats = intval($defeats);
      $table[] = $row;
    }
    $stmt->close();
    return $table;
  }

  /**
   * @return {Integer | null}
   */
  function getActiveChallenger() {
    $sql = "SELECT player FROM activechallenger";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($player);
    $activeChallenger = null;
    if ($stmt->fetch()) {
      $activeChallenger = intval($player);
    }
    $stmt->close();
    return $activeChallenger;
  }

  function chartHasData() {
    $sql = "SELECT player FROM chart";
    return sqlHasResult($sql);
  }

  function getTableSize($table) {
    $sql = "SELECT COUNT(*) as size FROM $table";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($size);
    $stmt->fetch();
    $stmt->close();
    return intval($size);
  }

  function scoreHasEnoughGames() {
    global $MIN_GAME_SIZE_PER_FIXTURE;
    $sql = "SELECT player1 FROM score WHERE points1 + points2 < $MIN_GAME_SIZE_PER_FIXTURE";
    return !sqlHasResult($sql);
  }

  function playerHasEnoughGames($player) {
    global $MIN_GAME_SIZE_PER_FIXTURE;
    $sql = "SELECT player1 FROM score WHERE points1 + points2 < $MIN_GAME_SIZE_PER_FIXTURE ".
      "AND (player1 = ? OR player2 = ?)";
    $stmt = prepare($sql);
    $stmt->bind_param("ii", $player, $player);
    return !statementHasResult($stmt);
  }

  /**
   * @return {[Integer]}
   */
  function nextChartGame() {
    $sql = "SELECT player1, player2 FROM score ORDER BY (points1 + points2) ASC";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($player1, $player2);
    $players = array();
    if ($stmt->fetch()) {
      $players[0] = intval($player1);
      $players[1] = intval($player2);
    }
    $stmt->close();
    return $players;
  }

  function nextChartGameFor($player) {
    $sql = "SELECT player1, player2 FROM score WHERE (player1 = ? OR player2 = ?) ".
      "ORDER BY (points1 + points2) ASC";
    $stmt = prepare($sql);
    $stmt->bind_param("ii", $player, $player);
    $stmt->execute();
    $stmt->bind_result($player1, $player2);
    $players = array();
    if ($stmt->fetch()) {
      $players[0] = intval($player1);
      $players[1] = intval($player2);
    }
    $stmt->close();
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
    insertIntoDroppedWorker($player);
    moveFileIntoDroppedWorker($player);
  }

  function moveFileIntoDroppedWorker($player) {
    global $WORKER_DIR;
    global $DROPPED_WORKER_DIR;
    $playerName = getWorkerName($player);
    rename($WORKER_DIR.$playerName, $DROPPED_WORKER_DIR.$playerName);
  }

  function insertIntoDroppedWorker($player) {
    $sql = "INSERT INTO droppedworker VALUES (?)";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $player);
    $stmt->execute();
    $stmt->close();
  }

  /**
   * @return {Integer | null}
   */
  function getBottomOfChart() {
    // TODO: Upload-timestamp isn't consider in case of equlas min points.
    $sql = "SELECT player FROM chart WHERE points = (SELECT MIN(points) FROM chart)";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($player);
    $hasResult = $stmt->fetch();
    $stmt->close();
    if ($hasResult) {
      return intval($player);
    } else {
      return null;
    }
  }

  /**
   * @param {Integer}
   */
  function removeFromChart($player) {
    $sql = "DELETE FROM chart WHERE player = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $player);
    $stmt->execute();
    $stmt->close();
  }

  /**
   * @param {Integer}
   */
  function removeFromScore($player) {
    $sql = "DELETE FROM score WHERE player1 = ? OR player2 = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("ii", $player, $player);
    $stmt->execute();
    $stmt->close();
  }

  /**
   * Remove relegated player from chart before removing his chart points!
   * Viz.: Call removeFromChart before removeChartPoints!
   *
   * @param {Integer}
   */
  function removeChartPoints($relegatedPlayer) {
    $sql = "SELECT player FROM chart";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($player);
    while($stmt->fetch()) {
      $score = getTotalScore($player, $relegatedPlayer);
      $points = 0;
      if ($score[0] > $score[1]) {
        $points = -1;
      }
      updateChart($player, $points, -$score[0], -$score[1]);
    }
    $stmt->close();
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
      "WHERE DATE(w.ts) <= ? ORDER BY w.ts ASC";
    $stmt = prepare($sql);
    $stmt->bind_param("s", $nextWinnerDateString);
    $stmt->execute();
    $stmt->bind_result($player);
    $hasResult = $stmt->fetch();
    $stmt->close();
    if ($hasResult) {
      return intval($player);
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
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($lastDateString);
    $lastDate = null;
    if ($stmt->fetch()) {
      $lastDate = new DateTime($lastDateString);
    }
    $stmt->close();
    return $lastDate;
  }

  /**
   * @param $challenger {Integer}
   */
  function deleteFromChallenger($challenger) {
    $sql = "DELETE FROM challenger WHERE player = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $challenger);
    $stmt->execute();
    $stmt->close();
  }

  function clearActiveChallenger() {
    $sql = "DELETE FROM activechallenger";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->close();
  }

  function insertIntoChart($player) {
    $sql = "INSERT INTO chart VALUES (?, 0, 0, 0)";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $player);
    $stmt->execute();
    $stmt->close();
  }

  function insertIntoActiveChallenger($challenger) {
    $sql = "INSERT INTO activechallenger VALUES (?)";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $challenger);
    $stmt->execute();
    $stmt->close();
  }

  function getPoints($player) {
    $sql = "SELECT points FROM chart WHERE player = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $player);
    $stmt->execute();
    $stmt->bind_result($points);
    $stmt->fetch();
    $stmt->close();
    return intval($points);
  }

  function fillUpMissingFixtures($player) {
    $sql = "SELECT player FROM chart WHERE player != ?";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $player);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($rivalString);
    while($stmt->fetch()) {
      $rival = intval($rivalString);
      if (!hasFixture($player, $rival)) {
        insertIntoScore($player, $rival);
      }
      if (!hasFixture($rival, $player)) {
        insertIntoScore($rival, $player);
      }
    }
    $stmt->free_result();
    $stmt->close();
  }

  function insertIntoScore($player1, $player2) {
    $sql = "INSERT INTO score VALUES (?, ?, 0, 0)";
    $stmt = prepare($sql);
    $stmt->bind_param("ii", $player1, $player2);
    $stmt->execute();
    $stmt->close();
  }

  function hasFixture($player1, $player2) {
    $sql = "SELECT player1 FROM score WHERE player1 = ? AND player2 = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("ii", $player1, $player2);
    return statementHasResult($stmt);
  }

  function getChallenger() {
    $sql = "SELECT w.name, w.author FROM worker w JOIN challenger c ON w.Id = c.player ORDER BY w.ts ASC LIMIT 100";
    $stmt = prepare($sql);
    $stmt->execute();
    $stmt->bind_result($name, $author);
    $table = array();
    while($stmt->fetch()) {
      $row = new stdClass;
      $row->name = $name;
      $row->author = $author;
      $table[] = $row;
    }
    $stmt->close();
    return $table;
  }

  // --- private ---

  /**
   * @see statementHasResult()
   */
  function sqlHasResult($sql) {
    $stmt = prepare($sql);
    return statementHasResult($stmt);
  }

  /**
   * @return {true: has result | false: has no result}
   */
  function statementHasResult($stmt) {
    $stmt->execute();
    $hasResult = $stmt->fetch();
    $stmt->close();
    if ($hasResult === false) {
      die("Error in statementHasResult: Statement::fetch failed!");
    }
    if ($hasResult === null) {
      $hasResult = false;
    }
    return $hasResult;
  }

  function prepare($sql) {
    global $db;
    $stmt = $db->prepare($sql);
    if ($stmt) {
      return $stmt;
    } else {
      die("Error in prepare(): ".$db->error);
    }
  }

  function logToFile($message, $myVar) {
      error_log($message." = ".json_encode($myVar)."\n", 3, 'log.txt');
  }

?>
