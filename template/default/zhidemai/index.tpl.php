<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

define('VIEW_PAGE',1);

include(DDROOT.'/comm/zhidemai.class.php');
$zhidemai_class=new zhidemai($duoduo);

$ajax_load_num=5;
$zhidemai_total=1;

$contentData=json_encode(array('cid'=>$cid,'pagesize'=>$pagesize));

$css[]=TPLURL."/css/zhide-css.css";
include(TPLPATH.'/header.tpl.php');
?>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<?php include(TPLPATH.'/inc/banner.tpl.php');?>

<div> </div>
    <div class="zdm-body yahei" id="zdm-body">
      <div class="zhidecontainer">
        <div id="J-zdm-article" class="zdm-article" data-pagename="index">
          <?php include(TPLPATH.'/zhidemai/top.tpl.php')?>
          <div class="zdm-list zhidemai_goods_list" id="zhidemaiDiv">
          <?php include(TPLPATH.'/zhidemai/data.tpl.php')?>
          </div>
          <div id="ajax_goods_loading" style="background:#999; color:#FFF; width:210px; height:25px; line-height:25px; margin:auto; margin-top:10px; display:none; text-align:center"><img src="<?=TPLURL?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
          <?php if($zhidemai_total==1){?><div class="megas512" style="padding:10px; display:none"><?=pageft($total,$pagesize*(1+$ajax_load_num),u(MOD,ACT,$url_arr),WJT)?></div><?php }?>
        </div>
        <div class="zdm-aside" style=" float:left;margin-left:10px"><?php include(TPLPATH.'/zhidemai/left.tpl.php')?></div>      
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
	zhidemaiLazyLoad();
	ajaxLoad('.zdm-list','.megas512',<?=$ajax_load_num?>,'<?=l($shuju_code,'data')?>',<?=$contentData?>,500,zhidemaiLazyLoad);
})
</script>
<?php include(TPLPATH.'/zhidemai/js.tpl.php')?>
<?php include(TPLPATH.'/zhidemai/cat.tpl.php');?>
<?php
include(TPLPATH.'/footer.tpl.php');
?>