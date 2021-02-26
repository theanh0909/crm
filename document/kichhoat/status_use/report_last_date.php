<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
$date = date("Y-m-d");
$date = time();
$t = date('Y-m-d', ($date - 1 * 24 * 3600));
//echo '<p align="right"><a href="../extend/out_put.php"><img src="../template/images/print.jpg" width="20" height="20" /></a></p>';
$no_record_per_page = 35;
$con = open_db();
//if ($permarr['viewallregistered']) {
//    $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t'";
//    $result = mysqli_query($con, $sql);
//    $row = mysqli_fetch_array($result);
//    $total_record = $row['tmp'];
//    $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DutoanGXD'";
//    $result1 = mysqli_query($sql1, $con);
//    $row1 = mysqli_fetch_array($result1);
//    $total_record1 = $row1['tmp'];
//    $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DuthauGXD'";
//    $result2 = mysqli_query($sql2, $con);
//    $row2 = mysqli_fetch_array($result2);
//    $total_record2 = $row2['tmp'];
//} else {
//    if ($permarr['viewregistered']) {
//        $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and license.id_user='$iduser'";
//        $result = mysqli_query($con, $sql);
//        $row = mysqli_fetch_array($result);
//        $total_record = $row['tmp'];
//        $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DutoanGXD' and license.id_user='$iduser'";
//        $result1 = mysqli_query($sql1, $con);
//        $row1 = mysqli_fetch_array($result1);
//        $total_record1 = $row1['tmp'];
//        $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DuthauGXD'and license.id_user='$iduser'";
//        $result2 = mysqli_query($sql2, $con);
//        $row2 = mysqli_fetch_array($result2);
//        $total_record2 = $row2['tmp'];
//    }
//}
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
?>
<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".tabContents").hide(); // Ẩn toàn bộ nội dung của tab
        $(".tabContents:first").show(); // Mặc định sẽ hiển thị tab1

        $("#tabContaier ul li a").click(function() { //Khai báo sự kiện khi click vào một tab nào đó

            var activeTab = $(this).attr("href");
            $("#tabContaier ul li a").removeClass("active");
            $(this).addClass("active");
            $(".tabContents").hide();
            $(activeTab).fadeIn();
        });
    });
</script>
<div id="rightcolumn">
    <h3 class="gxdh2"  align="center"> THÔNG TIN KHÁCH HÀNG ĐĂNG KÝ MỘT NGÀY TRƯỚC<a href='../extend/out_put_ld.php'><img src='../template/images/print.jpg' width='22' height='22' /></a></h3>
    <?php require_once("../Include/search_kh.php"); ?>
    <div id="tabContaier">
        <ul>
            <?php
            $sqlP = "select name from product";
            $resultP = mysqli_query($con, $sqlP);
            $i = 0;
            while ($rowP = mysqli_fetch_array($resultP)) {
                $nameP = $rowP['name'];
                $i++;
                ?>
                <li><a href="#tab<?= $i ?>"><?= $nameP ?></a></li>
            <?php } ?>
        </ul>
        <div class="tabDetails">
            <?php
            $sqlP1 = "select product_type,name from product";
            $resultP1 = mysqli_query($sqlP1, $con);
            $n = 0;
			mysqli_close($con);
			
            while ($rowP1 = mysqli_fetch_array($resultP1)) {
				$con = open_db();
                $product_typeP = $rowP1['product_type'];
				$product_name = $rowP1['name'];
                $sql = "select count(*) as tmp from registered, license where registered.product_type='$product_typeP' and license.status=1 and registered.license_serial=license.license_serial and license_activation_date='$date'";
				//$sql = "select count(*) as tmp from registered where registered.product_type='$product_typeP'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                $total_record = $row['tmp'];
                $n++;
                ?>
                <div id="tab<?= $n ?>" class="tabContents">
                    <?php
					mysqli_close($con);
                    get_registered_from_db_ranges_lastdate($iduser, $permarr, $product_typeP, $page * $no_record_per_page, $no_record_per_page);
					//get_registered_last_date($iduser, $permarr, $product_typeP, $page * $no_record_per_page, $no_record_per_page);
                        echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
                    ?>
				<a href="export_excel_.php?product=<?php echo $product_typeP; ?>&name=<?php echo $product_name; ?>&date=<?php echo $t; ?>&st=0" target="_blank"> xuất ra excel  </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
require_once("../Include/footer.php");
ob_flush();
?>
