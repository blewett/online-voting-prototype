<?php
/*
 * voting prototype vote_cast.php: Original work Copyright (C) 2021 by Blewett

MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

 */
require_once("includes/common.php");
$_SESSION = array();
?>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<!doctype html>
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
$vote_cast_1 = "<p>Your vote was improperly cast.<p>Contact your election commision immediately.";
?>

    <div id="middle">

      <h2 class="center"> Tech Square 2021 Presidential Election </h2>

<?php
       $cast_hash = "";
       if (isset($_GET["castkey"]))
           $cast_hash = $_GET["castkey"];
       if ($cast_hash == "")
           apologize($vote_cast_1);
?>

      <form action="vote_login.php" method="post">
        <table class="center">

	  <tr>
	    <td class="left"><h4> Your cast ballot number is: </h4></td>
	  </tr>
	  <tr>
	    <td class="center"><?php print($cast_hash) ?><br><br></td>
	  </tr>
	  <tr>
	    <td class="left"><h4>You can verify your vote using this number.</h4></td>
	  </tr>

        </table>
      </form>

    </div>

  </div>

</body>

</html>
