<?php
/*
 * voting prototype vote_login2.php: Original work Copyright (C) 2021 by Blewett

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
require_once("includes/update_timestamp.php");

{
    // require common code
    require_once("includes/common.php");
    require_once("includes/voting_hash.php");
    require_once("includes/voting_database_names.php");

    $vote_login2_1 = "<p>We could not access ballots database.<p>Try back later.";
    $vote_login2_2 = "<p>The system has recorded that your ID has been used and is in the process of voting.<p>Try again later.";
    $vote_login2_3 = "<p>The system has recorded that your ID has already been used to vote.";
    $vote_login2_4 = "<p>Your information does not match a registered voter on file.<p>Please try again.";

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    /* not currently used
    $address = $_POST["address"];
    $city = $_POST["city"];
    */
    $address = "";
    $city = "";
    $zipcode = $_POST["zipcode"];
    $socsec = $_POST["socsec"];

    //
    // calculate the voter hash from the user input
    //
    $v = voter_hash1($firstname, $lastname, $address,
                     $city, $zipcode, $socsec);

    //
    // search for the voter hash validation_ballot_database (this would be sql)
    //
    $fp_VVDB = @fopen($voter_validation, "r+");
    if ($fp_VVDB == false)
	    apologize($vote_login2_1);

    $mathc = false;
    while (!feof($fp_VVDB))
    {
        $record = fgets($fp_VVDB);
        $r = trim($record);
        if ($r == "")
            continue;

        $l = explode(" ", $r);
        if ($l[1] != $v)
            continue;

        // check if they have voted or are voting
        $lt = trim($l[3]);
        if ($lt != 'n')
        {
            if ($lt == 'o')
            {
                $t1 = $l[2];
                $t2 = time();
                // logged and no activity
                //  after 60 minutes we consider it a lost login - no votes
                //  cast at this point
                if (($t2 - $t1) > (60 * 60))
                    update_timestamp($fp_VVDB, 'n');

                $_SESSION["uid"] = -19;
                apologize($vote_login2_2);
            }
            if ($lt == 'v')
            {
                $_SESSION["uid"] = -19;
                apologize($vote_login2_3);
            }
        }

        update_timestamp($fp_VVDB, 'o');
        $match = true;

        // calculate the 2nd hash - user visible hash from the 1st hash
        $_SESSION["uid"] = voter_hash2($v);
        break;
    }

    fclose($fp_VVDB);

    if ($match == false)
    {
        session_destroy();
        apologize($vote_login2_4);
    }

    // redirect to vote
    redirect("vote_form.php");
}
?>
