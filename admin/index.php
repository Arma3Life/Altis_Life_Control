<?php
session_start ();
require_once "../config.php";
// DEBUG CHECK
if ($debug=="1"){
error_reporting(E_ALL); 
ini_set('display_errors', 1);
}
require_once PROJECT_PATH."/lang/de.php";
require_once PROJECT_PATH."/include/db.php";
require_once PROJECT_PATH."/admin/include/function_html_basic_admin.php";
loggedin();
startHTML();
?>
<div class="container" style="padding-top: 60px;">
    <div class="row">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="index.php">Start</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img data-src="holder.js/300x200" src="../img/player_list.jpg" alt="Player List">
                <div class="caption">
                    <h3>Player List</h3>
                    <p>See your Players and Manage them. Delete, change Inventory, set Police, Admin or Donator Status. And many more.</p>
                    <p><a href="player.php" class="btn btn-primary" role="button">Player List</a></p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img data-src="holder.js/300x200" src="../img/vehicle_list.jpg" alt="...">
                <div class="caption">
                    <h3>Vehicle List</h3>
                    <p>List the Vehicles, see the owner, and watch the inventory of the Cars. You can sort it after Type and Side.</p>
                    <p><a href="vehicles.php" class="btn btn-primary" role="button">Vehicle List</a></p>
                </div>
            </div>
        </div>
        <?php
        if($housing_mario == "1"){ 
        ?>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img data-src="holder.js/300x200" src="../img/houses_list.jpg" alt="Houses List">
                <div class="caption">
                    <h3>Houses List</h3>
                    <p>See the Houses bought by your ritch players. You can see the Inventory, the Owner and the Trunk. Thats so great.</p>
                    <p><a href="houses.php" class="btn btn-primary" role="button">Houses List</a></p>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
<?php
//GET DATA FROM DATABASE TO DISPLAY RANKINGS
$new_SQL = mysql_query("SELECT uid,name,cash,bankacc FROM players ORDER BY uid DESC LIMIT 0,10");
$cash_SQL = mysql_query("SELECT uid,name,cash,bankacc FROM players ORDER BY cash DESC LIMIT 0,10");
$bankacc_SQL = mysql_query("SELECT uid,name,cash,bankacc FROM players ORDER BY bankacc DESC LIMIT 0,10");
?>    
    <div class="row" style="margin-top:15px;">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Top 10 Newest Player</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Cash</td>
                            <td>Bank</td>
                        </tr>
                <?php while($row = mysql_fetch_object($new_SQL)){ ?>
                        <tr>
                            <td><?php echo $row->uid;?></td>
                            <td><?php echo "<a href='player_detail.php?uid=".$row->uid."'>".htmlspecialchars($row->name)."</a>";?></td>
                            <td><?php echo $row->cash;?></td>
                            <td><?php echo $row->bankacc;?></td>
                        </tr>
                <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Top 10 Cash</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Cash</td>
                            <td>Bank</td>
                        </tr>
                <?php while($row = mysql_fetch_object($cash_SQL)){ ?>
                        <tr>
                            <td><?php echo $row->uid;?></td>
                            <td><?php echo "<a href='player_detail.php?uid=".$row->uid."'>".htmlspecialchars($row->name)."</a>";?></td>
                            <td><?php echo $row->cash;?></td>
                            <td><?php echo $row->bankacc;?></td>
                        </tr>
                <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Top 10 Bank Account</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Cash</td>
                            <td>Bank</td>
                        </tr>
                <?php while($row = mysql_fetch_object($bankacc_SQL)){ ?>
                        <tr>
                            <td><?php echo $row->uid;?></td>
                            <td><?php echo "<a href='player_detail.php?uid=".$row->uid."'>".htmlspecialchars($row->name)."</a>";?></td>
                            <td><?php echo $row->cash;?></td>
                            <td><?php echo $row->bankacc;?></td>
                        </tr>
                <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
closeHTML();       

