<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once '../Include/header.php'; ?>
<?php require_once '../Include/sidebar.php'; ?>
<?php require_once '../config/dbconnect.php'; ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<?php
if (!isset($_GET["act"]))
{
//If not isset -> set with dumy value
$_GET["act"] = "undefine";
} 
if ($_GET["act"] == "do") {
    $con = open_db();
    $status = isset($_POST['status']) ? $_POST['status'] : "";
    $status1 = isset($_POST['status1']) ? $_POST['status1'] : "";
    $status2 = isset($_POST['status2']) ? $_POST['status2'] : "";
    $status3 = isset($_POST['status3']) ? $_POST['status3'] : "";
    $status4 = isset($_POST['status4']) ? $_POST['status4'] : "";
    $status5 = isset($_POST['status5']) ? $_POST['status5'] : "";
    $status6 = isset($_POST['status6']) ? $_POST['status6'] : "";
    $status7 = isset($_POST['status7']) ? $_POST['status7'] : "";
    $status8 = isset($_POST['status8']) ? $_POST['status8'] : "";
    $status9 = isset($_POST['status9']) ? $_POST['status9'] : "";
    $status10 = isset($_POST['status10']) ? $_POST['status10'] : "";
    $sql = "UPDATE seting SET status='$status' WHERE id =1";
    $sql1 = "UPDATE seting SET status='$status1' WHERE id =2";
    $sql2 = "UPDATE seting SET status='$status2' WHERE id =3";
    $sql3 = "UPDATE seting SET status='$status3' WHERE id =4";
    $sql4 = "UPDATE seting SET status='$status4' WHERE id =5";
    $sql5 = "UPDATE seting SET status='$status5' WHERE id =6";
    $sql6 = "UPDATE seting SET status='$status6' WHERE id =7";
    $sql7 = "UPDATE seting SET status='$status7' WHERE id =8";
    $sql8 = "UPDATE seting SET status='$status8' WHERE id =9";
    $sql9 = "UPDATE seting SET status='$status9' WHERE id =10";
    $sql10 = "UPDATE seting SET status='$status10' WHERE id =11";
    $result = mysqli_query($con, $sql);
    $result1 = mysqli_query($sql1, $con);
    $result2 = mysqli_query($sql2, $con);
    $result3 = mysqli_query($sql3, $con);
    $result4 = mysqli_query($sql4, $con);
    $result5 = mysqli_query($sql5, $con);
    $result6 = mysqli_query($sql6, $con);
    $result7 = mysqli_query($sql7, $con);
    $result8 = mysqli_query($sql8, $con);
    $result9 = mysqli_query($sql9, $con);
    $result10 = mysqli_query($sql10, $con);

    if (!$result) {
        echo "!!!!!!!!!!!!!!!!!";
    } else {

        echo "<meta http-equiv = \"refresh\" content=\"0;URL=control.php\">";
    }
}
?>
<div id="rightcolumn">
    <form method="POST" action="control.php?act=do">
        <div class="user" style="width: 980px;">
            <h3 align="center">Hệ thống cung cấp key phần mềm</h3>
            <table  width="980" id = "edit">
                <tr>
                    <?php
                    $con = open_db();
                    $sql = "select * from seting where id=1";
                    $result = mysqli_query($con, $sql);
                    $st = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <td><label><?php echo $row['proceding']; ?></label></td>
                        <td><input name="<?php echo "status" . $st1 . ""; ?>" type = "radio" value="1"<?php
                            if ($row['status'] == 1) {
                                echo"checked";
                            }
                            ?>/>Yes</td>
                        <td><input name="<?php echo "status" . $st1 . ""; ?>" type = "radio" value="0" <?php
                            if ($row['status'] == 0) {
                                echo"checked";
                            }
                            ?> name="status"/>No</td>
                            <?php
                        }
                        ?>
                </tr>

            </table>
        </div>
        <div class="user" style="width: 980px;">

            <h3 align="center">Hệ thống email tự động</h3>
            <table width="980" id = "edit">
                <tr>                    
                    <?php
                    $con = open_db();
                    $sql = "select * from seting where id!=1";
                    $result = mysqli_query($con, $sql);
                    $st1 = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <td><label><?php echo $row['proceding']; ?></label></td>
                        <td><input name="<?php echo "status" . $st1 . ""; ?>" type = "radio" value="1"<?php
                            if ($row['status'] == 1) {
                                echo"checked";
                            }
                            ?> />Yes</td>
                        <td><input name="<?php echo "status" . $st1 . ""; ?>" type = "radio" value="0" <?php
                            if ($row['status'] == 0) {
                                echo"checked";
                            }
                            ?> />No</td>
                    </tr>
                    <?php
                    $st1++;
                }
                ?>
            </table>
        </div>
        <p align="center"><input  type="submit" value="Lưu lại"/></p>
    </form>
</div>
<?php require_once '../Include/footer.php'; ?>