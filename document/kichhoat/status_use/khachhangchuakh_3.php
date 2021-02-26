<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
//$date = date("d-m-Y");
$date1 = time();
$t = date('Y-m-d',($date1-3* 24 * 3600));
$no_record_per_page = 35;
$con = open_db();
$date = date("Y-m-d");
?>
<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var hashes = window.location.href;
        $(".tabContents").hide(); // Ẩn toàn bộ nội dung của tab
        if(hashes.indexOf("tab") > -1)
        {
            hashes = window.location.href.slice(window.location.href.indexOf('#') + 1).split('&');
             $("#"+hashes).show();
        }else{
            $(".tabContents:first").show(); // Mặc định sẽ hiển thị tab1
        }

        $("#tabContaier ul li a").click(function() { //Khai báo sự kiện khi click vào một tab nào đó

            var activeTab = $(this).attr("href");
            $("#tabContaier ul li a").removeClass("active");
            $(this).addClass("active");
            $(".tabContents").hide();            
            $(activeTab).fadeIn();
        });
        
       

    });
    
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
            });
        });
    });
</script>
<!--<script type="text/javascript">
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
</script>-->
<div id="rightcolumn">

    <?php
    echo "<h3  align='center' class ='gxdh2'>KHÁCH HÀNG CHƯA KÍCH HOẠT " . $t . "</h3>";
    require_once("../Include/search_kh.php");
    ?>
    <div id="tabContaier">
        <ul>
            <?php
            $sqlP = "select name from product";
            $resultP = mysql_query($sqlP, $con);
            $i = 0;
            while ($rowP = mysql_fetch_array($resultP)) {
                $nameP = $rowP['name'];
                $i++;
                ?>
                <li><a href="#tab<?= $i ?>"><?= $nameP ?></a></li>
            <?php } ?>
        </ul>
        <form action="" method="post">
            <div class="tabDetails">
                <?php
                $sqlP1 = "select product_type,name from product";
                $resultP1 = mysql_query($sqlP1, $con);
                $n = 0;
				mysql_close($con);
				
                while ($rowP1 = mysql_fetch_array($resultP1)) {
					$con = open_db();
                    $product_typeP = $rowP1['product_type'];
					$product_name = $rowP1['name'];
                    $sql = "select * from n_registered where product_type='$product_typeP'";
                    $result = mysql_query($sql, $con);
                    $row = mysql_fetch_array($result);
                   // $total_record = $row['tmp'];
                    //$total_page = ceil($total_record / $no_record_per_page);
                    $page = isset($_GET['page']) ? $_GET['page'] : 0;
                    $n++;
                    ?>
                    <div id="tab<?= $n ?>" class="tabContents">
                        <?php
			mysql_close($con);
                        //get_n_registered($product_typeP);
						get_n_registered($product_typeP,$n,$t);
                        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
                        ?>
						 <a href="export_excel.php?product=<?php echo $product_typeP; ?>&name=<?php echo $product_name; ?>&date=<?php echo $t; ?>" target="_blank"> xuất ra excel  </a>
                    </div>
                <?php } ?>
            </div>
        </form>
    </div>
</div>
<?php
require_once("../Include/footer.php");
?>
<?php ob_flush(); ?>
