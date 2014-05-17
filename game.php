<!DOCTYPE html>
<html>
<head>
	<title>web worker contest</title>
	<meta name="robots" content="INDEX,FOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<header id="topmenu">
	<nav>
		<ul>
			<li class="logo"><div id="logo"><img src="images/logos/wwc_logo.jpg" alt="WWC-Logo" /></div></li>
			<li><a href="home.html">Home</a></li>
			<li><a href="guide.html">Guide</a></li>
			<li><a href="game.html" class="active">Game</a></li>
			<li><a href="upload.html">Upload</a></li>
			<li><a href="top20.html">Top 20 & Challenger</a></li>
			<li><a href="winner.html">Winner</a></li>
			<li><a target="_blank" href="http://webworkercontest.net/blog/">Blog</a></li>
		</ul>
	</nav>
</header>
<section id="page" class="gamePage">
	<section id="content">
		<div id="game">
			<h2>WEB WORKER CONTEST</h2>
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
<footer id="bottom">
	<section id="sponsors">
		<p class="prizeBy">sponsored by</p>
		<ul>
			<li><a target="_blank" href="http://www.team-neusta.de/"><div class="sponsorLogoNeusta sponsorLogo"></div></a></li>
			<li><a target="_blank" href="http://www.dpunkt.de/"><div class="sponsorLogoDpunkt sponsorLogo"></div></a></li>
			<li><a target="_blank" href="http://www.oreilly.de/"><div class="sponsorLogoOreilly sponsorLogo"></div></a></li>
			<li><a target="_blank" href="http://www.heise.de/ix/"><div class="sponsorLogoIX sponsorLogo"></div></a></li>
			<li><a target="_blank" href="http://www.galileocomputing.de/"><div class="sponsorLogoGalileo sponsorLogo"></div></a></li>
		</ul>
	</section>
	<section id="footerLine">
		<section class="left">
			<p>Copyright Web Worker Contest 2014</p>
		</section>
		<section class="right">
			<ul>
				<li><a href="kontakt.html">Kontakt</a></li>
				<li><a href="impressum.html">Impressum</a></li>
				<li><a target="_blank" href="https://twitter.com/workercontest"><img src="images/logos/twitter.jpg" alt="WWC-Logo" /></a></li>
			</ul>
		</section>
	</section>
</footer>
</body>
</html>