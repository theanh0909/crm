<?php ob_start(); ?>
<?php session_start() ?>
<?php
require_once("fck.php");
require_once '../phpmailer/active_software.php';
?>
<html>
    <?php require_once("../config/global.php"); ?>
    <?php require_once '../Include/header.php'; ?>
    <?php require_once '../Include/sidebar.php'; ?>
    <?php require_once '../config/dbconnect.php'; ?>
    <?php get_infor_from_conf("../config/DB.conf"); ?>
    <?php
    $con = open_db();
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $title = isset($_POST['title']) ? $_POST['title'] : "";
    $content = isset($_POST['message']) ? $_POST['message'] : "";
    $time = time();
    if (isset($_POST['add'])) {
        $result = update_email($id, $email, $title, $content, $time);
        if ($result) {
            if (isset($_POST['default'])) {
                if (isset($_POST['product'])) {
                    $con = open_db();
                    $sql='UPDATE `product` SET `email`='.$id.' WHERE product_type = "'.$_POST['product'].'"';
                    $result = mysqli_query($con, $sql);
                    $sql='UPDATE `email` SET `product`="'.$_POST['product'].'" WHERE id = '.$id;
                  
                    $result = mysqli_query($con, $sql);
            }
        }
            echo "<meta http-equiv = \"refresh\" content=\"0;URL=editemail.php?id=" . $id . "\">";
        }
        
    } else {
        if (isset($_POST['send'])) {
            $result = send_email($email, $name, $title, $content);
            if ($result) {
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=editemail.php?id=" . $id . "\">";
            }
        } else {
            if (isset($_POST['delete'])) {
                $result = delete_email($id);
                if ($result) {
                    echo "<meta http-equiv = \"refresh\" content=\"0;URL=editemail.php\">";
                }
            }
        }
    }
    ?>
    <?php
    $con = open_db();
    $sql = "select * from email where id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $(".btn1").click(function() {
                $("#view").slideToggle();
            });
            $(".btn2").click(function() {
                $("#view1").slideToggle();
            });
        });
    </script>
    <body>
        <div id="rightcolumn">

            <div id="container">
                <h3>Chỉnh sửa email<a style=' margin-top: 20px;' title="Thêm mới" href='form.php'><img width="35" height="35" src="../template/img/add_email.png"/></a></h3>
                <div class="form" style="width:70%; margin: 10px; float: left">
                    <?php
                    if ($_POST['add'] = "Lưu") {
                        echo '<form method="post" action="" id="contact-us" >';
                    }
                    if ($_POST['add'] = "Gửi") {
                        echo '<form method="post" action="send.php" id="contact-us" >';
                    } else {
                        
                    }
                    ?>
                    <div class="input-box" style="display:none">
                        <label>Name:</label>
                        <input type="text" name="name" style="width: 100%"></input>
                    </div>
                    <div class="input-box">
                        <label>Gửi tới :</label>
                        <input type="text" name="email" style="width: 100%; height: 28px" value="<?php echo $row['email'] ?> "></input>
                    </div>
                    <br>
                    <div class="input-box">
                        <label>Chọn phần mềm :</label>
                        <select name="product">
                            <?php
                                $sql1 = 'SELECT * FROM `product`';                                
                                $result1 = mysqli_query($sql1, $con);
								$sql2 = 'SELECT * FROM `email` where id = '.$id;                                
                                $result2 = mysqli_query($sql2, $con);
								$row2 = mysqli_fetch_array($result2);
                                while($row1 = mysqli_fetch_array($result1)){
                                    
                            ?>
                            <option <?php if($row1['product_type'] == $row2['product']){echo 'selected';} ?> value="<?php echo $row1['product_type'] ?>"><?php echo $row1['name']; ?></option>
                                <?php } ?>
                        </select>
                        <label>Mặc định :</label>
                        <?php
                                $sql1 = 'SELECT * FROM `product`';                                
                                $result1 = mysqli_query($sql1, $con);
                                $k=0;
                                while($row1 = mysqli_fetch_array($result1)){
                                    if($id == $row1['email']){
                                        $k =1;
                                    }
                                }
                            ?>
                        <?php if($k == 1){ 
                           echo '<input type="checkbox" name="default" checked  >';
                         } else echo '<input type="checkbox" name="default"  >;' ?>
                    </div>
                    <br>
                    <div class="input-box">
                        <label>Tiêu đề:</label>
                        <input type="text" name="title" style="width: 100%; height: 28px" value="<?php echo $row['subjects'] ?>" ></input>
                    </div> 
                    <br>
                    <div class="input-box">
                        <label>Nội dung thư:</label>
                        <?php
//5. Tao FCKeditor
                        echo $oFCKeditor->Create();
                        ?>
                    </div>
                    <div class="input-box">
                        <label><img src="../template/img/attachment.jpg" width="30" height="20"/></label>
                        <input type="file" name="attach"></input>
                    </div>
                    <div class="submit" style="float: right; margin-top: 10px">
                        <input type="submit" value="Lưu" name="add"/>
                        <input type="submit" value="Gửi" name="send"/>
                        <input type="submit" value="Xóa" name="delete"/>
                    </div>
                    </form>
                </div>
            </div>  
            <div style="border: 1px solid #E9E9E9; width: 25%;padding: 5px; float: right; height: auto; margin-right: 5px;" >
                <button class="btn1" style='color: red; font-weight: bold'>Email gửi thủ công</button>
                <div id="view"><?php echo view_email() ?></div>
                <button class="btn2" style='color: red; font-weight: bold'>Email gửi tự động</button>
                <div id="view1"><?php echo view_email_auto() ?></div>
            </div>
            <?php
//        if (!empty($_POST)) {
//            $arrParam = $_POST;
//            $attach = $_FILES['attach'];
//            // $dirUpload = 'files/';
//            @copy($attach['tmp_name'], $dirUpload . $attach['name']);
//            include('send.php');
//        }
            ?>
        </div>

    </body>
    <?php require_once '../Include/footer.php'; ?>
</html