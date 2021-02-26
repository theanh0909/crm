<?php ob_start(); ?>
<?php
session_start();
require_once("../phpmailer/active_software.php");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
?>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" charset="UTF-8">
    $(document).ready(function () {
        $("#datepicker0").datepicker();
    });
    $(document).ready(function () {
        $("#datepicker").datepicker();
    });
    $(document).ready(function () {
        $("#datepicker1").datepicker();
    });
    $(document).ready(function () {
        $("#datepicker2").datepicker();
    });
    function Click($count) {
            alert("Bạn đã xóa "+$count+" bản ghi !");

 
}
</script>
<?php
$t = time();
$today = date('Y-m-d', ($t - 0 * 365 * 24 * 3600));
if (isset($_POST['clean1']) && $_POST['clean1'] == 'Xóa') {
    $con = open_db();
    if(isset($_POST['date0']) && $_POST['date0'] != ''){
        $date = date("Y-m-d", strtotime($_POST['date3']));
    }
    else{
        echo "<script>
                alert('Bạn chưa nhập đủ dữ liệu');
                window.location.href = 'http://localhost/kichhoat/views/clean.php';
            </script>";
    }
    $sql1 = "SELECT * FROM `registered` WHERE `license_expire_date` < '$date' "
            . "and registered.license_expire_date < '$today'";
    $result1 = mysqli_query($sql1, $con);
    $count = mysqli_num_rows($result1);
    $sql = "DELETE FROM `registered` WHERE `license_expire_date` < '$date' "
            . "and registered.license_expire_date < '$today'";
    $result = mysqli_query($con, $sql);

        if($result){
    echo "<script>
                Click($count)
            </script>";
    }
    else {
        echo "<script>
                alert('Không có bản ghi nào được xóa');
            </script>";
    }
}
if (isset($_POST['clean2']) && $_POST['clean2'] == 'Xóa') {
    $con = open_db();
      
    if(isset($_POST['date3']) && $_POST['date3'] != ''){
        $date = date("Y-m-d", strtotime($_POST['date3']));
    }
    else{
       echo "<script>
                alert('Bạn chưa nhập đủ dữ liệu');
                window.location.href = 'http://localhost/kichhoat/views/clean.php';
            </script>";
    }
    $sql = "SELECT registered.id FROM `registered`, `license` "
            . "WHERE registered.license_serial = license.license_serial "
            . "and license.status != 1 and registered.license_expire_date < '$date' "
            . "and registered.license_expire_date < '$today'";

    $array = array();
    $array = mysqli_query($con, $sql);
    $count = mysqli_num_rows($array);
    $id = '';

    while ($value = mysqli_fetch_array($array)) {
        $id = $id.','.$value['id'];
    }
    $id = trim($id, ',');

    $sql1 = 'DELETE FROM `registered` WHERE id IN (' . $id . ')';
    $result = mysqli_query($sql1, $con);
    if($result){
    echo "<script>
                Click($count)
            </script>";
    }
    else {
        echo "<script>
                alert('Không có bản ghi nào được xóa');
            </script>";
    }
}
if (isset($_POST['clean3']) && $_POST['clean3'] == 'Xóa') {
    $con = open_db();
    if(isset($_POST['date1']) && isset($_POST['date2']) && $_POST['date1'] != '' && $_POST['date2'] != ''){
        $date1 = date("Y-m-d", strtotime($_POST['date1']));
        $date2 = date("Y-m-d", strtotime($_POST['date2']));
    }
    else{
       echo "<script>
                alert('Bạn chưa nhập đủ dữ liệu');
                window.location.href = 'http://localhost/kichhoat/views/clean.php';
            </script>";
    }
    $date_b = date("Y-m-d", strtotime($date1));
    $date_f = date("Y-m-d", strtotime($date2));
    $sql = "SELECT * FROM `registered` WHERE `last_runing_date` < '$date_f' "
            . "and `last_runing_date` > '$date_b'"
            . " and `license_expire_date` < '$today' "
            . "ORDER BY `license_expire_date` ASC";
    $result = mysqli_query($con, $sql);
    $k = 0;
    while ($value = mysqli_fetch_array($result)) {
        $customer_email = $value['customer_email'];
        $customer_phone = $value['customer_phone'];
        $product_type = $value['product_type'];
        $sql1 = "SELECT `id`, `customer_phone`, `customer_email` FROM `registered` WHERE `customer_email` = '$customer_email'"
                . "AND `customer_phone` = '$customer_phone'"
                . "AND `product_type` = '$product_type'";
        $result1 = mysqli_query($sql1, $con);       
        $count = mysqli_num_rows($result1);
        if($count != 1 && $count != 0){
            $id = $value['id'];
            $sql3 = "DELETE FROM `registered` WHERE id = $id";
            $result3 = mysqli_query($sql3, $con);
            $k++ ;
        }
    }
    echo "<script>
                Click($k);
            </script>";
    
}
?>

<form action="" method="post">
    <label>Xóa khách hàng đã hết hạn trước ngày <input style="width: 80px" name="date0" id="datepicker0" /> </label><input style="margin-left: 10px" type="submit" name="clean1" value="Xóa"></br>
    <label>Xóa khách hàng sử dụng key dùng thử đã hết hạn trước ngày <input style="width: 80px" name="date3" id="datepicker2" /> </label><input style="margin-left: 10px" type="submit" name="clean2" value="Xóa"></br>
    <label>Xóa khách hàng trùng nhau từ ngày <input style="width: 80px" name="date1" id="datepicker" /> đến ngày <input style="width: 80px" name="date2" id="datepicker1" /> </label><input style="margin-left: 10px" type="submit" name="clean3" value="Xóa"></br>
</form>

