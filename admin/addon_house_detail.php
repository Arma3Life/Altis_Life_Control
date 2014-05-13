<?php
session_start ();
require_once "../config.php";
if($housing_mario != "1"){
    header('Location: ../admin/index.php'); 
}
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
    header('Location: addon_houses.php');
}
if(ctype_digit($_GET['id']) == false){
    header('Location: addon_houses.php');
}
else{
    $id = intval(htmlspecialchars($_GET['id']));
}
///////////////////////////////////////////////////////////////////////////
//////////////////////// START RELOAD AREA ////////////////////////////////
///////////////////////////////////////////////////////////////////////////
if (isset($_POST['type']) || !empty($_POST['type'])){
    if($_POST['type'] == "edit_general"){
        $pid = intval($_POST["pid"]);
        $occupied = intval($_POST["occupied"]);
        $locked = intval($_POST["locked"]);
        $storage = mysql_real_escape_string($_POST["storage"]);
        $position = mysql_real_escape_string($_POST["position"]);
        $update = mysql_query("UPDATE houses SET pid = '".$pid."', occupied = '".$occupied."', locked = '".$locked."', storage = '".$storage."', position = '".$position."' WHERE id = '".$id."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
            
    }
    if($_POST['type'] == "edit_inv"){
        $trunk = mysql_real_escape_string($_POST["trunk"]);
        $weapon_storage = mysql_real_escape_string($_POST["weapon_storage"]);
        $update = mysql_query("UPDATE houses SET trunk = '".$trunk."', weapon_storage = '".$weapon_storage."' WHERE id = '".$id."' ");
            if(!$update) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
            
    }
    
    if($_POST['type'] == "delete"){
        $delete = mysql_query("DELETE FROM houses WHERE id = '".$id."' ");
            if(!$delete) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
            header('Location: addon_houses.php');
    }
    
}
///////////////////////////////////////////////////////////////////////////
///////////////////////// END RELOAD AREA /////////////////////////////////
///////////////////////////////////////////////////////////////////////////
$house_detail_SQL = mysql_query("SELECT * FROM houses LEFT JOIN players ON houses.pid = players.playerid WHERE id = ".$id."");
$row = mysql_fetch_object($house_detail_SQL);

?>
<div class="container" style="padding-top: 60px;">
    <div class="row">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="index.php">Start</a></li>
                <li><a href="addon_houses.php">Houses List</a></li>
                <li class="active"><?php echo "ID: ".$row->id." Owner: ".$row->name; ?></li>
            </ol>
        </div>
    <!-- Middle Box -->
        <div class="col-md-4">
            <div class="thumbnail">
                <ul class="list-group">
                    <li class="list-group-item">
                        <h4 class="text-center">ID: <?php echo $row->id; ?></h4>
                        <p class="text-center">Owner: <?php echo "<a href='player_detail.php?uid=".$row->uid."'>".$row->name."</a>";?></p>
                        <p style="text-align: center;">House ID: <?php echo $row->house_id;?></p>
                    </li>
                    <li class="list-group-item">
                        <h4 style="margin-top: 10px !important;">
                            <p class="text-center">
                            <?php 
                            if ($row->occupied == 1){
                                echo "<span class='label label-primary' style='margin-right:3px;'><strong>Occupied</strong></span>";
                            }
                            else{
                                echo "<span class='label label-default' style='margin-right:3px;'><strong>Not Occupied</strong></span>";
                            }
                            if ($row->locked == 1){
                                echo "<span class='label label-success' style='margin-right:3px;'><strong>Unlocked</strong></span>";
                            }
                            else{
                                echo "<span class='label label-default' style='margin-right:3px;'><strong>Locked</strong></span>";
                            }
                            ?>
                            </p>
                        </h4>
                    </li>
                    <li class="list-group-item">
                        <p class="text-center">Storage</p>
                        <p class="text-center"><small><?php echo $row->storage;?></small></p>
                    </li>
                    <li class="list-group-item">
                        <p class="text-center">Position</p>
                        <p class="text-center"><small><?php echo $row->position;?></small></p>
                    </li>
                </ul>
                <p class="text-right" style="margin-bottom: 0px !important;">
                    <a data-toggle="modal" href="#edit_general" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a data-toggle="modal" href="#delete" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a>
                </p>
            </div>
        </div>
    <!-- END MIDDLE BOX -->
    <!-- Right Box -->
        <div class="col-md-8">
            <div class="thumbnail">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="word-wrap: break-word;">
                                Trunk
                            </div>
                            <div class="panel-body">
                                <p style="word-wrap: break-word;"><?php echo $row->trunk;?></p>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="word-wrap: break-word;">
                                Normal Storage
                            </div>
                            <div class="panel-body">
                                <p style="word-wrap: break-word;"><?php echo $row->weapon_storage;?></p>
                            </div>
                        </div>
                    </li>
                </ul>
                <p class="text-right" style="margin-bottom: 0px !important;">
                    <a data-toggle="modal" href="#edit_inv" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                </p>
            </div>
        </div>
    <!-- END RIGHT BOX -->
    </div>
</div>
<br>
<!-- Start Modal Edit General -->
<div class="modal fade" id="edit_general" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit House</h4>
            </div>
            <form method="post" action="addon_house_detail.php?id=<?php echo $row->id;?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="edit_general" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Owner ID</label>
                                    <input class="form-control" name="pid" type="text" value="<?php echo $row->pid; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Occupied</label>
                                    <select class="form-control" name="occupied">
                                            <?php
                                            for ( $x = 0; $x < 2; $x++){
                                                if($x == $row->occupied){
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Locked</label>
                                    <select class="form-control" name="locked">
                                            <?php
                                            for ( $x = 0; $x < 2; $x++){
                                                if($x == $row->locked){
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Storage</label>
                                    <input class="form-control" name="storage" type="text" value="<?php echo htmlspecialchars($row->storage); ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position</label>
                                    <input class="form-control" name="position" type="text" value="<?php echo htmlspecialchars($row->position); ?>"/>
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
<!-- End Modal Edit General -->
<!-- Start Modal Edit Inv -->
<div class="modal fade" id="edit_inv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit House Inventory</h4>
            </div>
            <form method="post" action="addon_house_detail.php?id=<?php echo $row->id;?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="edit_inv" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Trunk</label>
                                    <textarea class="form-control" rows="8" name="trunk"><?php echo $row->trunk;?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Normal Storage</label>
                                    <textarea class="form-control" rows="8" name="weapon_storage"><?php echo $row->weapon_storage;?></textarea>
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
<!-- END MODAL EDIT INV -->
<!-- Modal Delete House -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="addon_house_detail.php?id=<?php echo $row->id;?>" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Delete <?php echo $row->id;?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="delete" />
                        <input type="hidden" name="id" value="<?php echo $id;?>" />
                        <p>Do you realy want to delete the House with the ID <strong>"<?php echo $row->id;?>" </strong>- Owner <strong><?php echo $row->name;?></strong> ?</p>                                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit">Delete House</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL DELETE -->
<!-- END MODAL AREA -->
<?php
closeHTML();

    
    