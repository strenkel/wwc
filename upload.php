<!DOCTYPE html>
<html>

<?php
	$headDataMain = 'upload/upload';
	include 'php/head.php';
?>

<body>

<?php
	$headerUploadIsActive="active";
	include 'php/header.php';
?>

<section id="page">
	<section id="content">
		<div id="left">
			<h2>Upload your web worker</h2>
			<hr width="100">
			<section class="grey_background">
				<div class="page-content">
					<div class="uploadContainer">
						<div class="fileUpload button_small">
							<span>Select File</span>
							<input id="uploadBtn" type="file" class="upload" />
						</div>
						<div id="uploadFile"></div>
						<script>
							document.getElementById("uploadBtn").onchange = function () {
								document.getElementById("uploadFile").innerHTML = this.value;
							};
						</script>
					</div>
					<input id="wwc-upload-author" type="text" maxlength="50" class="line" placeholder="Your name | team">
					<input id="wwc-upload-email" type="email" maxlength="50" class="line" placeholder="E-mail">
					<hr>
					<div class="participation">
						<?php include 'php/txten/participation.php';?>
						<br><br>
					</div>
					<div>
						<input type="checkbox" id="wwc_checkbox_termsofuse"><label class="checkbox_label" for="wwc_checkbox_termsofuse"><?php include 'php/txten/agree.php';?></label>
					</div>
					<div class="button button_small" id="wwc-upload">Upload</div>
					<div class="message" id="wwc-upload-message"></div>
				</div>
			</section>
		</div>
		<div id="right">
			<h2>Top 3</h2>
			<hr width="100">
				<section id="workerPlace1" class="workerTop3">
					<h3 class="place">1.</h3>
					<h3 id="workerPlace1name"></h3>
					<p class="autor">Author:</p><p class="autorName" id="workerPlace1Author"></p>
					<p class="points">Points:</p><p class="pointsGotten" id="workerPlace1Points"></p>
				</section>
				<section id="workerPlace2" class="workerTop3">
					<h3 class="place">2.</h3>
					<h3 id="workerPlace2name"></h3>
					<p class="autor">Author:</p><p class="autorName" id="workerPlace2Author"></p>
					<p class="points">Points:</p><p class="pointsGotten" id="workerPlace2Points"></p>
				</section>
				<section id="workerPlace3" class="workerTop3">
					<h3 class="place">3.</h3>
					<h3 id="workerPlace3name"></h3>
					<p class="autor">Author:</p><p class="autorName" id="workerPlace3Author"></p>
					<p class="points">Points:</p><p class="pointsGotten" id="workerPlace3Points"></p>
				</section>
		</div>
	</section>
</section>

<?php	include 'php/footer.php'; ?>

</body>
</html>