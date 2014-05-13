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
    // REMOVE USER
    if ($_POST['type'] == "delete"){
        $edit_player_id = intval($_POST['id']);
        $remove_player = mysql_query("DELETE FROM players WHERE uid = '".$edit_player_id."'");
            if(!$remove_player) {
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
        $player_SQL = mysql_query("SELECT * FROM players ORDER BY ".$mysql_sort." ");
        //mysql_query() or die(mysql_error());
    }
    if (isset($_GET['sort']) && isset($_GET['type']) && isset($_GET['letter'])){
        $mysql_sort = mysql_real_escape_string($_GET['sort']) ." ". mysql_real_escape_string($_GET['type']);
        $mysql_letter = mysql_real_escape_string($_GET['letter']);
        if ($_GET['letter'] == 'special'){
            $player_SQL = mysql_query("SELECT * FROM players WHERE name NOT RLIKE '^[A-Z]' ORDER BY ".$mysql_sort." ");    
        }
        else{
            $player_SQL = mysql_query("SELECT * FROM players WHERE name LIKE '".$mysql_letter."%' ORDER BY ".$mysql_sort." ");
        }
        //mysql_query() or die(mysql_error());
    }
    if (isset($_GET['letter'] )&& !isset($_GET['sort']) && !isset($_GET['type'])){
        $mysql_letter = mysql_real_escape_string($_GET['letter']);
        if ($_GET['letter'] == 'special'){
            $player_SQL = mysql_query("SELECT * FROM players WHERE name NOT RLIKE '^[A-Z]' ORDER BY name");    
        }
        else{
            $player_SQL = mysql_query("SELECT * FROM players WHERE name LIKE '".$mysql_letter."%' ORDER BY name");
        }
    }
}
else{
    $player_SQL = mysql_query("SELECT * FROM players ORDER BY name");
    }          
//DISPLAY HTML CONTENT
startHTML();
?>
   <div class="container" style="padding-top: 60px;">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="index.php">Start</a></li>
                    <li class="active">Player List</li>
                </ol>
            </div>
           
                
            <div class="panel panel-default">
                <div class="panel-heading"><span class='glyphicon glyphicon-user'></span> Player List </div>
                <div class="panel-body">
                    <p>Here you can view, edit or remove Players from your Server</p>
                    <ul class="pagination pagination-sm">
                            <li><a href="player.php">All</a></li>
                            <li><a href="player.php?letter=special">[/()\] 0-9</a></li>
                            <?php
                            $azRange = range('A', 'Z');
                            foreach ($azRange as $letter){
                            ?>
                            <li>
                                <a href="player.php?letter=<?php echo $letter;?>"><?php echo $letter; ?></a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                </div>
            <table class="table table-hover">
                <tr>
                    <td><strong>#</strong> <a href="player.php?sort=uid&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="player.php?sort=uid&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Name</strong> <a href="player.php?sort=PlayerName&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-alphabet"></span></a><a href="player.php?sort=PlayerName&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span></a></td>
                    <td><strong>Cash</strong> <a href="player.php?sort=cash&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="player.php?sort=cash&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Bank Account</strong> <a href="player.php?sort=bankacc&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="player.php?sort=bankacc&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Cop Level</strong> <a href="player.php?sort=coplevel&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="player.php?sort=coplevel&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Donator Level</strong> <a href="player.php?sort=donatorlvl&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="player.php?sort=donatorlvl&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Admin Level</strong> <a href="player.php?sort=adminlevel&type=ASC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes"></span></a><a href="player.php?sort=adminlevel&type=DESC<?php if(isset($_GET['letter'])) {echo "&letter=".$_GET['letter'];}?>" style="color:grey;"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a></td>
                    <td><strong>Settings</strong></td>
                </tr>
                <?php while($row = mysql_fetch_object($player_SQL)){ ?>
                <tr>
                    <td><?php echo $row->uid;?></td>
                    <td><?php echo "<a href='player_detail.php?uid=".$row->uid."'>".htmlspecialchars($row->name)."</a>";?></td>
                    <td><?php echo $row->cash;?></td>
                    <td><?php echo $row->bankacc;?></td>
                    <td><?php echo $row->coplevel;?></td>
                    <td><?php echo $row->donatorlvl;?></td>
                    <td><?php echo $row->adminlevel;?></td>
                    <td><a href="player_detail.php?uid=<?php echo $row->uid;?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a data-toggle="modal" href="player.php#player_delete_<?php echo $row->uid;?>" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a></td>
                    
                </tr>
            
            </div>
            <!-- Modal Delete Player -->
            <div class="modal fade" id="player_delete_<?php echo $row->uid;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Delete <?php echo $row->name;?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <form method="post" action="player.php#player_delete_<?php echo $row->uid;?>" role="form"> 
                                        <input type="hidden" name="type" value="delete" />
                                        <input type="hidden" name="id" value="<?php echo $row->uid;?>" />
                                        <p>Do you realy want to delete the User "<?php echo $row->name;?>"?</p>                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" type="reset">Cancel</button>
                                <button class="btn btn-primary" type="submit">Delete User</button>
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
       
