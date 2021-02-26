<?php
require_once '../config/dbconnect.php';
require_once '../config/global.php';
get_infor_from_conf("../config/DB.conf");
$id = preg_replace("/'\/<>\"/", "", $_GET['id']);
if (empty($id))
    die("Invalid ID");
$link = "SELECT * FROM users WHERE id='$id'";
$res = mysqli_query($link) or die(mysqli_error());
$r = mysqli_fetch_assoc($res);

if ($r['status'] == "subscribed")
    $up = "un";
elseif ($r['status'] == "un")
    $up = "subscribed";

$link = "UPDATE users SET status='$up' WHERE id='$id'";
$res = mysqli_query($link) or die(mysqli_error());
if ($res)
    die("Updated.<br />Click <a href='index.php'>here</a> to go back.");
?>