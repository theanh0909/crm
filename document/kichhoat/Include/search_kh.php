
<?php
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
global $no_record_per_page;
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$date = isset($_POST['txt_actived_date']) ? $_POST['txt_actived_date'] : "";
?>
<div style="width:90%; height:auto; padding: 8px; height: 40px; border: 1px solid #CCC; margin-left: 10px; background: seashell">
    <form  action = "../status_use/manager_dtoan.php" method = "post" name = "serch_bar_form">
        <table border = "0"  align="left">
            <tr>
                <td> Nhập ngày kích hoạt key</td>
                <td> <input  id="txt_actived_date" name = "txt_actived_date" value="<?php echo $date; ?>" type = "text" size = "80">
                </td>
                <td><a href='report_date.php&txt_actived_date=<?php echo $date; ?>'</a></td>
                <td> <input style=" height: 25px; width: 60px;padding:0 8px; background: yellowgreen; border: yellowgreen solid 1px" type="submit" value="Hiển thị"></td>
            </tr>
        </table>
    </form>
    <div id = "searchresult">	
    </div>
</div>





