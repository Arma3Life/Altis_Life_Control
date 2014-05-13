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
    // CHECK EDIT
    if ($_POST['type'] == "edit"){
        $edit_user_id = $_POST['id'];
        if (empty ($_POST['new_username'])){
           $error_user['empty_user'] = $lang_de_error_portal_user_login_user_empty; 
        }
        else{
            $edit_user_name = $_POST['new_username'];    
        }
        if (empty ($_POST['new_email'])){
            $error_user['empty_email'] = $lang_de_error_empty_email;
        }
        else{
            $edit_user_email = $_POST['new_email'];
        }
        if (empty($_POST['new_password'])){
            $error_user['empty_password'] = $lang_de_error_empty_password;
        }
        else{
            $edit_user_password = $_POST['new_password'];
        }
        if (empty($_POST['new_password'])){
            $error_user['empty_password_2'] = $lang_de_error_empty_password_2;
        }
        else{
            $edit_user_password_2 = $_POST['new_password_2'];
        }
        if($edit_user_password_2 != $edit_user_password){
            $error_user['password_check'] = $lang_de_error_password_check;
        }
        
        if (empty($error_user)){
            $salt = rand_string("7");
            $edit_user_password = hash('sha256',$salt.$edit_user_password);          
            $update_user = mysql_query("UPDATE alc_login SET username = '".$edit_user_name."', password = '".$edit_user_password."', email = '".$edit_user_email."', salt = '".$salt."' WHERE id = '".$edit_user_id."'");
            if(!$update_user) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
        }
        
        
    }
    // REMOVE USER
    if ($_POST['type'] == "delete"){
        $edit_user_id = $_POST['id'];
        $remove_user = mysql_query("DELETE FROM alc_login WHERE id = '".$edit_user_id."'");
            if(!$remove_user) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            }
    }
    //CHECK AND ADD NEW
    if ($_POST['type'] == "new"){
        if (empty ($_POST['new_username'])){
           $error_user['empty_user'] = $lang_de_error_portal_user_login_user_empty; 
        }
        else{
            $new_user_name = $_POST['new_username'];    
        }
        if (empty ($_POST['new_email'])){
            $error_user['empty_email'] = $lang_de_error_empty_email;
        }
        else{
            $new_user_email = $_POST['new_email'];
        }
        if (empty($_POST['new_password'])){
            $error_user['empty_password'] = $lang_de_error_empty_password;
        }
        else{
            $new_user_password = $_POST['new_password'];
        }
        if (empty($_POST['new_password'])){
            $error_user['empty_password_2'] = $lang_de_error_empty_password_2;
        }
        else{
            $new_user_password_2 = $_POST['new_password_2'];
        }
        if($new_user_password_2 != $new_user_password){
            $error_user['password_check'] = $lang_de_error_password_check;
        }
        
        if (empty($error_user)){
            $salt = rand_string("7");
            $new_user_password = hash('sha256',$salt.$new_user_password);            
            $new_user_mysql = mysql_query("INSERT INTO alc_login SET id = NULL, username = '".$new_user_name."', password = '".$new_user_password."', email = '".$new_user_email."', salt = '".$salt."'");
            if(!$new_user_mysql) {
                echo "fehler: ".mysql_error()."<br>"; 
                exit();        
            } 
        }
    }
}
//END RELOAD AREA

// GET DATA FROM DB FOR USER LIST
$list_logins_SQL = mysql_query("SELECT * FROM alc_login");
$list_logins = array();
for ($i = 0; $i < mysql_num_rows($list_logins_SQL); $i++)
{
	// Get needed data from mysql
	$user_id = mysql_result($list_logins_SQL, $i, 0);
	$username = mysql_result($list_logins_SQL, $i, 1);
	$password = mysql_result($list_logins_SQL, $i, 2);
	$session_id = mysql_result($list_logins_SQL, $i, 3);
	$email = mysql_result($list_logins_SQL, $i, 4);
	$salt = mysql_result($list_logins_SQL, $i, 5);
        // Save into array for iteration
	$list_logins[$user_id] = array ($username, $password, $session_id, $email, $salt);
}
//DISPLAY HTML CONTENT
startHTML();
?>

    <div class="container" style="padding-top: 60px;">
           <!-- Error Check -->
            <?php if(!empty($error_user)&& $_POST['type'] == "edit"){ ?>
                    <script type="text/javascript">$(window).load(function(){
                        $('<?php echo "#user_edit_" .$edit_user_id;?>').modal('show');
                        });
                    </script> 
            <?php } ?>
            <?php if(!empty($error_user) && $_POST['type'] == "new"){ ?>
                    <script type="text/javascript">$(window).load(function(){
                        $('#user_new').modal('show');
                        });
                    </script> 
            <?php } ?>
            <!-- End Error Check --> 
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="index.php">Start</a></li>
                    <li><a href="#">Settings</a></li>
                    <li class="active">Manage Logins</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-md-8"></div> 
                <div class="col-md-4" style="padding-right: 0 !important;">
                    <p style="float:right;"><a data-toggle="modal" href="manage_login.php#user_new" ><button class="btn btn-default" style="float: right;"><span class="glyphicon glyphicon-plus"></span> Add User</button></a></p>
                </div>
            </div>
            <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading"><span class='glyphicon glyphicon-user'></span> Manage Logins </div>
                <div class="panel-body">
                    <p>Here you can add, edit or remove Users for DayZ Control</p>
                </div>
            <table class="table table-hover">
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>E-Mail</td>
                    <td>Settings</td>
                </tr>
                <?php foreach ($list_logins AS $id => $logins): ?>
                <tr>
                    <td><?php echo $id;?></td>
                    <td><?php echo $logins[0];?></td>
                    <td><?php echo $logins[3];?></td>
                    <td><a data-toggle="modal" href="manage_login.php#user_edit_<?php echo $id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a data-toggle="modal" href="manage_login.php#user_delete_<?php echo $id;?>" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
            
            </div>
            <!-- Modal Edit User -->
            <div class="modal fade" id="user_edit_<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit <?php echo $logins[0];?></h4>
                            </div>
                            <div class="modal-body">
                                <?php
                                // Errorausgabe
                                if (!empty($error_user)){
                                    echo "<div class='alert alert-danger'>";
                                    foreach($error_user as $output_error_schluessel => $output_error_wert){
                                        echo $output_error_wert." <br>";}
                                    echo" </div>";
                                }
                                ?>
                                <div class="form-group">
                                    <form method="post" action="manage_login.php#user_edit_<?php echo $id;?>" role="form"> 
                                        <input type="hidden" name="type" value="edit" />
                                        <input type="hidden" name="id" value="<?php echo $id;?>" />
                                        <label for="exampleInputEmail1">Username</label>
                                        <input type="text" class="form-control" name="new_username" value="<?php echo $logins[0];?>" />
                                        <label for="exampleInputEmail1">E-Mail</label>
                                        <input type="text" class="form-control" name="new_email" value="<?php echo $logins[3];?>" />
                                        <label for="exampleInputEmail1">New Password</label>
                                        <input type="password" class="form-control" placeholder="Enter Password" name="new_password" />
                                        <label for="exampleInputEmail1">Re-Enter new Password</label>
                                        <input type="password" class="form-control" placeholder="Re-Enter Password" name="new_password_2" />
                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Modal Delete User -->
            <div class="modal fade" id="user_delete_<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit <?php echo $logins[0];?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <form method="post" action="manage_login.php#user_edit_<?php echo $id;?>" role="form"> 
                                        <input type="hidden" name="type" value="delete" />
                                        <input type="hidden" name="id" value="<?php echo $id;?>" />
                                        <p>Do you realy want to delete the User "<?php echo $logins[0];?>"?</p>                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                                <button class="btn btn-primary" type="submit">Delete User</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     <?php endforeach; ?>
            </table>
            <!-- Modal NEW-->
            <div class="modal fade" id="user_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Create New User</h4>
                            </div>
                            <div class="modal-body">
                                <?php
                                // Errorausgabe
                                if (!empty($error_user)){
                                    echo "<div class='alert alert-danger'>";
                                    foreach($error_user as $output_error_schluessel => $output_error_wert){
                                        echo $output_error_wert." <br>";}
                                    echo" </div>";
                                }
                                ?>
                                <div class="form-group">
                                    <form method="post" action="manage_login.php#user_new" role="form"> 
                                        <input type="hidden" name="type" value="new" />
                                        <label for="exampleInputEmail1">Username</label>
                                        <input type="text" class="form-control" name="new_username" />
                                        <label for="exampleInputEmail1">E-Mail</label>
                                        <input type="text" class="form-control" name="new_email" />
                                        <label for="exampleInputEmail1">New Password</label>
                                        <input type="password" class="form-control" placeholder="Enter Password" name="new_password" />
                                        <label for="exampleInputEmail1">Re-Enter new Password</label>
                                        <input type="password" class="form-control" placeholder="Re-Enter Password" name="new_password_2" />
                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     </div>
</div>
<?php
closeHTML();
?>
       
