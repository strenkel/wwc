<!DOCTYPE html>
<html>

<?php
  $headDataMain = 'droppedworker/droppedworker';
	include 'php/head.php';
?>

<body>

<?php
	include 'php/header.php';
?>

<section id="page">
	<section id="content">
		<h2>Dropped Worker</h2>
		<hr width="100">
		<table id="dropped-worker" cellspacing="5">
				<thead>
					<tr>
						<th class="column">Name</th>
						<th class="column">Author</th>
						<th class="column">Date</th>
					</tr>
				</thead>
				<tbody id="wwc-dropped-worker">
					<!-- filles by javaScript -->
				</tbody>
			</table>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>