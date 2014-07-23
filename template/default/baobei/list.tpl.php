<?php
$parameter=act_baobei_list();
extract($parameter);
$css[]=TPLURL.'/css/baobei.css';
$css[]=TPLURL.'/css/shai_l.css';
$css[]='css/qqFace.css';
include(TPLPATH."/header.tpl.php");
?>
<div class="biaozhun5" style="width:1000px; background:#FFF;  margin:auto; margin-top:10px; padding-bottom:10px">
<div class="main">
<?=AD(11)?>
  <?php include(TPLPATH."/baobei/topcat.tpl.php");?>
  <div class="keywords ad">
    <button id="<?=$share_button_id?>">分享我喜欢的</button>
    <span>
    <?php if($dduser['level']<$webset['baobei']['share_level']){?>
    等级达到<?=$webset['baobei']['share_level']?>才可分享宝贝！
    <?php }else{?>
    告诉大家你喜欢的宝贝！
    <?php }?>
    </span>
  </div>
  <div style="height:2px; overflow:hidden; background:#F0F0F0; border-left:1px solid #ECECEC; border-right:1px solid #ECECEC;">&nbsp;</div>
  <div class="good">
    <div class="goods-top">
      <ul>
        <li <?php if($sort=='id'){?> class="cur"<?php }?>><a href="<?=u('baobei','list',array('sort'=>'id','cid'=>0,'q'=>'','page'=>1))?>">最新宝贝</a></li>
        <li <?php if($sort=='hart'){?> class="cur"<?php }?>><a href="<?=u('baobei','list',array('sort'=>'hart','cid'=>0,'q'=>'','page'=>1))?>">最热宝贝</a></li>
      </ul>
    </div>
    <!-- 产品列表 开始 -->
    <div class="goods">
    <?php if($total==0){?><div style="text-align:center; padding-top:20px; font-size:16px; color:#F00; font-weight:bold">暂无宝贝</div><?php }?>
    <?php include(TPLPATH."/baobei/baobei.tpl.php")?>
  </div>
  	<!-- 产品列表 结束 -->
<script type="text/javascript">
$(function(){
	<?php if($dduser['level']<$webset['baobei']['share_level']){?>
	$('#<?=$share_button_id?>').attr('disabled',true).attr('title','等级达到<?=$webset['baobei']['share_level']?>才可分享宝贝');
	<?php }?>
	$('#noLogin').click(function(){
	    alert(errorArr[10]);
		window.location='<?=u('user','login')?>&from='+encodeURIComponent(location.href);
	});
	$('#noLevel').click(function(){
	    alert(errorArr[21]);
		helpWindows('每次成功购物级别都可增加<b>1</b>，亲加油吧！','<?=WEBNAME?>小助手');
	});
})
</script>
</div>
</div>
</div>
<?php
include(TPLPATH."/baobei/share.tpl.php");
?>
<?php
include(TPLPATH."/footer.tpl.php");
?>