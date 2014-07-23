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

$ddmall=defined('DDMALL')?DDMALL:0;

include(DDROOT.'/comm/mall.class.php');
$mall_class=new mall($duoduo);

if(isset($_GET['del'])){
	$duoduo->query('TRUNCATE TABLE `'.BIAOTOU.'ddmall`');
	jump(u(MOD,ACT),'清空完成');
}

if(isset($_GET['update']) && $_GET['update']=='sort'){
	$id=$_GET['id'];
	$sort=$_GET['v'];
	$mall_class->update_sort($id,$sort);
	exit;
}

if(isset($_GET['update'])){
	$pagesize=50;
	$url=DD_U_URL.'/index.php?m=DdApi&a=nowap_mall_list&page_size='.$pagesize.'&page=';
	$page=$_GET['page']?$_GET['page']:1;
	$url=$url.$page;
	$a=dd_get_json($url);
	if(count($a)<$pagesize){
		$next=0;
	}
	else{
		$next=1;
	}
	foreach($a as $v){
		$b=array();
		$b['title']=$v['title'];
		$b['pinyin']=$v['pinyin'];
		$b['url']=$v['url'];
		$b['img']=$v['img'];
		$b['cid']=$v['cid'];
		$b['fan']=$v['fan'];
		$b['des']=str_replace("'","\\'",$v['des']);
		$b['content']=str_replace("'","\\'",$v['content']);
		$b['edate']=$v['edate'];
		$b['domain']=$v['domain'];
		$b['sort']=$v['sort']>0?$v['sort']:DEFAULT_SORT;
		$b['addtime']=TIME;
		$id=(int)$duoduo->select('ddmall','id','domain="'.$b['domain'].'"');
		if($id==0){
			$duoduo->insert('ddmall',$b);
		}
		else{
			$duoduo->update('ddmall',$b,'id="'.$id.'"');
		}
	}
	
	if($next==1){
		$page++;
		PutInfo('商城数据获取中。。。<br/><br/><img src="../images/wait2.gif" />',u(MOD,ACT,array('update'=>1,'page'=>$page)));
	}
	else{
		jump(u(MOD,ACT),'导入完成');
	}
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

$q=$_GET['q'];
$cid=(int)$_GET['cid'];

$page_arr=array();
$where='1=1';

if($cid>0){
    $where.=" and cid='".$cid."'";
	$page_arr['cid']=$cid;
}

if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  `del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and `del`="0"';
}

if(isset($_GET['edate']) && $_GET['edate']!=''){
	$by='edate '.$_GET['edate'].',';
	$page_arr['edate']=$edate;
}
else{
    $by='';
}
if($_GET['edate']=='desc'){
    $listedate='asc';
}
else{
    $listedate='desc';
}

if(isset($_GET['sort']) && $_GET['sort']!=''){
	$sort=$_GET['sort'];
    $by.='sort '.$sort.',';
	$page_arr['sort']=$sort;
}
if($_GET['sort']=='asc'){
    $listsort='desc';
}
else{
    $listsort='asc';
}

if($q!=''){
	$page_arr['q']=$q;
	$where.=' and (title like "%'.$q.'%" or url like "%'.$q.'%")';
}

$data=$mall_class->select($where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize,1);
$total=$data['total'];
$row=$data['data'];