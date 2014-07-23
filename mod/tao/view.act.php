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
* @name 淘宝商品详情
* @copyright duoduo123.com
* @example 示例tao_view();
* @param $field 字段
* @param $q 关键字
* @param $iid 商品ID
* @return $parameter 结果集合
*/
function act_tao_view(){
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	$has_fanli=0;
	$ju_html='';
	$lanmu_title='';
	$zhuanxiang=0;
	$zhuanxiang_price=0;
	$qrcode='';
	$max_fan=$webset['taoapi']['max_fan'];
	$id=(int)$_GET['id'];
	$iid=(float)$_GET['iid'];
	$q=trim($_GET['q']);
	if($q!=''){
		$is_url=reg_taobao_url($q);
	}
	
	if($iid>0 && strlen($iid)<8){
		$id=$iid;
	}
	
	if($id>0){
		$ddgoods=$duoduo->select('ddgoods','*','id="'.$id.'"');
		$iid=$ddgoods['iid'];
		if($ddgoods['code']=='zhuanxiang'){
			$zhuanxiang=1;
			$qrcode=SITEURL.'/api/qrcode.php?id='.$id;
			$zhuanxiang_price=$ddgoods['shouji_price'];
		}
		$lanmu_title=$webset['ddgoodslanmu'][$ddgoods['code']];
	}
	elseif($is_url){
		$iid=(float)get_tao_id($q);
	}
	elseif($q!=''){
		if($webset['taoapi']['s8']==1){
			$url=$ddTaoapi->taobao_taobaoke_listurl_get($q,$dduser['id']);
			$url=$goods['jump']="index.php?mod=jump&act=s8&url=".urlencode(base64_encode($url)).'&name='.urlencode($q);
			jump($url);
		}
		else{
			error_html('S8未开启',5);
		}
	}

	if((strpos($iid,'E')!==false || strlen($iid)>=13) && strpos($q,'ju.taobao.com')!==false){
		$ju_html=file_get_contents($q);
		$a=explode('<input type="hidden" id="itemId" value="',$ju_html);
		preg_match('/(\d+)"/',$a[1],$a);
		$iid=$a[1];
	}
	
	if($iid==0){
		error_html('缺少淘宝商品id',5);
	}
	
	if($ju_html==''){
		$ju_url='http://detail.ju.taobao.com/home.htm?item_id='.$iid;
		$ju_html=file_get_contents($ju_url);
	}
	
	if($ju_html!='' && strpos($ju_html,'<input type="hidden" id="itemId" value="'.$iid.'"')!==false && strpos($ju_html,'<span class="out floatright">')===false){
		error_html('聚划算商品无返利！<br/><a data-type="0" biz-itemid="'.$iid.'" data-tmpl="628x100" data-tmplid="7" data-rd="1" data-style="2" data-border="1" href=""></a><a data-type="0" biz-itemid="'.$iid.'" data-tmpl="192x40" data-tmplid="225" data-rd="1" data-style="2" data-border="1" href=""></a>');
	}

	$goods=$duoduo->select('goods','*','iid="'.$iid.'"');
	if(!empty($goods)){
		$allow_fanli=1;
		$has_fanli=1;
		$max_fan=(int)fenduan($goods['commission'],$webset['fxbl'],$dduser['level'],TBMONEYBL).TBMONEY;
	}
	
	$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
	if($ddgoods['discount_price']>0){
		$a['ds_discount_price']=$ddgoods['discount_price'];
	}
	if($zhuanxiang_price>0){
		$a['ds_discount_price']=$zhuanxiang_price;
	}
	$tao_goods['discount_price']=$a['ds_discount_price'];
	$tao_goods['rate']=$a['ds_discount_rate'];
	$tao_goods['img']=$tao_goods['pic_url']=$a['ds_img']['src'];
	$tao_goods['iid']=$a['ds_nid'];
	$tao_goods['diqu']=$a['ds_provcity'];
	$tao_goods['price']=$a['ds_reserve_price'];
	$tao_goods['sell']=$tao_goods['volume']=$a['ds_sell'];
	$tao_goods['title']=$a['ds_title'];
	$tao_goods['user_id']=$a['ds_user_id'];
	$tao_goods['taoke']=(int)$a['ds_taoke'];
	$tao_goods['click_url']=$a['ds_item_click'];
	$tao_goods['shop_click_url']=$a['ds_shop_click'];
	
	if($tao_goods['title']==''){
		error_html('该商品不存在，<a style="font-size:14px" href="'.tao_goods_url($iid).'" target="_blank">去淘宝看看</a>。<br/><a data-type="0" biz-itemid="'.$iid.'" data-tmpl="628x100" data-tmplid="7" data-rd="1" data-style="2" data-border="1" href=""></a><a data-type="0" biz-itemid="'.$iid.'" data-tmpl="192x40" data-tmplid="225" data-rd="1" data-style="2" data-border="1" href=""></a>',-1,1);
	}
	
	if($tao_goods['taoke']>0){
		$has_fanli=1;
	}
	
	$a=$ddTaoapi->taobao_tbk_tdj_get($tao_goods['user_id'],2,1);
	
	$tao_goods['logo']=$a['ds_img']['src'];
	$tao_goods['shopname']=$a['ds_shopname'];
	$tao_goods['keywords']=$a['ds_vidname'];
	$tao_goods['dsr_mas']=$a['ds_dsr_mas'];
	$tao_goods['dsr_sas']=$a['ds_dsr_sas'];
	$tao_goods['dsr_cas']=$a['ds_dsr_cas'];
	$tao_goods['nick']=$a['ds_nick'];
	if($a['ds_istmall']==1){
		$a['ds_rank']=21;
	}
	$tao_goods['level']=$a['ds_rank'];
	
	$seelog=array('type'=>'tao','iid'=>$tao_goods['iid'],'pic'=>$tao_goods['img'].'_100x100.jpg','title'=>$tao_goods['title'],'price'=>$tao_goods['price'],'discount_price'=>$tao_goods['discount_price']);
	set_browsing_history($seelog);
	
	$tao_goods['jump']=u('jump','goods',array('iid'=>$tao_goods['iid'],'price'=>$tao_goods["discount_price"],'pic'=>$tao_goods["img"].'_100x100.jpg','fan'=>$max_fan));
	$tao_goods['shop_jump']=u('jump','shop',array('user_id'=>$tao_goods['user_id'],'nick'=>$tao_goods["nick"],'pic'=>$tao_goods["logo"]));
	$shop=array('jump'=>$tao_goods['shop_jump'],'user_id'=>$tao_goods['user_id'],'pic_url'=>$tao_goods["logo"],'title'=>$tao_goods['shopname'],'nick'=>$tao_goods['nick'],'click_url'=>$tao_goods['shop_click_url']);
	if($tao_goods['level']==21){
		$shop['onerror']='images/tbsc.gif';
	}
	else{
		$shop['onerror']='images/tbdp.gif';
	}

	if(TAO_SEARCH_URL!=1 && $is_url){
		error_html('搜索格式有误，不能搜索网址了！请到网站查看查找自己想要的商品！或搜索淘宝商品名关键词！');
	}
	
	if($tao_goods['click_url']!='' && $_GET['go_click']==1){ //不经过jump，直接跳转
		jump($tao_goods['click_url']);
	}
	
	if(WEBTYPE==0 && $_GET['stop']!=1){
		jump($tao_goods['jump']);
	}

	if($tao_goods['discount_price']<$tao_goods['price']){
		$price_name='<span class="tbcuxiao"><i>打折促销</i><span>';
		$tao_goods['yuanjia']=$tao_goods['price'];
		$tao_goods['price']=$tao_goods['promotion_price']=$tao_goods['discount_price'];
	}
	else{
		$price_name='商品价格';
	}
	
	if($lanmu_title!=''){
		$price_name='<span class="tbcuxiao"><i>'.$lanmu_title.'</i><span>';
	}
	
	if(BROWSER==1){  //浏览器访问获取返利授权，节约api
		$allow_fanli=$ddTaoapi->taobao_taobaoke_rebate_authorize_get($iid);
	}
	else{
		$allow_fanli=1;
	}
	
	$goods=$tao_goods;
	
	$comment_url="http://rate.taobao.com/detail_rate.htm?&auctionNumId=".$iid."&showContent=2&currentPage=1&ismore=1&siteID=7&userNumId=".$shop['user_id'];
		
	$tuijian_lanmu_code='jiu';
	$tuijian_lanmu_title=$webset['ddgoodslanmu'][$tuijian_lanmu_code];
	include(DDROOT.'/comm/ddgoods.class.php');
	$ddgoods_class=new ddgoods($duoduo);
	$tuijian_lanmu_goods=$ddgoods_class->index_list(5,1,'code="'.$tuijian_lanmu_code.'"');
	
	include(DDROOT.'/plugin/tao_coupon.php');

	if(REPLACE<3){
		$noword_tag='';
	}
	else{
		$noword_tag='3';
	}
	$nowords=dd_get_cache('no_words'.$noword_tag);
	$goods['title']=dd_replace($goods['title'],$nowords);
	
	$parameter['goods']=$goods;
	$parameter['price_name']=$price_name;
	$parameter['comment_url']=$comment_url;
	$parameter['allow_fanli']=$allow_fanli;
	$parameter['max_fan']=$max_fan;
	$parameter['tao_coupon_str']=$tao_coupon_str;
	$parameter['has_fanli']=$has_fanli;
	$parameter['shop']=$shop;
	$parameter['tuijian_lanmu_goods']=$tuijian_lanmu_goods;
	$parameter['tuijian_lanmu_title']=$tuijian_lanmu_title;
	$parameter['tuijian_lanmu_code']=$tuijian_lanmu_code;
	$parameter['zhuanxiang']=$zhuanxiang;
	$parameter['qrcode']=$qrcode;
	
	unset($duoduo);
	return $parameter;
}
?>