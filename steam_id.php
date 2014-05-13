<?php
session_start ();
require_once "config.php";
// DEBUG CHECK
if ($debug=="1"){
error_reporting(E_ALL); 
ini_set('display_errors', 1);
}
require_once PROJECT_PATH."/lang/de.php";
require_once PROJECT_PATH."/include/function_html_basic.php";
startHTML();



?>
<div class="container" style="padding-top: 60px;">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">Start</a></li>
            <li class="active">How to find your Steam ID</li>
        </ol>
    </div>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4>Step 1 - Starting Arma</h4>
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="col-md-6">
                        <img src="img/steam_id_1.png" alt="Get Steam ID Picture 1" class="img-thumbnail">
                    </div>
                    <div class="col-md-6">
                        <p>Start your Arma 3 and wait until you see the Main Menu. Now chose the Point "Configure".</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <h4>Step 2 - Find your Way</h4>
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="col-md-6">
                        <img src="img/steam_id_2.png" alt="Get Steam ID Picture 1" class="img-thumbnail">
                    </div>
                    <div class="col-md-6">
                        <p>The Menu will expand and you find all the Points where you can configre your Arma 3. Now click on the Point "Profile" to simply find you Steam ID.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <h4>Step 3 - Find your Steam ID</h4>
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="col-md-6">
                        <img src="img/steam_id_3.png" alt="Get Steam ID Picture 1" class="img-thumbnail">
                    </div>
                    <div class="col-md-6">
                        <p>You will find all your Profiles you created. On the right Side you will find your unique Steam ID. <br> If you click on "Edit", you can simply Copy and Paste your Steam ID</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    
    
    
    
    
    
<?php
closeHTML();
?>