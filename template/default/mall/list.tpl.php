<?php
$parameter=act_mall_list();
extract($parameter);
$css[]=TPLURL.'/css/malllist.css';
include(TPLPATH."/header.tpl.php");
$zimu=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
?>
<div class="mainbody">
<div class="mainbody1000"> 
<div class="fuleft">
<!--返利步骤开始-->
<?php include(TPLPATH."/inc/top1.tpl.php");?>
<!--返利步骤结束-->

<!--购物返现开始-->
<div class="gouwufanxian biaozhun1">
<div class="gwbiaoti"><h3><div class="shutiao"></div>返现商城</h3> </div>
<div class="fusearch"><div class="fusearch1">
<form action="index.php" method="get">
<input type="text" name="q" class="fusearchkang" value="输入您想要查找的商城名称" onfocus="if(this.value=='输入您想要查找的商城名称'){this.value='';}" />  
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="<?=ACT?>" />
<input class="fusearchbt" name="" type="submit" value="搜索" />
</form>
<ul><li style="font-family:'宋体'"><strong>热门搜索:</strong></li>
<?php for($i=0;$i<6;$i++){?>
<li style="width:auto; margin-right:10px"><a target="_blank" href="<?=u('mall','view',array('id'=>$malls[$i]['id']))?>"><?=$malls[$i]['title']?></a></li>
<?php }?>
</ul></div>
</div>
<div class="fufenlei"><ul><li style="border:1px solid #FFF; background:none">全部商家：</li>
<?php foreach($mall_type as $type_id=>$type_title){?>
<li <?php if($type_id==$q){?> class="current"<?php }?>><a href="<?=u('mall','list',array('cid'=>$type_id))?>"><?=$type_title?></a></li>
<?php }?>
</ul></div>

<div class="funumber"><ul>
<?php foreach($zimu as $v){?>
<li <?php if($q==$v){?> class="current" <?php }?>><a href="<?=u('mall','list',array('cid'=>$v))?>"><?=strtoupper($v)?></a></li>
<?php }?>
</ul></div>
<script>
$(function(){
    $('.fushangjia ul li').hover(function(){
	    $(this).css('position','relative');
		$(this).find('.fuxuanting').show();
	},function(){
	    $(this).css('position','static');
		$(this).find('.fuxuanting').hide();
	});
})
</script>
<!--商家展示开始-->
<div class="fushangjia">
<ul>
<?php foreach($malls as $row){?>
<li>
<div class="fuxuanting" style="border:1px solid #dfdfdf; background:#fff;"> 
  <div class="fuxt01"><div class="fuxt01b"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></div><div class="fuxt01a">返 <span><?=$row['fan']?></span></div></div>
    <div class="fuxt02">
      <ul>
        <li><a href="<?=$row['view']?>"><img alt="返现详情" src="<?=TPLURL?>/images/fx01.png" /></a></li>
        <li><a target="_blank" href="<?=$row['view_jump']?>"><img alt="直接购买" src="<?=TPLURL?>/images/fx02.png" /></a></li>
      </ul>
    </div>
    <div class="fuxt03" style="background:#fff;"><?=utf_substr($row['des'],46)?>...</div>
    <div class="fuxt04">评分:<?=$row['score']?>&nbsp;&nbsp;&nbsp;[<?=$row['pjnum']?>条评论]</div>
    </div>
<div class="pailie"><a href="<?=$row['view']?>"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></a>  <p><?=$row['title']?> | 最高返<span id="fontk"><?=$row['fan']?></span></p></div>
</li>
<?php }?>
  </ul>
  

  </div>
  
  <div class="megas512" style="margin:35px 0"><?=pageft($total,$pagesize,u(MOD,ACT,array('cid'=>$q)),WJT)?></div>

<!--商家展示结束-->

</div></div>
<!--购物返现结束-->

<div class="furight">
<?php include(TPLPATH.'/mall/right.tpl.php');?>
<?=AD(2)?>

</div>

<div class="cleandd"></div>


</div>
</div>
<?php include(TPLPATH."/footer.tpl.php");?>