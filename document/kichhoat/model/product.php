<?php

require_once("../config/dbconnect.php");

function addproduct($product, $product_type, $price, $icon) {
    $con = open_db();
    $sql = "INSERT INTO product (id, name, product_type, price, icon) VALUES 
        (NULL, '$product', '$product_type', '$price','$icon')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $check = true;
    } else {
        $check = false;
    }
    return $check;
    mysqli_close();
}

function checkproduct($product) {
    $con = open_db
            ();
    $sql = "select count(*) as tmp from product where name = '$product'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if ($row['tmp'] > 0) {
        $fb = true;
    } else {
        $fb = false;
    }
    mysqli_close($con);
    return $fb;
}

function editproduct($id, $name, $product_type, $price, $icon, $description,$version,$key_version) {
    $con = open_db();
    $sql = "update product set name='$name', 
            product_type='$product_type', 
            price='$price', 
            icon='$icon', 
            description='$description',
			version='$version',
			key_version='$key_version'
			where id='$id'";
			
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "$sql";
        return false;
    }
    mysqli_close($con);
    return true;
}

function editproduct1($id, $name, $product_type, $price, $description,$version,$key_version) {
    $con = open_db();
    $sql = "update product set name='$name', 
            product_type='$product_type', 
            price='$price',  
            description='$description',
			version='$version',
			key_version='$key_version'
			where id='$id'";
			
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "$sql";
        return false;
    }
    mysqli_close($con);
    return true;
}

function viewtproduct($a, $b, $per) {
    $con = open_db();
    $sql = "SELECT * from product";
    $result = mysqli_query($con, $sql);
    if ($per['deleteproduct']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />All";
    } else {
        $delall = "";
    }
    echo
    "<table id='listcheck' cellspacing = '0' cellpadding = '0' class = 'tbl_user' align = 'center'>
            <tr><th>$delall</th><th>STT</th>
            <th>Icon</th><th>Tên sản phẩm</th><th>Product_type</th><th>Giá sản phẩm</th><th>Mô tả</th>
            <th><p width = '25' height = '25'</th><th><p width = '25' height = '25'></p></th><tr>";
			$count = 0;
    while ($row = mysqli_fetch_array($result)) {
        $img = "../files/product/" . $row['icon'];
        $pr = number_format($row['price'], 0, ',', '.');
        if ($per['editproduct']) {
            $edit = "<a href = 'editproduct.php?id=$row[id]'><img src = '../template/images/edit.png' width = '20' height = '20'></a>";
        }
        if ($per['deleteproduct']) {
            $del = "<a href = 'deleteproduct.php?id=$row[name]'><img src = '../template/images/delete.png' width = '20' height = '20'></a>";
            $delall = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
        }
        $tmp = sprintf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td td width='400'>%s</td><td>%s</td><td>%s</td>", $delall, $count, "<img src='$img' width='25' height='25' border='0'>", $row['name'], $row['product_type'], $pr, $row['description'], $edit, $del);
        echo $tmp;
        echo "</tr>";
        $count++;
        echo "</tr>";
    }
    echo "<tr>";
    echo '<td colspan="9" align="right" bgcolor="#FFFFFF">';
    if ($per['addproduct']) {
        echo'
        <a style="text-decoration:none; margin-right:5px" href="addproduct.php"><input class="button" type="button" value="Thêm sản phẩm mới"/></a>';
    }
    if ($per['deleteproduct']) {
        echo '<input name = "delete" type = "submit" class="button" id = "delete" value = "Xóa"></td>';
    }
    echo "</tr>";
	$_POST['delete'] = isset($_POST['delete']) ? $_POST['delete'] : "";
    if ($_POST['delete'] == "Xóa") {
        if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
            $t = $_POST['chkid'];
            foreach ($t as $key => $value) {
                $deleteSQL = "delete from product where id ='" . $value . "'";
                $Result = mysqli_query($deleteSQL, $con);
            }
            if ($Result) {
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=product.php\">";
            }
        }
    }
    echo "</tr>";
    echo "</table>";
    mysqli_close($con);
}

