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

$where='1';
if(isset($_GET['sub'])){
	$se=trim($_GET['se']);
	$q=trim($_GET['q']);
	if(!empty($q)){
		if($se=='ddusername'){
			$id=$duoduo->select('user','id',$se.'="'.$q.'"');
			$where.=' and b.'.$se.'="'.$q.'"';
		}else{
			$where.=' and a.'.$se.'="'.$q.'"';
		}
		$page_arr['se']=$se;
		$page_arr['q']=$q;
	}
}
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and a.`del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and a.`del`="0"';
}
$select_arr=array('ddusername'=>'会员','eventid'=>'流水号','programname'=>'任务名');

$type=array('0'=>'等待结算','已结算','已结算','审核无效');
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$total=$duoduo->count('task as a left join '.BIAOTOU.'user as b on b.id=a.memberid',$where);
$plugin_data=$duoduo->select_all('task as a left join '.BIAOTOU.'user as b on b.id=a.memberid','a.*,b.ddusername',$where.' order by addtime desc limit '.$frmnum.','.$pagesize);
?>