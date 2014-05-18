<?php

  /**
   * Returns next Worker-Pair that haven't enough games.
   */

  header("Content-type: application/json");
  require_once('sql.php');
  connectToDatabase();

  $password = $_POST['password'];
  if (isSuperuser($password)) {
    echo json_encode(nextWorkerPair());
  }

  // --- private helper ---

  function nextWorkerPair() {
    $workerIds = null;
    $activeChallenger = getActiveChallenger();
    if ($activeChallenger) {
      $workerIds = nextActiveChallenge($activeChallenger);
    } else {
      if (scoreHasEnoughGames()) {
        if (chartHasTooMuchPlayers()) {
          removeLastPlayerFromChart();
        }
        $workerIds = nextChallengeOrChartGame();
      } else {
        $workerIds = nextChartGame();
      }
    }
    return getWorkerNames($workerIds);
  }

  function nextActiveChallenge($activeChallenger) {
    if (playerHasEnoughGames($activeChallenger)) {
      clearActiveChallenger();
      if (challengerHasEnoughPoints($activeChallenger)) {
        fillUpMissingFixtures($activeChallenger);
        return nextChartGame();
      } else {
        removePlayerFromChart($activeChallenger);
        return nextChallengeOrChartGame();
      }
    } else {
      return nextChartGameFor($activeChallenger);
    }
  }

  function challengerHasEnoughPoints($activeChallenger) {
    if (getPoints($activeChallenger) == 0 && chartHasTooMuchPlayers()) {
      return false;
    } else {
      return true;
    }
  }

  function nextChallengeOrChartGame() {
    $challenger = nextChallenger();
    if ($challenger) {
      activateChallenger($challenger);
      return nextChartGameFor($challenger);
    } else {
      return nextChartGame();
    }
  }

  function activateChallenger($challenger) {
    deleteFromChallenger($challenger);
    insertIntoActiveChallenger($challenger);
    $bottomOfCharts = getBottomOfChart();
    insertIntoChart($challenger);
    if ($bottomOfCharts) {
      insertIntoScore($challenger, $bottomOfCharts);
      insertIntoScore($bottomOfCharts, $challenger);
    }
  }

  function getWorkerNames($ids) {
    $workerPair = array();
    if (isset($ids[0]) && isset($ids[1])) {
      $workerPair[0] = getWorkerName($ids[0]);
      $workerPair[1] = getWorkerName($ids[1]);
    }
    return $workerPair;
  }

?>