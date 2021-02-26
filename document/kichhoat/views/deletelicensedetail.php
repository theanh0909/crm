<?php ob_start(); ?>
<?php

session_start();
require_once("../Include/header.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");

$id = isset($_GET['id']) ? $_GET['id'] : "";
$st = isset($_GET['st']) ? $_GET['st'] : "";
$tab = isset($_GET['tab']) ? $_GET['tab'] : "";
//$license_serial = isset($_GET['license_serial']) ? $_GET['license_serial'] : "";
if ($id != "" && $st == "" && $tab == "") {
    $con = open_db();
    
    $sql = "select license_serial from registered where id = '$id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $license_serial = $row['license_serial'];
        mysqli_close();
        $no_computers_registered = check_no_computers($license_serial);

        //die($license_serial);
    }
    echo "<script language='JavaScript'> alert('Khách hàng đã được xóa',1,4);
               window.history.back(-1);
    </script>";
    delete_client_info($id, $license_serial);

    //header("Location : editlicense.php?id=" . $license_serial);
}
if ($id != "" && $st == 1 && $tab != '') {
    $con = open_db();
    $sql = "delete from n_registered where id = '$id'";
    $result = mysqli_query($con, $sql);
    
    echo "<script language='JavaScript'> 
        alert('Khách hàng đã được xóa',1,4);
               
    </script>";
    header("Location: ../status_use/khachhangchuakh.php#$tab");
    //header( "Refresh : 0 ; url = khachhangchuakh.php");
    //header('Location: '.$_SERVER['khachhangchuakh.php']);
    //header("Location : editlicense.php?id=" . $license_serial);
}

if ($id != "" && $st == 2 && $tab == '') {
    $con = open_db();
    $sql = "delete from registered where id = '$id'";

    $result = mysqli_query($con, $sql);
    
    echo "<script language='JavaScript'> 
        alert('Khách hàng đã được xóa',1,4);
               
    </script>";
    header("Location: ../views/province_customer.php");
    //header( "Refresh : 0 ; url = khachhangchuakh.php");
    //header('Location: '.$_SERVER['khachhangchuakh.php']);
    //header("Location : editlicense.php?id=" . $license_serial);
}

if ($id != "" && $st == 3 && $tab == '') {
    $con = open_db();
    $sql = "delete from n_registered where id = '$id'";

    $result = mysqli_query($con, $sql);
    
    echo "<script language='JavaScript'> 
        alert('Khách hàng đã được xóa',1,4);
               
    </script>";
    header("Location: ../views/province_customer.php");
    //header( "Refresh : 0 ; url = khachhangchuakh.php");
    //header('Location: '.$_SERVER['khachhangchuakh.php']);
    //header("Location : editlicense.php?id=" . $license_serial);
}
?>

<?php
    
    ob_flush(); 
   ?>