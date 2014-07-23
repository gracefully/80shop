<?php
error_reporting(0);
date_default_timezone_set('PRC');
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));
include(DDROOT.'/comm/lib.php');
class pic {
	function yzm() {
		include('yzm.php');
		$rsi = new Utils_Caption();
        $rsi->TFontSize = array (16,18);
        $rsi->Width = 50;
        $rsi->Height = 25;
        $code = $rsi->RandRSI();
        dd_session_start();
        $_SESSION["captcha"] = $code;
        $rsi->Draw();
	}

	function show_pic($pic) {
		if(strpos($pic,'http')!==false){
		    echo dd_get($pic);
		}
		else{
			if($pic=='images/tbdp.gif' || $pic=='images/tbsc.gif'){
			    include('../'.$pic);
			}
		}
	}
}

$pic=new pic;
if(!isset($_GET['pic'])){
	$pic->yzm();
}
else{
	$picname=base64_decode($_GET['pic']);
	$pic->show_pic($picname);
}
?>