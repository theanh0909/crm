<?php ob_start(); ?> 
<?php session_start(); ?>
<?php
require_once '../config/dbconnect.php';
require_once '../config/global.php';
get_infor_from_conf("../config/DB.conf");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Chuyển key</title>
    </head>
    <?php
    $iduser = isset($_POST['username']) ? $_POST['username'] : "";
    $so = isset($_POST['key']) ? $_POST['key'] : "";
    $con = open_db();
    $sql = "update license set id_user = $iduser ORDER BY id DESC LIMIT $so";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo "Đã chuyển thành công";
        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_key.php\">";
    } else {
        echo "Đã có lỗi xảy ra bạn hãy nhập lại thông tin";
    }
    mysqli_close();
    ?>
    <body style="background:  #D1DCEB">
        <form action="" method="post">
            <p>Chuyển key cho user</p>
            <select name="username" style="width:140px; height:30px;">
                <?php
                $con = open_db();
                $sql = "select * from user";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option style='height:30px;' value='$row[id]'> $row[username]</option>";
                }
                mysqli_close();
                ?>
            </select>
            <p>Số key chuyển:</p>
            <input style="width: 40; height: 30px"  type="text" name="key"/>
            <hr>
                <input type="submit" value="Chuyển"/> 
        </form>  
    </body>
</html>