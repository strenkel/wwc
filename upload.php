<!DOCTYPE html>
<html>

<?php
	include 'php/head.php';
?>

<body>

<?php
	$headerUploadIsActive="active";
	include 'php/header.php';
?>

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
						Die Teilname am WEB WORKER CONTEST (WWC) ist kostenlos. Teilnahmeberechtigt sind
						alle Personen und Teams. Man darf pro Tag mit maximal 5 Web Workern teilnehmen.
						Es ist untersagt, codegleiche Web Worker zweimal hoch zu laden. Dies gilt sowohl
						für eigene als auch für fremde Web Worker. Der Web Worker Code
						von anderen Teilnehmern darf nur dann verwendet werden, wenn der andere Teilnehmer
						das nicht untersagt und wenn der Code signifikant verbessert wurde.
						Für das Copyright des Web Worker Codes ist der jeweilige Autor verantwortlich.
						Der WWC verwendet den Code ausschließlich für den Wettbewerb. Der eingereichte
						Web Worker Code, der Name des Teilnehmers und seine E-Mail werden gespeichert.
						Der Web Worker Code und der Name des Teilnehmers können auf den Seiten des WWC
						sowie auf Twitter und im zugehörigen Blog veröffentlicht werden.
						Die E-Mail Adresse wird nicht veröffentlicht und nicht an Dritte weitergegeben.
						Sie wird nicht für Werbe-Zwecke verwendet.
						Bei Verstoß gegen die Teilnahmebedingungen können Teilnehmer ohne weitere Begründung
						vom CONTEST ausgeschlossen werden. Die Gewinner des CONTESTS werden per E-Mail benachrichtigt. Teilnehmer können
						jederzeit die Löschung ihrer Daten verlangen. Hierzu reicht eine Email an die WWC Adresse.
						Für technische Störungen übernimmt der WWC keine Haftung.
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

<?php	include 'php/footer.php'; ?>

</body>
</html>