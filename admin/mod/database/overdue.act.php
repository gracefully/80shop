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

$pagesize=20;
if($_GET['jiance']!=''){
	$code = $_GET['code']?$_GET['code']:1;
	$code_arr = array('1'=>'tejia','2'=>'jiu','3'=>'shijiu','4'=>'zhuanxiang');
	$code1_arr = array('1'=>'天天特价','2'=>'九元购','3'=>'十九元购','4'=>'手机专享');
	if($code<=4){
		$auto_del = $_GET['auto_del'];
		$page_no=$_GET['page']?$_GET['page']:'1';
		$page1 = ($page_no-1)*$pagesize;
		$where = 'endtime>'.time().' and code like "%'.$code_arr[$code].'%"';
		$total = $duoduo->count('ddgoods',$where);
		$goods = $duoduo->select_all('ddgoods','id,iid',$where.' order by sort asc,id desc limit '.$page1.','.$pagesize);
		$str='';
		$aa=array();
		foreach($goods as $row){
			$str.=$row['iid'].',';
			$aa[(string)$row['iid']]=$row['id'];
		}
		$str=preg_replace('/,$/','',$str);
		$str = '';
		$arr=check_sold_out($str);
		foreach($arr as $k=>$v){
			if($v==1){
				$id=$aa[$k];
				if($auto_del==0){
					$duoduo->update('ddgoods',array('xiajia'=>'1'),'id = "'.$id.'"');
				}else{	
					$duoduo->delete('ddgoods','id = "'.$id.'"');
				}
			}
		}
		
		if(count($goods)<$pagesize || $page_no>25){
			if($code>=4){
				jump(u(MOD,ACT),'检测完毕！');
			}else{
				$code++;
				jump(u(MOD,ACT,array('page'=>1,'jiance'=>1,'auto_del'=>$auto_del,'code'=>$code)));
			}
		}else{
			$page_no++;
			PutInfo('<img src="../images/wait2.gif"><br><br>检测【'.$code1_arr[$code].'】商品：正在检测第'.($page_no-1).'页，请不要刷新页面...',u(MOD,ACT,array('page'=>$page_no,'jiance'=>1,'auto_del'=>$auto_del,'code'=>$code)));
		}
	}
}
else{
	$where='`xiajia`=1';
	$page_arr=array();
	if($_GET['title']!=''){
		$title=$_GET['title'];
		$where.=' and title like "%'.$title.'%"';
		$page_arr['title']=$title;
	}
	include(DDROOT.'/comm/ddgoods.class.php');
	$ddgoods_class=new ddgoods($duoduo);
	$data=$ddgoods_class->admin_list($pagesize,$where);
	$zhidemai_data=$data['data'];
	$total=$data['total'];
}
?>