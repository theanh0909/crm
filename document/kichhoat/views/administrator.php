<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">
</script>
<script>
    $(document).ready(function() {
        $(".btn1").click(function() {
            $("#view1").slideToggle();
            $(".btn1").hide();
            $(".btn2").show();
        });
        $(".btn2").click(function() {
            $("#view1").slideToggle();
            $(".btn").show();
            $('.btn2').hide();
        });
    });
    $(document).ready(function() {
        $(".btn3").click(function() {
            $("#view1").slideToggle();
            $(".btn3").hide();
            $(".btn4").show();
        });
        $(".btn4").click(function() {
            $("#view2").slideToggle();
            $(".btn3").show();
            $('.btn4').hide();
        });
    });
</script>
<div class="rightcolumn">
    <div class="user" style="width: 980px;">
        <h3 align="center">Tin mới nhất</h3>
        <?php
        $con = open_db();
        $sql = "select * from post ORDER BY id DESC LIMIT 0,2";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            echo "<b>$row[title]</b>";
            $chuoi = $row['description'];
            $new_chuoi = '';
            $mang = explode(' ', $row['description']);
            foreach ($mang as $k => $v) { 
                if (strlen($new_chuoi . $v) < 1000) {
                    $new_chuoi.=$v . ' ';
                } else {
                    break;
                }
            }
            echo "<p>$new_chuoi<button class='btn'>Đọc tiếp</button> ";
            $new_chuoi1 = substr($row['description'], strlen($new_chuoi));
            echo "<div id='view1' style='display:none'>$new_chuoi1<button class='btn2'>Rút gọn</button></div></p>";
        }
        ?>
    </div>
</div>
<?php
require_once("../Include/footer.php");
?>


<?php ob_flush(); ?>
