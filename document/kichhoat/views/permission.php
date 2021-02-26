<?php ob_start(); ?>
<?php session_start() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Giá xây dựng </title>
        <?php require_once("../Include/header.php"); ?>
        <script language="javascript" type="text/javascript" src="datetimepicker.js">
        </script>
        <script type="text/javascript">
            $(function() {
                $('#btnRadio').click(function() {
                    var checkedradio = $('[name="type"]:radio:checked').val();
                    $('#sel').html('Selected value: ' + checkedradio);
                });
            });
        </script>

    </head>
    <body>
        <div>
            <form action="" method="post">
                <h3>Phân quyền thành viên</h3>
                <label>Nhóm quản trị</label>
                <select name="usertype">
                    <option>Admin</option>
                    <option>Nhân viên công ty GXD</option>
                    <option>Đại lý phân phối</option>
                </select>
        </form>
    </div>