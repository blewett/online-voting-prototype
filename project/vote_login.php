<?php
/*
 * voting prototype vote_login.php: Original work Copyright (C) 2021 by Blewett

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

logout();
?>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<script type="text/javascript">

function HelpAlert(message)
{
    var messages = [];

    messages["firstname"] = "Enter your first name as it appears on your voter registration or your driver's license.";

    messages["lastname"] = "Enter your last name as it appears on your voter registration or your driver's license.";

    messages["address"] = "Enter your adderss as it appears on your voter registration or your driver's license.";

    messages["city"] = "Enter your city name as it appears on your voter registration or your driver's license.";

    messages["zipcode"] = "Enter your zip code as it appears on your voter registration or your driver's license.";

    messages["socsec"] = "Enter the last four digits of your social security number or your drivers license - which ever you used to register to vote";

    messages["birthday"] = "Enter the month, day, and year of your birth.  The year must contain four digits - for example 1983.  The icon on the left can help you should you need to select each item (month, day, and year) from a menu.  Press enter to verify your date.";

    messages["loginbutton"] = "Select the login button to complete your login process.";

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

      <h2 class="center"> Login for Tech Square 2021 Voting </h2>

      <form action="vote_login2.php" method="post">
        <table class="center">

	  <tr>
	    <td class="right">first name:</td>
	    <td><input name="firstname" type="text" 
		       placeholder="e.g. John or Jane"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('firstname')" class="linkStyle vote">Help</a>
	    </td>
	  </tr>

	  <tr>
	    <td class="right">last name:</td>
	    <td><input name="lastname" type="text"
		       placeholder="e.g. Smith"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('lastname')" class="linkStyle vote">Help</a>
	    </td>
	  </tr>
<!-- city and address can be added as needed
          <tr>
            <td class="right">address:</td>
            <td><input name="address" type="text"
		       placeholder="e.g. 410 Main Street"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('address')" class="linkStyle vote">Help</a>
	    </td>
          </tr>
          <tr>
            <td class="right">city:</td>
            <td><input name="city" type="text"
		       placeholder="e.g. Barrington Cove"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('city')" class="linkStyle vote">Help</a>
	    </td>
          </tr>
-->
          <tr>
            <td class="right">zip code:</td>
            <td><input name="zipcode" type="text"
		       placeholder="e.g. 90210 (your zip code)"
		       maxlength="5"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('zipcode')" class="linkStyle vote">Help</a>
	    </td>
          </tr>
          <tr>
            <td class="right">social security:</td>
            <td><input name="socsec" type="text"
		       placeholder="e.g. 1234 (the last four digits)"
		       maxlength="4"
		       required></td>
	    <td>
	      <a href="javascript:HelpAlert('socsec')" class="linkStyle vote">Help</a>
	    </td>
          </tr>

	    </td>
          </tr>
          <tr>
            <td class="right">
		  <label for="birthday">birthday:</label>
	    </td>
	    <td>

	      <input name="birthday" type="date"
		     placeholder="e.g. 12/21/1983"
		     id="birthday"  min="1900-01-01" max="2002-11-02"
		  required></td>
	    <td>
	      <a href="javascript:HelpAlert('birthday')" class="linkStyle vote">Help</a>
	    </td>
          </tr>

          <tr>
            <td><br><br></td>
	    <td><button id="login" type="submit"> Login </button> </td>
	    <td>
	      <a href="javascript:HelpAlert('loginbutton')" class="linkStyle vote">Help</a>
	    </td>
          </tr>
        </table>
      </form>

    </div>

  </div>

</body>

</html>
