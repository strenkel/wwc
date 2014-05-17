<!DOCTYPE html>
<html>

<?php
	include 'php/head.php';
?>

<body>

<?php
	$headerGameIsActive="active";
	include 'php/header.php';
?>

<section id="page" class="gamePage">
	<section id="content">
		<div id="game">
			<h2>GAME</h2>
			<hr width="100">
			<div id="left40">
				<canvas id="wwc-canvas" width="500" height="500"></canvas>
			</div>
			<div id="right60">
				<div id="result">
					<div class="color-player0 new-line">
						<div class="playerLine">
							<div class="color_player_0"></div><div class="line name" id="wwc-name-player0">RandomWalk10Percent.js</div>
						</div>
						<div class="playerLine">
							<div class="line label">Punkte:</div><div class="line score" id="wwc-score-player0">0</div>
						</div>
						<div class="playerLine">
							<div class="line label">Gewonnen:</div><div class="line points" id="wwc-points-player0">0</div>
						</div>
						<div class="playerLine">
							<div class="line label author">Author:</div><div class="line author" id="wwc-author-player0">Moritz</div>
						</div>
					</div>
					<div class="color-player1 new-line">
						<div class="playerLine">
							<div class="color_player_1"></div><div class="line name" id="wwc-name-player1">RandomWalk.js</div>
						</div>
						<div class="playerLine">
							<div class="line label">Punkte:</div><div class="line score" id="wwc-score-player1">0</div>
						</div>
						<div class="playerLine">
							<div class="line label">Gewonnen:</div><div class="line points" id="wwc-points-player1">0</div>
						</div>
						<div class="playerLine">
							<div class="line label author">Author:</div><div class="line author" id="wwc-author-player1">Max</div>
						</div>
					</div>
				</div>
				<div id="controls">
					<div class="control button_mid" id="wwc-stop" style="display: none;">Stop</div>
					<div class="control button_mid" id="wwc-reset" style="display: inline-block;">Next</div>
					<div class="control button_mid" id="wwc-play" style="display: inline-block;">Play</div>
					<div class="control button_mid" id="wwc-step" style="display: inline-block;">Step</div>
				</div>
				<hr>
				<div id="wwc-scheduler" style="display: block;">
				<div class="label_header">Select web workers | Test your own web worker</div>
				<div class="page-content">
					<div class="schedule schedule_left">
						<select class="select-player" id="wwc-select-player0">
							<option>Random</option>
						</select>
						<div class="uploadContainer">
							<div class="fileUpload button_small_grey">
								<span>Choose File</span>
								<input id="wwc-file0_upload" type="file" class="upload" />
							</div>
							<div id="uploadFile_text"></div>
							<script>
								document.getElementById("wwc-file0_upload").onchange = function () {
									document.getElementById("uploadFile_text").innerHTML = this.value;
								};
							</script>
						</div>
						<input type="file" id="wwc-file0" style="display: none;">
					</div>
					<div class="schedule schedule_right">
						<select class="select-player" id="wwc-select-player1">
							<option>Local file</option>
						</select>
						<div class="uploadContainer">
							<div class="fileUpload button_small_grey">
								<span>Choose File</span>
								<input id="wwc-file1_upload" type="file" class="upload" />
							</div>
							<div id="uploadFile1_text"></div>
							<script>
								document.getElementById("wwc-file1_upload").onchange = function () {
									document.getElementById("uploadFile1_text").innerHTML = this.value;
								};
							</script>
						</div>
						<input type="file" id="wwc-file1"  style="display: none;">
					</div>
					<hr>
					<div class="control button_small" id="wwc-refresh" style="display: inline-block;">Refresh</div>
				</div>
			</div>
			</div>
		</div>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>