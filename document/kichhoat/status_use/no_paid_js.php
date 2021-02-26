<?php
    require_once("../config/global.php");
    require_once("../model/registered.php");
    require_once '../config/site.php';
    require_once '../config/bitfield.php';
    get_infor_from_conf("../config/DB.conf");
    
    $con = open_db();
    if(isset($_POST['id'])){        
            $id = $_POST['id'];
            $sql1 = "UPDATE `license` SET Stt_sell = 0 WHERE `id` = '$id'";
            $result = mysqli_query($sql1, $con);
            
    }
	if(isset($_POST['iddel'])){        
           $iddel = $_POST['iddel'];
            $sql = "SELECT * FROM `license` WHERE `id` = ".$iddel;
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $license_key = str_replace("-","",$row['license_key']);
            $email_cus = $row['email_cus'];
            //echo $row['license_key'];
            
			
             $sql1 = "DELETE FROM `registered` WHERE `license_original` = '$license_key' and `customer_email` = '$email_cus'";
			 $sql2 = "DELETE FROM `license` WHERE id = $iddel";
            $result = mysqli_query($sql1, $con);
			$result = mysqli_query($sql2, $con);
    }