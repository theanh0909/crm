<?php
session_start();
require_once("../config/global.php");
require_once("function.php");
get_infor_from_conf("../config/DB.conf");
require_once("../config/dbconnect.php");
if(isset($_POST['customer_name']) && isset($_POST['address']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['date']) && isset($_POST['key'])){
    $con = open_db();
    $Date = date("Y-m-d", strtotime($_POST['date']));
    $note = isset($_POST['note']) ? $_POST['note'] : "";
    $sql='SELECT * FROM `tbl_note` WHERE `key` = "'.$_POST["key"].'" and `email` = "'.$_POST["email"].'"';
    $Result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($Result);
    if($count != 0){
       $sql ='UPDATE `tbl_note` SET `time`="'.$Date.'", `note`="'.$note.'" WHERE `key` = "'.$_POST["key"].'" and `email` = "'.$_POST["email"].'"';
       echo $sql;
       $Result = mysqli_query($con, $sql);
    }else{
    $sql='INSERT INTO `tbl_note`(`user`, `key`, `time`, `status`,`email`,`note`) VALUES ("'.$_SESSION['username'].'","'.$_POST['key'].'","'.$Date.'",1,"'.$_POST['email'].'","'.$note.'")';
    $Result = mysqli_query($con, $sql);
}
}
   else    echo 'Không thành công';
?>
