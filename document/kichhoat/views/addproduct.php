<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../model/product.php"); ?>
<?php
if (!isset($_GET["act"]))
{
//If not isset -> set with dumy value
$_GET["act"] = "undefine";
} 
if ($_GET['act'] == "do") {
    $product = isset($_POST['product']) ? $_POST['product'] : "";
    $product_type = isset($_POST['product_type']) ? $_POST['product_type'] : "";
    $price = isset($_POST['price']) ? $_POST['price'] : "0";
    $icon = $_FILES["file"]["name"];
    if (!$product || !$product_type) {
        echo "<script language='JavaScript'> alert('Bạn chưa nhập đầy đủ thông tin của sản phẩm');
                                 </script>";
        echo "<meta http-equiv = \"refresh\" content=\"0;URL=addproduct.php\">";
    } else {
        $test = checkproduct($product);
        if ($test) {
            echo "<script language='JavaScript'> alert('Sản phẩm trên đã tồn tại');
                                    </script>";
            echo "<meta http-equiv = \"refresh\" content=\"0;URL=addproduct.php\">";
        } else {
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
                        move_uploaded_file($_FILES["file"]["tmp_name"], "../files/product/" . $_FILES["file"]["name"]);
                        echo "File được lưu ở: " . "../files/product/" . $_FILES["file"]["name"];
                    }
                }
            } else {
                //echo " định dang file lỗi";
                //exit();
            }
            $fb = addproduct($product, $product_type, $price, $icon);
            if ($fb) {
                echo "<script language='JavaScript'> 
               alert('Đã thêm sản phẩm thành công');             
               window.history.go(-2);</script>";
            } else {
                echo "Lỗi sảy ra";
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=addproduct.php\">";
            }
        }
    }
}
?>
<div id="rightcolumn">
    <form action="addproduct.php?act=do" method="post" onsubmit="return doUpload();" enctype="multipart/form-data" name="form1">
        <h3 align="center">Tạo thêm sản phẩm </h3>
        <table  align = "center" >
            <tr>
                <td><label>Nhập tên sản phẩm: </label></td>
                <td><input class = "ipt" size = "35" name = "product" type = "text" /></td>
            </tr>
            <tr>
                <td><label>Dãy nhận biết phần mềm:<br/><span style="font-size: 10px">(vd: DutoanGXD, DuthauGXD...)</span></label></td>
                <td><input class = "ipt" size = "35" name = "product_type" type = "text" /></td>
            </tr>
            <tr>
                <td><label>Giá của sản phẩm: </label></td>
                <td><input class = "ipt" size = "15" name = "price" type = "text" /></td>
            </tr>
            <tr>
                <td><label>Mô tả: </label></td>
                <td><textarea rows="10" cols="50"  name = "text"></textarea></td>
            </tr>
            <tr>
                <td>Icon phần mềm: </td>
                <td><input type="file" name="file"></td>
            </tr>
            <tr><td colspan="3"><input type="submit" class="button" value="Thêm mới"/></td></tr>
        </table>
    </form>
</div>
<?php require_once '../Include/footer.php'; ?>