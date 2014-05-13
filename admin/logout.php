<?php
$_SESSION['login_user'] = "";
$_SESSION['login_pswd'] = "";
$_SESSION['login_id'] = "";
session_destroy();
session_regenerate_id(true);
header('Location: ../index.php');

