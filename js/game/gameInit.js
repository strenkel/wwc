require([
  "jquery",
  "game/GameController",
  "game/Game",
  "game/Plotter",
  "game/Field",
  "game/DrawingArea",
  "game/Score",
  "game/Gear",
  "game/Scheduler",
  "game/ScheduleSelect",
  "game/SuperUser"
], function($, GameController, Game, Plotter, Field, DrawingArea, Score, Gear,
            Scheduler, ScheduleSelect, SuperUser) {

  "use strict";

  $(document).ready(function() {

    // Create and connect objects.

    var
      width = 100,
      height = 100,
      maxMoveLength = width * height;

    var scheduleSelect = new ScheduleSelect({
      select0: document.getElementById("wwc-select-player0"),
      select1: document.getElementById("wwc-select-player1"),
      file0: document.getElementById("wwc-file0"),
      file1: document.getElementById("wwc-file1"),
      fileRoot0: document.getElementById("uploadContainer0"),
      fileRoot1: document.getElementById("uploadContainer1")
    });

    var superUser = new SuperUser({
       loginRoot: document.getElementById("wwc-login-root"),
       controlRoot: document.getElementById("wwc-control-root"),
       passwordElm: document.getElementById("wwc-password"),
       enterElm: document.getElementById("wwc-enter"),
       messageElm: document.getElementById("wwc-login-message"),
       uploadResultElm: document.getElementById("wwc-upload-result"),
       removePlayerInput: document.getElementById("wwc-remove-player-id"),
       removePlayerButton: document.getElementById("wwc-remove-player"),
       scheduleSelect: scheduleSelect
    });

    var score = new Score({
      playerElements: [
        document.getElementById("wwc-name-player0"),
        document.getElementById("wwc-name-player1")
      ],
      scoreElements: [
        document.getElementById("wwc-score-player0"),
        document.getElementById("wwc-score-player1")
      ],
      pointElements: [
        document.getElementById("wwc-points-player0"),
        document.getElementById("wwc-points-player1")
      ],
      superUser: superUser
    });

    var drawingArea = new DrawingArea({
      canvas: document.getElementById("wwc-canvas"),
      unit: 5,
      width: width,
      height: height
    });

    var plotter = new Plotter({
      drawingArea : drawingArea,
      score: score,
      superUser: superUser
    });

    var field = new Field({
      width: width,
      height: height,
      maxMoveLength: maxMoveLength
    });

    var game = new Game(field);
    var scheduler = new Scheduler(scheduleSelect);
    var gameController = new GameController({
      game: game,
      plotter: plotter,
      scheduler: scheduler,
      superUser: superUser
    });

    var gear = new Gear({
      playElement: document.getElementById("wwc-play"),
      stopElement: document.getElementById("wwc-stop"),
      stepElement: document.getElementById("wwc-step"),
      nextElement: document.getElementById("wwc-reset"),
      refreshElement: document.getElementById("wwc-refresh")
    });

    gear.addOnPlayListener(gameController.play.bind(gameController));
    gear.addOnStopListener(gameController.pause.bind(gameController));
    gear.addOnStepListener(gameController.stepForward.bind(gameController));
    gear.addOnNextListener(gameController.next.bind(gameController));
    gear.addOnRefreshListener(gameController.refresh.bind(gameController));

    gameController.initNewGame();
  });
});