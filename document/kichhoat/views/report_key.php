<?php ob_start(); ?>
<?php
session_start();
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
?>

<div id='rightcolumn'>
    <form action="" method="post">
        <h3 align="center"> THÔNG TIN KEY PHẦN MỀM </h3>
        <?php
        $no_record_per_page = 25;
        $con = open_db();
        $total_record = get_total_record();
        $total_page = ceil($total_record / $no_record_per_page);
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        get_licenses_from_db_ranges($page * $no_record_per_page, $no_record_per_page, $iduser, $permarr);
        echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
        ?>
        <?php require_once("../Include/footer.php");
        ?>
    </form></div>
<?php ob_flush(); ?>
