<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../config/dbconnect.php"); ?>
<?php require_once("../config/bitfield.php"); ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<?php
    if(isset($_GET['id1'])){
        $id1 = $_GET['id1'];
        $sql = 'DELETE FROM `tbl_stt` WHERE id ='. $id1;
        $result = mysqli_query($con, $sql);
        if($result){
            echo '<script language="javascript" type="text/javascript" >
                    alert("Bạn đã xóa thành công!");
                </script>';
        }
        else {
            echo '<script language="javascript" type="text/javascript" >
                           alert("Bạn chưa xóa được nhóm khách hàng!");
                       </script>';
        }
    }
    else if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql = 'SELECT `id`, `name`, `note`, `describe` FROM `tbl_stt` WHERE id = '.$id;
        $result = mysqli_query($con, $sql);
        $row=  mysqli_fetch_array($result);
                if(isset($_POST['submit']) && isset($_POST['name_group'])){                   
                    if($_POST['name_group'] != ''){
                        $comment = isset($_POST['comment']) ? $_POST['comment'] : "";  
                        $sql1='UPDATE `tbl_stt` SET `name`="'.$_POST['name_group'].'",`describe`="'.$comment.'" WHERE id = '.$id;
                        $result = mysqli_query($sql1, $con);
                        echo '<script language="javascript" type="text/javascript" >
                                    alert("Bạn đã sửa thành công!");
                                </script>';
                    }
                    else echo '<script language="javascript" type="text/javascript" >
                                    alert("Không có tên nhóm khách hàng");
                                </script>';
                }
?>
        <div id="rightcolumn">
            <h2 align="center" class="gxdh2"> TẠO NHÓM KHÁCH HÀNG </h2>

            <form action = "" method = "post" id="usrform">
                <table cellspacing="15" align="center" border="0" style="font-size: 14px; border:thick 0px; margin-top:25px;">
                    <tr>
                        <td >Tên nhóm:</td>
                        <td><input id="name_group" name="name_group" type="text" size="25" value="<?php echo $row['name']; ?>"></td>
                    </tr>
                    <tr>
                        <td >Mô tả:</td>
                        <td><textarea rows="4" cols="50" name="comment" form="usrform" value=''><?php echo $row['describe']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><input id='center' type="submit" value="lưu" name="submit"></td>

                    </tr>
                </table>
            </form>
        </div>
    <?php require_once '../Include/footer.php'; 
    
                }?>
