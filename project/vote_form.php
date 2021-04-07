<?php // -*- mode: javascript; -*-
/*
 * voting prototype vote_form.php: Original work Copyright (C) 2021 by Blewett

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
require_once("includes/voting_database_names.php");
?>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<script type="text/javascript">

function HelpAlert(message)
{
    var messages = [];

    messages["ballotnumber"] = "Enter the ballot number that was included with your ballot.";

    messages["Dewey"] = "Pick this button to select Thomas E. Dewey, the governor of New York, to be the next President of the United States.";

    messages["Truman"] = "Pick this button to select Harry S. Truman, the current President, to be the next President of the United States.";

    messages["vote"] = "Submit your vote so that your voice may be counted.";

    alert(messages[message]);
}
</script>

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
?>

    <div id="middle">

      <h2 class="center"> Tech Square 2021 Presidential Election </h2>

      <form action="vote_form2.php" method="post">
        <table class="center">

	  <tr>
	    <td class="right">ballot number:</td>
	    <td><input name="ballotnumber" type="text" 
		       placeholder="printed number on your ballot"
		       required>
	    </td>
	    <td>
	      <a href="javascript:HelpAlert('ballotnumber')" class="linkStyle vote">Help</a>
	    </td>
	  </tr>

	  <tr>
            <td></td>
            <td></td>
            <td></td>
	  </tr>

	  <tr>
            <td></td>
            <td></br></td>
            <td></td>
	  </tr>

	  <tr>
            <td></td>
	    <td class="left">
	      <input type="radio" id="Dewey" name="president" required value="Dewey">
	      <label for="Dewey">Thomas E. Dewey</label>
	    </td>
	    <td>
	      <a href="javascript:HelpAlert('Dewey')" class="linkStyle vote">Help</a>
	    </td>
	  </tr>

	  <tr>
	    <td></td>
	    <td class="left">
	      <input type="radio" id="Truman" name="president" required value="Truman">
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

          <tr>
            <td></td>
	    <td><button id="vote" type="submit"> Submit the Vote </button> </td>
	    <td>
	      <a href="javascript:HelpAlert('vote')" class="linkStyle vote">Help</a>
	    </td>
          </tr>
        </table>
      </form>

    </div>

  </div>

</body>

</html>
