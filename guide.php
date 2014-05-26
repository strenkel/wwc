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
		<div id="left">
			<h2>Guide</h2>
			<hr width="100">
			<article>
				<?php
					$withExample = false;
					include 'php/guideText.php';
				?>
			</article>
		</div>
		<div id="right">
			<h2>Web Worker Example</h2>
			<hr width="100">
				<section class="grey_background">
					<?php include 'php/example.php'; ?>
				</section>
		</div>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>