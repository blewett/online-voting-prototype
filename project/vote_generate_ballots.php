<?php
/*
 * voting prototype vote_generate_ballots.php: Original work Copyright (C) 2021 by Blewett

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
    print("$message\n");
    exit(0);
}

function generate_ballots()
{
    require_once("includes/voting_database_names.php");

    /*
     * The ballot number database has a hash for the voter data and a hash
     * of the ballot number.  The voter is sent and enters the ballot
     * number in the clear (not encrypted).  The voter is identified by
     * name, address, city, zipcode, social security or driver's license
     * ID.  The voter and the ballot number are represented internally
     * with a one way hash code most likely one of the sha3 hashes.  We
     * are using php versions of those routines.
     * 
     * As in the 2020 election ballots are sent to all registered voters.
     * Those ballots include the human readable ballot number.  It could
     * also be emailed or texted in the clear - no encryption required.
     * The encryption is all done on the "election commission" server
     * side.
     * 
     * When the voter decides to vote, they login to a voting web server.
     * The server takes only HTTPS protocol requests - which avoids "man
     * in the middle" style interventions.  The voter logs in using name,
     * city, zip, and last four digits of their social security number or
     * their driver's license number.  This data and these numbers are
     * part of every voter registration in every state in the United
     * States.
     * 
     * The voter's login is verified by looking up a hash of the voter's
     * input information in a voter validation ballot database (VVDB).
     * The voter validation ballot database contains four entries: voter
     * hash code, ballot hash code, a timestamp for the last activity and
     * a flag denoting if the voter has voted in this election or the
     * ballot is currently "in use" - the voter is voting.  The "in use"
     * marking keeps the ballot from being reused via various hacking
     * techniques.
     * 
     * The VVDB is produced by the registrar for the election commission
     * for each election.  This is much as the voting officials did to
     * create the mailing list for ballots in 2020. We have a php script
     * of less than 20 lines that creates the VVDB and the mailing list
     * used to send out ballots - again as was done in 2020.  At no time
     * is the voter's identity exposed in the VVDB or is access enabled
     * via the mailed ballot and ballot number.
     * 
     * After the voter logs in, the voter is sent a webpage with the
     * ballot to be filled out for the current election.  The ballot
     * number is entered by the voter into the webpage and returned as
     * part of casting the ballot.  The returned ballot number is hashed
     * by the web server for use as an index to search for the hashed
     * ballot number and hashed voter data stored in the ballot database.
     * 
     * On the voting screen a hash of the hash of the voter data is
     * included with the web page.  What we are saying is that the voter
     * data is doubly hashed.  This double hash allows the system to
     * verify that the ballot number and the voter ID match what was sent
     * out.  The double hash keeps the first hash of the voter data
     * hidden.  This protects against hackers repeated entry attacks.
     * This also preserves the voter's identity and maintains the secrecy
     * of the vote.
     * 
     * The hash of the voter data is located by hashing the ballot number
     * returned in the clear.  That new ballot hash is used to find the
     * stored hash of the ballot number and the stored hash of the voter
     * data stored in the ballot database.
     * 
     * When the ballot matches the hashed ballot number, the stored hash
     * of the voter data is hashed to check for a match with the returned
     * doubly hashed voter data.  This avoids some one snooping the hashes
     * and acts as an added security factor.
     *
     */

    $fp_VVDB = @fopen($voter_validation, "w");
    if ($fp_VVDB == false)
	    apologize("$voter_validation is not writable.");

    $fp_mailing_list = @fopen($voter_mail, "w");
    if ($fp_mailing_list == false)
	    apologize("$voter_validation is not writable.");

    // the registration database has name, address, zip, socsec, and birthday
    $fp_voter_registration = @fopen($voter_registration, "r");
    if ($fp_voter_registration == false)
        apologize("The voter registration database is not readable.\n");

    $ifirst = 0; $ilast = 1; $iaddress = 2; $icity = 3; $izip = 4; $isocsec = 5;
    $ibirthday = 6;
    $ballot_number = 1024;
    while (!feof($fp_voter_registration))
    {
        $record = fgets($fp_voter_registration);
        $r = trim($record);
        if ($r == "")
            continue;

        $l = explode(":", $r);

        // create the hashes for the 
        // city not used by hash function - demo
        $v = voter_hash1($l[$ifirst], $l[$ilast], $l[$iaddress],
                         $l[$icity], $l[$izip], $l[$isocsec], $ibirthday);

        $b = ballot_hash("$ballot_number");

        $t = time();

        fwrite($fp_VVDB, "$b $v $t n\n");

        // create the mailing list entry
        fwrite($fp_mailing_list,
               "\n" .
               "  send to:\n" .
               "    " . "$l[$ifirst] $l[$ilast]\n" .
               "    " . $l[$iaddress] . "\n" .
               "    " . $l[$icity] . "\n" .
               "      " . $l[$izip] . "\n\n");

        fwrite($fp_mailing_list,
               "\n" .
               "NEW PAGE INSERTED HERE\n\n" .
               "ballot ID: " . $ballot_number . "\n\n" .
               "BALLOT INSERTED HERE as occurred in 2020\n\n");
        
        $ballot_number++;
    }

    fclose($fp_voter_registration);

    fclose($fp_VVDB);

    fclose($fp_mailing_list);

    // clear the $voter_cast_ballots database
    $fp = @fopen($voter_cast_ballots, "w");
    if ($fp == false)
        apologize("$voter_cast_ballots database is not writable.\n");
    fclose($fp);
    print("<h2> the ballot database has been created </h2>\n");
}

generate_ballots();
?>
