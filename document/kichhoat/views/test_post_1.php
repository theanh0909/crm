<?php
session_start();
$fp = fopen("../tmp/pass.txt", "r");
$pass= fread($fp,filesize("../tmp/pass.txt"));
fclose($fp);
if(isset($_POST['name'])){
    $x=  md5($_POST['name']);
   if($x == $pass){
       $_SESSION['pass_key']=$x;
        echo 'correct';
        die();
    }
}