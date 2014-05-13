<?php
require_once PROJECT_PATH.'/config.php';
function startHTML(){
    //Setup Addon Menu
    global $housing_mario;
    if($housing_mario == "1"){
        $addon_menu = "<li><a href='addon_houses.php'>Houses List by Mario</a></li>";
    }
    if (!isset($addon_menu)){
        $addon_menu = "<li><a href='#'>No Addons activated. See config.php</a></li>";
    }
// OUTPUT MENU AND ALL THE HEADER STUFF
echo "<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <meta http-equiv='content-language' content='en' />
        <meta name='copyright' content='Copyright (c) 2014 Altis Life Control by Pictureclass - Revoplay.de' />
        <title>Altis Life Control</title>
        <link href='css/bootstrap.css' rel='stylesheet' media='screen'>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
        <script src='https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'></script>
        <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src='//code.jquery.com/jquery.js'></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src='js/bootstrap.js'></script>     
    </head>
<body>
<div id='wrap'>
    <nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class='navbar-header'>
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-ex1-collapse'>
      <span class='sr-only'>Toggle navigation</span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>
        <a class='navbar-brand' href='index.php' style='padding-top:0 !important;padding-bottom:0 !important;'><img src='img/logo_small.png'></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class='collapse navbar-collapse navbar-ex1-collapse'>
    <ul class='nav navbar-nav'>
       <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Survivor Section <b class='caret'></b></a>
        <ul class='dropdown-menu'>
          <li><a href='player.php'>Player Editor</a></li>
        </ul>
      </li>
      <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Vehicle Section <b class='caret'></b></a>
        <ul class='dropdown-menu'>
          <li><a href='vehicles.php'>Vehicle List</a></li>
        </ul>
      </li>
      <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Addons Section <b class='caret'></b></a>
        
        <ul class='dropdown-menu'>
            ".$addon_menu." 
        </ul>
      </li>
    <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Settings <b class='caret'></b></a>
        <ul class='dropdown-menu'>
          <li><a href='manage_login.php'><span class='glyphicon glyphicon-user'></span> Manage Logins</a></li>
        </ul>
      </li>
    </ul>
    <ul class='nav navbar-nav navbar-right'>
      <li><a href='../index.php'>Start Page</a></li>
        <p class='navbar-text'>Signed in as ". @$_SESSION['login_user'] ."</p>
    <form class='navbar-form navbar-right' role='search' action='logout.php' method='post'>
        <button class='btn btn-default' type='submit'>Logout</button>
    </form>
    </ul>
    
  </div><!-- /.navbar-collapse -->
  </nav>";
};
function closeHTML(){
echo"
</div><!-- Close Wrapper -->
<div id='footer'>
    <div class='container' color: #999999;'>
        <p class='text-center' style='margin-top: 20px; margin-bottom: 0px !important; color: #999999;'>Copyright © 2014 Altis Life Control Version 0.1 by <a href='http://revoplay.de/'>Pictureclass</a> - <a href='http://www.revoplay.de'>Revoplay.de</a>. All Rights Reserved.<br>                                      Only for Private Use. No Commercial Use. Advanced Permissions beyond this license may be available at <a xmlns:cc='http://creativecommons.org/ns#' href='mailto:pictureclass@revoplay.de' rel='cc:morePermissions'>pictureclass@revoplay.de</a>.</p>
            <form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top' class='text-center'>
                <input type='hidden' name='cmd' value='_s-xclick'>
                <input type='hidden' name='hosted_button_id' value='P8E8XVKTZ3BKG'>
                <input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
                <img alt='' border='0' src='https://www.paypalobjects.com/de_DE/i/scr/pixel.gif' width='1' height='1'>
            </form>
    </div>
</div>
</body>
</html>
";    
};

function loggedin(){
    global $disable_login;
    if ($disable_login == "0"){
        if(!isset($_SESSION['login_id']) || empty($_SESSION['login_id'])){ 
            header('Location: ../admin/login.php'); 
        }
    $sql = mysql_query("SELECT username FROM `alc_login` WHERE `id` = '".  mysql_real_escape_string($_SESSION['login_id'])."' AND `session_id` = '".  mysql_real_escape_string(session_id())."' LIMIT 1"); 

        //Redicrect if not Login
        if(mysql_num_rows($sql)=="0"){ 
            header('Location: ../admin/login.php'); 
        } 
    }
}
/*function settings(){
    $settings_SQL = mysql_query("SELECT * FROM alc_settings");
    $settings = array();
    for ($i = 0; $i < mysql_num_rows($settings_SQL); $i++)
    {
            // Get needed data from mysql
            $id = mysql_result($settings_SQL, $i, 0);
            $name = mysql_result($settings_SQL, $i, 1);
            $value = mysql_result($settings_SQL, $i, 2);
            // Save into array for iteration
            $settings[$id] = array ($name, $value);
    }
}*/

function rand_string($lng) 
   { 
   mt_srand(crc32(microtime())); 

   //Welche Buchstaben benutzt werden sollen (Charset) 
   $buchstaben = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789"; 
    
   $str_lng = strlen($buchstaben)-1; 
   $rand= ""; 

   for($i=0;$i<$lng;$i++)         
      $rand.= $buchstaben{mt_rand(0, $str_lng)}; 
       

   return $rand; 
   } 


?>

