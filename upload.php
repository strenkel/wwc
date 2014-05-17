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
			<li><a href="game.html">Game</a></li>
			<li><a href="upload.html" class="active">Upload</a></li>
			<li><a href="top20.html">Top 20 & Challenger</a></li>
			<li><a href="winner.html">Winner</a></li>
			<li><a target="_blank" href="http://webworkercontest.net/blog/">Blog</a></li>
		</ul>
	</nav>
</header>
<section id="page">
	<section id="content">
		<div id="left">
			<h2>Upload your web worker</h2>
			<hr width="100">
			<section class="grey_background">
				<div class="page-content">
					<div class="uploadContainer">
						<div class="fileUpload button_small">
							<span>Datei auswählen</span>
							<input id="uploadBtn" type="file" class="upload" />
						</div>
						<div id="uploadFile"></div>
						<script>
							document.getElementById("uploadBtn").onchange = function () {
								document.getElementById("uploadFile").innerHTML = this.value;
							};
						</script>
					</div>
					<input type="file" class="line" id="wwc-upload-file" style="display:none;">
					<input type="text" maxlength="50" class="line" placeholder="Your name | team" id="wwc-upload-author">
					<input type="email" maxlength="50" class="line" placeholder="E-Mail" id="wwc-upload-email">
					<hr>
					<div class="participation">
						Teilnahmebedingungen:<br>
						<br>
						Die Teilname am WEB WORKER CONTEST (W2C) ist kostenlos. Teilnahmeberechtigt sind
						alle Personen und Teams. Man kann mit beliebig vielen Web Workern teilnehmen.
						Für das Copyright des Web Worker Codes ist der jeweilige Autor verantwortlich.
						Der W2C verwendet den Code ausschließlich für den Wettbewerb. Der eingereichte
						Web Worker Code, der Name des Teilnehmers, E-Mail und Kommentar werden gespeichert.
						Der Web Worker Code, der Name des Teilnehmer und der Kommentar können auf den Seiten des W2C
						sowie auf Twitter und im Blog veröffentlicht werden.
						Die E-Mail Adresse wird nicht veröffentlicht und nicht an Dritte weitergegeben.
						Sie wird nicht für Werbe-Zwecke verwendet.
						Die Gewinner des Contests werden per E-Mail benachrichtigt. Teilnehmer können
						jederzeit die Löschung ihrer Daten verlangen. Hierzu reicht eine Email an die W2C Adresse.
						Für technische Störungen übernimmt der W2C keine Haftung.
						Der Rechtsweg ist ausgeschlossen.<br>
						<br>
					</div>
					<div>
						<input type="checkbox" id="wwc_checkbox_termsofuse"><label class="checkbox_label" for="wwc_checkbox_termsofuse">Ja, ich möchte teilnehmen und akzeptiere die Teilnahmebedingungen.</label>
					</div>
					<div class="button button_small" id="wwc-upload">Upload</div>
					<div class="message" id="wwc-upload-message">Dies ist ein Errortext</div>
				</div>
			</section>
		</div>
		<div id="right">
			<h2>Top 3</h2>
			<hr width="100">
				<section id="workerPlace1" class="workerTop3">
					<h3 class="place">1.</h3>
					<h3 id="workerPlace1name">RandomWalk10Percent.js</h3>
					<p class="autor">Author:</p><p class="autorName" id="workerPlace1Author">Max Muster</p>
					<p class="points">Points:</p><p class="pointsGotten" id="workerPlace1Points">54321</p>
				</section>
				<section id="workerPlace2" class="workerTop3">
					<h3 class="place">2.</h3>
					<h3 id="workerPlace2name">Start Up</h3>
					<p class="autor">Author:</p><p class="autorName" id="workerPlace2Author">Peter Lustig</p>
					<p class="points">Points:</p><p class="pointsGotten" id="workerPlace2Points">11223</p>
				</section>
				<section id="workerPlace3" class="workerTop3">
					<h3 class="place">3.</h3>
					<h3 id="workerPlace3name">Start Up</h3>
					<p class="autor">Author:</p><p class="autorName" id="workerPlace3Author">Nikolaus</p>
					<p class="points">Points:</p><p class="pointsGotten" id="workerPlace3Points">12345</p>
				</section>
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