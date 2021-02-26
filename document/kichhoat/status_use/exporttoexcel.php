<?php  
$name_table='export';
if(isset($_POST['name_table'])){
    $name_table=    $_POST['name_table'];
    
}
header('Content-Type: application/force-download');  
header('Content-disposition: attachment; filename='.$name_table.'.xls');  
// Fix for crappy IE bug in download.  
header("Pragma: ");  
header("Cache-Control: ");  
echo $_REQUEST['datatodisplay'];  
?>  

