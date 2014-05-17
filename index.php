<!DOCTYPE html>
<html>

<?php
	$headDataMain = 'index/index';
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
					<a target="_blank" href="http://de.wikipedia.org/wiki/Programmierspiel">Programmierspiel</a>.
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
					<?php	include 'php/guideText.php'; ?>
				</article>
			</div>
			<a class="button" href="game.php"><span class="button_mid">Spiel starten</span></a>
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