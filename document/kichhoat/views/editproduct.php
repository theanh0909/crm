<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../model/product.php"); ?>

<?php
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
if(isset($_POST['submit'])){	
	$product = isset($_POST['product']) ? $_POST['product'] : "";
	$product_type = isset($_POST['product_type']) ? $_POST['product_type'] : "";
	$price = isset($_POST['price']) ? $_POST['price'] : "";
	$version = isset($_POST['version']) ? $_POST['version'] : "";
	$key_version = isset($_POST['key_version']) ? $_POST['key_version'] : "";
	$des = isset($_POST['description']) ? $_POST['description'] : "";
	$icon = $_FILES["file"]["name"];
	if($icon != ''){
		$allowedExts = array("jpg", "jpeg", "gif", "png");
		$extension = end(explode(".", $_FILES["file"]["name"]));
		if (in_array($extension, $allowedExts)) {
		if ($_FILES["file"]["error"] > 0) {
			echo "Mã lỗi trả về: " . $_FILES["file"]["error"] . "<br>";
		} else {
			echo "Tên file: " . $_FILES["file"]["name"] . "<br>";
			echo "Kiểu file: " . $_FILES["file"]["type"] . "<br>";
			echo "Kích thước: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
			if (file_exists("../files/product/" . $_FILES["file"]["name"])) {
				echo $_FILES["file"]["name"] . " file đã tồn tại. ";
			} else {
				$t = move_uploaded_file($_FILES["file"]["tmp_name"], "../files/product/" . $_FILES["file"]["name"]);
				echo "File được lưu ở: " . "../files/product/" . $_FILES["file"]["name"];
			}
		}
		} else {
                //echo " định dang file lỗi";
                //exit();
		}
		$ck1 = editproduct($id, $product, $product_type, $price, $icon, $des, $version, $key_version);
			if ($ck1) {
				echo "<script language='JavaScript'> window.history.go(-2);</script>";
			}
		}
		else{
			$ck1 = editproduct1($id, $product, $product_type, $price, $des, $version, $key_version);
			if ($ck1) {
				echo "<script language='JavaScript'> window.history.go(-2);</script>";
			}
		}
}
$con = open_db();
$sql = "select * from product where id = '$id'";
$result = mysqli_query($con, $sql);
$text = mysqli_fetch_array($result);
$hinh = "../files/product/" . $text['icon'];
$product = isset($product) ? $product : "";
if ($product != "") {
    if ($hinh != "") {
        $icon = $text['icon'];
    } else {
        if ($_FILES["file"]["error"] > 0) {
            echo "Mã lỗi trả về: " . $_FILES["file"]["error"] . "<br>";
            exit();
        } else {
            if (file_exists("../files/product/" . $_FILES["file"]["name"])) {
                echo "<script language='JavaScript'> alert('File đã tồn tại');</script>";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], "../files/product/" . $_FILES["file"]["name"]);
                echo "File được lưu ở: " . "../files/product/" . $_FILES["file"]["name"];
                $icon = $_FILES["file"]["name"];
            }
        }
    }
    
}
?>
<div id="rightcolumn">
    <form action="" method="post" enctype="multipart/form-data">
        <h3 align="center">Tạo thêm sản phẩm </h3>
        <table  align = "center" >
            <tr>
                <td><label>Nhập tên sản phẩm: </label></td>
                <td><input class = "ipt" size = "35" name = "product" type = "text"  value="<?php echo $text['name'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Dãy nhận biết phần mềm:<br/><span style="font-size: 10px">(vd: DutoanGXD, DuthauGXD...)</span></label></td>
                <td><input class = "ipt" size = "35" name = "product_type" type = "text" value="<?php echo $text['product_type'] ?>" /></td>
            </tr>
            <tr>
                <td><label>Giá của sản phẩm: </label></td>
                <td><input class = "ipt" size = "15" name = "price" type = "text" value="<?php echo $text['price'] ?>" /></td>
            </tr>
            <tr>
                <td><label>Mô tả: </label></td>
                <td><textarea rows="10" cols="50"  name = "description"><?php echo $text['description'] ?></textarea></td>
            </tr>
            <tr>
                <td>Icon: </td>
                <?php if ($hinh != "") { ?>
                    <td><img src="<?php echo $hinh ?>" width="25" height="25"/><input style="margin-left: 50px;" type="file" name="file"></td>
                <?php } else { ?>
                    <td><input type="file" name="file1"/></td>
                <?php } ?>
				
            </tr>
			<tr>
                <td><label>Version: </label></td>
                <td><input class = "ipt" size = "15" name = "version" type = "text" value="<?php echo $text['version'] ?>" /></td>
            </tr>
			<tr>
                <td><label>Key version: </label></td>
                <td><input class = "ipt" size = "15" name = "key_version" type = "text" value="<?php echo $text['key_version'] ?>" /></td>
            </tr>
            <tr><td colspan="3"><input type="submit" name="submit" value="Lưu"/></td></tr>
        </table>
    </form>
</div>
<?php require_once '../Include/footer.php'; ?>
