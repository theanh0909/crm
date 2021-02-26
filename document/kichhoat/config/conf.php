<?php

require_once("global.php");
$con = "";
function get_infor_from_conf($path) {
    global $server, $userid, $pass;
    $fp = fopen($path, "r");
    $server = trim(fgets($fp));
    $userid = trim(fgets($fp));
    $pass = trim(fgets($fp));

    fclose($fp);
}

//Kết nối với database
function open_db() {
    global $server, $userid, $pass;
    $con = mysqli_connect($server, $userid, $pass);
    if (!$con) {
        die("Cannot connect to the server");
        return "";
    }
    $select_db = mysqli_select_db("giaxaydung_key", $con);
    if (!$select_db) {
        die("Cannot select the database");
        return "";
    }
    return $con;
}

?>
