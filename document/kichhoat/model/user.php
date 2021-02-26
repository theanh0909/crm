<?php

require_once("../config/dbconnect.php");
/* Bussiness function for tbl_account */

function add_account($username, $password, $email, $tinhthanh, $type) {
    $con = open_db();
    $sql = "insert into user (id, username, password, email,tinhthanh,type) values(NULL, '$username', '$password','$email','$tinhthanh', '$type')";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        $fb = FALSE;
    } else {
        $fb = TRUE;
    }
    mysqli_close($con);
    return $fb;
}

function check_username_email($email) {
    $con = open_db();
    $sql = "select count(*) as tmp from user where email = '$email'";
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

function get_user_from_db_ranges($frompos, $norecords) {
    $con = open_db();
    $sql = "select * from usergroup,user where user.type=usergroup.id";
    $result = mysqli_query($con, $sql);
    $t = mysqli_num_rows($result);
    $count = 0;
    echo "<table id='listcheck' cellspacing = '0' cellpadding = '0' class = 'tbl_user' align = 'center'><tr><th><input type='checkbox' id='checkall' name='checkall' />All</th><th>STT</th><th width = '260'>Tên tài khoản</th><th>Email</th><th>Quyền hạn</th><th><p width = '25' height = '25'</th><th><p width = '25' height = '25'></p></th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $tmp = sprintf("<td>%s</td><td>%d</td><td width = '60'>%s</td><td>%s</td><td align = 'center'>%s</td><td align = 'center'>%s</td><td>%s</td>", "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>", $count, $row['username'], $row['email'], $row['description'], "<a href = 'edituser.php?id=$row[id]'><img src = '../template/images/edit.png' width = '20' height = '20'></a>", "<a href = 'deleteuser.php?id=$row[username]'><img src = '../template/images/delete.png' width = '20' height = '20'></a>");
        echo $tmp;
        echo "</tr>";
        $count++;
    }
    echo "</tr>";
    echo "<tr>";
    echo '<td colspan="7" align="right" bgcolor="#FFFFFF">
        <a style="text-decoration:none;" href="createaccount.php"><input type="button" value="Tạo tài khoản"/></a>   
       <input name="delete" type="submit" id="delete" value="Xóa"></td>';
    echo "</tr>";
    if ($_POST['delete'] == "Xóa") {
        if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
            $t = $_POST['chkid'];
            foreach ($t as $key => $value) {
                $deleteSQL = "delete from user where id ='" . $value . "'";
                $Result = mysqli_query($deleteSQL, $con);
            }
            if ($Result) {
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=user.php\">";
            }
        }
    }
    echo "</tr>";

    echo "</table>";
    mysqli_close($con);
}

function delete_user($username) {
    $con = open_db();

//Xóa user
    $sql = "delete from user where username = '" . $username . "'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot delete data from database";
        return false;
    }
    mysqli_close($con);
    return true;
}

/* Đổi pass cho user */

function changce_pass($id, $pass) {
    $con = open_db();
    $sql = "UPDATE user SET  password = '$pass'
    WHERE
    id = '$id'";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update user";
        return false;
    }
    mysqli_close($con);
    return true;
}

/* Sửa thông tin user */

function update_user($id, $username, $email, $type) {
    $con = open_db();
    $sql = "UPDATE user SET username = '$username',
    type = '$type',
    email = '$email'
    WHERE
    id = '$id'";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update user";
        return false;
    }
    mysqli_close($con);
    return true;
}

function update_doanhthu($id, $doanhthu) {
    $con = open_db();
    $sql = "UPDATE user SET doanhthu = '$doanhthu'
     WHERE
    id = '$id'";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update user";
        return false;
    }
    mysqli_close($con);
    return true;
}

