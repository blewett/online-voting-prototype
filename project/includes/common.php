<?php

    /*
     * common.php
     *
     * From Harvard Computer Science 50
     * Thank you Harvard!
     *
     * Code common to (i.e., required by) most pages.
     */


    // display errors and warnings but not notices
    ini_set("display_errors", TRUE);
    error_reporting(E_ALL ^ E_NOTICE);

    // enable sessions, restricting cookie to /~username/pset7/
    if (preg_match("{^(/~[^/]+/pset7/)}", $_SERVER["REQUEST_URI"], $matches))
        session_set_cookie_params(0, $matches[1]);

    session_start();

    // requirements
    require_once("helpers.php");

    // require authentication for most pages
    if (!preg_match("/(:?log(:?in|out)|register)\d*\.php$/", $_SERVER["PHP_SELF"]))
    {
        if (!isset($_SESSION["uid"]))
            redirect("vote_login.php");
    }
?>
