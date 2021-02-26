<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../model/product.php"); ?>

<?php
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$product = isset($_POST['product']) ? $_POST['product'] : "";
$product_type = isset($_POST['product_type']) ? $_POST['product_type'] : "";
$price = isset($_POST['price']) ? $_POST['price'] : "";
$icon = "";
if (!$product) {
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
            if (file_exists("upload/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " file đã tồn tại. ";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], "files/product/" . $_FILES["file"]["name"]);
                echo "File được lưu ở: " . "files/product/" . $_FILES["file"]["name"];
            }
        }
    } else {
        echo "Lỗi định dạng file";
    }
    $result = editproduct($product, $product_type, $price, $icon);
    if ($result) {
        echo "<script language='JavaScript'> window.history.go(-2);</script>";
    }
}
$con = open_db();
$sql = "select * from product where id = '$id'";
$result = mysqli_query($con, $sql);
$text = mysqli_fetch_array($result);
?>
<div id="rightcolumn">
    <form action="edit_product.php" method="post" onsubmit="return doUpload();" enctype="multipart/form-data">
        <h3 align="center">Chỉnh sửa thông tin </h3>
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
                <td><textarea rows="10" cols="50"  name = "text"></textarea></td>
            </tr>
            <tr>
                <td>Icon: </td>
                <td><input type="file" name="file" value="<?php echo $text['icon'] ?>"></td>
            </tr>
			
            <tr><td colspan="3"><input type="submit" value="Lưu"/></td></tr>
        </table>
    </form>
</div>
<?php require_once '../Include/footer.php'; ?>
