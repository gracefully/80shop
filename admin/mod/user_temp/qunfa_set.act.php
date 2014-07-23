<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

if(isset($_GET['sub']) && $_GET['sub']!=''){
	$_GET['page'] = !($_GET['page'])?'1':intval($_GET['page']);
	$page=$_GET['page'];
	$pagesize=$_GET['pagesize']?$_GET['pagesize']:20;
	$frmnum=($page-1)*$pagesize;
	$page_arr=$_GET;
	extract($page_arr);
	
	$tbtxstatus=(int)$tbtxstatus;
	$txstatus=(int)$txstatus;
	$mobile_test=(int)$mobile_test;
	
	if($page==1){
		$sql="TRUNCATE TABLE `".BIAOTOU."user_temp`";
		$duoduo->query($sql);
	}
	
	if($do=='sms'){
		if($page==1){
			$content=trim($_GET['content']);
			$duoduo->update_serialize('sms','content',$content);
			$duoduo->webset();
		}
		$where=" mobile<>'' ";
	}
	else{
		$where="1 ";
	}
	
	if($sid>0){
		$where.=" and ".(int)$sid."<=id";
	}
	if($eid>0){
		$where.=" and id<=".(int)$eid;
	}
	if($ddusername!=''){
		$where.=" and ddusername like '".$ddusername."'";
	}
	if($mobile_test<=1){
		$where.=" and mobile_test =".$mobile_test;
	}
	if($slastlogintime!='' && $elastlogintime!=''){
		$where.=" and lastlogintime between '".date("Y-m-d 00:00:00",strtotime($slastlogintime))."' and '".date("Y-m-d 23:59:59",strtotime($elastlogintime))."'";
	}
	if($sregtime!='' && $eregtime!=''){
		$where.=" and regtime between '".date("Y-m-d 00:00:00",strtotime($sregtime))."' and '".date("Y-m-d 23:59:59",strtotime($eregtime))."'";
	}
	if($smoney>0){
		$where.=" and ".(float)$smoney."<=money";
	}
	if($emoney>0){
		$where.=" and money <=".(float)$emoney;
	}
	if($sjifenbao>0){
		$where.=" and ".(float)$sjifenbao."<=jifenbao";
	}
	if($ejifenbao>0){
		$where.=" and jifenbao <=".(float)$ejifenbao;
	}
	if($syitixian>0){
		$where.=" and ".(float)$syitixian."<=yitixian";
	}
	if($eyitixian>0){
		$where.=" and yitixian <=".(float)$eyitixian;
	}
	if($stbyitixian>0){
		$where.=" and ".(float)$stbyitixian."<=tbyitixian";
	}
	if($etbyitixian>0){
		$where.=" and tbyitixian <=".(float)$etbyitixian;
	}
	if($tbtxstatus<=1){
		$where.=" and tbtxstatus =".$tbtxstatus;
	}
	if($txstatus<=1){
		$where.=" and txstatus =".$txstatus;
	}
	if($slevel>=0){
		$where.=" and level>=".(int)$slevel;
	}
	if($elevel>0){
		$where.=" and level <=".(int)$elevel;
	}

	$total=(int)$duoduo->count('user',$where);	

	if($total==0){
		if($page==1){
			jump(u('user_temp','qunfa_set',array('do'=>$do)),'检索结果为空，请检查检索条件');
		}
		jump(u('user_temp','list',array('do'=>$do)),'检索完毕');
	}

	$users=$duoduo->select_all('user','id',$where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize);
	
	foreach($users as $row){
		$duoduo->insert('user_temp',$row);
	}
	if(count($users)<$pagesize){
		jump(u('user_temp','list',array('do'=>$do)),'检索完毕');
	}

	$page_arr['page']=$page+1;
	$url='index.php?'.http_build_query($page_arr);
	
	putInfo('<b style="color:red">会员总数：【'.$total.'】，已检入【'.$pagesize*$page.'】。。。</b><br/><img src="../images/wait2.gif" /><br/><a href="'.$url.'">如果浏览器没有跳转，请点击这里</a>',$url);
}
else{
	
}
?>