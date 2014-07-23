<?php
if($_GET){
	$q = trim($_GET['q']);
	$row = $duoduo->select_all('api', '*',' title like "%'.$q.'%"');
	$total = count($row);
}else{
	$row = array();
	$row = $duoduo->select_all('api', '*');
	$total = count($row);
}
?>