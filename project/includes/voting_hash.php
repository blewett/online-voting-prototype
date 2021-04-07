<?php
/*
 * voting prototype voting_hash.php: Original work Copyright (C) 2021 by Blewett

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
// the ballot hash is only used internally with the voting system
function ballot_hash($ballot_number)
{
    return(hash('sha3-224', "$ballot_number"));
}

/*
 * the voter hash is used as the voter ID internally with the voting
 *   system.  this masks voter ID opaque to all with DB access to
 *   guard against a possible hack and release of the database The
 *   voting registrar is the only group with access to voter IDs.
 */
function voter_hash1($first, $last, $address, $city, $zip, $socsec)
{
    /*
     * we are ignoring address and city - here as a place holders the
     * order of the variables can be set to an arbitrary standard
     * socsec, zip, and names are enough to identify the voter they
     * can further be separated by a pirvate key, known only to this
     * district or the private key can be added to each bag of bits to
     * be hashed.
     */
    $bits = $socsec . ":" . $last . ":" . $first . ":" . $zip;

    return(hash('sha3-224', "$bits"));
}

// this key is changed by the election commission with each voting
//  season
$secrect_key = "qux";

// this hash is used as the session key after login - it doubly masks
// voter ID this is a hash of a hash
function voter_hash2($voter_hash1)
{
    return(hash('sha3-512', "$voter_hash1:$secrect_key"));
}

// this hash is used to return a hash to the voter for later verifying
//  votes
function vote_hash($ballot_hash, $where)
{
    return(hash('sha3-224', "$ballot_hash:$where:$secrect_key"));
}
?>
