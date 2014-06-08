<?php
	if (!isset($headerIndexIsActive)) $headerIndexIsActive = "";
	if (!isset($headerGuideIsActive)) $headerGuideIsActive = "";
	if (!isset($headerGameIsActive)) $headerGameIsActive = "";
	if (!isset($headerUploadIsActive)) $headerUploadIsActive = "";
	if (!isset($headerTop20IsActive)) $headerTop20IsActive = "";
	if (!isset($headerWinnerIsActive)) $headerWinnerIsActive = "";
?>

<header id="topmenu">
	<nav>
		<ul>
			<li class="logo"><a href="index.php"><div id="logo"><img src="images/logos/wwc_logo.jpg" alt="WWC-Logo" /></a></div></li>

      <li><a href="index.php" class='<?php echo "$headerIndexIsActive"; ?>' >Home</a></li>
			<li><a href="guide.php" class='<?php echo "$headerGuideIsActive"; ?>' >Guide</a></li>
			<li><a href="game.php" class='<?php echo "$headerGameIsActive"; ?>' >Game</a></li>
			<li><a href="upload.php" class='<?php echo "$headerUploadIsActive"; ?>' >Upload</a></li>
			<li><a href="top20.php" class='<?php echo "$headerTop20IsActive"; ?>' >Top 30 & Challenger</a></li>
			<li><a href="winner.php" class='<?php echo "$headerWinnerIsActive"; ?>' >Winner</a></li>

      <li><a target="_blank" href="http://webworkercontest.net/blog/">Blog</a></li>
		</ul>
	</nav>
</header>
