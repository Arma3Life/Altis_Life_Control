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
if (!isset($_GET['uid'])){
    header('Location: player.php');
}
if(ctype_digit($_GET['uid']) == false){
    header('Location: player.php');
}
else{
    $uid = intval(htmlspecialchars($_GET['uid']));
}
///////////////////////////////////////////////////////////////////////////
//////////////////////// START RELOAD AREA ////////////////////////////////
///////////////////////////////////////////////////////////////////////////
if (isset($_POST['type']) || !empty($_POST['type'])){
    if($_POST['type'] == "edit_level_money"){
        $coplevel = intval($_POST["coplevel"]);
        $donatorlvl = intval($_POST["donatorlvl"]);
        $adminlevel = intval($_POST["adminlevel"]);
        $cash = intval($_POST["cash"]);
        $bankacc = intval($_POST["bankacc"]);
        $arrested = intval($_POST["arrested"]);
        $blacklist = intval($_POST["blacklist"]);
        $update = mysql_query("UPDATE players SET coplevel = '".$coplevel."', donatorlvl = '".$donatorlvl."', adminlevel = '".$adminlevel."', cash = '".$cash."', bankacc = '".$bankacc."', arrested = '".$arrested."', blacklist = '".$blacklist."' WHERE uid = '".$uid."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
            
    }
    if($_POST['type'] == "civ_licenses"){
        $civ_licenses_value = htmlspecialchars($_POST["civ_licenses_value"]);
        $update = mysql_query("UPDATE players SET civ_licenses = '".$civ_licenses_value."' WHERE uid = '".$uid."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
    }
    if($_POST['type'] == "cop_licenses"){
        $cop_licenses_value = htmlspecialchars($_POST["cop_licenses_value"]);
        $update = mysql_query("UPDATE players SET cop_licenses = '".$cop_licenses_value."' WHERE uid = '".$uid."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
    }
    if($_POST['type'] == "civ_gear"){
        $civ_gear_value = htmlspecialchars($_POST["civ_gear_value"]);
        $update = mysql_query("UPDATE players SET civ_gear = '".$civ_gear_value."' WHERE uid = '".$uid."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
    }
    if($_POST['type'] == "cop_gear"){
        $cop_gear_value = htmlspecialchars($_POST["cop_gear_value"]);
        $update = mysql_query("UPDATE players SET cop_gear = '".$cop_gear_value."' WHERE uid = '".$uid."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            }  
    }
    if($_POST['type'] == "delete"){
        $delete_player = mysql_query("DELETE FROM players WHERE uid = '".$uid."' ");
            if(!$delete_player) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            }
        $pid = intval($_POST['playerid']);
        $delete_vehicles = mysql_query("DELETE FROM vehicles WHERE pid = '".$pid."' ");
            if(!$delete_vehicles) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            }
        if($housing_mario == "1"){
            $delete_housing = mysql_query("DELETE FROM houses WHERE pid = '".$pid."' ");
            if(!$delete_housing) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            }
        
        }
        header('Location: player.php');
    }
}
///////////////////////////////////////////////////////////////////////////
///////////////////////// END RELOAD AREA /////////////////////////////////
///////////////////////////////////////////////////////////////////////////
$player_detail_SQL = mysql_query("SELECT * FROM players WHERE uid = ".$uid."");
$row = mysql_fetch_object($player_detail_SQL);

$get_skin_civ = $row->civ_gear;
if($get_skin_civ == "\"[]\"") {
    $get_skin_civ = "U_C_Poloshirt_stripped";
}
else{
    $get_skin_civ = substr($get_skin_civ,3);
    $get_skin_civ = substr ($get_skin_civ,0,strpos ($get_skin_civ, "`"));
    if(empty($get_skin_civ)){
        $get_skin_civ = "U_C_Poloshirt_stripped";
    }
}
$get_skin_cop = $row->cop_gear;
if($get_skin_cop == "\"[]\""){
    $get_skin_cop = "not_a_cop";
}
else{
    $get_skin_cop = "U_Rangemaster";
}

?>
<div class="container" style="padding-top: 60px;">
<div class="row">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">Start</a></li>
            <li><a href="player.php">Player List</a></li>
            <li><a href="player.php">Player Editor</a></li>
            <li class="active"><?php echo $row->name; ?></li>
        </ol>
    </div>
<!-- CIVIL BOX -->
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="../img/skin/<?php echo $get_skin_civ;?>.jpg" style="height: 450px;">
        </div>
    </div>
<!-- Middle Box -->
    <div class="col-md-4">
        <div class="thumbnail">
            <ul class="list-group">
                <li class="list-group-item">
                    <h4 class="text-center"><?php echo $row->name; ?></h4>
                    <p class="text-center">User ID: <?php echo $row->uid;?></p>
                    <p class="text-center">SteamID: <a href="http://steamcommunity.com/profiles/<?php echo $row->playerid;?>" target="_blank"><?php echo $row->playerid;?></a></p>
                </li>
                <li class="list-group-item">
                    <h4 style="margin-top: 10px !important;">
                        <p class="text-center">
                        <?php 
                        if ($row->coplevel > 0){
                            echo "<span class='label label-primary' style='margin-right:3px;'><strong>Cop Level ".$row->coplevel."</strong></span>";
                        }
                        else{
                            echo "<span class='label label-default' style='margin-right:3px;'><strong>No Cop</strong></span>";
                        }
                        if ($row->donatorlvl > 0){
                            echo "<span class='label label-success' style='margin-right:3px;'><strong>Donator ".$row->donatorlvl."</strong></span>";
                        }
                        else{
                            echo "<span class='label label-default' style='margin-right:3px;'><strong>No Donator</strong></span>";
                        }
                        if($row->adminlevel > 0){
                            echo "<span class='label label-info' style='margin-right:3px;'><strong>Admin Level ".$row->adminlevel."</strong></span>";
                        }
                        else{
                            echo "<span class='label label-default' style='margin-right:3px;'><strong>No Admin</strong></span>";
                        }
?>
                        </p>
                    </h4>
            </li>
            <li class="list-group-item">
                <h4 style="margin-top: 10px !important;">
                    <p class="text-center">
<?php
                if ($row->arrested == 1) {
                    echo "<span class='label label-danger' style='margin-right:3px;'>Arrested</strong></span>";
                }
                else {
                    echo "<span class='label label-default' style='margin-right:3px;'>Not Arrested</strong></span>";
                }
                if ($row->blacklist == 1) {
                    echo "<span class='label label-danger' style='margin-right:3px;'>Blacklisted</strong></span>";
                }
                else {
                    echo "<span class='label label-default' style='margin-right:3px;'>Not Blacklisted</strong></span>";
                }
                ?>
                    </p>
                </h4>
            </li>
            <li class="list-group-item">
                <p class="text-center"><img src="../img/bank.png"> <strong><?php echo $row->bankacc;?>$</strong> <img src="../img/money.png"> <strong><?php echo $row->cash;?>$</strong></p>
            </li>
            <li class="list-group-item">
                <p class="text-center"><strong>Aliases</strong></p>
                <p class="text-center"><?php echo substr($row->aliases,3,-3);?></p>
            </li>
        </ul>
        <p class="text-right" style="margin-bottom: 0px !important;">
            <a data-toggle="modal" href="#edit_level_money" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
            <a data-toggle="modal" href="#delete" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a>
        </p>
    </div>
    </div>
    <!-- COP BOX -->
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="../img/skin/<?php echo $get_skin_cop;?>.jpg" style="height: 450px;">
        </div>
    </div>
</div>
<br>
<!-- TAB Menu -->
<div class="row">
    <div class="panel panel-default">
    <ul class="nav nav-tabs" id="player_tabs">
        <li class="active"><a href="#licenses">Licenses</a></li>
        <li><a href="#civ_inventory">Civ Inventroy</a></li>
        <li><a href="#cop_inventory">Cop Inventory</a></li>
        <li><a href="#vehicles">Vehicles</a></li>
        <?php if($housing_mario == "1"){ echo "<li><a href='#houses'>Houses</a></li>";}
        ?>
    </ul>
<!-- TAB CONTENT -->
    <div id="player_tabs_content" class="tab-content">
        <div class="tab-pane fade active in" id="licenses">
            <div class="panel panel-default">
                <div class="panel-body">
                    CIV LICENSES <a data-toggle="modal" href="#edit_civ_licenses" class="btn btn-primary" style="float: right;"><span class="glyphicon glyphicon-pencil"></span></a>
                </div>            
                <div class="well ">
                    <!-- CIV Licenses CONTENT -->
                    <?php 
                    //Format the String of the Licenses to a nice layout
                    $civ_licenses = array();
                    $civ_licenses = explode("],[", $row->civ_licenses);
                    $civ_licenses = str_replace("]]\"","",$civ_licenses);
                    $civ_licenses = str_replace("\"[[","",$civ_licenses);
                    $civ_licenses = str_replace("`","",$civ_licenses);
                    //CREATING OUTPUT        
                    for ( $x = 0; $x < count ($civ_licenses); $x++){
                        //if($x%2 !== 0){
                        //    echo "<p>";
                        //}
                        if(strpos($civ_licenses[$x], "1")!==false){
                            echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".substr($civ_licenses[$x],2,-2)."</span> ";    
                        }
                        else{
                            echo "<span class='label label-danger' style='margin-right:3px; line-height:2;'>".substr($civ_licenses[$x],2,-2)."</span> "; 
                        }
                        //if($x%2 == 0){
                        //    echo "</p>";
                        //}
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    COP LICENSES <a data-toggle="modal" href="#edit_cop_licenses" class="btn btn-primary" style="float: right;"><span class="glyphicon glyphicon-pencil"></span></a>
                </div>            
                <div class="well ">
                    <!-- COP Licenses CONTENT -->
                    <?php 
                    //Format the String of the Licenses to a nice layout
                    $cop_licenses = array();
                    $cop_licenses = explode("],[", $row->cop_licenses);
                    $cop_licenses = str_replace("]]\"","",$cop_licenses);
                    $cop_licenses = str_replace("\"[[","",$cop_licenses);
                    $cop_licenses = str_replace("`","",$cop_licenses);
                    //CREATING OUTPUT        
                    for ( $x = 0; $x < count ($cop_licenses); $x++){
                        if(strpos($cop_licenses[$x], "1")!==false){
                            echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".substr($cop_licenses[$x],2,-2)."</span> ";    
                        }
                        else{
                            echo "<span class='label label-danger' style='margin-right:3px; line-height:2;'>".substr($cop_licenses[$x],2,-2)."</span> "; 
                        }
                    }
                    ?>
                </div>
            </div>
        </div>      
<!-- CIV INVENTORY CONTENT -->
        <div class="tab-pane fade" id="civ_inventory">
            <div class="panel panel-default">
                <div class="panel-heading" style="word-wrap: break-word;">
                    <small><?php echo $row->civ_gear;?></small>
                </div>
                <div class="panel-body">
                    <a data-toggle="modal" href="#edit_civ_inventory" class="btn btn-primary" style="float: right;"><span class="glyphicon glyphicon-pencil"></span></a>
                </div>
            </div>
        </div> 
        
<!-- COP INVENTORY CONTENT -->
        <div class="tab-pane fade" id="cop_inventory">
            <div class="panel panel-default">
                <div class="panel-heading" style="word-wrap: break-word;">
                    <small><?php echo $row->cop_gear;?></small>
                </div>
                <div class="panel-body">
                    <a data-toggle="modal" href="#edit_cop_inventory" class="btn btn-primary" style="float: right;"><span class="glyphicon glyphicon-pencil"></span></a>
                </div>
            </div>
        </div> 
        <?php
        // VEHICLE TAB
        $vehicle_SQL = mysql_query("SELECT * FROM vehicles WHERE pid = ".$row->playerid." ORDER BY side");
        
        ?>
        <div class="tab-pane fade" id="vehicles">
            <table class="table table-hover">
                <tr>
                    <td><strong>#</strong> </td>
                    <td><strong>Name</strong></td>
                    <td><strong>Side</strong></td>
                    <td><strong>Type</strong></td>
                    <td><strong>Alive</strong></td>
                    <td><strong>Active</strong></td>
                    <td><strong>Inventory</strong></td>
                    <td><strong>Settings</strong></td>
                </tr>
            <?php while($row_veh = mysql_fetch_object($vehicle_SQL)){ ?>
                <tr>
                    <td><?php echo $row_veh->id;?></td>
                    <td><?php echo "<a href='vehicle_detail.php?id=".$row_veh->id."'>".$row_veh->classname."</a>";?></td>
                    <td><?php echo $row_veh->type;?></td>
                    <td><?php echo $row_veh->side;?></td>
                    <td><?php echo $row_veh->alive;?></td>
                    <td><?php echo $row_veh->active;?></td>
                    <td><?php echo $row_veh->inventory;?></td>
                    <td><a href="vehicle_detail.php?id=<?php echo $row_veh->id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a></td>
                </tr>
            <?php } ?>
            </table>
        </div> 
      <?php
// Houses TAB
    if($housing_mario == "1"){
        $houses_SQL = mysql_query("SELECT * FROM houses WHERE pid = ".$row->playerid."");
        
        ?>
        <div class="tab-pane fade" id="houses">
            <table class="table table-hover">
                <tr>
                    <td><strong>#</strong> </td>
                    <td><strong>House ID</strong></td>
                    <td><strong>Storage</strong></td>
                    <td><strong>Trunk</strong></td>
                    <td><strong>Weapon Storrage</strong></td>
                    <td><strong>Position</strong></td>
                    <td><strong>Occupied</strong></td>
                    <td><strong>Locked</strong></td>
                    <td><strong>Settings</strong></td>
                </tr>
            <?php while($row_houses = mysql_fetch_object($houses_SQL)){ ?>
                <tr>
                    <td><?php echo $row_houses->id;?></td>
                    <td><?php echo "<a href='houses.php?id=".$row_houses->house_id."'>".$row_houses->house_id."</a>";?></td>
                    <td><?php echo $row_houses->storage;?></td>
                    <td><?php echo $row_houses->trunk;?></td>
                    <td><?php echo $row_houses->weapon_storage;?></td>
                    <td><?php echo $row_houses->position;?></td>
                    <td><?php echo $row_houses->occupied;?></td>
                    <td><?php echo $row_houses->locked;?></td>
                    <td><a href="houses.php?id=<?php echo $row_houses->id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a></td>
                </tr>
            <?php 
            //END WHILE
                } ?>
            </table>
        </div>
<?php 
//END IF HOUSING
    }
?>
    </div>
    </div>
</div>
</div>
<!-- START MODAL -->
<!-- MODAL LEVEL AND MONEY -->
<div class="modal fade" id="edit_level_money" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Basic Character Settings</h4>
            </div>
            <form method="post" action="player_detail.php?uid=<?php echo $row->uid;?>" role="form">
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="type" value="edit_level_money" />
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">
                                    Cop Level
                                </label>
                                <select class="form-control" name="coplevel">
                                <?php
                                    for ( $x = 0; $x < 8; $x++){
                                        if($x == $row->coplevel){
                                            echo "<option selected value='".$x."'> ".$x."</option>";    
                                        }
                                        else{
                                            echo "<option value='".$x."'> ".$x."</option>"; 
                                        }
                                    }
                                ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">
                                    Donator Level
                                </label>
                                <select class="form-control" name="donatorlvl">
                                    <?php
                                    for ( $x = 0; $x < 8; $x++){
                                        if($x == $row->donatorlvl){
                                            echo "<option selected value='".$x."'> ".$x."</option>";    
                                        }
                                        else{
                                            echo "<option value='".$x."'> ".$x."</option>"; 
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">
                                    Admin Level
                                </label>
                                <select class="form-control" name="adminlevel">
                                    <?php
                                    for ( $x = 0; $x < 8; $x++){
                                        if($x == $row->adminlevel){
                                            echo "<option selected value='".$x."'> ".$x."</option>";    
                                        }
                                        else{
                                            echo "<option value='".$x."'> ".$x."</option>"; 
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Cash</label>
                            <input class="form-control" name="cash" type="text" value="<?php echo $row->cash; ?>"/>
                        </div>
                        <div class="col-md-6">
                            <label>Bankaccount</label>
                            <input class="form-control" name="bankacc" type="text" value="<?php echo $row->bankacc; ?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Arrested</label> 
                            <select class="form-control" name="arrested">
                                    <?php
                                    for ( $x = 0; $x < 2; $x++){
                                        if($x == $row->arrested){
                                            echo "<option selected value='".$x."'> ".$x."</option>";    
                                        }
                                        else{
                                            echo "<option value='".$x."'> ".$x."</option>"; 
                                        }
                                    }
                                ?>
                                </select>
                        </div>
                        <div class="col-md-6">
                            <label>Arrested</label> 
                            <select class="form-control" name="blacklist">
                                    <?php
                                    for ( $x = 0; $x < 2; $x++){
                                        if($x == $row->blacklist){
                                            echo "<option selected value='".$x."'> ".$x."</option>";    
                                        }
                                        else{
                                            echo "<option value='".$x."'> ".$x."</option>"; 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL LEVEL AND MONEY -->
<!-- START MODAL CIV LICENSES -->
<div class="modal fade" id="edit_civ_licenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Civ Licenses</h4>
            </div>
            <form method="post" action="player_detail.php?uid=<?php echo $row->uid;?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="civ_licenses" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="civ_licenses_value"><?php echo $row->civ_licenses;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL CIV LICENSES -->
<!-- START MODAL COP LICENSES -->
<div class="modal fade" id="edit_cop_licenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Cop Licenses</h4>
            </div>
            <form method="post" action="player_detail.php?uid=<?php echo $row->uid;?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="cop_licenses" />
                        <div class="row">
                            <textarea class="form-control" rows="3" name="cop_licenses_value"><?php echo $row->cop_licenses;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL COP LICENSES -->
<!-- START MODAL CIV Inventory -->
<div class="modal fade" id="edit_civ_inventory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Civ Inventory</h4>
            </div>
            <form method="post" action="player_detail.php?uid=<?php echo $row->uid;?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="civ_gear" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="civ_gear_value"><?php echo $row->civ_gear;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL CIV INVENTORY -->
<!-- START MODAL COP Inventory -->
<div class="modal fade" id="edit_cop_inventory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Cop Inventory</h4>
            </div>
            <form method="post" action="player_detail.php?uid=<?php echo $row->uid;?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="cop_gear" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="cop_gear_value"><?php echo $row->cop_gear;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL COP INVENTORY -->
<!-- START MODAL DELETE -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="player_detail.php?uid=<?php echo $row->uid;?>" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Delete <?php echo $row->name;?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="delete" />
                        <input type="hidden" name="playerid" value="<?php echo $row->playerid;?>" />
                        <p>Do you realy want to delete the Player <strong>"<?php echo $row->name;?>" </strong> and all his Stuff (Vehicles/Houses)?</p>                                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit">Delete Player</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS FOR TABS -->
<script type="text/javascript">
$('#player_tabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
  })
</script>
<?php
closeHTML();

    
    