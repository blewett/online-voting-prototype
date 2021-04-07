<?php
/*
 * voting prototype update_timestamp.php: Original work Copyright (C) 2021 by Blewett

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

function update_timestamp($fp_VVDB, $which)
{
    $vha = "<p>We could not access ballots database.<p>Try back later.";

    $where = ftell($fp_VVDB);
    if ($where > 13)
    {
        fseek($fp_VVDB, -13, SEEK_CUR);
        if (flock($fp_VVDB, LOCK_EX))
        {
            $t = time();
            fwrite($fp_VVDB, "$t $which");
            fflush($fp_VVDB);
            flock($fp_VVDB, LOCK_UN);
        } else {
            apologize($vha);
        }
    }
}
?>
