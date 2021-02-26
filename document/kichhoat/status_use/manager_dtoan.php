<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
$date = isset($_POST['txt_actived_date']) ? $_POST['txt_actived_date'] : "";
?>
<div id="rightcolumn">
    <h2 align="center" class="gxdh2">Key được kích hoạt trong ngày <?php echo $date ?></h2>
    <div class="report_left">
        <div class="left">
            <p > Tổng số key Dự toán đã được kích hoạt : <b style="color:#FF00FF"><?php
                    $con = open_db();
                    if ($permarr['viewallregistered']) {
                        $sql = "select count(*) as tmp from registered where product_type='DutoanGXD'";
                    } else {
                        if ($permarr['viewregistered']) {
                            $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and registered.product_type='DutoanGXD' and license.id_user='$iduser'";
                        }
                    }
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($result);
                    $count = $row['tmp'];
                    mysqli_close($con);
                    echo "$count";
                    ?></b>
            </p>
            <p > Tổng số key Dự toán đã kích hoạt trong ngày <?php echo $date ?> : <b style="color:#FF00FF"><?php
                    $con = open_db();
                    if ($permarr['viewallregistered']) {
                        $sql = "select count(*) as tmp from registered where product_type='DutoanGXD' and license_activation_date='$date'";
                    } else {
                        if ($permarr['viewregistered']) {
                            $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and registered.product_type='DutoanGXD' and license_activation_date='$date' and license.id_user='$iduser'";
                        }
                    }
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($result);
                    $count = $row['tmp'];
                    mysqli_close($con);
                    echo "$count";
                    ?></b>
            </p>
        </div>
        <div class="right">
            <p > Tổng số key Dự thầu đã được kích hoạt : <b style="color:#FF00FF"><?php
                    $con = open_db();
                    if ($permarr['viewallregistered']) {
                        $sql = "select count(*) as tmp from registered where product_type='DuthauGXD'";
                    } else {
                        if ($permarr['viewregistered']) {
                            $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and registered.product_type='DuthauGXD' and license.id_user='$iduser'";
                        }
                    }
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($result);
                    $count = $row['tmp'];
                    mysqli_close($con);
                    echo "$count";
                    ?></b>
            </p>

            <p > Tổng số key Dự thầu đã kích hoạt trong ngày <?php echo $date ?> : <b style="color:#FF00FF"><?php
                    $con = open_db();
                    if ($permarr['viewallregistered']) {
                        $sql = "select count(*) as tmp from registered where product_type='DuthauGXD' and license_activation_date='$date'";
                    } else {
                        if ($permarr['viewregistered']) {
                            $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and registered.product_type='DuthauGXD' and license_activation_date='$date' and license.id_user='$iduser'";
                        }
                    }
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($result);
                    $count = $row['tmp'];
                    mysqli_close($con);
                    echo "$count";
                    ?></b>
            </p>	

        </div>      
    </div>
    <?php
    if ($date != "") {
        search_license_date($iduser, $permarr, $date);
    }
    ?>
</div>
<?php require_once("../Include/footer.php") ?>
<?php ob_flush(); ?>
