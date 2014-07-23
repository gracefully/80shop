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
if(isset($_GET['sub']) || $_GET['page_no']!=''){
	$stime=$_GET['stime'];
	$etime=$_GET['etime'];
	$mun=$_GET['mun'];
	$page_no=$_GET['page_no']?$_GET['page_no']:1;
	$yun_url=DD_U_URL.'/?g=Home&m=DdApi&a=lists&type=game&url='.urlencode(CURURL).'&key='.DDYUNKEY.'&stime='.$stime.'&etime='.$stime.'&listRows=40&p='.$page_no;
	$a=dd_get_json($yun_url);
	
	$url = 'index.php?mod=gametask&act=report';
	if($a['s']==0){
		jump(-1,$a['r']);
	}
	$info_arr=$a['r']['result'];
	$n=0;
	foreach($info_arr as $row){
			$n++;
			$info=$duoduo->select('gametask','id,memberid','eventid="'.$row['eventid'].'"');
			$mingxi_id=$duoduo->select('mingxi','id','shijian="gametask_1" and source="'.$row['eventid'].'"');
			if(empty($info)){
				unset($data);
				$data['memberid']=$row['mid'];
				$data['point']=$row['point'];
				$data['eventid']=$row['eventid'];
				$data['money']=$row['money'];
				$data['programname']=$row['programname'];
				$data['addtime']=date('Y-m-d H:i:s');
				if($row['addtime']!=''){
					$data['addtime']=date('Y-m-d H:i:s',$row['addtime']);
				}
				$duoduo->insert('gametask',$data);
				//给会员结算
				if(empty($mingxi_id)){
					unset($arr);
					$arr=array('f'=>'money','e'=>'+','v'=>$row['point']);
					$duoduo->update('user',$arr,'id="'.$row['mid'].'"');
					//插入明细
					unset($data);
					$data=array('uid'=>$row['mid'],'shijian'=>'gametask_1','money'=>$row['point'],'source'=>'任务名：'.$row['programname']);
					$duoduo->mingxi_insert($data);
				}
			}
	}
	$mun=$n+$mun;
	$msg = date('Ymd', strtotime($stime)) . " | 本次获取订单" . $n . '条！<br/><b style="color:red">订单获取中，不要操作浏览器！</b><br/><img src="../images/wait2.gif" />';
	if ($c == 40) {
		$page_no++;
		$param = '&stime=' . $stime . '&etime=' . $etime . '&page_no=' . $page_no. '&mun=' . $mun;
		$url = $url . $param;
		PutInfo($msg, $url);
	}elseif ($c < 40 && $stime < $etime) {
		$stime = date('Ymd', strtotime($stime . ' +1 day'));
		$param = '&stime=' . $stime . '&etime=' . $etime . '&page_no=1&mun=' . $mun;
		$url = $url . $param;
		PutInfo($msg, $url);
	} else {
		$msg = "<b style='color:red'>获取订单完毕！</b><br/>共有订单" . $mun . '条';
		PutInfo($msg);
	}
	
}
?>