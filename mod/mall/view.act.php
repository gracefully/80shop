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
* @name 商城列表
* @copyright duoduo123.com
* @example 示例mall_lists();
* @param $field 字段
* @param $field2 字段
* @param $field3 字段
* @return $parameter 结果集合
*/
function act_mall_view($field='*',$field2='a.*,b.ddusername',$field3='a.id,a.sdate,a.edate,a.title,a.img,a.desc,a.mall_id,a.relate_id,b.title as mallname,b.img as logo,b.fan'){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	include(DDROOT.'/comm/mallapi.config.php');
	$id=intval($_GET['id'])?intval($_GET['id']):0;
	$do=$_GET['do']?$_GET['do']:'content';
	
	$fanli_type=array(1=>'金额',2=>'积分');
	
	if($do!='content' && $do!='huodong' && $do!='goods'){
		$do='content';
	}
	if($id==0){
		error_html('miss id');
	}
	
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=10;
	$frmnum=($page-1)*$pagesize;
	$zong_fen=0;
	$pjf='0.0';
	$x=0;
	$fen=0;
	
	//查找店铺数据库
	$table_name=get_mall_table_name();
	
	$mall=$duoduo->select($table_name,'*','id="'.$id.'"');
	
	$seelog=array('type'=>'mall','id'=>$mall['id'],'pic'=>$mall['img'],'title'=>$mall['title'],'fan'=>$mall['fan']);
	set_browsing_history($seelog);
	
	if($mall['id']==''){error_html('数据不存在！',-1);}
	
	$jump_arr=array('mid'=>$mall['id']);
	
	if($_GET['url']!=''){
		$jump_arr['url']=$_GET['url'];
	}
	$jump=l('jump','mall',$jump_arr);
	
	if($_GET['jump']==1){
		jump($jump);
	}
	
	if($do=='content'){
		$mall_comment_total=$duoduo->count('mall_comment',"`mall_id` = '$id'");
		$mall_comment=$duoduo->select_all('mall_comment as a,user as b',$field2,"a.`mall_id` = '$id' and a.uid=b.id order by a.id desc limit $frmnum,$pagesize");
	}
	elseif($do=='huodong'){
		$total=$duoduo->count('huodong as a,'.$table_name.' as b','a.mall_id=b.id and a.mall_id="'.$id.'"');
		$huodong=$duoduo->select_all('huodong as a,'.$table_name.' as b',$field3, "a.mall_id=b.id and a.mall_id='".$id."' order by a.sort desc,a.id desc limit $frmnum,$pagesize");
		foreach($huodong as $k=>$row){
			if($row['relate_id']>0){
				$huodong[$k]['goto']=u('huan','view',array('id'=>$row['relate_id']));
			}
			else{
				$huodong[$k]['goto']=u('huodong','view',array('id'=>$row['id']));
			}
		}
	}
	elseif($do=='goods'){
		
		if($mall_api_set['api']=='yiqifa'){
			$param['keyword']=$ddYiqifa->hotword;
			$param['rowcount']=8;
			$param['merchantids']=$mall['merchantId'];
			$goods=$ddYiqifa->product_search($param); //获取商品
		}
		elseif($mall_api_set['api']=='wujiumiao'){
			$param['page_no']=1;
			$param['sid']=$mall['wujiumiaoid'];
			$param['page_size']=8;
			$param['outer_code']=$dduser['id'];
			$goods=$dd59miao->items_search($param);
		}
		
		
		if(is_array($goods)){
			$total=count($goods);
			foreach($goods as $k=>$row){
				$goods[$k]['fan']=$mall['fan'];
				$goods[$k]['renzheng']=1;
				$goods[$k]['goods_jump']='index.php?mod=jump&act=mall_goods&pic='.urlencode($goods[$k]['base64_pic']).'&name='.$goods[$k]['name_url'].'&url='.urlencode(base64_encode($row['url'])).'&price='.$row['price'].'&fan='.urlencode($goods[$k]['fan']);
				$goods[$k]['mall_jump']='index.php?mod=jump&act=s8&url='.urlencode(base64_encode($row['mall_url'])).'&name='.urlencode($row['mall_name']).'&fan='.urlencode($goods[$k]['fan']);
			}
		}
	}

	$mall_comment_total=$duoduo->count('mall_comment',"`mall_id` = '".$id."'");
	if($mall_comment_total>0){
		$zong_fen=$duoduo->sum('mall_comment','fen',"mall_id='".$id."'");
		$pjf=number_format($zong_fen/$mall_comment_total,1);
		$fen=(float)round($zong_fen/$mall_comment_total,2);
	}
	$data=array('score'=>$fen,'pjnum'=>$mall_comment_total);
	$duoduo->update('mall',$data,'id="'.$id.'"');
	
	/*if(isset($sjidname) && $mall[$sjidname]>0){
		$do_arr=array('content'=>'商家介绍','goods'=>'精品推荐','huodong'=>'促销&amp;优惠');
	}
	else{
		$do_arr=array('content'=>'商家介绍','huodong'=>'促销&amp;优惠');
	}*/
	
	$do_arr=array('content'=>'商家介绍','huodong'=>'促销&amp;优惠');
	
	$page_url=u(MOD,ACT,array('id'=>$id,'do'=>$do));
	unset($duoduo);
	$parameter['mall']=$mall;
	$parameter['jump']=$jump;
	$parameter['do']=$do;
	$parameter['id']=$id;
	$parameter['do_arr']=$do_arr;
	$parameter['fanli_type']=$fanli_type;
	$parameter['pjf']=$pjf;
	$parameter['fen']=$fen;
	$parameter['page']=$page;
	$parameter['pagesize']=$pagesize;
	$parameter['mall_comment_total']=$mall_comment_total;
	$parameter['mall_comment']=$mall_comment;
	$parameter['huodong']=$huodong;
	$parameter['total']=$total;
	return $parameter;
}
?>