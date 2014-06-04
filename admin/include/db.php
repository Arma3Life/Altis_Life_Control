<?php
require_once PROJECT_PATH."/config.php";
$db_connect = mysql_connect("$dbhost", "$dbuser", "$dbpswd");
        if (!$db_connect) {
            echo "<p>Could not connect to the server '" . $dbhost . "'</p>\n";
            echo mysql_error();
        }

if ( !mysql_select_db($dbname))
{
    echo "DB CONNECT ERROR: ".mysql_error();	
    logString("Couldn't select mysql database!");
}

?>