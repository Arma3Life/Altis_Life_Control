<?php
require_once PROJECT_PATH."/config.php";
//require_once "./config.php";
if ( ! @mysql_connect($dbhost, $dbuser, $dbpswd, $dbport))
{
    echo "DB CONNECT ERROR: ".mysql_error();
    logString("Couldn't connect to mysql server!");
}

if ( !mysql_select_db($dbname))
{
    echo "DB CONNECT ERROR: ".mysql_error();	
    logString("Couldn't select mysql database!");
}

?>