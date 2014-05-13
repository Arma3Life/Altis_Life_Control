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
//START RELOAD AREA
if (!empty($_POST)){
    $error_user = array();
    // REMOVE Vehicle
    if ($_POST['type'] == "delete"){
        $edit_vehicle_id = intval($_POST['id']);
        $remove_vehicle = mysql_query("DELETE FROM vehicles WHERE uid = '".$edit_vehicle_id."'");
            if(!$remove_vehicle) {
                echo "Error: ".mysql_error()."<br>"; 
                exit();        
            }
    }
}
//END RELOAD AREA

// GET DATA FROM DB FOR USER LIST
if (!empty($_GET)){
    if (isset($_GET['sort']) && isset($_GET['type']) && !isset($_GET['letter'])){
        $mysql_sort = mysql_real_escape_string($_GET['sort']) ." ". mysql_real_escape_string($_GET['type']);
        $vehicles_SQL = mysql_query("SELECT * FROM vehicles LEFT JOIN players ON vehicles.pid = players.playerid ORDER BY ".$mysql_sort." ");
        //mysql_query() or die(mysql_error());
    }
    if (isset($_GET['sort']) && isset($_GET['type']) && isset($_GET['letter'])){
        $mysql_sort = mysql_real_escape_string($_GET['sort']) ." ". mysql_real_escape_string($_GET['type']);
        $mysql_letter = mysql_real_escape_string($_GET['letter']);
        if ($_GET['letter'] == 'special'){
            $vehicles_SQL = mysql_query("SELECT * FROM vehicles LEFT JOIN players ON vehicles.pid = players.playerid WHERE classname NOT RLIKE '^[A-Z]' ORDER BY ".$mysql_sort." ");    
        }
        else{
            $vehicles_SQL = mysql_query("SELECT * FROM vehicles LEFT JOIN players ON vehicles.pid = players.playerid WHERE classname LIKE '".$mysql_letter."%' ORDER BY ".$mysql_sort." ");
        }
            }
    if (isset($_GET['letter'] )&& !isset($_GET['sort']) && !isset($_GET['type'])){
        $mysql_letter = mysql_real_escape_string($_GET['letter']);
        if ($_GET['letter'] == 'special'){
            $vehicles_SQL = mysql_query("SELECT * FROM vehicles LEFT JOIN players ON vehicles.pid = players.playerid WHERE classname NOT RLIKE '^[A-Z]' ORDER BY cassname");    
        }
        else{
            $vehicles_SQL = mysql_query("SELECT * FROM vehicles LEFT JOIN players ON vehicles.pid = players.playerid WHERE classname LIKE '".$mysql_letter."%' ORDER BY classname");
        }
    }
}
else{
    $vehicles_SQL = mysql_query("SELECT * FROM vehicles LEFT JOIN players ON vehicles.pid = players.playerid ORDER BY classname");
    }          
//DISPLAY HTML CONTENT
startHTML();
?>
   <div class="container" style="padding-top: 60px;">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="index.php">Start</a></li>
                    <li class="active">Vehicle List</li>
                </ol>
            </div>
           
                
            <div class="panel panel-default">
                <div class="panel-heading"><span class='glyphicon glyphicon-user'></span> Vehicle List </div>
                <div class="panel-body">
                    <p>Here you can view, edit or remove Vehicles from your Server</p>
                    <ul class="pagination pagination-sm">
                            <li><a href="vehicles.php">All</a></li>
                            <li><a href="vehicles.php?letter=special">[/()\] 0-9</a></li>
                            <?php
                            $azRange = range('A', 'Z');
                            foreach ($azRange as $letter){
                            ?>
                            <li>
                                <a href="vehicles.php?letter=<?php echo $letter;?>"><?php echo $letter; ?></a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                </div>
            <table class="table table-hover">
                <tr>
                    <td><strong>#</strong> <a href="vehicles.php?sort=id&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="vehicles.php?sort=id&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Name</strong> <a href="vehicles.php?sort=classname&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-alphabet"></span></a><a href="vehicles.php?sort=classname&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span></a></td>
                    <td><strong>Type</strong> <a href="vehicles.php?sort=type&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="vehicles.php?sort=type&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Owner</strong> <a href="vehicles.php?sort=name&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="vehicles.php?sort=name&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Side</strong> <a href="vehicles.php?sort=side&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="vehicles.php?sort=side&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Alive</strong> <a href="vehicles.php?sort=alive&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="vehicles.php?sort=alive&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Active</strong> <a href="vehicles.php?sort=active&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="vehicles.php?sort=active&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Settings</strong></td>
                </tr>
                <?php while($row = mysql_fetch_object($vehicles_SQL)){ ?>
                <tr>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo "<a href='vehicle_detail.php?id=".$row->id."'>".htmlspecialchars($row->classname)."</a>";?></td>
                    <td><?php echo $row->type;?></td>
                    <td><?php echo "<a href='player_detail.php?uid=".$row->uid."'>".htmlspecialchars($row->name)."</a>";?></td>
                    <td><?php echo $row->side;?></td>
                    <td><?php echo $row->alive;?></td>
                    <td><?php echo $row->active;?></td>
                    <td><a href="vehicle_detail.php?id=<?php echo $row->id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a data-toggle="modal" href="vehicles.php#vehicles_delete_<?php echo $row->id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a></td>
                    
                </tr>
            
            </div>
            <!-- Modal Delete Vehicle -->
            <div class="modal fade" id="vehicles_delete_<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Delete <?php echo $row->classname;?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <form method="post" action="vehicles.php#vehicles_delete_<?php echo $row->uid;?>" role="form"> 
                                        <input type="hidden" name="type" value="delete" />
                                        <input type="hidden" name="id" value="<?php echo $row->id;?>" />
                                        <p>Do you realy want to delete the Vehicle "<?php echo $row->classname;?>" from the User <?php echo $row->name;?>?</p>                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" type="reset">Cancel</button>
                                <button class="btn btn-primary" type="submit">Delete Vehicle</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </table>
            </div>
</div>

<?php
closeHTML();
?>
       
