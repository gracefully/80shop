<?php
$parameter=act_tao_index();
extract($parameter);

/*if($webset['taoapi']['taobao_chongzhi_pid']!='' && $webset['taoapi']['taobao_chongzhi_pid']!=$webset['taodianjin_pid']){
	$chongzhi_url=SITEURL.'/page/chongzhi.php?pid='.$webset['taoapi']['taobao_chongzhi_pid'].'&uid='.$dduser['id'];
}
else{
	$chongzhi_url=$ddTaoapi->tdj_zujian(1,$dduser['id']);
}*/
$chongzhi_url=$ddTaoapi->tdj_zujian(1,$dduser['id']);

$css[]=TPLURL."/css/tao_index.css";
include(TPLPATH.'/header.tpl.php');
?>
<script src="<?=TPLURL?>/js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script>
$(function(){
	<?php if(!empty($slides)){?>
	$("#KinSlideshow").KinSlideshow({
		isHasTitleFont:false,
		isHasTitleBar:false,
		btn:{btn_fontHoverColor:"#FFFFFF"}
	});
	<?php }?>
	$('.url-how-to span').hover(function(){
	    $(this).next('.hover-tips').show();
	},function(){
		$(this).next('.hover-tips').hide();
	});
	
    $('#content form').jumpBox({  
		LightBox:'show',
		jsCode:'$content.html($("#searchtip").html());',
		reg:'reg_url($("#inner-offer-q").val())',
		height:250,
		width:555,
		bind:'submit',
		a:1,
		background:'url(images/xiexian.gif) #FFFFFF'
    });
	
	//$('tkbox').remove().next('a').show();
})
</script>
<div class="biaozhun5" style="width:1000px; background:#FFF; margin:auto; margin-top:10px; padding-bottom:10px">
<div id="main" style="width:950px; margin:auto; padding-top:10px">
            <?php if(!empty($slides)){?>
        <div>
        <div style="margin-bottom:10px">
    <div id="KinSlideshow" style="visibility:hidden;">
      <?php foreach($slides as $row){?>
      <a href="<?=$row['url']?>" target="_blank"><img src="<?=$row['img']?>" alt="<?=$row['title']?>" width="948" height="90" /></a>
      <?php }?>
    </div>
</div>
        </div>
        <?php }?>
		<?php if(TAOTYPE==1){include(TPLPATH.'/tao/catlist.tpl.php');}?>
        <?php if(TAOTYPE==2){include(TPLPATH.'/tao/category.tpl.php');}?>
        <div class="taoright">
        <script>
        document.write('<iframe name="alimamaifrm" frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="no" width="230" height="212" style="border:1px solid #D8D8D8" src="<?=$chongzhi_url?>" ></iframe>');
        </script>
        <div class="ir_cx">
			<div class="ir_cxtt"><em>淘宝最热店铺</em></div>
			<div id="cxlist" class="ir_cxlist" style="padding-bottom:10px">
            <?php if(TAODATATPL==2){?>
                    <?php foreach($shops as $row){?>
                    <li style=" width:180px;height:190px;padding-left:20px;padding-top:8px;">
                    <a data-type="1" biz-sellerid="<?=$row['uid']?>" data-tmpl="140x190" data-tmplid="3" data-rd="1" data-style="2" target="_blank" data-border="1" href="#"><?=$row['nick']?></a>
                    </li>
                    <? }?>
                    <?php }else{?>
           <?php foreach($shops as $row){?>
				<dl>
					<dt class="i_border"><a class="pointer" target=_blank <?=tdj_click($row['jump'],$row['uid'],'shop')?>><img onerror="this.src='images/tbdp.gif'" src="<?=$row['logo']?>" alt="<?=$row['title']?>" /></a></dt>
					<dd><div class="aleft"><a class="pointer" target=_blank <?=tdj_click($row['jump'],$row['uid'],'shop')?>><s><?=$row['title']?></s></a></div><span><img src="images/level_<?=$row['level']?>.gif" alt="等级" /></span></dd>
				</dl>
           <?php }?>
            <?php }?>
			</div>
		</div>
        </div>
 
</div>
<div style="clear:both"></div>
</div>
<?=AD(108)?>
<?php include(TPLPATH.'/footer.tpl.php');?>