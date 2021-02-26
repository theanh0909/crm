<?php ob_start(); ?>
<?php
session_start();
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
require_once("../views/header_key_no_reg.php");
require_once("../Include/sidebar.php");
if(!isset($_SESSION["product"]) && !isset($_SESSION["key"])  && !isset($_SESSION["thanhvien"]) && !isset($_SESSION["date"])){
    $_SESSION["product"] = '';
    $_SESSION["key"] = 1;
    $_SESSION["thanhvien"]='';
    $_SESSION["date"] = date('m/Y');

}
if(isset($_POST['email'])){
    $email = $_POST['email'];
}
if(isset($_POST['loc'])){

    $_SESSION["product"] = $_POST['product_type'];
    $_SESSION["thanhvien"] = $_POST['thanhvien'];
    $_SESSION["date"] = $_POST['date'];
//     $product_type=$_POST['product_type'];
//     $key=$_POST['key_1'];
}
if(isset($_GET['page'])){
    $_SESSION['page'] = $_GET['page'];
}
else {
        $_SESSION['page'] = '';
}

?>

<div id='rightcolumn'>
    <h3 align="center" id="td_java"> THÔNG TIN KEY PHẦN MỀM </h3>
    <form action = "" method = "post">
        <tr>
                <td>Tên thành viên:</td>
                <td>
                    
                    <select class="thanhvien" name="thanhvien" >
                        <?php
                            $sql1 = "select * from user ";
                            $result1 = mysqli_query( $con, $sql1);
                             while ($row1 = mysqli_fetch_array($result1)) {
                        ?>
                        <option <?php if( isset($_SESSION["thanhvien"]) && $_SESSION["thanhvien"] == $row1['id']){ echo 'selected="selected"';}?>  value="<?php echo $row1['id'] ?>"><?php echo $row1['username'] ?></option>                                    
                        <?php
                             }
                        ?>
                    </select> 
                </td>
            </tr>   
        <tr>
                <td>Loại Key:</td>
                <td>                    
                    <select class="key" name="product_type" >
                        
                        <?php
                        $con = open_db();
                        $sql = "select product_type, name from product ";
                        $result = mysqli_query($con, $sql);
                         while ($row = mysqli_fetch_array($result)) {
                            ?>
                        <option <?php if( isset($_SESSION["product"]) && $_SESSION["product"]==$row['product_type']){ echo 'selected="selected"';$_SESSION["product_type"]=$row['name'];}?> value="<?php echo $row['product_type'] ?>"> <?php echo $row['name'] ?></option>           
                            <?php
                        }
                         ?>   
                    </select> 
                </td>
            </tr>  
            <tr>
                <td>Ngày:</td>
                <td>
                    
                    <select class="date" name="date" >
                        <?php
                            for($i=0;$i<5;$i++){                                
                                $date = time();
                                $t = date('m/Y',($date-$i*30 * 24 * 3600));
                                $date_act = date('Y-m',($date-$i*30 * 24 * 3600));
                            
                        ?>
                        <option <?php if( isset($_SESSION["date"]) && $_SESSION["date"] == $date_act){ echo 'selected="selected"';}?>  value="<?php echo $date_act;?>"><?php echo $t;?> </option>  
                            <?php } ?>
                        
                    </select> 
                </td>
            </tr>
             
            <tr><input type="submit" name="loc" value="Lọc >>"></tr>
    </form>
    <form action="send_mail.php" method="post">
        
        <?php
        $no_record_per_page = 25;
        $con = open_db();
        $total_record = array();
        $total_record = get_total_record_nv($_SESSION["product"],$_SESSION["thanhvien"],$_SESSION["date"]);
        echo 'Tổng số key:  '.$total_record[0].'</br>'.'    Tổng số key bán được:  '.$total_record[1].'</br>'.'     Số key còn lại:  '.$total_record[2];
        $total_page = ceil($total_record[1] / $no_record_per_page);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        manager_nv(($page-1) * $no_record_per_page, $no_record_per_page, $iduser, $permarr,$_SESSION["product"],$_SESSION["thanhvien"],$_SESSION["date"]);             
        ?>
        
    </form></div>
<?php ob_flush(); ?>
