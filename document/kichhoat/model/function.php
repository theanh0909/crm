<?php
//require_once("../config/dbconnect.php");
/*******************************Login*******************************************/
function check_username_password($username, $password) {
    $con = open_db();
    $sql = "select count(*) as tmp from user where username = '$username' and password='$password'";
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

function check_per($username, $password) {
    $con = open_db();
    $sql = "select * from user where username = '$username' and password='$password'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if ($row['type']!='') {
        $fb = $row['type'];
    mysqli_close($con);

    return $fb;
}
else return 0;
}
?>
