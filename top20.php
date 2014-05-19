<!DOCTYPE html>
<html>

<?php
	$headDataMain = 'top20/top20';
	include 'php/head.php';
?>

<body>

<?php
	$headerTop20IsActive="active";
	include 'php/header.php';
?>

<section id="page">
	<section id="content">
		<div id="left50">
			<h2>Top 20</h2>
			<hr width="100">
			<table id="top20" cellspacing="5">
				<thead>
					<tr>
						<th class="column rank">#</th>
						<th class="column author">Name</th>
						<th class="column points">Points</th>
						<th class="column games">Games</th>
					</tr>
				</thead>
				<tbody id="wwc-table-body">
					<!-- filles by javaScript -->
				</tbody>
			</table>
		</div>
		<div id="right50">
			<h2>Challenger</h2>
			<hr width="100">
			<table id="challenger" cellspacing="5">
				<thead>
					<tr>
						<th class="column name">Name</th>
						<th class="column author">Author</th>
					</tr>
				</thead>
				<tbody id="wwc-challenger-body">
					<!-- filles by javaScript -->
				</tbody>
			</table>
		</div>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>