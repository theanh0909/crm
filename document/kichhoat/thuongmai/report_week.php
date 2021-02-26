<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
//echo '<p align="right"><a href="../extend/out_putweek.php"><img src="../template/images/print.jpg" width="20" height="20" /></a></p>';
$no_record_per_page = 25;
$con = open_db();
//$date = date('Y-m-d');
//while (date('w', strtotime($date)) != 1) {
//    $tmp = strtotime('-1 day', strtotime($date));
//    $date = date('Y-m-d', $tmp);
//}
//$week = date('W', strtotime($date));
//if ($permarr['viewallregistered']) {
//    $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week'";
//    $result = mysqli_query($con, $sql);
//    $row = mysqli_fetch_array($result);
//    $total_record = $row['tmp'];
//    $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week' and registered.product_type='DutoanGXD'";
//    $result1 = mysqli_query($sql1, $con);
//    $row1 = mysqli_fetch_array($result1);
//    $total_record1 = $row1['tmp'];
//    $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week' and registered.product_type='DuthauGXD'";
//    $result2 = mysqli_query($sql2, $con);
//    $row2 = mysqli_fetch_array($result2);
//    $total_record2 = $row2['tmp'];
//} else {
//    if ($permarr['viewregistered']) {
//        $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week' and license.id_user='$iduser'";
//        $result = mysqli_query($con, $sql);
//        $row = mysqli_fetch_array($result);
//        $total_record = $row['tmp'];
//        $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week' and registered.product_type='DutoanGXD' and license.id_user='$iduser'";
//        $result1 = mysqli_query($sql1, $con);
//        $row1 = mysqli_fetch_array($result1);
//        $total_record1 = $row1['tmp'];
//        $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week' and registered.product_type='DuthauGXD'and license.id_user='$iduser'";
//        $result2 = mysqli_query($sql2, $con);
//        $row2 = mysqli_fetch_array($result2);
//        $total_record2 = $row2['tmp'];
//    }
//}
//mysqli_close($con);
//$total_page = ceil($total_record / $no_record_per_page);
//$page = isset($_GET['page']) ? $_GET['page'] : 0;
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
    <form method="post" action="">
        <h3  class="gxdh2" align="center"> THÔNG TIN KHÁCH HÀNG ĐĂNG KÝ TRONG TUẦN</h3>
        <div id="tabContaier">
            <ul>
                <?php
                $sqlP = "select name from product";
                $resultP = mysqli_query($sqlP, $con);
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
                $sqlP1 = "select product_type from product";
                $resultP1 = mysqli_query($sqlP1, $con);
                $n = 0;
                while ($rowP1 = mysqli_fetch_array($resultP1)) {
                    $product_typeP = $rowP1['product_type'];
                    $n++;
                    ?>
                    <div id="tab<?= $n ?>" class="tabContents">
                        <?php
                        get_registered_in_week_tm($iduser, $permarr, $product_typeP, $page * $no_record_per_page, $no_record_per_page);
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </form>
</div>
<?php
require_once("../Include/footer.php");
?>
</div>
<?php ob_flush(); ?>
