<?php
error_reporting(0);
$dataname = $_POST['dataname'];
$datauser = $_POST['datauser'];
$datapwd = $_POST['datapwd'];
$host = $_POST['host'];
$conn = mysql_connect($host,$datauser,$datapwd);
if($conn==''){
    echo 0;exit;
}
else echo 1;