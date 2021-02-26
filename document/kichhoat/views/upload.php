<?php
    session_start();
    if(!isset($_SESSION['pass_key'])){
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
        var i =0;

        var person = prompt("Please enter your name", "");
        if(person == null){
            window.location.assign("../views/administrator.php")
            die();
        }
            $.post("test_post_1.php",
            {
              name: person
            },
            function(data,status){
            
                if(data == 'correct'){
                    die();
                }
                 alert("Data: " + data + "\nStatus: " + status);
                window.location.assign("../views/upload.php")
            });
});
</script>
<?php
    }
?>
<?php
$uploadedStatus = 0;
if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {
//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else {
if (file_exists($_FILES["file"]["name"])) {
unlink($_FILES["file"]["name"]);
}

$storagename = "KEY_GXD.xls";
move_uploaded_file($_FILES["file"]["tmp_name"],  '../files/'.$storagename);
$uploadedStatus = 1;
header('Location: ../views/index_upload.php');

}
} else {
echo "No file selected <br />";
}
}
?>
<meta charset="UTF-8">
<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:20px 0 25px 0;">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
<tr><td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">
<!--<a href="http://www.discussdesk.com" target="_blank">DiscussDesk.com</a></td></tr>-->
Key kích hoạt phần mềm GXD</td></tr>
<tr><td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Browse and Upload Your File </td></tr>
<tr>
<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>
<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="file" name="file" id="file" /></td>
</tr>
<tr>
<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>
<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>
</tr>
</table>