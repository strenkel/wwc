<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">

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
					Willkommen beim <b>WEB WORKER CONTEST (WWC)</b>, einem JavaScript-
					<a target="_blank" href="http://de.wikipedia.org/wiki/Programmierspiel">Programmierspiel</a>.
					Dabei treten jeweils zwei JavaScript-Programme gegeneinander an.
					Sie müssen auf einer Spielfläche von 100 x 100 Feldern mit einfachen Zügen (top, down, left, right) möglichst viele Felder besetzen.
					Gewonnen hat das Programm, das am Ende mehr Felder besetzt.
					<br><br>
					Realisiert wird der CONTEST auf Basis von <a target="_blank" href="http://en.wikipedia.org/wiki/Web_worker">Web Workern</a>.
					Eure JavaScript-Programme, die gegeneinander antreten, sind Web Worker.
					Der WWC ist vielleicht das erste Programmierspiel, das mithilfe von Web Workern im Browser gespielt wird.
					Die genauen Spielregeln und wie man solche Web Worker programmiert, erfahrt ihr im Guide.
					<br><br>
					Auf die besten Web Worker warten viele schöne Preise. Gespielt wird über vier Runden: Start Up, Round 1, Round 2 und Final.
					Die jeweils drei besten Worker werden prämiert. In den ersten drei Runden gibt es Bücher rund um JavaScript und die Webentwicklung zu gewinnen.
					Im Finale warten ein Laptop und zwei Jahresabos der iX.
					<br><br>
					Startschuss für den CONTEST ist der 27.05.2014. Ab diesem Zeitpunkt lassen sich Web Worker hochladen. Die Start-Up-Sieger werden
					am 31. Mai festgelegt und danach geht es jede Woche weiter. Am 21. Juni 2014 ist das Finale!
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
					<p class="place">1st</p><p class="prize"><?php include 'php/links/prize11.php'; ?></p>
					<p class="place">2nd</p><p class="prize"><?php include 'php/links/prize12.php'; ?></p>
					<p class="place">3rd</p><p class="prize"><?php include 'php/links/prize13.php'; ?></p>
					<p class="prizeBy">by dpunkt.verlag</p>
				</section>
				<section id="round1" class="prizesHome">
					<h3>Round 1 | 07.06.14</h3>
					<p class="place">1st</p><p class="prize"><?php include 'php/links/prize21.php'; ?></p>
					<p class="place">2nd</p><p class="prize"><?php include 'php/links/prize22.php'; ?></p>
					<p class="place">3rd</p><p class="prize"><?php include 'php/links/prize23.php'; ?></p>
					<p class="prizeBy">by O'Reilly</p>
				</section>
				<section id="round2" class="prizesHome">
					<h3>Round 2 | 14.06.14</h3>
					<p class="place">1st</p><p class="prize"><?php include 'php/links/prize31.php'; ?></p>
					<p class="place">2nd</p><p class="prize"><?php include 'php/links/prize32.php'; ?></p>
					<p class="place">3rd</p><p class="prize"><?php include 'php/links/prize33.php'; ?></p>
					<p class="prizeBy">by Galileo Computing</p>
				</section>
				<section id="final" class="prizesHome">
					<h3>Final | 21.06.14</h3>
					<p class="place">1st</p><p class="prize"><?php include 'php/links/prize41.php'; ?></p>
					<p class="place">2nd</p><p class="prize"><?php include 'php/links/prize42.php'; ?></p>
					<p class="place">3rd</p><p class="prize"><?php include 'php/links/prize42.php'; ?></p>
					<p class="prizeBy">by team neusta & iX</p>
				</section>
			</section>
		</div>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>