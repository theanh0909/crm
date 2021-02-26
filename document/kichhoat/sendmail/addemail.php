<?php session_start(); ?>
<?php ob_start(); ?>
<?php

require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once('../phpmailer/class.phpmailer.php');
require_once('../phpmailer/active_software.php');
$con = open_db();
$email = isset($_POST['email']) ? $_POST['email'] : "";
$title = isset($_POST['title']) ? $_POST['title'] : "";
$content = isset($_POST['message']) ? $_POST['message'] : "";
$status = isset($_POST['status']) ? $_POST['status'] : "";
$button = isset($_POST['add']) ? $_POST['add'] : "";
$time = time();
if (isset($_POST['add'])) {
    $r = add_email($email, $title, $content, $time, $status);
    if($r == TRUE){
        $sql = 'SELECT * FROM `email` ORDER BY id DESC';
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $id = $row['id'];
        if (isset($_POST['product'])){
            
                $con = open_db();

                $sql='UPDATE `email` SET `product`="'.$_POST['product'].'" WHERE id = '.$id;
                $result = mysqli_query($con, $sql);
                if (isset($_POST['default'])) {
                $sql='UPDATE `product` SET `email`='.$id.' WHERE product_type = "'.$_POST['product'].'"';
                $result = mysqli_query($con, $sql);
            }
        }
}
} else if (isset($_POST['send'])) {
    send_email($email, "", $title, $content);
}
?>
