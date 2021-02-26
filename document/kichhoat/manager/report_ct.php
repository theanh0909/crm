<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once '../Include/header.php'; ?>
<?php require_once '../Include/sidebar.php'; ?>
<?php require_once '../config/dbconnect.php'; ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<?php
if ($_GET['act'] = "do") {
    $title = isset($_POST['title']) ? $_POST['title'] : "";
    $description = isset($_POST['description']) ? $_POST['description'] : "";
    $creattime = date("d-m-y H:i:s");
    $category = 1;
    if (!$title || !$description || !$category) {
        echo "Bạn phải nhập đầy đủ thông tin";
    } else {
        $con = open_db();
        $sql = "INSERT INTO post (id,title, description, creattime, category) VALUES (NULL,'$title', '$description','$creattime', '$category') ";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            echo "Thông báo bị lỗi !!!!!!!!!!!!!!!!";
        } else {
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=../views/administrator.php\">";
        }
    }
}
?>
<div id="rightcolumn">
    <h3 align="center">Tạo thông báo mới</h3>
    <div class="form" style="width:100%; margin: 10px; float: left">
        <form method="post" action="report_ct.php?act=do" id="contact-us">
            <div class="input-box">
                <label>Tiêu đề:</label><br/>
                <input type="text" name="title" class="ipt" size="50" value="<?php echo $row['title'] ?>" />
            </div>
            <br>
            <div class="input-box">
                <label>Nội dung thông báo:</label><br/>
                <?php
                include("../template/fckeditor/fckeditor_php5.php");
                $sBasePath = '../template/fckeditor/';
                $oFCKeditor = new FCKeditor('description');
                $oFCKeditor->Value = "";
                $oFCKeditor->BasePath = $sBasePath;
                $oFCKeditor->Width = '80%';
                $oFCKeditor->Height = 300;
                $oFCKeditor->ToolbarSet = '';
                $oFCKeditor->Config['AutoDetectLanguage'] = false;
                $oFCKeditor->Config['DefaultLanguage'] = 'en';
                echo $oFCKeditor->Create();
                ?>
            </div>
            <div class="submit" style="float: left; margin-top: 10px">
                <input type="submit" value="Lưu" name="add"/>
            </div>
        </form>
    </div>
</div>
<?php require_once '../Include/footer.php'; ?>