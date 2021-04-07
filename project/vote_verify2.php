<?php
/*
 * voting prototype vote_verify2.php: Original work Copyright (C) 2021 by Blewett

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
require_once("includes/voting_hash.php");

function apologize($message)
{
    // require template
    require_once("includes/apology.php");

    // exit immediately since we're apologizing
    exit;
}

function vote_finalize()
{
    require("includes/voting_database_names.php");

    $vote_verify2_1 = "We could not access ballots database.";
    $vote_verify2_2 = "<p>Your information does not match a vote on file.<p>Please try again.";

    $ballotnumber = $_POST["ballotnumber"];
    $b = ballot_hash("$ballotnumber");
    $verifynumber = $_POST["verifynumber"];

    $fp = @fopen($voter_cast_ballots, "r");
    if ($fp == false)
    {
        apologize($vote_verify2_1);
    }

    $match = false;
    while (!feof($fp))
    {
        $record = fgets($fp);
        $r = trim($record);
        if ($r == "")
            continue;

        $l = explode(" ", $r);
        if ($l[0] != $verifynumber)
            continue;

        if ($l[1] != $b)
            continue;

        $vote = $l[2];
        $match = true;
        break;
    }

    fclose($fp);

    if ($match == false)
    {
        session_destroy();
        apologize($vote_verify2_2);
    }

    return $vote;
}

$vote = vote_finalize();

?>

<script type="text/javascript">

function HelpAlert(message)
{
    var messages = [];

    messages["Dewey"] = "Pick this button to select Thomas E. Dewey, the governor of New York, to be the next President of the United States.";

    messages["Truman"] = "Pick this button to select Harry S. Truman, the current President, to be the next President of the United States.";

    alert(messages[message]);
}

function checkradio(button) { document.getElementById(button).checked = true; }

</script>

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

<?php
  print("<body onload=\"checkradio('$vote')\">");
?>
  <div id="all">

<?php
  require("includes/top-banner.php");
?>

<div id="middle">

  <h2 class="center"> 2021 Tech Square Vote Verification </h2>

  <table class="center">
    <tr>
      <td></td>
      <td></br></td>
      <td></td>
    </tr>

    <tr>
      <td></td>
      <td class="left">
	<input class="green" type="radio" id="Dewey" name="president" disabled value="Dewey">
	<label for="Dewey">Thomas E. Dewey</label>
      </td>
      <td>
	<a href="javascript:HelpAlert('Dewey')" class="linkStyle vote">Help</a>
      </td>
    </tr>

    <tr>
      <td></td>
      <td class="left">
	<input type="radio" id="Truman" name="president" disabled value="Truman">
	<label for="Truman">Harry S. Truman</label><br>
      </td>
      <td>
	<a href="javascript:HelpAlert('Truman')" class="linkStyle vote">Help</a>
      </td>
    </tr>

    <tr>
      <td></td>
      <td></br></td>
      <td></td>
    </tr>

  </table>
</div>

  </div>

</body>

</html>
