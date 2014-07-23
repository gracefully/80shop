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
* @name 淘宝首页
* @copyright duoduo123.com
* @example 示例tao_list();
* @param $q 关键字
* @param $cid 分类cid
* @param $pagesize 每页多少
* @return $parameter 结果集合
*/
function act_tao_list($pagesize=0){
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$tao_area=include (DDROOT.'/data/tao_area.php');
	$tao_sort=include (DDROOT.'/data/tao_list_sort.php');
	$shield_cid = include (DDROOT.'/data/shield_cid.php');

	if(empty($pagesize)){
		$pagesize=$webset['taoapi']['pagesize'];
	}
	if(empty($q)){
		$q=empty($_GET['q']) ? '' : $_GET['q'];
	}
	$cid = empty($_GET['cid'])?'':intval($_GET['cid']);
	
	if($webset['taoapi']['shield']==1 && in_array($cid,$shield_cid)){
		error_html('商品不存在',-1);
	}
	
	if($cid=='' && $q==''){$q=$webset['hotword'][0];}
	$search=(int)$_GET['search'];
	$page=empty($_GET['page'])?'1':(int)$_GET['page'];
	$list=$_GET['list']?(int)$_GET['list']:2; //注意全局变量
	$liebiao=(int)get_cookie('liebiao',0);
	if($list==0){
		if($liebiao>0){
			$list=$liebiao;
		}
		else{
			$list=$webset['liebiao'];
		}
	}
	set_cookie('liebiao', $list, 12000,0);
	
	if(TAOTYPE==1){
		global $dd_tao_class;
		$goods_type=$dd_tao_class->get_type('goods');
		
		$pagesize=$webset['taoapi']['pagesize'];
		$frmnum=($page-1)*$pagesize;

		$a=$dd_tao_class->dd_tao_goods(array('num'=>$pagesize,'frmnum'=>$frmnum,'cid'=>$cid,'q'=>$q,'total'=>1));
		$TotalResults=$a['total'];
		$goods=$a['data'];

		$itemcatsname=$goods_type[$cid]?$goods_type[$cid]:'淘宝精品';
	}
	elseif(TAOTYPE==2){
		if($cid=='' && $q==''){$q=$webset['hotword'][0];}
		$Tapparams['keyword']=$q; 
		$Tapparams['cid']=$cid;
		$Tapparams['page_no']=$page;
		$Tapparams['page_size']=$pagesize;
		$Tapparams['sort']=$webset['taoapi']['sort']; 
		$Tapparams['outer_code']=$dduser['id'];
		if(BROWSER==1){ //浏览器行为，获取掌柜信息
			$Tapparams['seller']=1;
		}
		$Tapparams['total']=1;
	
		$goods=$ddTaoapi->taobao_tbk_items_get($Tapparams);
	
		if(!is_numeric($goods)){
			//最多显示10页
			if($goods['total']>$pagesize*10){
				$TotalResults=10*$pagesize;
			}
			else{
				$TotalResults=$goods['total'];
			}
			$goods=arr_diff($goods, array('total')); //因为返回的数组中包含个数total，需要去掉
	
			//网站头
			if($Tapparams['keyword']!=''){
				$itemcatsname=$Tapparams['keyword'];
			}
			elseif($Tapparams['cid']>0){
				$converter=include(DDROOT.'/comm/converter.php');
				unset($converter[0]);
				foreach($converter as $v){
					$v=trim($v);
					if(preg_match('/^'.$Tapparams['cid'].',/',$v)){
						preg_match('/^'.$Tapparams['cid'].',\d+,(.*), /',$v,$a);
						$itemcatsname=$a[1];
					}
				}
			}

		}
		else{
			error_html('商品不存在',-1,1);
		}
	}
	
	
	$show_parameter=array('cid'=>$cid,'q'=>$q,'list'=>$list,'page'=>$page);
	$showpic_list1=u(MOD,ACT,arr_replace($show_parameter,'list',1)); //小图显示
	$showpic_list2=u(MOD,ACT,arr_replace($show_parameter,'list',2)); //大图显示
	unset($show_parameter['page']);
	$show_page_url=u(MOD,ACT,$show_parameter);
	
	$parameter['goods_type']=$goods_type;
	$parameter['tao_area']=$tao_area;
	$parameter['tao_sort']=$tao_sort;
	$parameter['shield_cid']=$shield_cid;
	$parameter['pagesize']=$pagesize;
	$parameter['q']=$q;
	$parameter['cid']=$cid;
	$parameter['list']=$list;
	$parameter['page']=$page;
	$parameter['TotalResults']=$TotalResults;
	$parameter['liebiao']=$liebiao;
	$parameter['goods']=$goods;
	$parameter['itemcatsname']=$itemcatsname;
	$parameter['search']=$search;
	$parameter['cat_list']=$cat_list;
	$parameter['item_cid']=$item_cid;
	$parameter['show_parameter']=$show_parameter;
	$parameter['showpic_list1']=$showpic_list1;
	$parameter['showpic_list2']=$showpic_list2;
	$parameter['show_page_url']=$show_page_url;
	
	unset($duoduo);
	return $parameter;
}
?>