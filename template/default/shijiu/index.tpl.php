<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

define('VIEW_PAGE',1);

include(DDROOT.'/comm/ddgoods.class.php');
$ddgoods_class=new ddgoods($duoduo);

$code=$shuju_code=MOD;
$ajax_load_num=2;
$cat_arr=$ddgoods_class->catname($code);

$ddgoods_total=1;

$order_by='sort asc,id desc';
$cur_cid=(int)$_GET['cid'];
$cur_sort=$_GET['sort'];

$css[]=TPLURL."/css/jiu.css";
include(TPLPATH.'/header.tpl.php');
?>
<script type="text/javascript" src="js/scrollpagination.js"></script>

<?php include(TPLPATH.'/inc/banner.tpl.php');?>

<div class="main2" style="width:1000px;">
	<div class="piece jiu_goods">
		<div class="piece_box">
			<div class="white_dh">
				<div class="jiudaohang">
					<div class="h_left">
					</div>
					<div class="h_center" style="width:976px;">
						<div class="jiu_hd">
							<div class="jiu_dao">
								<h3><?=$webset['ddgoodslanmu'][$code]?>：</h3>
								<ul>
                                <?php foreach($cat_arr as $k=>$v){?>
                                <li class="<?php if($cur_cid==$k){?>current<?php }?> cat<?=(int)$k?>"><a href="<?=u(MOD,ACT,array('cid'=>(int)$k,'sort'=>$cur_sort))?>"><i class="cat_<?=(int)$k?>"></i><span><?=$v?></span></a></li>
                                <?php }?>
								</ul>
						</div>
					</div>
					<div class="category_sort_all">
						<b>排序：</b>
						<ul class="category_color">
							<li class="category_sort_l"><a <?php if($cur_sort==''){?> class="c"<?php }?> href="<?=u(MOD,ACT,array('cid'=>$cur_cid,'sort'=>''))?>"><i></i><span title="全部">不限制</span></a></li>
							<li class="category_sort_c"><a <?php if($cur_sort=='price'){?> class="c"<?php }?> href="<?=u(MOD,ACT,array('cid'=>$cur_cid,'sort'=>'price'))?>"><span title="按价格从低到高排序">价格</span></a></li>
							<li class="category_sort_c"><a <?php if($cur_sort=='sell'){?> class="c"<?php }?> href="<?=u(MOD,ACT,array('cid'=>$cur_cid,'sort'=>'sell'))?>"><span title="按销量从高到底排序">销量</span></a></li>
							<li class="category_sort_r"><a <?php if($cur_sort=='rate'){?> class="c"<?php }?> href="<?=u(MOD,ACT,array('cid'=>$cur_cid,'sort'=>'rate'))?>"><span title="按折扣从低到高排序">折扣</span><i class="right_yuan"></i></a></li>
						</ul>
					</div>
					<!--<div class="type_page">
						<span class="normal" style="color:#666">上一页</span><a class="pg_next" href="http://yun.duoduo123.com/index.php?g=Home&m=Shuju&a=jiu&p=2&type=2"><span>下一页</span><em></em></a>
					</div>-->
				</div>
				<div class="h_right">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="goods_list jiu_goods_list" id="jiuDiv">
<?php include(TPLPATH.'/jiu/data.tpl.php');?>
</div>
<div style="clear:both"></div>
<?php if(!empty($ddgoods_list)){?>
<div id="ajax_goods_loading"><img src="<?=TPLURL?>/images/white-ajax-loader.gif" />&nbsp;&nbsp;&nbsp;正在加载商品</div>
<?php }?>
<div class="megas512" style="padding:10px; display:none"><?php if($ddgoods_total==1){?><?=pageft($total,$pagesize*(1+$ajax_load_num),u(MOD,ACT,$url_arr),WJT)?><?php }?></div>
</div>
<?php
$a=$url_arr;
$a['code']=$code;
$contentData=json_encode($a);
?>
<script type="text/javascript">
scrollPaginationPage=(<?=$ajax_load_num?>-1)*<?=($page-1)?>+1;

$(function(){
	jiuLazyLoad();
	ajaxLoad('.goods_list','.megas512',<?=$ajax_load_num?>,'<?=l($shuju_code,'data')?>',<?=$contentData?>,500,jiuLazyLoad);
	fixDiv('.piece_box',0);
})
</script>
<?php
include(TPLPATH.'/footer.tpl.php');
?>