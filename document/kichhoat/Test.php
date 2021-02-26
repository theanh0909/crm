

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Untitled Document</title>

    </head>

    <body>
        <?php
        require_once("config/dbconnect.php");
        require_once("phpmailer/active_software.php");
        get_infor_from_conf("config/DB.conf");
        echo $_SERVER["REMOTE_ADDR"] . "<br>";
        echo gethostbyaddr($_SERVER['REMOTE_ADDR']) . "<br>";
        echo $_SERVER['HTTP_USER_AGENT'] . "<br>";
        echo $_SERVER["HTTP_REFERER"] . "<br>";
        echo $_SERVER["PATH_INFO"] . "<br>";
        $conn = mysqli_connect("localhost", "giaxaydung_dtoan", "ur2cfzNLJTp3m44M") or die("can't connect this database");
        mysqli_select_db("giaxaydung_dtoan", $conn);
        $spl = "SELECT * FROM `user` ORDER BY `userid` DESC LIMIT 360";
        $result = mysqli_query($spl, $conn);
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['userid'];
            $sl = " INSERT INTO `userfield` (
`userid` ,
`temp` ,
`field9` ,
`field10` ,
`field11` ,
`field14` ,
`field15` ,
`field18`
)
VALUES (
'$id', NULL , '', '', '', '', '', ''
)";
            $re = mysqli_query($sl, $conn);
        }
        ?>

    </body>
</html>
