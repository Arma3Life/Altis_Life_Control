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
if (!isset($_GET['id'])){
    header('Location: vehicles.php');
}
if(ctype_digit($_GET['id']) == false){
    header('Location: vehicles.php');
}
else{
    $id = intval(htmlspecialchars($_GET['id']));
}
///////////////////////////////////////////////////////////////////////////
//////////////////////// START RELOAD AREA ////////////////////////////////
///////////////////////////////////////////////////////////////////////////
if (isset($_POST['type']) || !empty($_POST['type'])){
    
    if($_POST['type'] == "edit_vehicle"){
        
        $side = mysql_real_escape_string($_POST["side"]);
        $classname = mysql_real_escape_string($_POST["classname"]);
        $type = mysql_real_escape_string($_POST["type_data"]);
        $pid = mysql_real_escape_string($_POST["pid"]);
        $alive = intval($_POST["alive"]);
        $active = intval($_POST["active"]);
        $plate = intval($_POST["plate"]);
        $color = intval($_POST["color"]);
        $inventory = mysql_real_escape_string($_POST["inventory"]);
        $update = mysql_query("UPDATE vehicles SET side = '".$side."', classname = '".$classname."', type = '".$type."', pid = '".$pid."', alive = '".$alive."', active = '".$active."', plate = '".$plate."', color = '".$color."', inventory = '".$inventory."' WHERE id = '".$id."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
            
    }
    if($_POST['type'] == "delete"){
        $delete = mysql_query("DELETE FROM vehicles WHERE id = '".$id."' ");
            if(!$delete) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            }
		header('Location: vehicles.php');
    }
    
}
///////////////////////////////////////////////////////////////////////////
///////////////////////// END RELOAD AREA /////////////////////////////////
///////////////////////////////////////////////////////////////////////////
$vehicle_detail_SQL = mysql_query("SELECT * FROM vehicles LEFT JOIN players ON vehicles.pid = players.playerid WHERE id = ".$id."");
$row = mysql_fetch_object($vehicle_detail_SQL);

?>
<div class="container" style="padding-top: 60px;">
    <div class="row">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="index.php">Start</a></li>
                <li><a href="vehicles.php">Vehicle List</a></li>
                <li><a href="vehicles.php">Vehicle Editor</a></li>
                <li class="active"><?php echo $row->classname." ID: ".$row->id ; ?></li>
            </ol>
        </div>
    <!-- LEFT BOX -->
        <div class="col-md-6">
            <div class="thumbnail">
                <img src="../img/veh/<?php echo $row->classname;?>.jpg" style="height: 450px;">
            </div>
        </div>
    <!-- Right Box -->
        <div class="col-md-6">
            <div class="thumbnail">
                <ul class="list-group">
                    <li class="list-group-item">
                        <h4 class="text-center"><?php echo $row->classname; ?></h4>
                        <p class="text-center">Owner: <?php echo "<a href='player_detail.php?uid=".$row->uid."'>".$row->name."</a>";?></p>
                        <p style="text-align: center;">Plate: <?php echo $row->plate;?> - Color: <?php echo $row->color;?></p>
                    </li>
                    <li class="list-group-item">
                        <h4 style="margin-top: 10px !important;">
                            <p class="text-center">
                            <?php 
                            if ($row->side == "cop"){
                                echo "<span class='label label-primary' style='margin-right:3px;'><strong>Cop Vehicle</strong></span>";
                            }
                            else{
                                echo "<span class='label label-default' style='margin-right:3px;'><strong>Civ Vehicle</strong></span>";
                            }
                            if ($row->active == 1){
                                echo "<span class='label label-success' style='margin-right:3px;'><strong>Driving Arround</strong></span>";
                            }
                            else{
                                echo "<span class='label label-default' style='margin-right:3px;'><strong>In Garage</strong></span>";
                            }
                            if($row->alive == 1){
                                echo "<span class='label label-info' style='margin-right:3px;'><strong>Undestroyed</strong></span>";
                            }
                            else{
                                echo "<span class='label label-default' style='margin-right:3px;'><strong>Destroyed</strong></span>";
                            }
                            ?>
                            </p>
                        </h4>
                    </li>
                    <li class="list-group-item">
                        <p class="text-center">Inventory</p>
                        <p class="text-center"><small><?php echo $row->inventory;?></small></p>
                    </li>
                </ul>
                <p class="text-right" style="margin-bottom: 0px !important;">
                    <a data-toggle="modal" href="#edit" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a data-toggle="modal" href="#delete" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a>
                </p>
            </div>
        </div>
    </div>
</div>
<br>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Vehicle</h4>
            </div>
            <form method="post" action="vehicle_detail.php?id=<?php echo $row->id;?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="edit_vehicle" />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        Classname
                                    </label>
                                    <input class="form-control" name="classname" type="text" value="<?php echo $row->classname; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        Side
                                    </label>
                                    <input class="form-control" name="side" type="text" value="<?php echo $row->side; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        Type
                                    </label>
                                    <input class="form-control" name="type_data" type="text" value="<?php echo $row->type; ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Owner ID</label>
                                    <input class="form-control" name="pid" type="text" value="<?php echo $row->pid; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Plate</label>
                                    <input class="form-control" name="plate" type="text" value="<?php echo $row->plate; ?>"/>
                                </div>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Alive</label>
                                    <select class="form-control" name="alive">
                                            <?php
                                            for ( $x = 0; $x < 2; $x++){
                                                if($x == $row->alive){
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
                                    <label>Active</label>
                                    <select class="form-control" name="active">
                                            <?php
                                            for ( $x = 0; $x < 2; $x++){
                                                if($x == $row->active){
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
                                    <label>Color</label>
                                    <input class="form-control" name="color" type="text" value="<?php echo $row->color; ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Inventory</label> 
                                    <textarea class="form-control" rows="3" name="inventory"><?php echo $row->inventory;?></textarea>
                                </div>
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
<!-- Modal Delete Vehicle -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="vehicle_detail.php?id=<?php echo $row->id;?>" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Delete <?php echo $row->classname;?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="delete" />
                        <input type="hidden" name="id" value="<?php echo $id;?>" />
                        <p>Do you realy want to delete the Vehicle <strong>"<?php echo $row->classname;?>" </strong>- Owner <strong><?php echo $row->name;?></strong> ?</p>                                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit">Delete Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL LEVEL AND MONEY -->
<?php
closeHTML();

    
    