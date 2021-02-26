<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("Include/header.php");
require_once("Include/sidebar.php");
?>