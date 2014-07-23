<?php
$about_us_article=$duoduo->select_all('article','id,title','cid="28" and del=0 order by sort asc limit 4');

$web_help_title=array(5=>'提现问题',3=>'返利问题');
foreach($web_help_title as $k=>$v){
    $web_help_article[$k]=$duoduo->select_all('article','id,title','cid="'.$k.'" and del=0 order by sort asc limit 4');
}
?>
<div style="clear:both; height:10px">&nbsp;</div>
<div class="bottom01">
<div class="xiangguan">
<ul>
<li><a target="_blank" href="<?=u('help','index')?>"><h3>新手帮助 <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>3))?>">返利常见问题</a></p>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>4))?>">返利订单问题</a></p>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>5))?>">返利提现问题</a></p>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>6))?>">用户常见问题</a></p>
</li>

<?php foreach($web_help_article as $k=>$row){?>
<li><a target="_blank" href="<?=u('article','list',array('cid'=>$k))?>"><h3><?=$web_help_title[$k]?> <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<?php foreach($row as $arr){?>
<p><a target="_blank" href="<?=u('article','view',array('id'=>$arr['id']))?>"><?=$arr['title']?></a></p>
<?php }?>
</li>
<?php }?>
<li><a target="_blank" href="<?=u('about','index')?>"><h3>关于我们 <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<?php foreach($about_us_article as $arr){?>
<p><a target="_blank" href="<?=u('about','index',array('id'=>$arr['id']))?>"><?=$arr['title']?></a></p>
<?php }?>
</li>
</ul>


</div>
<div id="line01">&nbsp;</div>
<div class="xhqu"><?=html_entity_decode($webset['banquan']);?></div>
</div>
</div>
<?php if(MOD=='huan'){?>
<!--[if IE 6]>
<script src="<?=TPLURL?>/js/DD_belatedPNG_0.0.8a-min.js" mce_src="<?=TPLURL?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.syts');
DD_belatedPNG.fix('.sgq');
</script> 
<![endif]--> 
<?php }?>

<?php
$kefu=dd_get_cache('kefu');
if(!empty($kefu)){
?>
<div class='QQbox' id='divQQbox' >
<div class='Qlist' id='divOnline' onmouseout='hideMsgBox(event);' style='display : none;'>
<div class='t'></div>
<div class='infobox'><?=WEBNAME?>真诚为您服务</div>
<div class='con'>
<table border="0">
  <?php foreach($kefu as $row){?>
  <tr>
    <?php if($row['type']==1){?>
    <td><?=qq($row['code'])?></td><td scope="col"><?=$row['title']?></td>
    <?php }else{?>
    <td><?=wangwang($row['code'])?></td><td scope="col"><?=$row['title']?></td>
    <?php }?>
  </tr>
  <?php }?>
</table>
</div>
<div class='b'></div>
</div>
<div id='divMenu' onmouseover='OnlineOver();'><img src='images/qq_1.gif' class='press' alt='在线咨询'></div>
<script language='javascript' src='js/kefu.js' type='text/javascript' charset='utf-8'></script>
</div>
<?php }?>

<?php
if($webset['seelog']==1){
$seelog=get_browsing_history();
?>
<div id="see-log">
<div class="see-log-title">浏览过的<span>(<b><?=count($seelog)?></b>)</span></div>
  <ul>
  <?php $k=-1; foreach($seelog as $k=>$row){?>
    <li<?php if($k>4){?> class="none"<?php }?> index="<?=$k?>">
    <?php if($row['type']=='tao'){?>
    <a target="_blank" class="img" href="<?=u('tao','view',array('iid'=>$row['iid']))?>"><img src="<?=$row['pic']?>" alt="<?=$row['title']?>"></a>
    <span class="vr-panel-remove" title="删除记录"></span>
    <div class="vr-itemtip"><p class="vr-itemtip-title"><?=$row['title']?></p><p class="vr-itemtip-price">￥<span><?=$row['discount_price']?></span> <span class="yuanjia"><?=$row['price']?></span></p><span class="vr-itemtip-arrow"></span></div>
    <?php }elseif($row['type']=='mall'){?>
    <a target="_blank"  class="img" href="<?=u('mall','view',array('id'=>$row['id']))?>"><img style="height:40px; margin-top:20px" src="<?=$row['pic']?>" alt="<?=$row['title']?>"></a>
    <span class="vr-panel-remove" title="删除记录"></span>
    <div class="vr-itemtip"><p class="vr-itemtip-title"><?=$row['title']?></p><p class="vr-itemtip-price">最高返：<span><?=$row['fan']?></span></p><span class="vr-itemtip-arrow"></span></div>
    <?php }elseif($row['type']=='share'){?>
    <a target="_blank"  class="img" href="<?=u('baobei','view',array('id'=>$row['id']))?>"><img src="<?=$row['pic']?>" alt="<?=$row['title']?>"></a>
    <span class="vr-panel-remove" title="删除记录"></span>
    <div class="vr-itemtip"><p class="vr-itemtip-title"><?=$row['title']?></p><p class="vr-itemtip-price">￥<span><?=$row['price']?></span></span></p><span class="vr-itemtip-arrow"></span></div>
    <?php }elseif($row['type']=='zhidemai'){?>
    <a target="_blank"  class="img" href="<?=u('zhidemai','view',array('id'=>$row['id']))?>"><img src="<?=$row['pic']?>" alt="<?=$row['title']?>"></a>
    <span class="vr-panel-remove" title="删除记录"></span>
    <div class="vr-itemtip"><p class="vr-itemtip-title"><?=$row['title']?></p><p class="vr-itemtip-price"><span><?=substr_ext($row['subtitle'],0,13)?></span></span></p><span class="vr-itemtip-arrow"></span></div>
    <?php }elseif($row['type']=='jifen'){?>
    <a target="_blank"  class="img" href="<?=u('huan','view',array('id'=>$row['id']))?>"><img src="<?=$row['pic']?>" alt="<?=$row['title']?>"></a>
    <span class="vr-panel-remove" title="删除记录"></span>
    <div class="vr-itemtip"><p class="vr-itemtip-title"><?=$row['title']?></p><p class="vr-itemtip-price"><span style="font-size:13px">所需<?=TBMONEY?>：<?=(float)$row['jifenbao']?><br/>所需积分：<?=$row['jifen']?></span></span></p><span class="vr-itemtip-arrow"></span></div>
    <?php }elseif($row['type']=='paipai'){?>
    <a target="_blank"  class="img" href="<?=$row['jump']?>"><img src="<?=$row['pic']?>" alt="<?=$row['title']?>"></a>
    <span class="vr-panel-remove" title="删除记录"></span>
    <div class="vr-itemtip"><p class="vr-itemtip-title"><?=$row['title']?></p><p class="vr-itemtip-price">￥<span><?=$row['price']?></span></p><span class="vr-itemtip-arrow"></span></div>
    <?php }?>
    </li>
    <?php }?>
  </ul>
  <?php if($k>=0){?>
  <div class="see-log-clear">清空</div>
  <?php }?>
</div>
<?php }?>
<script>
$(function(){
	backToTop();
	var $header = $('#header-bottom');
	var sidebarTop = $header.offset().top+ 20;
	$('#see-log').css({
		'top': sidebarTop + 'px'
	}).sidebar({
		min: 0,
		ieOffset: sidebarTop,
		position: 'top',
		relative: true,
		relativeWidth: 1020,
		backToTop: false
	});	   
	
	$seeLog=$('#see-log');
	$seeLog.find('li').hover(function(){
		$(this).find('.vr-itemtip,.vr-panel-remove').show();
	},function(){
		$(this).find('.vr-itemtip,.vr-panel-remove').hide();
	});
	
	$seeLog.find('li .vr-panel-remove').click(function(){
		$t=$(this);
		var index=$t.parent('li').attr('index');
		var $a=$t.parent('li').parent('ul').prev('.see-log-title').find('span b');
		
		var data={'index':index};
		$.get('<?=u('ajax','delseelog')?>',data,function(){
			$t.parent('li').slideUp(200);
			$a.html(parseInt($a.html())-1);
			$t.parent('li').parent('ul').find('li').each(function(){
				if($(this).hasClass('none')){
					$(this).removeClass('none');
					return false;
				}
			});
		});
	});
	$seeLog.find('.see-log-clear').click(function(){
		var data={'index':-1};
		$.get('<?=u('ajax','delseelog')?>',data,function(){
			$seeLog.find('ul').hide('slow');
			$seeLog.find('.see-log-title').find('span b').html(0);
			$seeLog.find('.see-log-clear').hide();
		});
	});
})
</script>

</body>
</html>