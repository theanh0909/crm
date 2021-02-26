<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../model/product.php"); ?>
<?php
	$page = isset($page) ? $page : 1;
?>
<div id="rightcolumn">
    <form action="" method="post">
        <?php
        echo" <h2 align='center' class='gxdh2'>DANH SÁCH PHẦN MỀM  </h1> ";
        viewtproduct($page * $no_record_per_page, $no_record_per_page, $permarr);
        echo '</br>';
        ?>
    </form>
</div>
<?php
require_once("../Include/footer.php");
?>
<?php ob_flush(); ?>