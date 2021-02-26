
<?php require_once '../Include/header.php'; ?>
<?php require_once '../config/dbconnect.php'; ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<?php

$con = open_db();
$sql = "select * from email where id='$id'";
$result = mysql_query($sql, $con);
$row = mysqli_fetch_array($result);
?><?php

//1. Nhung tap tin fckeditor vao file chay
include("../template/fckeditor/fckeditor_php5.php");

//2. Khai bao duong dan URL den thu muc fckeditor
$sBasePath = '../template/fckeditor/';

//3. Khoi tao doi tuong FCKeditor
$oFCKeditor = new FCKeditor('message');
//4. Thiet lap duong den cho thuong BasePath
$oFCKeditor->Value =$row['content'];
        $oFCKeditor->BasePath = $sBasePath;

//Thay doi kich thuoc cua Editor
$oFCKeditor->Width = '100%';
$oFCKeditor->Height = 300;
$oFCKeditor->ToolbarSet = 'Default';
$oFCKeditor->Config['AutoDetectLanguage'] = false;
$oFCKeditor->Config['DefaultLanguage'] = 'en';
