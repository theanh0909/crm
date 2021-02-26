<style>
    .cty{
        float: left;
        width: 15%;
       
    }
</style>
<?php ob_start(); ?>
<?php
session_start();
require_once("../Include/header.php");
require_once("../config/bitfield_city.php");
require_once("../model/user.php");
require_once("../Include/sidebar.php");
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : "";
$type = isset($_POST['type']) ? $_POST['type'] : "";
$password = isset($_POST['pass']) ? $_POST['pass'] : "";
if(isset($_POST['submit'])){
if ($username != "") {
    update_user($id, $username, $email, $type);
    //header("Location:user.php?id=" . $username);
}
if ($password != "") {
    $passm = md5($password);
    changce_pass($id, $passm);
}

                    $con = open_db();
                    echo $sql1="SELECT * FROM tbl_city";
                        $result1=mysqli_query($sql1, $con);
                        
                        $text='';
                        if ($result1){      
                            
                            while ($row1 = mysqli_fetch_array($result1)) {
                                
                                $row1['type'];
                                
                                if(isset($_POST[$row1['type']])){
                                $text=$row1['type'].'-'.$text;
                                }
                                 
                            }
                            
                           $text='-'.$text;
                        }  
                    
                    if($text != ''){
                    echo $sql1='UPDATE `user` SET `permission`= "'.$text.'" where username = "'.$username.'"';
                    $result1=mysqli_query($sql1, $con);
                    }
}

$con = open_db();
$sql = "select * from user where id = '".$id."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

?>
<div id="rightcolumn">
    
    <br>
    <form id ="form" action = 'edituser.php' method = 'post'>
        <div class="user" >
            <h3>Thông tin user</h3>
            <table id = "edit" align = "left">
                <tr>
                    <td><label>ID</label></td>
                    <td><input class = "ipt-t" name = "id" size = "5" type = "text" readonly = "true" value = "<?php echo $row['id'] ?>"/></td>
                </tr>
                <tr>
                    <td><label>Tên thành viên </label></td>
                    <td><input class = "ipt" size = "35" name = "username" type = "text"   value = "<?php echo $row['username'] ?>"/></td>
                </tr>
                
                <tr>
                    <td><label>Email </label></td>
                    <td><input class = "ipt" size = "35" name = "email" type = "text"  value = "<?php echo $row['email'] ?>"/></td>
                </tr>
				<tr>
                    <td><label>Password </label></td>
                    <td><input class = "ipt" size = "35" name = "pass" type = "password"  value = ""/></td>
                </tr>
            </table>
        </div>
        <div class="user" >
            <h3>Quyền hạn thành  viên</h3>
            <table id = "edit" align = "left">
                
                <?php
                
                $sql1 = "select id, description from usergroup";
                $result = mysqli_query($sql1, $con);
                while ($row1 = mysqli_fetch_array($result)) {                  
                    ?>
                                          
                        <td><input type="radio" name="type" <?php if ($row1['id'] == $row['type']) echo "checked"; ?> value="<?php echo $row1['id'] ?>"/><?php echo $row1['description']; ?> </td>
                   
                <?php } ?>
                
            </table>
        </div>
        <div class="user" >
            <h3>Phân chia tỉnh thành</h3>
            <?php
            $k=1;
            $sql1='SELECT * FROM `tbl_city`';
            $result1=mysqli_query($sql1, $con);
            if ($result1){        
                $i = 1;
                               echo '<ul class = "cty">';    
                while ($row1 = mysqli_fetch_array($result1)) {
                    //$name = $row1['type'];
                    $k = $k+1;
                    $name = $row1['type'].'-';
                     
                     echo '<li>';
                    if(strpos($row['permission'],$name) != FALSE){

                    echo  "<input name='".$row1['type']."' type='checkbox' checked /> ";
                    echo $row1['name'];

                    }
                    else{
                        echo  "<input name='".$row1['type']."' type='checkbox' />";
                    echo $row1['name'];
                    }
                     echo '</li>';
                    if($k > 15* $i){
                        $i = $i+1;
                        echo '</ul>';
                        echo '<ul class = "cty">';
                    }
                }
                              
            }  
            ?>
        </div>
        <input class = "button" type = "submit" name='submit' value = "Cập nhật"/>
    </form>
</div>

<?php require_once("../Include/footer.php"); ?>
<?php ob_flush(); ?>