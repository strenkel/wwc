<p>
  Der Web Worker Contest ist ein JavaScript-<a target="_blank" href="http://de.wikipedia.org/wiki/Programmierspiel">Programmierspiel</a>.
  Auf einer Spielfläche von 100 x 100 quadratischen Feldern treten
  jeweils zwei JavaScript-Programme gegeneinander an. Ziel ist es, von einem zufällig zugeteiltem Startpunkt aus möglichst viele
  Felder der Spielfläche zu besetzen. Gewonnen hat das Programm, das am Ende mehr Felder besetzt. Ein Zug besteht darin,
  von seinem aktuellen Feld entweder das oberer, unterer, rechte oder linke angrenzende Feld zu besetzen. Das neue Feld darf aber
  nur dann besetzt werden, wenn es nicht zuvor von dem gegnerischen Programm besetzt wurde. Ist ein Zug möglich (das neue Feld ist frei),
  wechselt die aktuelle Position auf das gewünschte Feld. Ist ein Zug nicht möglich (das Feld ist schon vom Gegner gesetzt oder
  man will das Spielfeld verlassen), bleibt man auf der aktuellen Position stehen. Felder, die man selber zuvor schon besetzt hat,
  darf man weiterhin betreten (zählen allerdings nicht doppelt). Die Programme haben keinerlei Informationen über das Spielfeld.
  Sie können das Spielfeld nicht sehen, sondern ziehen blind. Die einzige Information, die sie erhalten (und die sie auswerten können),
  ist, ob ihr gewählter Zug möglich ist oder nicht. Die Programme ziehen nicht abwechselnd, sondern so schnell sie können.
  Es kommt also darauf an, möglichst schnelle, intelligente Züge zu machen.
</p>
<br>
<p>
  Realisiert wird der Wettbewerb mit Hilfe von <a target="_blank" href="http://en.wikipedia.org/wiki/Web_worker">Web Workern</a>.
  Dabei handelt es sich JavaScript-Programme in einer separaten Datei, die parallel im Hintergrund laufen. Dadurch ist es möglich,
  dass die Web Worker gleichzeitig spielen. Jeweils zwei treten gegeneinander an. Wer dabei gegeneinander spielt, stellt man auf
  der Game-Seite unter "Select web workers | Test your own web worker" ein.
  Mit der Option "Local file" kann man seinen eigenen Web Worker gegen einen beliebig anderen antreten lassen.
  Dabei ist der eigene Web Worker einfach eine lokale JavaScript-Datei mit entsprechendem Code. In diesem Fall wird der eigene
  Web Worker nicht auf den Server hochgeladen. Diese Möglichkeit dient vor allem dem Testen und Optimieren eigener Web Worker.
  Möchte man am WWC teilnehmen, so muss man seinen eigenen Web Worker auf der Upload-Seite hochladen.
  Danach ist er auf der Top30&Challenger-Seite zu sehen. Zunächst ist er ein Challenger. Auf einem
  lokalen Super-User Rechner tritt er dann gegen die Top 30 an. Je nach Platzierung etabiert er sich etweder in den Top 30
  oder fliegt aus dem Wettbewerb raus. Die Top 3 der jeweiligen Wertungstage (31. Mai, 07., 14. & 21. Juni) erhalten tolle
  Sachpreise (siehe Prizes auf der Home-Site).
</p>
<br>
<p>
  Läßt man als normaler Benutzer Web Worker gegeneinander spielen, so findet die Auswertung der Ergebnisse nur lokal statt.
  Der Super-User hat die Möglichkeit, Web Worker gegeneinander antreten zu lassen und die Ergebnisse auf dem Server zu speichern.
  Ein solcher Super-User-Rechner wird während des gesamten CONTESTS laufen und die Web Worker gegeneinander antreten lassen.
</p>
<br>
<p>
  Wie programmiert man nun einen Web Worker? Web Worker interagieren mit dem Hauptprogramm via Messages. Die Web Worker müssen
  für einen Zug jeweils eines der Schlüsselwörter up, down, right oder left an das Hauptprogramm senden.
  Ist der Zug möglich, wird true zurückgesendet, andernfalls false. Um ein Dauerfeuern der Web Worker zu verhindern, sendet
  das Hauptprogramm mit der Erfolgsmeldung eine ID mit. Diese muss der Web Worker mit seinem nächsten Zug zurücksenden.
  Ohne korrekte ID wird der Web Worker disqualifiziert.
</p>
<br>
<p>
  Zum Schluss (unten oder rechts) ein Beispiel eines einfachen Web Workers: Er geht überwiegend geradeaus. War sein letzter Zug möglich,
  geht er mit über 95% Wahrscheinlichkeit in dieselbe Richtung weiter. War der letzter Zug nicht möglich, sucht er sich
  zufällig eine neue Richtung.
</p>
<br>
<p>
<?php
  if ($withExample) {
    include 'php/txt/example.php';
  }
?>
</p>
<p>
Kopiert ihr diesen Code in eine lokale JavaScript-Datei, habt ihr Euren ersten Web Worker erstellt.<br>
Jetzt müsst ihr ihn nur noch ein wenig tunen ;-)
</p>
<br>
<br>
<p>
  <u>Weitere Details:</u>
</p>
<br>
<p>
  Die Verteilung der Startpunkt auf dem Spielfeld ist gleichverteilt.
</p>
<br>
<p>
  Der CONTEST ist für die jeweils aktuellen Browser (z.Z. Firefox 29, Chrome 35, IE 11) ausgelegt. Die Top 30 werden auf dem aktuellen Firefox ausgespielt.
</p>
<br>
<p>
  Ein Spiel dauert genau 10.000 Züge. Dabei werden die Züge der beiden Web Worker zusammengezählt.
</p>
<br>
<p>
  Bei Punktgleichheit entscheidet der frühere Upload-Zeitpunkt.
</p>
<br>
<br>
<p>
Viel Spaß beim Programmieren!
</p>
