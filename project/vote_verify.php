<?php
/*
 * voting prototype vote_verify.php: Original work Copyright (C) 2021 by Blewett

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
?>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<script type="text/javascript">

function HelpAlert(message)
{
    var messages = [];

    messages["verifynumber"] = "Enter the verification number that was displayed when you cast your vote.";

    messages["ballotnumber"] = "Enter the ballot number that was included with your ballot.";

    messages["verifybutton"] = "Select the verify button to examine your vote.";

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

      <h2 class="center"> Vote Verification Tech Square 2021 </h2>

      <form action="vote_verify2.php" method="post">
        <table class="center">

	  <tr>
	    <td class="right">vote verify number:</td>
	    <td><input name="verifynumber" type="text" size="27"
		       placeholder="e.g. number from voting"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('verifynumber')" class="linkStyle vote">Help</a>
	    </td>
	  </tr>

	  <tr>
	    <td class="right">ballot number:</td>
	    <td><input name="ballotnumber" type="text"
		       placeholder="e.g. your ballot number"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('ballotnumber')" class="linkStyle vote">Help</a>
	    </td>
	  </tr>
          <tr>
            <td><br><br></td>
	    <td><button id="verify" type="submit"> Verify </button> </td>
	    <td>
	      <a href="javascript:HelpAlert('verifybutton')" class="linkStyle vote">Help</a>
	    </td>
          </tr>
        </table>
      </form>

    </div>

  </div>

</body>

</html>
