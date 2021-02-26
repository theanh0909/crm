<?php ob_start(); ?>
<?php session_start() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Giá xây dựng </title>
        <?php require_once("../Include/header.php"); ?>
        <?php require_once("../Include/sidebar.php"); ?>
    </head>
    <body>
        <?php
        if ($_GET['act'] == "do") {
            $email = isset($_POST['email']) ? $_POST['email'] : "";
            $subject = isset($_POST['subject']) ? $_POST['subject'] : "";
            $content = isset($_POST['comments']) ? $_POST['comments'] : "";
            if (!$email || !$subject || !$email) {
                echo "Bạn hãy nhập đầy đủ thông tin để gửi liên hệ";
            } else {
                $to = 'vuthibich2126@gmail.com';
                mail($to, $subject, $content, $email);
                echo "Yêu cầu của bạn đã được gửi đi";
                $con = open_db();
                $sql = "UPDATE user SET status='0' where id='$iduser'";
                $result = mysqli_query($con, $sql);
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=status_dtoan.php?id=$iduser\">";
            }
        }
        ?>
        <div id="rightcolumn">
            <form  style="margin-left: 20px; padding: 15px;" method="post" action="lienhe.php?act=do">
                <label><strong>Email của bạn</strong></label><br/>
                <input type="text" class="ipt" name="email" size=50/> <br/>
                <label><strong>Tiêu đề</strong></label><br/>
                <input class="ipt" type="text" name="subject" size=70/> <br/>
                <label><strong>Nội dung</strong></label><br/>
                <textarea name="comments" value="Your Message Here" rows=5 cols=70></textarea> <br/>
                <input type="submit" name="submit" value="Gửi !"/> <input type="reset" name="reset" value="Làm lại"/> <br/>
            </form>
        </div>
        <?php require_once("../Include/footer.php"); ?>

    </body>
</html>
<?php ob_flush(); ?>
