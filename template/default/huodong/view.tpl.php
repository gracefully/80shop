<?php
$parameter=act_huodong_view();
extract($parameter);
$css[]=TPLURL."/css/malllist.css";
include(TPLPATH."/header.tpl.php");
?>
<script>
$(function(){
    $('.mall2txt img').each(function(){
        var theImage = new Image(); 
        theImage.src = $(this).attr("src");
        if(theImage.width>680){
			if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){ 
                $(this).css('width','680px');
            }
			else{
			    $(this).css('width','680');
			}
		} 
	});
})
</script>
<div class="mainbody">
<div class="mainbody1000"> 
<div class="fuleft">
<!--返利步骤开始-->
<?php include(TPLPATH."/inc/top1.tpl.php");?>
<!--返利步骤结束-->


<!--商家简介开始-->
<div class="mall2xx biaozhun5">
<div class="mall2xxwz"> 当前位置：<a href="<?=u('index')?>">首页</a> > <a href="<?=u('mall','view')?>">商城返现</a> > <?=$mall['title']?></div>
<?php include(TPLPATH."/mall/mallinfo.tpl.php");?>
<DIV class=mall2lan>
<DIV class=mall2lan-n>
<UL><LI class=current><A href="<?=u('mall','view',array('id'=>$id,'do'=>'huodong'))?>">促销&amp;优惠</A></LI></UL></DIV></DIV>
<div class="mall2txt">
<table width="390" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="67" height="25"class="color_4"><strong>活动名称：</strong></td>
                  <td width="323" height="25" class="color_4"><?=$huodong['title']?></td>
                </tr>
                <tr>
                  <td height="25" class="color_4"><strong>有效日期：</strong></td>
                  <td height="25" class="color_4"><?=date('Y-m-d',$huodong['sdate'])?> -- <?=date('Y-m-d',$huodong['edate'])?> (<?=trantime($huodong['edate'])?>)</td>
                </tr>
              </table>
<?=$huodong['content']?>
</div>
<div class="cleandd">  &nbsp;</div>

</div>
<!--商家简介结束-->
</div>
<!--购物返现结束-->
<div class="furight">
<?php include(TPLPATH.'/mall/right.tpl.php');?>
</div>

<div class="cleandd"></div>

</div>
</div>
<?php include(TPLPATH."/footer.tpl.php");?>