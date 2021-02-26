<?php
session_start();
require_once("../config/dbconnect.php");
if(!isset($_SESSION["product"]) && !isset($_SESSION["key"])){
    $_SESSION["product"] = '';
    $_SESSION["key"] = '';
    die();
}
else $product_name= $_SESSION['product_type'];

$page_1 = $_SESSION['page'];
require_once("../config/dbconnect.php");
require_once("../phpmailer/active_software.php");
    require_once("../config/global.php");
	
	get_infor_from_conf("../config/DB.conf");
 $con = open_db();
if (isset($_POST['delete'])) {
                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                  
                    $t = $_POST['chkid'];
                    foreach ($t as $key => $value) {
                        
                        $deleteSQL = "delete from license where id ='" . $value . "'";
                        $Result = mysqli_query($deleteSQL, $con);
                        echo $value;
                    }
                    if ($Result) {
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php\">";
                    }
                }
            }
            
// file send.php
//Nhúng thư viện phpmailer
//require_once 'class.phpmailer.php';
$n=0;
$str="";
$mail="";
$key="";
for($n;$n<25;$n++)
{
$str="submit".$n;
$stragain="submitagain".$n;

$str_email="mail".$n;
$str_id="id".$n;
$str_key="key".$n;
$mail='';
$stlk_1="lk".$n;
$key='';
$id='';
    $sql = 'SELECT * FROM `email`,`product` WHERE product.name = "'.$product_name.'" and product.product_type = email.product';
    $result = mysqli_query($con, $sql);
    $count=  mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    if($count == 0){

        echo '<script type="text/javascript" charset="UTF-8">  
                           alert("Bạn cần thêm email mặc định cho phần mềm này");
                           </script>';
        die();
//                if($page_1 != ''){
//               header('Location: http://localhost/kichhoat/views/key_no_reg.php?page='.$page_1);
//           } else header('Location: http://localhost/kichhoat/views/key_no_reg.php');
    }
else $id1=$row['email'];
if(isset($_POST[$stragain])){
    if(isset($_POST['input'])){
       $mail=$_POST['input'];
    }else
    if($_POST[$str_email]!=""){
    $mail=$_POST[$str_email];
    }
	    if(isset($_POST[$stlk_1])){
        $text_lk='bản khóa mềm';
    }
    else $text_lk ='bản dùng thử';

    $key=$_POST[$str_key];
    $id=$_POST[$str_id];
    $con = open_db();

    $sql = 'SELECT * FROM `email` WHERE id = '.$id1;
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $title = $row['subjects'];
    $content = $row['content'];
    $content1 = str_replace( 'PASTE_KEY', $key, $content );

send_email_1($mail,$id ,$title, $content1);
}
if(isset($_POST[$str]))
{
if($_POST[$str_email]!=""){
$mail=$_POST[$str_email];
$stlk_1="lk".$n;
$key=$_POST[$str_key];
$id=$_POST[$str_id];

    if(isset($_POST[$stlk_1])){
        $text_lk='bản khóa mềm';
    }
    else $text_lk ='bản dùng thử';
	
$sql = 'SELECT * FROM `email` WHERE id = '.$id1;
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $title = $row['subjects'];
    $content = $row['content'];
    $content1 = str_replace( 'PASTE_KEY', $key, $content );
    send_email_1($mail,$id ,$title, $content1);
}
}
else{
    //echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php\">";
     if($page_1 != ''){
        header('Location: http://giaxaydung.vn/kichhoat/views/key_no_reg.php?page='.$page_1);
    } else header('Location: http://giaxaydung.vn/kichhoat/views/key_no_reg.php');
}
}
