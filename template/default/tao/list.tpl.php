<?php  //淘宝商品列表
$parameter=act_tao_list();
extract($parameter);
$css[]=TPLURL."/css/goods.css";
$css[]=TPLURL."/css/list.css";
$js[]="js/md5.js";
$js[]="js/jssdk.js";
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
	<div class="mainbody1000">
        <div class="small_big" id="layerPic">
			<div class="sell_bg"></div>
			<div class="photo"></div>
		 </div>

        <div class="gouwufanxian biaozhun1">
        
        	<div class="goodslist">
                <?php if(TAOTYPE==1){include(TPLPATH."/tao/hotcat.tpl.php");}?>
                <?php if(TAOTYPE==2){include(TPLPATH."/tao/hotword.tpl.php");}?>
                <?php if(TAOTYPE==1){$listtpl=$list+2;}else{$listtpl=$list;} include(TPLPATH."/tao/list".$listtpl.".tpl.php");?>
                <?php if(empty($goods)){?>
                     <div style="margin-left:10px; margin-bottom:30px; font-size:14px">暂无查询条件商品数据！</div>
                     <?php }?> 
                <div class="megas512" ><?=pageft($TotalResults,$pagesize,$show_page_url,WJT)?></div>
            </div>
            </div>

        <div class="goodsright">
            <?php if(TAOTYPE==1){include(TPLPATH."/tao/right_goods.tpl.php");}?>
        	<?php if(TAOTYPE==2){include(TPLPATH."/tao/right_category.tpl.php");}?>
              <?=AD(3)?>      
        </div>
        <div style="clear:both"></div>
        <?=AD(108)?>
	</div>
</div>	

<script type="text/javascript" src="js/jquery.lazyload.js"></script>
<script language="javascript">
$(function(){
	$("div.pic a img").lazyload({
        placeholder : "<?=TPLURL?>/images/grey.gif",
        effect      : "fadeIn",
	    threshold : 200
    });
})
</script>
<?php include(TPLPATH."/footer.tpl.php");?>