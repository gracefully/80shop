<?php
$parameter=act_baobei_user();
extract($parameter);
$css[]=TPLURL.'/css/baobei.css';
$css[]=TPLURL.'/css/shai_l.css';
include(TPLPATH."/header.tpl.php");
?>
<div style="width:1000px; background:#FFF; border:#D0210C 1px solid; margin:auto; margin-top:10px; padding-bottom:10px">
<div class="main">
<?=AD(11)?>
  <?php include(TPLPATH."/baobei/topcat.tpl.php");?>
  <?php include(TPLPATH."/baobei/topuser.tpl.php");?>
  <div style="height:2px; overflow:hidden; background:#F0F0F0; border-left:1px solid #ECECEC; border-right:1px solid #ECECEC;">&nbsp;</div>
  <div class="good">
  <!-- 产品列表 开始 -->
    <div class="goods">
    <?php if($total==0){?><div style="text-align:center; padding-top:20px; font-size:16px; color:#F00; font-weight:bold">暂无宝贝</div><?php }?>
    <?php include(TPLPATH."/baobei/baobei.tpl.php");?>
  </div>
  	<!-- 产品列表 结束 -->
<script type="text/javascript">
$(function(){
	$('#noLogin').click(function(){
	    alert('登陆后才可分享宝贝');
		window.location='<?=u('user','login')?>&from='+encodeURIComponent(location.href);
	});
	$('#noLevel').click(function(){
	    alert('等级大于等于<?=$webset['share']['share_level']?>才可分享宝贝');
		helpWindows('每次成功购物级别都可增加<b>1</b>，亲加油吧！','<?=WEBNAME?>小助手');
	});
})
</script>
  </div>
</div>
</div>
<?php
include(TPLPATH."/footer.tpl.php");
?>