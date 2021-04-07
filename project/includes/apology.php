<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">

    <link href="css/vote.css" rel="stylesheet" type="text/css">

    <title>Voting Prototype</title>

  </head>

  <body>

  <div id="all">

<?php
  require_once("includes/top-banner.php");
?>

      <div id="middle">
	<h4 class="center">Sorry: <?php print("$message") ?></h4>
      </div>

      <div class="center" id="bottom">
	<button id="vote" onclick="history.go(-1);"> Go Back </button>
<!--
	<a href="javascript:history.go(-1);">Back</a>
-->
      </div>

    </div>

  </body>

</html>
