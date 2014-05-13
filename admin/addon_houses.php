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
//START RELOAD AREA
if (!empty($_POST)){
    $error_user = array();
    // REMOVE Vehicle
    if ($_POST['type'] == "delete"){
        $edit_house_id = intval($_POST['id']);
        $remove_house = mysql_query("DELETE FROM houses WHERE id = '".$edit_house_id."'");
            if(!$remove_house) {
                echo "Error: ".mysql_error()."<br>"; 
                exit();        
            }
    }
}
//END RELOAD AREA

// GET DATA FROM DB FOR Houses LIST
if (!empty($_GET)){
    if (isset($_GET['sort']) && isset($_GET['type']) && !isset($_GET['letter'])){
        $mysql_sort = mysql_real_escape_string($_GET['sort']) ." ". mysql_real_escape_string($_GET['type']);
        $houses_SQL = mysql_query("SELECT * FROM houses LEFT JOIN players ON houses.pid = players.playerid ORDER BY ".$mysql_sort." ");
        //mysql_query() or die(mysql_error());
    }
    
}
else{
    $houses_SQL = mysql_query("SELECT * FROM houses LEFT JOIN players ON houses.pid = players.playerid ORDER BY id");
    }          
//DISPLAY HTML CONTENT
startHTML();
?>
   <div class="container" style="padding-top: 60px;">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="index.php">Start</a></li>
                    <li><a href="index.php">Addons</a></li>
                    <li class="active">Houses List</li>
                </ol>
            </div>
           
                
            <div class="panel panel-default">
                <div class="panel-heading"><span class='glyphicon glyphicon-user'></span> Houses List </div>
                <div class="panel-body">
                    <p>Here you can view, edit or remove Houses from your Server</p>
                </div>
            <table class="table table-hover">
                <tr>
                    <td><strong>#</strong> <a href="addon_houses.php?sort=id&type=ASC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="addon_houses.php?sort=id&type=DESC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>House ID</strong> <a href="addon_houses.php?sort=house_id&type=ASC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-alphabet"></span></a><a href="addon_houses.php?sort=house_id&type=DESC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span></a></td>
                    <td><strong>Owner</strong> <a href="addon_houses.php?sort=name&type=ASC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="addon_houses.php?sort=name&type=DESC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Occupied</strong> <a href="addon_houses.php?sort=occupied&type=ASC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="addon_houses.php?sort=occupied&type=DESC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Locked</strong> <a href="addon_houses.php?sort=locked&type=ASC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="addon_houses.php?sort=locked&type=DESC" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Settings</strong></td>
                </tr>
                <?php while($row = mysql_fetch_object($houses_SQL)){ ?>
                <tr>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo "<a href='addon_house_detail.php?id=".$row->id."'>".$row->house_id."</a>";?></td>
                    <td><?php echo "<a href='player_detail.php?uid=".$row->uid."'>".htmlspecialchars($row->name)."</a>";?></td>
                    <td><?php echo $row->occupied;?></td>
                    <td><?php echo $row->locked;?></td>
                    <td><a href="house_detail.php?id=<?php echo $row->id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a data-toggle="modal" href="addon_houses.php#houses_delete_<?php echo $row->id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
            </div>
            <!-- Modal Delete House -->
            <div class="modal fade" id="houses_delete_<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Delete <?php echo $row->id;?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <form method="post" action="addon_houses.php#houses_delete_<?php echo $row->id;?>" role="form"> 
                                        <input type="hidden" name="type" value="delete" />
                                        <input type="hidden" name="id" value="<?php echo $row->id;?>" />
                                        <p>Do you realy want to delete the House ID "<?php echo $row->id;?>" from the User <?php echo $row->name;?>?</p>                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" type="reset">Cancel</button>
                                <button class="btn btn-primary" type="submit">Delete House</button>
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
       
