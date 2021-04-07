<?php
/*
 * voting prototype vote_form2.php: Original work Copyright (C) 2021 by Blewett

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

function voter_cast_ballot($voter_cast_ballots, $ballotnumber, $vote)
{
    # fallback message if the voter_cast_ballots database cannot be accessed
    $vote_form2_0 = "<p>We could not lock the ballots database.";

    $b = ballot_hash("$ballotnumber");
    $cast_hash = 0;

    $fp = @fopen($voter_cast_ballots, "a");
	if ($fp == false)
    {
        apologize($vote_form2_0);
        return $cast_hash;
    }

    if (flock($fp, LOCK_EX))
    {
        $where = ftell($fp);
        $cast_hash = vote_hash($b, $where);

        fwrite($fp, "$cast_hash $b $vote\n");
        fflush($fp);

        flock($fp, LOCK_UN);
    } else {
        apologize($vote_form2_0);
    }

    fclose($fp);
    
    return($cast_hash);
}

function vote_finalize()
{
    // require common code
    if ($_SESSION["uid"] == -19)
        apologize($vote_form2_1);

    require_once("includes/common.php");
    require_once("includes/voting_hash.php");
    require_once("includes/voting_database_names.php");

    $vote_form2_1 = "<p>The system has recorded that your ID has been used and is in the process of voting.<p>Try again later.";
    $vote_form2_2 = "<p>$voter_validation is not readable.";
    $vote_form2_3 = "<p>The system has recorded that your ID has timed out.<p>Try again later.";
    $vote_form2_4 = "<p>The system has recorded your ID has already been used to vote.";
    $vote_form2_5 = "<p>The system has recorded that your ID has timed out.<p>Try again later.";
    $vote_form2_6 = "<p>Your information does not match a registered voter on file.<p>Please try again.";

    $vote = $_POST["president"];
    $ballotnumber = $_POST["ballotnumber"];
    $b = ballot_hash("$ballotnumber");

    //
    // search for the voter hash validation_ballot_database (this would be sql)
    //
    $fp_VVDB = @fopen($voter_validation, "r+");
    if ($fp_VVDB == false)
	    apologize($vote_form2_2);

    $cast_hash = "";
    $match = false;
    while (!feof($fp_VVDB))
    {
        $record = fgets($fp_VVDB);
        $r = trim($record);
        if ($r == "")
            continue;

        $l = explode(" ", $r);
        $v2 = voter_hash2($l[1]);
        if ($v2 != $_SESSION["uid"])
            continue;

        // check if they have voted or are voting
        $lt = trim($l[3]);
        if ($lt != 'n')
        {
            if ($lt != 'o')
            {
                $_SESSION["uid"] = -19;
                apologize($vote_form2_3);
            }
            if ($lt == 'v')
            {
                $_SESSION["uid"] = -19;
                apologize($vote_form2_4);
            }
        }

        $lock = 'v';
        $match = true;

        // the session matches however the ballot does not match
        if ($l[0] != $b)
        {
            $lock = 'n';
            $match = false;
        }

        update_timestamp($fp_VVDB, $lock);

        if ($match == true)
            $cast_hash = voter_cast_ballot($voter_cast_ballots, $ballotnumber, $vote);
        break;
    }

    fclose($fp_VVDB);

    if ($match == false)
    {
        session_destroy();
        $s = $_SESSION["uid"];
        if ($s == -19)
            apologize($vote_form2_5);
        else
            apologize($vote_form2_6);
    }

    // redirect to vote
    $_SESSION["uid"] = 0;
    redirect("vote_cast.php?castkey=$cast_hash");
}

vote_finalize();
?>
