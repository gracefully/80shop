<?php
error_reporting();
include "../comm/phpqrcode.php";
$id=(int)$_GET['id'];
$value='http://'.$_SERVER['HTTP_HOST'].($_SERVER['SCRIPT_NAME']?$_SERVER['SCRIPT_NAME']:$_SERVER['PHP_SELF']);
$value=str_replace("api/qrcode.php",'',$value);
$value=$value.'index.php?mod=tao&act=view&go_click=1&id='.$id;
$errorCorrectionLevel = "L";
$matrixPointSize = 4;
QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
exit;
?>