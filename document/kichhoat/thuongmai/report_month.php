<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
//echo '<p align="right"><a href="../extend/out_putmonth.php"><img src="../template/images/print.jpg" width="25" height="25" /></a></p>';
$no_record_per_page = 25;
$con = open_db();
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
    <form action="" method="post">
        <h3  align="center" class="gxdh2"> THÔNG TIN KHÁCH HÀNG ĐĂNG KÝ TRONG THÁNG <a href='../extend/out_putmonth.php'><img src='../template/images/print.jpg' width='22' height='22' /></a></h3>
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
				mysqli_close();
                while ($rowP1 = mysqli_fetch_array($resultP1)) {
				$con = open_db();
                    $product_typeP = $rowP1['product_type'];
                    $n++;
                    ?>
                    <div id="tab<?= $n ?>" class="tabContents">
                        <?php
						mysqli_close();
                        get_registered_in_month_tm($iduser, $permarr, $product_typeP, $page * $no_record_per_page, $no_record_per_page);
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
<?php ob_flush(); ?>
