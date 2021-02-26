<script>
    function error(){
        alert('Upload không thành công');
        window.location.replace("http://giaxaydung.vn/kichhoat/views/administrator.php");
    }
</script>
<?php
require_once("../Include/header.php"); 
require_once("../Include/sidebar.php"); 
require_once("../model/license.php");
/************************ YOUR DATABASE CONNECTION START HERE   ****************************/
echo '<head> <meta charset="UTF-8"> </head>';
define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "root"); // set database user
define ("DB_PASS",""); // set database password
define ("DB_NAME",""); // set database name

$link = mysqli_connect('localhost', 'giaxaydung_key', 'Chuyen_QuaMail_Kichhoat_1210201375') or die("Couldn't make connection.");
$db = mysqli_select_db('giaxaydung_key', $link) or die("Couldn't select database");

$databasetable = "license";

/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'php/Classes/PHPExcel/IOFactory.php';

$storagename = "KEY_GXD.xls";
// This is the file path to be uploaded.
$inputFileName = '../files/'.$storagename; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$query="SELECT license_key FROM license";
$sql = mysqli_query($query,$link);
$n=  mysqli_num_rows($sql);
$arr= array();
$key_fail = array();
$k=0;
$msg='';
 while ($row = mysqli_fetch_array($sql)) {
        $arr[]=$row['license_key'];
}

for($i=3;$i<=$arrayCount;$i++){
    $license_serial = trim($allDataInSheet[$i]["A"]);
    if($license_serial != 'license_serial'){
        $license_key = trim($allDataInSheet[$i]["B"]);
        $license_is_registered = trim($allDataInSheet[$i]["C"]);
        $license_created_date = trim($allDataInSheet[$i]["D"]);
        $type_expire_date = trim($allDataInSheet[$i]["E"]);
        $hardware_id = NULL;
        $license_no_instance= trim($allDataInSheet[$i]["H"]);
        $license_no_computers= trim($allDataInSheet[$i]["G"]);
        $product_type= trim($allDataInSheet[$i]["F"]);
        $iduser= trim($allDataInSheet[$i]["J"]);
        $status= trim($allDataInSheet[$i]["I"]);
if($license_key == '' || $license_is_registered == '' || $license_created_date == '' || $type_expire_date == '' || $license_no_instance=='' || $license_no_computers == '' || $product_type == '' || $iduser == '' || $status == ''){
            echo '<script type="text/javascript">'
                    , 'error();'
                    , '</script>'
;
        }
//    echo $license_key;
//    echo $i;
//    die();
//$userName = trim($allDataInSheet[$i]["A"]);
//$userMobile = trim($allDataInSheet[$i]["B"]);

//$query = "SELECT * FROM test WHERE name = '".$userName."' and tel = '".$userMobile."'";
//$sql = mysqli_query($query);
//$recResult = mysqli_fetch_array($sql);
//$existName = $recResult["name"];
$kt=0;
for($j=0;$j<$n;$j++){
    if($license_key==$arr[$j]){
        $kt=1;
        $key_fail[$k] = $license_key;        
        $k++;
        break;
    }
}
if($kt==0) {
//$insertTable= mysqli_query("insert into test (name, tel) values('".$userName."', '".$userMobile."');");
    add_license_to_db($license_serial, $license_key, 0, $license_created_date, $type_expire_date, 'NA', $license_no_instance, $license_no_computers, $product_type, $iduser, $status,'NA');
$msg = 'Record has been added. <div style="Padding:20px 0 0 0;"><a href="http://www.discussdesk.com/import-excel-file-data-in-mysql-database-using-PHP.htm" target="_blank">Go Back to tutorial</a></div>';
} 
}
}
if($key_fail[0] != '')
{
//$msg = 'Record already exist. <div style="Padding:20px 0 0 0;"><a href="http://www.discussdesk.com/import-excel-file-data-in-mysql-database-using-PHP.htm" target="_blank">Go Back to tutorial</a></div>';
        echo 'KEY BỊ TRÙNG:'.'</br>';
        for($n=0;$n<$k;$n++){
            echo $key_fail[$n].'</br>';
        }
}
if($msg!=''){
echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";
}
?>