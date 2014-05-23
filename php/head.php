<head>
	<title>WWC</title>
	<meta name="robots" content="INDEX,FOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<?php
    if (isset($headDataMain)) {
      include("openGraph.php");
    }
  ?>

	<script>
		var require = {
			baseUrl: 'js',
			paths: {
				jquery: 'libs/jquery'
			}
		};
	</script>

	<?php
    if (isset($headDataMain)) {
      echo "<script data-main='$headDataMain' src='js/libs/require.js' async='true'></script>";
    }
  ?>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>