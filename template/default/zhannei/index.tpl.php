<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

define('VIEW_PAGE',1);

include(DDROOT.'/comm/ddgoods.class.php');
$ddgoods_class=new ddgoods($duoduo);

$ajax_load_num=5;
$code=$shuju_code=MOD;
$ddgoods_total=1;

$contentData=json_encode(array('pagesize'=>$pagesize));

include(TPLPATH.'/header.tpl.php');
?>
<link rel="stylesheet" href="<?=TPLURL?>/css/zhannei.css"/>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<div class="taoshihui">
            <div class="lay-1000-auto">
                <div class="tsh_tabmain">
                    <!-- 全部 -->
                    <div class="ten-tuan-bottom">
                        <ul id="zhanneiDiv">
                            <?php include(TPLPATH.'/zhannei/data.tpl.php');?>
                        </ul>
                    </div>
                    <div id="ajax_goods_loading" ><img src="<?=TPLURL?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
					<div class="megas512" style="padding:10px; display:none"><?php if($ddgoods_total==1){?><?=pageft($total,$pagesize*(1+$ajax_load_num),u(MOD,ACT,$url_arr),WJT)?><?php }?></div>
                </div>
            </div>
        </div>
        

<?php include(TPLPATH.'/zhuanxiang/jumpbox.tpl.php');?>


<?php
$a=$url_arr;
$a['code']=$code;
$contentData=json_encode($a);
?>
<script type="text/javascript">
scrollPaginationPage=(<?=$ajax_load_num?>-1)*<?=($page-1)?>+1;


$(function(){
	zhanneiLazyLoad();
	ajaxLoad('#zhanneiDiv','.megas512',<?=$ajax_load_num?>,'<?=l($shuju_code,'data')?>',<?=$contentData?>,500,zhanneiLazyLoad);
});
</script>
<?php
include(TPLPATH.'/footer.tpl.php');
?>