<!DOCTYPE html>
<html>

<?php
	$headDataMain = 'js/index';
	include 'php/head.php';
?>

<body>

<?php
	$headerIndexIsActive="active";
	include 'php/header.php';
?>

<section id="page">
	<section id="content">
		<div id="left">
			<h2>Intro</h2>
			<hr width="100">
			<article>
				<p>
					Willkommen beim <b>WEB WORKER CONTEST</b>, einem JavaScript
					<a target="_blank" href="http://de.wikipedia.org/wiki/Programmierspiel">Programmierspiel</a>.<br>
					Bei diesem Spiel treten jeweils zwei JavaScript-Programme gegeneinander an.
					Sie müssen auf einer Spielfläche von 100 x 100 Felder mit einfachen Zügen (top, down, left, right) möglichst viele Felder besetzen.
					Gewonnen hat das Programm, dass am Ende mehr Felder besetzt hat.
					<br><br>
					Realisiert wird der CONTEST auf Basis von <a target="_blank" href="http://en.wikipedia.org/wiki/Web_worker">Web Workern</a>.
					Eure JavaScript-Programme, die gegeneinander antreten, sind Web Worker.
					Der WEB WORKER CONTEST ist vielleicht das erste Programmierspiel, das mit Hilfe von Web Workern im Browser gespielt wird.
					Die genauen Spielregeln und wie man solche Web Worker programmiert, erfahrt ihr im Guide.
					<br><br>
					Auf die besten Web Worker warten viele schöne Preise. Gespielt wird über 4 Runden: Start Up, Round 1, Round 2 und Final.
					Die jeweils 3 besten Worker werden prämiert. In den ersten 3 Runden gibt es Bücher rund um JavaScript und Webentwicklung zu gewinnen.
					Im Finale warten ein tolles Laptop und 2 iX Jahresabos.
					<br><br>
					Startschuss für den CONTEST ist der 27.05.2014. Ab diesem Zeitpunkt können Web Worker hochgeladen werden. Die Start Up Sieger werden
					am 31.05. bestimmt. Dann geht es jede Woche weiter. Am 21.06.2014 ist Finale!
					<br><br>
					Ich freue mich auf tolle Programme!
					<br>
					Stefan Trenkel
				</p>
			</article>
			<h2>Wie kann ich teilnehmen?</h2>
			<hr width="100">
			<div class="toggleBox">
				<p id="toggleHeadline" class="toggleHeadline">WEB WORKER CONTEST - Guide</p><div id="toggleIcon" class="toggleIcon">+</div>
				<article id="toggleText" class="toggleText hidden">
					<p>
						Der Web Worker Contest ist ein JavaScript Programmierwettbewerb. Auf einer Spielfläche von 100 x 100 quadratischen Feldern treten jeweils 2 JavaScript-Programme gegeneinander an. Ziel ist es, von einem zufällig zugeteiltem Startfeld aus möglichst viele Felder der Spielfläche zu besetzen. Gewonnen hat das Programm, dass am Ende mehr Felder besetzt hat. Ein Zug besteht darin, von seinem aktuellen Feld entweder das oberer, unterer, rechte oder linke angrenzende Feld zu besetzen. Das neue Feld darf aber nur dann besetzt werden, wenn es nicht zuvor von dem gegnerischen Programm besetzt wurde. Ist ein Zug möglich (das neue Feld ist frei) wechselt die aktuelle Position auf das gewünschte Feld. Ist ein Zug nicht möglich (das Feld ist schon vom Gegner gesetzt oder man will das Spielfeld verlassen), bleibt man auf der aktuellen Position stehen. Felder, die man selber zuvor schon besetzt hat, darf man weiterhin betreten (zählen allerdings nicht doppelt). Die Programme haben keinerlei Informationen über das Spielfeld. Sie können das Spielfeld nicht sehen. Sie ziehen gewissermaßen blind. Die einzige Information, die sie erhalten (und die sie auswerten können), ist, ob ihr gewählter Zug möglich ist oder nicht. Die Programme ziehen nicht abwechselnd, sondern so schnell sie können. Es kommt also darauf an, möglichst schnell, möglichst intelligente Züge zu machen.<br>
						<br>
						Realisiert wird der Wettbewerb mit Hilfe von Web Workern. Web Worker sind JavaScript Programme in einer separaten Datei, die parallel im Hintergrund laufen (Wiki). Jeweils 2 Web Worker treten bei dem Spiel gegeneinander an. Welche Web Worker gegeneinander spielen, stellt man auf der Seite 'Select web workers | Test your own web worker' ein. Mit der Option 'Random' wählt der Server zufällig 2 Web Worker aus den bereits hochgeladenen Web Workern aus. Alternativ kann man selbst 2 konkrete Web Worker auswählen. Mit der Option 'Local file' kann man seinen eigenen Web Worker gegen einen beliebig anderen antreten lassen. Dabei ist der eigene Web Worker einfach eine lokale JavaScript-Datei mit entsprechendem Code. In diesem Fall wird der eigene Web Worker nicht auf den Server hochgeladen. Diese Möglichkeit dient vor allem dem Testen und Optimieren eigener Web Worker. Möchte man an dem Web Worker Contest teilnehmen, so muss man seinen eigenen Web Worker auf der Seite 'Upload your web worker' hochladen. Man kann ihn anschließend (nach einem reload) in der Web Worker - Selectbox auswählen.<br>
						<br>
						Läßt man als normaler Benutzer Web Worker gegeneinander spielen, so werden die Ergebnisse nur lokal ausgewertet. Der Super-User hat die Möglichkeit, Web Worker gegeneinander antreten zu lassen und die Ergebnisse auf dem Server zu speichern. Aus allen so gespielten Partien wird die Tabelle errechnet, die auf der Seite 'Table' angezeigt wird. Dort ist also immer der aktuelle Spitzenreiter zu sehen.<br>
						<br>
						Wie programmiert man nun einen Web Worker? Web Worker interagieren mit dem Hauptprogramm via Messages. Der Web Worker müssen für einen Zug jeweils eines der Schlüsselwörter up, down, right oder left an das Hauptprogramm senden. Ist der Zug möglich, wird true zurück gesendet, andernfalls false. Um ein Dauerfeuern der Web Worker zu verhindern, sendet das Hauptprogramm mit der Erfolgsmeldung eine Id mit. Diese Id muss der Web Worker mit seinem nächsten Zug zurücksenden. Ohne korrekte Id wird der Web Worker disqualifiziert.<br>
						<br>
						Zum Schluss noch ein Beispiel eines einfachen Web Workers. Er geht überwiegend gerade aus. War sein letzter Zug möglich, geht er mit über 95% Wahrscheinlichkeit in dieselbe Richtung weiter. War sein letzter Zug nicht möglich, sucht er sich zufällig eine neue Richtung.<br>
						<br>
						<br>
					</p>
				<pre>
					<code>
var direction;

// Wird aufgerufen, sobald das Hauptprogramm die Erfolgsmeldung
// an den Web Worker sendet.
onmessage = function (event) {

	// Die Erfolgsmeldung wird mit dem Feld 'done' (true | false) gesendet.
	var done = event.data.done;

	// Neue Richtung bestimmen.
		if (done) {
	direction = holdOrChangeDirection(direction);
	} else {
		direction = getRandomDirection();
	}

	// Teilt dem Hauptprogramm die neue Richtung mit.
	// Die Richtung wird mit dem Feld 'direction' gesendet.
	// Die zu wiederholende Id wird mit dem Feld 'id' gesendet.
	postMessage({
		id: event.data.id,
		direction: direction
	});
};

function holdOrChangeDirection(dir) {
	if (Math.random() &lt; 0.05) {
		return getRandomDirection();
	} else {
		return dir;
	}
}

function getRandomDirection() {
	var randomDirection;
	var randomNumber = Math.random();
	if (randomNumber &lt; 0.25) {
		randomDirection = "up";
	} else if (randomNumber &lt; 0.5) {
		randomDirection = "down";
	} else if (randomNumber &lt; 0.75) {
		randomDirection = "left";
	} else {
		randomDirection = "right";
	}
	return randomDirection;
}
				</code>
					</pre>

					Viel Spaß beim Programmieren!

				</article>
			</div>
			<a class="button" href="game.html"><span class="button_mid">Spiel starten</span></a>
		</div>
		<div id="right">
			<h2>Prizes</h2>
			<hr width="100">
			<section class="grey_background">
				<section id="startUp" class="prizesHome">
					<h3>Start Up | 31.05.14</h3>
					<p class="place">1st</p><p class="prize"><a target="_blank" href="http://www.dpunkt.de/buecher/4489/angularjs.html">AngularJS</a></p>
					<p class="place">2rd</p><p class="prize"><a target="_blank" href="http://www.dpunkt.de/buecher/4606/javascript-effektiv.html">JavaScript effektiv</a></p>
					<p class="place">3nd</p><p class="prize"><a target="_blank" href="http://www.dpunkt.de/buecher/4690/the-principles-of-object-oriented-javascript.html">The Principles of Object-Orientated JavaScript</a></p>
					<p class="prizeBy">by dpunkt.verlag</p>
				</section>
				<section id="round1" class="prizesHome">
					<h3>Round 1 | 07.06.14</h3>
					<p class="place">1st</p><p class="prize"><a target="_blank" href="http://www.oreilly.de/catalog/search.html?SESSION=ba100000_83c4102408e338dc;DUE=index;NO=9">Backbone.js Applications</a></p>
					<p class="place">2nd</p><p class="prize"><a target="_blank" href="http://www.oreilly.de/catalog/search.html?SESSION=ba100000_83c4102408e338dc;DUE=index;NO=15">Functional JavaScript </a></p>
					<p class="place">3rd</p><p class="prize"><a target="_blank" href="http://www.oreilly.de/catalog/search.html?SESSION=ba100000_83c4102408e338dc;DUE=index;NO=28">JavaScript Testing with Jasmine</a></p>
					<p class="prizeBy">by O'Reilly</p>
				</section>
				<section id="round2" class="prizesHome">
					<h3>Round 2 | 14.06.14</h3>
					<p class="place">1rd</p><p class="prize"><a target="_blank" href="http://www.galileocomputing.de/katalog/buecher/titel/gp/titelID-3429">Responsive Webdesign</a></p>
					<p class="place">2st</p><p class="prize"><a target="_blank" href="http://www.galileocomputing.de/katalog/buecher/titel/gp/titelID-3319">Node.js</a></p>
					<p class="place">3nd</p><p class="prize"><a target="_blank" href="http://www.galileocomputing.de/katalog/buecher/titel/gp/titelID-3330">Apps mit HTML5 und CSS3</a></p>
					<p class="prizeBy">by Galileo Computing</p>
				</section>
				<section id="final" class="prizesHome">
					<h3>Final | 21.06.14</h3>
					<p class="place">1st</p><p class="prize"><a target="_blank" href="http://www.team-neusta.de/" title="Ein Laptop Deiner Wahl im Wert von 500 Euro.">Ein team neusta Laptop</a></p>
					<p class="place">2nd</p><p class="prize"><a target="_blank" href="http://shop.heise.de/ix-abo">iX Jahresabo</a></p>
					<p class="place">3rd</p><p class="prize"><a target="_blank" href="http://shop.heise.de/ix-abo">iX Jahresabo</a></p>
					<p class="prizeBy">by team neusta & iX</p>
				</section>
			</section>
		</div>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>