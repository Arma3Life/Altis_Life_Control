<?php
// CHECK IF STEAM ID IS EMPTY
if (!isset($_POST['steam_id']) || empty($_POST['steam_id'])){
    header('Location: index.php');
}
// CHECK IF STEAM ID IS ONLY NUMERIC
if(ctype_digit($_POST['steam_id']) == false){
    echo "Falsche STEAM ID";
    exit;
}
else{
    $steam_id = intval($_POST['steam_id']);
}

require_once "config.php";
// DEBUG CHECK
if ($debug=="1"){
error_reporting(E_ALL); 
ini_set('display_errors', 1);
}
require_once PROJECT_PATH."/lang/de.php";
require_once PROJECT_PATH."/include/db.php";
require_once PROJECT_PATH."/include/function_html_basic.php";
startHTML();
$player_detail_SQL = mysql_query("SELECT * FROM players WHERE playerid = ".$steam_id."");
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
            <img src="img/skin/<?php echo $get_skin_civ;?>.jpg" style="height: 450px;">
        </div>
    </div>
<!-- Middle Box -->
    <div class="col-md-4">
        <div class="thumbnail">
            <ul class="list-group">
                <li class="list-group-item">
                    <h4 class="text-center"><?php echo $row->name; ?></h4>
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
                <p class="text-center"><img src="img/bank.png"> <strong><?php echo $row->bankacc;?>$</strong> <img src="img/money.png"> <strong><?php echo $row->cash;?>$</strong></p>
            </li>
        </ul>
    </div>
    </div>
    <!-- COP BOX -->
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="img/skin/<?php echo $get_skin_cop;?>.jpg" style="height: 450px;">
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
                    CIV LICENSES
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
                    COP LICENSES
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
            </div>
        </div> 
        
<!-- COP INVENTORY CONTENT -->
        <div class="tab-pane fade" id="cop_inventory">
            <div class="panel panel-default">
                <div class="panel-heading" style="word-wrap: break-word;">
                    <small><?php echo $row->cop_gear;?></small>
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
                </tr>
            <?php while($row_veh = mysql_fetch_object($vehicle_SQL)){ ?>
                <tr>
                    <td><?php echo $row_veh->id;?></td>
                    <td><?php echo $row_veh->classname;?></td>
                    <td><?php echo $row_veh->type;?></td>
                    <td><?php echo $row_veh->side;?></td>
                    <td><?php echo $row_veh->alive;?></td>
                    <td><?php echo $row_veh->active;?></td>
                    <td><?php echo $row_veh->inventory;?></td>
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
<!-- JS FOR TABS -->
<script type="text/javascript">
$('#player_tabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
  })
</script>
<?php
closeHTML();

    
    