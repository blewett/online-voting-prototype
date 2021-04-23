These are the steps for running and testings the voting software
downloaded as a zip file from github.com.  These steps are in Windows
10 jargon.  Substitute "/" for "\" and "terminal" for "cmd" for Linux
and Macs.

0. This system uses python3 and php.  This works well on Linux, Apple
   macs, and Windows 10.  One has to install python3 and php on each
   of those systems - easy.  On Linux systems (often Ubuntu) one uses
   apt install.  On macs, one uses brew to install python after
   installing xcode.  xcode is free.  xcode ships with php.  On
   Windows 10, one uses the following links:

    https://www.python.org/downloads
    https://windows.php.net/download

   python3 will complain about missing pacakges.  Install them with
   pip3.

1. Create a Desktop vote folder.
    right click on the Desktop and select New -> folder
    we commonly use "vote" as the name of the folder
    extract the zip file to the vote folder

2. Start a command prompt window by entering cmd in the search bar and
   look at the voter registraion "database".

  cd Desktop\vote\online-voting-using-existing-registration-data-in-sha-3-main\project

  more data\voter_registration.txt

   the output will be the following:

  Jane:Doe:121 Canoba St:Palo Alto:94301:1234:1999-07-11
  John:Smith:1823 Baxter street:Menlo Park:94025:2341:2000-07-12
  Sarah:Lewis:454 Alameda de las Pulgas Street:Menlo Park:94025:4567:2001-07-13
  Michael:Chan:927 Thames Way #412:Portola Valley:94028:7890:2002-07-14

   The ballot numbering starts at 1024.  Sarah Lewis has ballot number 1026.

3. Now start a php server in the directory.  This is the directory we
   moved to from above.

  php -S localhost:8181

   The php web server will continue to run in this window.

4. Run the protoype from a web browser.  We used firefox and brave:
   enter localhost:8181 as the url.  Login as any of the people in the
   registration database.  Remember the ballot numbers start at 1024

5. After casting a vote sweep out the vote verify number.
   Enter that number and the ballot number into the following url link
   in a browser window to inspect your vote.

  localhost:8181/vote_verify.php
