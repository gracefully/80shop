<?php
$parameter=act_tao_shop();
extract($parameter);
$css[]=TPLURL."/css/shop.css";
$css[]=TPLURL."/css/list.css";
$js[]="js/md5.js";
$js[]="js/jssdk.js";
include(TPLPATH."/header.tpl.php");
?>
<?php include(DDROOT.'/comm/jssdk.php');?>
<div class="mainbody">
	<div class="mainbody1000">
        
		<div class="shopleft">
            <div id="shopfix">
        	<?php include(TPLPATH.'/tao/shopinfo.tpl.php');?>
            </DIV>
            <?=AD(8)?>        
        </div>
        <div class="small_big" id="layerPic">
			<div class="sell_bg"></div>
			<div class="photo"></div>
		 </div>
        <div class="shopright">
        	<div class="goodslist">
                <?php include(TPLPATH."/tao/hotword.tpl.php");?>
                <?php include(TPLPATH."/tao/list".$list.".tpl.php");?> 
            </div>
            
        </div> 
	</div>
</div>
<script>
//fixDiv('shopfix',2);
</script>
<?php
include(TPLPATH."/footer.tpl.php");
?>
