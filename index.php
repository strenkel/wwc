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
					<?php
					  include 'php/txten/welcome.php';
					?>
				</p>
			</article>
			<h2>How can I participate?</h2>
			<hr width="100">
			<div class="toggleBox">
				<p id="toggleHeadline" class="toggleHeadline">Guide</p><div id="toggleIcon" class="toggleIcon">+</div>
				<article id="toggleText" class="toggleText hidden">
					<?php
					  $withExample = true;
					  include 'php/txten/guide.php';
					?>
				</article>
			</div>
			<a class="button" href="game.php"><span class="button_mid">Start Game</span></a>
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