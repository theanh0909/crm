<?php ob_start(); ?>
<style>
	#listcheck {
    width: 900px;
}
</style>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
//if(isset($_POST['ok']) && isset($_POST['id'])){
//    if($_POST['id'] != ''){
//        $id = $_POST['id'];
//        $sql1 = "UPDATE `kichhoat`.`license` SET Stt_sell = 0 WHERE `id` = '$id'";
//        $result = mysqli_query($sql1, $con);
//    }
//}
//if(isset($_POST['del']) && isset($_POST['id'])){
//    if($_POST['id'] != ''){
//        $id = $_POST['id'];
//        $sql1 = "DELETE FROM `license` WHERE `id` = '$id'";
//        $result = mysqli_query($sql1, $con);
//    }
//}
//if(isset($_POST['id'])){
//    $id = $_POST['id'];
//    $ok='ok'.$id;
//    $del = 'del'.$id;
//    if(isset($_POST[$ok])){
//        echo    $sql1 = "UPDATE `kichhoat`.`license` SET Stt_sell = 0 WHERE `id` = '$id'";
//        die();
//        $result = mysqli_query($sql1, $con);
//    }
//    echo $ok;
//}
?>
<script>
    function call_ok(id){
       var person = confirm("Khách hàng đã thanh toán?");
        if (person) { 
                $.post( "no_paid_js.php", { id: id })
                .done(function( data ) {
                  alert( "Data Loaded: " + data );
                });
                window.location.replace("http://giaxaydung.vn/kichhoat/status_use/no_paid.php");
        }
    }
	function call_del(id){
       var person = confirm("Xóa khách hàng");
        if (person) { 
                $.post( "no_paid_js.php", { iddel: id })
                .done(function( data ) {
                  alert( "Data Loaded: " + data );
                });
                window.location.replace("http://localhost/kichhoat/status_use/no_paid.php");
        }
    }
</script>
<div id = "rightcolumn">
    <form action = "" method = "post" >
        <h3  align='center'>Khách hàng chưa thanh toán</h3>
        <?php
        
        no_paid();
       
         
        ?>
         
    </form>
   
    <?php
    require_once("../Include/footer.php");
    ?>
</div>
<?php ob_flush(); ?>
