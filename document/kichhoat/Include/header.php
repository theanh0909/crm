<?php ob_start(); ?>

<?php require_once '../config/site.php'; ?>
<?php require_once '../config/bitfield.php'; ?>
<?php
header('Cache-Control: max-age=13600');
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    <html lang="vi">
<head>
<?php //echo SITE_URL; die() ?>
    <title>GXD - License </title>
    <meta name="description" content="abc">
    <meta name="copyright" http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="author" content="Giá Xây Dựng" >
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL ?>/template/css/style.css" />
    <script language="javascript" type="text/javascript" src="<?php echo SITE_URL ?>/template/js/datetimepicker.js"></script>
    <script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type = "text/javascript" ></script>
    <script language = "javascript" type = "text/javascript" src = "<?php echo SITE_URL ?>/template/js/checkbox.js" ></script>
    <script language = "javascript" type = "text/javascript" src = "<?php echo SITE_URL ?>/template/js/flyout.js" ></script>
    <script language = "javascript" type = "text/javascript" src = "<?php echo SITE_URL ?>/template/js/jquery-1.3.2.js" ></script>
    <script language = "javascript" type = "text/javascript" src = "<?php echo SITE_URL ?>/template/js/jquery.watermark.js" ></script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript" src="../template/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="../template/js/jquery.gvChart-1.0.1.min.js"></script>
    <script type="text/javascript">
        gvChartInit();
        jQuery(document).ready(function() {
            jQuery('#myTable1').gvChart({
                chartType: 'BarChart',
                gvSettings: {
                    vAxis: {title: 'Tỉnh thành'},
                    hAxis: {title: 'Số lượng khách hàng'},
                    width: 1300,
                    height: 1650
                }
            });
        });
    </script>
    <script language="javascript">
        function show_info_detail(str)
        {
            document.getElementById("search_advanced").style.display = 'block';
            if (str == "")
            {
                document.getElementById("search_advanced").innerHTML = "";
                return;
            }

            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("search_advanced").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "editlicense_ajax.php?id=" + str, true);
            xmlhttp.send();
        }
         function call_notice()
        {
            alert('Bạn không có quyền truy cập!');
            location.replace('../Mod/show.php');
        }

        function hide_info_detail()
        {
            document.getElementById("search_advanced").style.display = 'none';
        }

        function toggle(x, origColor) {
            var newColor = 'red';
            if (x.style) {
                x.style.backgroundColor = (newColor == x.style.backgroundColor) ? origColor : newColor;
            }
        }
    </script>
</head>
<body>
    <?php
    $user = $_SESSION['username'];
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $con = open_db();
    $sql = "select usergroup.permission, user.id, user.type from user, usergroup where user.type=usergroup.id and user.username='$user'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $iduser = $row['id'];
    $type = $row['type'];
    $perms = new bitmask();
    $a = $row['permission'];
    $permarr = $perms->getPermissions($a);
	if($type !=1 && $type!=2 || $type ==''){
        echo '<script type="text/javascript">
            call_notice();
            </script>'; 
    die();
    }
    ?>
    <div id="wrap">
        <div id = "mainmenu">
            <ul>
                <li style="float: left !important; margin-top: 10px;"><img src="../template/img/home-go.png" width="20" height="20" style="margin-bottom: -2px;margin-right: 3px"/><a class="active" href="<?php echo SITE_URL ?>/views/send_key.php">Home</a></li>
                <li><a href="<?php echo SITE_URL ?>/views/thoat.php"><img src="../template/img/thoat.png" width="20" height="20" style="margin-bottom: -2px;margin-right: 3px"/>Thoát</a></li>
                <li>|</li>
                <?php
                if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
                    echo "<script language='JavaScript'> alert('Bạn hãy đăng nhập tài khoản');</script>";
                    echo "<meta http-equiv = \"refresh\" content=\"0;URL=/index.php\">";
                    die();
                } else {
                    setcookie("username", $user, time() + 7 * 24 * 60 * 60);
                    setcookie("status", 'login', time() + 7 * 24 * 60 * 60);
                    ?>
                    <li><a href="<?php echo SITE_URL ?>/views/edituser.php?id=<?php echo $iduser ?> "><img src="../template/img/user.png" width="20" height="20" style="margin-bottom: -2px; margin-right: 3px; margin-left: 25px;"/><?php echo $user ?></a></li>
                    <?php
                }

                $keyword = isset($_POST['txt_last_running_days']) ? $_POST['txt_last_running_days'] : "";
                ?>
                <!--<div id= "searchbar">-->
                <li> <form  action = "<?php echo SITE_URL . "/views/mainresult.php?search=$_POST[txt_last_running_days]" ?>" method = "post">
                        <table align="right" border = "0">
                            <tr>
                                <td> Từ khóa tìm kiếm </td>
                                <td> <input style="height: 25px; border-radius: 5px" name = "txt_last_running_days" type = "text" size = "35" value="<?php echo $keyword; ?>"></td>
                                <td> <button type="submit" value="Search"><img src="../template/img/search.jpg" with="15" height="15"/></button></td>
                            </tr>
                        </table>
                    </form>
                </li>
                <div id = "searchresult">	
                </div>
            </ul>
        </div>
