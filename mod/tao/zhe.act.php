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

if(!defined('INDEX')){
	exit('Access Denied');
}
/**
* @name 淘宝打折
* @copyright duoduo123.com
* @example 示例tao_zhe();
* @param $page 哪一页
* @param $pagesize 每页多少
* @return $parameter 结果集合
*/
function act_tao_zhe(){
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$tao_zhe=$webset['tao_zhe'];
	$tao_zhe_tag=dd_get_cache('tao_zhe.tag');
	$ajax_load_num=$tao_zhe['ajax_load_num'];
	if(empty($page)){
		$page=$_GET['page']?(int)$_GET['page']:1;
	}
	if(empty($pagesize)){
		$pagesize=$tao_zhe['page_size']*($ajax_load_num+1);
	}
	$tao_zhe_page=($page-1)*($ajax_load_num+1)+1;
	
	$cid=(int)$_GET['cid'];
	$q=$_GET['q'];
	
	if(isset($_POST['page'])){
		$q=$_POST['q'];
		$cid=(int)$_POST['cid'];
		$tao_zhe_page=(int)$_POST['page'];
	}
	
	if($cid==0 && $q==''){
		$cid=0;
		$q=$tao_zhe['keyword'];
	}
	
	$Tapparams['keyword']=$q; 
	$Tapparams['cid']=$cid; 
	$Tapparams['shop_type']=$tao_zhe['shop_type']; 
	$Tapparams['sort']=$tao_zhe['sort']; 
	$Tapparams['outer_code']=$dduser['id']; 
	$Tapparams['start_coupon_rate']=$tao_zhe['start_coupon_rate']; 
	$Tapparams['end_coupon_rate']=$tao_zhe['end_coupon_rate']; 
	$Tapparams['start_credit']=$tao_zhe['start_credit']; 
	$Tapparams['end_credit']=$tao_zhe['end_credit']; 
	$Tapparams['start_commission_rate']=$tao_zhe['start_commission_rate']; 
	$Tapparams['end_commission_rate']=$tao_zhe['end_commission_rate']; 
	$Tapparams['start_commission_volume']=$tao_zhe['start_commission_volume']; 
	$Tapparams['end_commission_volume']=$tao_zhe['end_commission_volume']; 
	$Tapparams['start_commission_num']=$tao_zhe['start_commission_num'];
	$Tapparams['end_commission_num']=$tao_zhe['end_commission_num']; 
	$Tapparams['start_volume']=$tao_zhe['start_volume']; 
	$Tapparams['end_volume']=$tao_zhe['end_volume']; 
	$Tapparams['page_size']=$tao_zhe['page_size']; 
	$Tapparams['page_no']=$tao_zhe_page; 
	$Tapparams['total']=1;
	$goods=$ddTaoapi->taobao_taobaoke_items_coupon_get($Tapparams);
	
	if($goods['total']>0){
		//最多显示99页
		if($goods['total']>$pagesize*99){
			$TotalResults=$pagesize*99;
		}
		else{
			$TotalResults=$goods['total'];
		}
		unset($goods['total']);
		
		//网站头
		$itemcatsname=$Tapparams['keyword'];
		//获取商品类目信息
		if($itemcatsname==''){
			$cat_list=$ddTaoapi->taobao_itemcat_msg($cid);
			$itemcatsname=$cat_list['name'];
		}
		if($cat_list['parent_cid']==0){
			$item_cid=$cid;
		}
		else{
			$item_cid=$cat_list['parent_cid'];
		}
		if($item_cid>0){
			$cat_list=$ddTaoapi->taobao_itemcats($item_cid);
		}
	}
	else{
		if(AJAX==1){
			dd_exit('over');
		}
		else{
			error_html('没有该商品内容！',-1,1);
		}
	}
	
	if(isset($_POST['page'])){
		$ajax_loading=1;
		if($TotalResults>0){
			include TPLPATH.'/tao/zhe.goods.tpl.php';
		}
		else{
			echo 'over';
		}
		dd_exit();
	}
	
	$show_page_url=u('tao','zhe',array('q'=>$q,'cid'=>$cid));
	unset($duoduo);
	$parameter['tao_zhe']=$tao_zhe;
	$parameter['tao_zhe_tag']=$tao_zhe_tag;
	$parameter['ajax_load_num']=$ajax_load_num;
	$parameter['cid']=$cid;
	$parameter['tao_zhe_page']=$tao_zhe_page;
	$parameter['pagesize']=$pagesize;
	$parameter['q']=$q;
	$parameter['goods']=$goods;
	$parameter['TotalResults']=$TotalResults;
	$parameter['itemcatsname']=$itemcatsname;
	$parameter['item_cid']=$item_cid;
	$parameter['cat_list']=$cat_list;
	$parameter['ajax_loading']=$ajax_loading;
	$parameter['show_page_url']=$show_page_url;
	return $parameter;
}
?>