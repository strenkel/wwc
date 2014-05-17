<!DOCTYPE html>
<html>

<?php
	include 'php/head.php';
?>

<body>

<?php
	$headerGuideIsActive="active";
	include 'php/header.php';
?>

<section id="page">
	<section id="content">
		<h2>Guide</h2>
		<hr width="100">
		<article>
			<p>

				Der Web Worker Contest ist ein JavaScript Programmierwettbewerb. Auf einer Spielfläche von 100 x 100 quadratischen Feldern treten jeweils 2 JavaScript-Programme gegeneinander an. Ziel ist es, von einem zufällig zugeteiltem Startfeld aus möglichst viele Felder der Spielfläche zu besetzen. Gewonnen hat das Programm, dass am Ende mehr Felder besetzt hat. Ein Zug besteht darin, von seinem aktuellen Feld entweder das oberer, unterer, rechte oder linke angrenzende Feld zu besetzen. Das neue Feld darf aber nur dann besetzt werden, wenn es nicht zuvor von dem gegnerischen Programm besetzt wurde. Ist ein Zug möglich (das neue Feld ist frei) wechselt die aktuelle Position auf das gewünschte Feld. Ist ein Zug nicht möglich (das Feld ist schon vom Gegner gesetzt oder man will das Spielfeld verlassen), bleibt man auf der aktuellen Position stehen. Felder, die man selber zuvor schon besetzt hat, darf man weiterhin betreten (zählen allerdings nicht doppelt). Die Programme haben keinerlei Informationen über das Spielfeld. Sie können das Spielfeld nicht sehen. Sie ziehen gewissermaßen blind. Die einzige Information, die sie erhalten (und die sie auswerten können), ist, ob ihr gewählter Zug möglich ist oder nicht. Die Programme ziehen nicht abwechselnd, sondern so schnell sie können. Es kommt also darauf an, möglichst schnell, möglichst intelligente Züge zu machen.<br>
				<br>
				Realisiert wird der Wettbewerb mit Hilfe von Web Workern. Web Worker sind JavaScript Programme in einer separaten Datei, die parallel im Hintergrund laufen
				(<a target="_blank" href="http://en.wikipedia.org/wiki/Web_worker">Wiki</a>). Jeweils 2 Web Worker treten bei dem Spiel gegeneinander an. Welche Web Worker gegeneinander spielen, stellt man auf der Seite 'Select web workers | Test your own web worker' ein. Mit der Option 'Random' wählt der Server zufällig 2 Web Worker aus den bereits hochgeladenen Web Workern aus. Alternativ kann man selbst 2 konkrete Web Worker auswählen. Mit der Option 'Local file' kann man seinen eigenen Web Worker gegen einen beliebig anderen antreten lassen. Dabei ist der eigene Web Worker einfach eine lokale JavaScript-Datei mit entsprechendem Code. In diesem Fall wird der eigene Web Worker nicht auf den Server hochgeladen. Diese Möglichkeit dient vor allem dem Testen und Optimieren eigener Web Worker. Möchte man an dem Web Worker Contest teilnehmen, so muss man seinen eigenen Web Worker auf der Seite 'Upload your web worker' hochladen. Man kann ihn anschließend (nach einem reload) in der Web Worker - Selectbox auswählen.<br>
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


Viel Spaß beim Programmieren!
Stefan Trenkel
					</code>
				</pre>
		</article>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>