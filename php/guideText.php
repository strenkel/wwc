<p>
  Der Web Worker Contest ist ein JavaScript Programmierspiel. Auf einer Spielfläche von 100 x 100 quadratischen Feldern treten
  jeweils 2 JavaScript-Programme gegeneinander an. Ziel ist es, von einem zufällig zugeteiltem Startfeld aus möglichst viele
  Felder der Spielfläche zu besetzen. Gewonnen hat das Programm, dass am Ende mehr Felder besetzt hat. Ein Zug besteht darin,
  von seinem aktuellen Feld entweder das oberer, unterer, rechte oder linke angrenzende Feld zu besetzen. Das neue Feld darf aber
  nur dann besetzt werden, wenn es nicht zuvor von dem gegnerischen Programm besetzt wurde. Ist ein Zug möglich (das neue Feld ist frei)
  wechselt die aktuelle Position auf das gewünschte Feld. Ist ein Zug nicht möglich (das Feld ist schon vom Gegner gesetzt oder
  man will das Spielfeld verlassen), bleibt man auf der aktuellen Position stehen. Felder, die man selber zuvor schon besetzt hat,
  darf man weiterhin betreten (zählen allerdings nicht doppelt). Die Programme haben keinerlei Informationen über das Spielfeld.
  Sie können das Spielfeld nicht sehen. Sie ziehen blind. Die einzige Information, die sie erhalten (und die sie auswerten können),
  ist, ob ihr gewählter Zug möglich ist oder nicht. Die Programme ziehen nicht abwechselnd, sondern so schnell sie können.
  Es kommt also darauf an, möglichst schnell, möglichst intelligente Züge zu machen.
</p>
<br>
<p>
  Realisiert wird der Wettbewerb mit Hilfe von <a target="_blank" href="http://en.wikipedia.org/wiki/Web_worker">Web Workern</a>.
  Web Worker sind JavaScript Programme in einer separaten Datei, die parallel im Hintergrund laufen. Dadurch ist es möglich,
  dass die Web Worker gleichzeitig spielen. Jeweils 2 Web Worker treten bei dem Spiel gegeneinander an. Welche Web Worker
  gegeneinander spielen, stellt man auf der Game-Seite unter 'Select web workers | Test your own web worker' ein.
  Mit der Option 'Local file' kann man seinen eigenen Web Worker gegen einen beliebig anderen antreten lassen.
  Dabei ist der eigene Web Worker einfach eine lokale JavaScript-Datei mit entsprechendem Code. In diesem Fall wird der eigene
  Web Worker nicht auf den Server hochgeladen. Diese Möglichkeit dient vor allem dem Testen und Optimieren eigener Web Worker.
  Möchte man an dem WEB WORKER CONTEST teilnehmen, so muss man seinen eigenen Web Worker auf der Upload-Seite hochladen.
  Nach dem Upload ist der Web Worker auf der Top20&Challenger-Seite zu sehen. Zunächst ist er ein Challenger. Auf einem
  lokalen Super-User Rechner tritt er dann gegen die Top 20 an. Je nach Platzierung etabiert er sich etweder in den Top 20,
  oder fliegt aus dem Wettbewerb raus. Die Top 3 der jeweiligen Wertungstage (31.5, 07.06, 14.6 & 21.06) erhalten tolle
  Sachpreise (siehe Prizes auf der Home - Site).
</p>
<br>
<p>
  Läßt man als normaler Benutzer Web Worker gegeneinander spielen, so werden die Ergebnisse nur lokal ausgewertet.
  Der Super-User hat die Möglichkeit, Web Worker gegeneinander antreten zu lassen und die Ergebnisse auf dem Server zu speichern.
  Ein solcher Super-User-Rechner wird während des gesammten CONTESTS laufen und die Web Worker gegeneinander antreten lassen.
</p>
<br>
<p>
  Wie programmiert man nun einen Web Worker? Web Worker interagieren mit dem Hauptprogramm via Messages. Die Web Worker müssen
  für einen Zug jeweils eines der Schlüsselwörter up, down, right oder left an das Hauptprogramm senden.
  Ist der Zug möglich, wird true zurück gesendet, andernfalls false. Um ein Dauerfeuern der Web Worker zu verhindern, sendet
  das Hauptprogramm mit der Erfolgsmeldung eine Id mit. Diese Id muss der Web Worker mit seinem nächsten Zug zurücksenden.
  Ohne korrekte Id wird der Web Worker disqualifiziert.
</p>
<br>
<p>
  Zum Schluss ein Beispiel eines einfachen Web Workers. Er geht überwiegend gerade aus. War sein letzter Zug möglich,
  geht er mit über 95% Wahrscheinlichkeit in dieselbe Richtung weiter. War sein letzter Zug nicht möglich, sucht er sich
  zufällig eine neue Richtung.
</p>
<br>
<p>

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
</p>
<p>
Kopiert Ihr diesen Code in eine lokale JavaScript-Datei, habt Ihr Euren ersten Web Worker erstellt.<br>
Jetzt müsst Ihr ihn nur noch ein wenig tunen ;-)
</p>
<br>
<br>
<p>
  <u>Weitere Details:</u>
</p>
<br>
<p>
  - Um sicherzustellen, dass die Web Worker zum Start etwa gleich Anfangsbedingungen besitzen, werden die Startpunkt in schräg gegenüberliegende
  Teil-Quadrate gelost. Startet z.B. der erste Web Worker im linken, oberen Teilquadrat (Felder 1-50 horizontal und vertical), so
  wird der zweite Web Worker in das rechte, untere Teilquadrat gelost (Felder 51-100 horizontal und vertical). Die Verteilung
  innerhalb der Teil-Qudrate ist gleichverteilt.
</p>
<br>
<p>
  - Gespielt wird auf dem jeweils aktuellen Firefox.
</p>
<br>
<br>
<p>
Viel Spaß beim Programmieren!
</p>
