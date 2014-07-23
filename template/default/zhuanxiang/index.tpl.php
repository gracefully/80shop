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

$contentData=json_encode(array('pagesize'=>$pagesize));

$css[]=TPLURL."/css/zhuanxiang.css";
include(TPLPATH.'/header.tpl.php');
?>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<?php include(TPLPATH.'/inc/banner.tpl.php');?>
<div class="wrap">
	<div class="sec_main">
		<div class="wrap-cont">
			<!-- 商品开始 [[-->
			<div class="more-goods" id="zhuanxiangDiv">
				<div class="more-goods-list" id="goods_detail">
					<ul id="goods_list" class="zhuanxiang_goods_list">
                    <?php include(TPLPATH.'/zhuanxiang/data.tpl.php');?>
					</ul>
				</div>
                <?php include(TPLPATH.'/zhuanxiang/jumpbox.tpl.php');?>
				<div class="mod_pager">
                <div id="ajax_goods_loading"><img src="<?=TPLURL?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
					<div class="megas512" style="padding:10px; display:none"><?php if($ddgoods_total==1){?><?=pageft($total,$pagesize*(1+$ajax_load_num),u(MOD,ACT,$url_arr),WJT)?><?php }?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$a=$url_arr;
$a['code']=$code;
$contentData=json_encode($a);
?>
<script type="text/javascript">
scrollPaginationPage=(<?=$ajax_load_num?>-1)*<?=($page-1)?>+1;


$(function(){
	zhuanxiangLazyLoad();
	ajaxLoad('#goods_list','.megas512',<?=$ajax_load_num?>,'<?=l($shuju_code,'data')?>',<?=$contentData?>,500,zhuanxiangLazyLoad);
});
</script>
<?php
include(TPLPATH.'/footer.tpl.php');
?>