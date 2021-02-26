<?php
ob_start();
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<div id="rightcolumn">
    <form method="post" action="">
        <h2 align="center" class="gxdh2">Thông tin tìm kiếm</h2>
        
        
        <?php
        //  $con = open_db();
        $keyword = isset($_POST['txt_last_running_days']) ? $_POST['txt_last_running_days'] : "";
        if($type=1){
        echo "<a title='In danh sách ' href='../extend/fill_registered.php?search=$keyword'><img style='margin-left:35px' src='../template/images/print.jpg' width='30' height='32' /></a>";
        }
        if ($keyword != "") {
            // echo "<p style='margin-left:10px'><b>Bạn hãy in danh sách trước khi xóa khách hàng: " . $total_record . " </b><a href='../extend/op_expire_date.php'><img src='../template/images/print.jpg' width='22' height='22' /></a>";
            search_license($iduser, $permarr, $keyword);
            // search_license_by($iduser, $permarr, $license_serial, $customer_name, $customer_email, $expire_days, $created_date, $last_running_days, 0 * 30, 30);
        }
		  if ($_POST['delete']) {

				if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                        $t = $_POST['chkid'];
                        foreach ($t as $key => $value) {
						
                            $deleteSQL = "delete from registered where id ='" . $value . "'";
                            $Result = mysqli_query($deleteSQL, $con);
                        }
                        if ($Result) {
                           // echo "Đã xóa ";
						    header('Location: http://giaxaydung.vn/kichhoat/views/mainresult.php?search='.$keyword);
                            // echo "<meta http-equiv = \"refresh\" content=\"0\">";
                        }
                    }
				}
        ?>
    </form>
</div>
<?php require_once("../Include/footer.php"); ?>
<?php ob_flush();
?>

