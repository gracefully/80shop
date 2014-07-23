<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

define('VIEW_PAGE',1);

include(DDROOT.'/comm/ddgoods.class.php');
$ddgoods_class=new ddgoods($duoduo);

$ajax_load_num=2;
$code=$shuju_code=MOD;

$ddgoods_total=1;
$cat_arr=$ddgoods_class->catname($code);

$rate_arr=array(0=>'默认','一折','两折','三折','四折','五折'/*,'六折','七折','八折','九折'*/);

$cur_cid=(int)$_GET['cid'];
$cur_rate=(int)$_GET['rate'];

$css[]=TPLURL."/css/tejia.css";
include(TPLPATH.'/header.tpl.php');
?>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<?php include(TPLPATH.'/inc/banner.tpl.php');?>
<div id="tejiaContent">
	
    
    <div class="brand-category">
    <div id="tejia-top">
				<div class="ks-tabs-panel" id="fenlei">
					<ul class="ks-switchable-nav">
                    <?php foreach($cat_arr as $k=>$v){?>
                    <li class="brand-category-navitem member-<?=(int)$k?>"><a <?php if($k==$cur_cid){?>class="brand-category-selected"<?php } ?> href="<?=u(MOD,ACT,array('cid'=>(int)$k,'rate'=>(int)$cur_rate))?>"><?=$v?></a></li>
                    <?php }?>
					</ul>
				</div>
				<div class="ks-switchable-content">
					<div class="ks-tabs-body ks-tabs-selected">
                    <?php foreach($rate_arr as $k=>$v){?><a href="<?=u(MOD,ACT,array('cid'=>$cur_cid,'rate'=>$k))?>" <?php if($k==$cur_rate){?>class="current"<?php }?>><?=$v?></a><?php }?>
					</div>
				</div>
                </div>
			</div>    
    

	<div class="filter-list-detail">
		<ul class="clrfix tejia_goods_list" id="tejiaDiv">
        <?php include(TPLPATH.'/tejia/data.tpl.php');?>
			
		</ul>
	</div>
	<!--page start-->
    <div id="ajax_goods_loading" style="background:#999; color:#FFF; width:210px; height:25px; line-height:25px; margin:auto; margin-top:10px; display:none; text-align:center"><img src="<?=TPLURL?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
		<div class="megas512" style="padding:10px; display:none"><?php if($ddgoods_total==1){?><?=pageft($total,$pagesize*(1+$ajax_load_num),u(MOD,ACT,$url_arr),WJT)?><?php }?></div>
	<!--page end-->
</div>
<?php
$a=$url_arr;
$a['code']=$code;
$contentData=json_encode($a);
?>
<script type="text/javascript">
scrollPaginationPage=(<?=$ajax_load_num?>-1)*<?=($page-1)?>+1;

$(function(){
	tejiaLazyLoad();
	ajaxLoad('.filter-list-detail ul','.megas512',<?=$ajax_load_num?>,'<?=l($shuju_code,'data')?>',<?=$contentData?>,500,tejiaLazyLoad);
	fixDiv('#tejia-top',0);
})
</script>
<?php
include(TPLPATH.'/footer.tpl.php');
?>