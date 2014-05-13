<?php
session_start ();
session_regenerate_id(true);
$_SESSION['login_user'] = ""; 
$_SESSION['login_pswd'] = "";
$_SESSION['login_id'] = "";
require_once "../config.php";
// DEBUG CHECK
if ($debug=="1"){
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);
}
require_once PROJECT_PATH."/lang/de.php";
require_once PROJECT_PATH."/include/db.php";
// CHECK IF POST EMPTY
if (!empty($_POST)) {
    //Prüfung ob Felder ausgefüllt
    $error_login = array();
    if(empty($_POST['login_user'])) {
        $error_login['login_user'] = $lang_de_error_portal_user_login_user_empty;
    }
     else{
         $login_user = mysql_real_escape_string($_POST['login_user']);
    }
    if (empty($error_login)) { 
        if(empty($_POST['login_password'])) {
            $error_login['login_password'] = $lang_de_error_portal_user_login_password_empty;
        }
        else{
             $login_password = mysql_real_escape_string($_POST['login_password']);
        }
    }
    //Überprüfen ob Username in DB vorhanden  
    if (empty($error_login)) { 
        $db_user_check = mysql_query('SELECT username FROM alc_login WHERE username="'.$login_user.'"');
        $result_db_user_check = mysql_num_rows($db_user_check);
        if ($result_db_user_check === 0){
                $error_login['error_portal_user_login_user_db_check'] = $lang_de_error_portal_user_login_user_db_check;
        } 
    }
    if (empty($error_login)) { 
        //Auslesen der Userdaten aus DB
        $db_userdata = mysql_query('SELECT * FROM alc_login WHERE username="'.$login_user.'"') or die(mysql_error());    
        $result_db_user_data = mysql_fetch_object($db_userdata);  
        if ( false===$result_db_user_data ) {
            echo "kein entsprechender Datensatz gefunden";
       }
        else{
        //Prüfen ob Passwort richtig
            if(hash('sha256',$result_db_user_data->salt.$login_password) !== $result_db_user_data->password){
            $error_login['error_portal_user_login_user_db_pw_check'] = $lang_de_error_portal_user_login_user_pswd_check;
                
            }
        }
    }
    
    if (empty($error_login)) {  
    //Schreiben aller Daten in Session
    $_SESSION['login_user'] = $login_user;
    $_SESSION['login_pswd'] = $login_password;
    $_SESSION['login_id'] = $result_db_user_data->id;
    $write_ssid = mysql_query("UPDATE alc_login SET session_id = '". mysql_real_escape_string(session_id())."' WHERE id = '". mysql_real_escape_string($_SESSION['login_id'])."'");
    
    if(!$write_ssid) {
        echo "fehler: ".mysql_error()."<br>"; 
        exit();        
        } 
    header('Location: ../admin/index.php');
    }
}
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN'
       'http://www.w3.org/TR/html4/strict.dtd'>
    <html>
        <head>
        <title>Altis Life Control</title>
        <!-- <link type='text/css' rel='stylesheet' href='css/style.css'/> -->
        <link href='css/bootstrap.css' rel='stylesheet' media='screen'>
        <link href='css/signin.css' rel='stylesheet'>
        </head>
        <body>
        <?php
            // Errorausgabe
            if (isset($error_login)){
            echo "<div class='alert alert-danger'>";
            foreach($error_login as $output_error_schluessel => $output_error_wert){
                    echo $output_error_wert." <br>";
            }
            echo" </div>";
            }
            ?>
            <div class="container">
                <img src="img/logo.png" style="margin: auto;text-align: center;display: block;margin-top: 40px;"/>
                <form class="form-signin" method='post' action='login.php'>
                    <h2 class="form-signin-heading">Please sign in</h2>
                    <input type="text" class="form-control" name='login_user' placeholder="Username" autofocus>
                    <input type="password" class="form-control" name='login_password' placeholder="Password">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div> <!-- /container -->
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="//code.jquery.com/jquery.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="js/bootstrap.js"></script>
        </body>
    </html>