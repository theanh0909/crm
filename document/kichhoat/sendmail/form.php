<?php ob_start(); ?>
<?php session_start() ?>
<?php
require_once("fck.php");
?>
<html>
    <?php require_once '../Include/header.php'; ?>
    <?php require_once '../Include/sidebar.php'; ?>
    <?php require_once '../config/dbconnect.php'; ?>
    <?php get_infor_from_conf("../config/DB.conf"); ?>
    <?php
    $con = open_db();
    $sql = "select * from email where id='$id'";
    $result = mysql_query($sql, $con);
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

    <script type = "text/javascript" >
        $(function() {
            $('#btnRadio').click(function() {
                var checkedradio = $('[name="starus"]:radio:checked').val();
                $('#sel').html('Selected value: ' + checkedradio);
            });
        });
    </script>
    <body>
        <div id="rightcolumn">

            <div id="container">

                <h3>Soạn thảo email<a style=' margin-top: 20px;' title="Thêm mới" href='form.php'><img width="35" height="35" src="../template/img/add_email.png"/></a></h3>
                <div class="form" style="width:70%; margin: 10px; float: left">
                    <form method="post" action="addemail.php" id="contact-us">
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
                                        while($row1 = mysqli_fetch_array($result1)){

                                    ?>
                                    <option  value="<?php echo $row1['product_type'] ?>"><?php echo $row1['name']; ?></option>
                                        <?php } ?>
                                </select>
                            <label>Mặc định :</label>
                            <input type="checkbox" name="default"  >
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
                        <br>
                        <div style="display:none" >
                            <input type="radio" name="status" value="1" checked/>Email thủ công
                            <input type="radio" name="status" value="0"/>Email tự động
                        </div>
                        <br>
                        <hr>
                        <div class="input-box">
                            <label><img src="../template/img/attachment.jpg" width="30" height="20"/></label>
                            <input type="file" name="attach"></input>
                        </div>
                        <div class="submit" style="float: right; margin-top: 10px">
                            <input type="submit" value="Lưu" name="add"/>
                            <input type="submit" value="Gửi" name="send"/>
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
        </div>
    </body>
    <?php require_once '../Include/footer.php'; ?>
</html