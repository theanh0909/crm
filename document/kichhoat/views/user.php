<?php ob_start(); ?>
<?php
session_start();
require_once("../model/user.php");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
?>
<div id="rightcolumn">
    <form action="" method="post">
        <?php
        echo" <h2 align='center' class='gxdh2'>DANH SÁCH THÀNH VIÊN  </h1> ";
        get_user_from_db_ranges($page * $no_record_per_page, $no_record_per_page);
        echo '</br>';
        ?>
    </form>
</div>
<?php
require_once("../Include/footer.php");
?>
<?php ob_flush(); ?>
