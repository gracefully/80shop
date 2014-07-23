<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$parameter=act_zhidemai_view($duoduo);
extract($parameter);

include(TPLPATH.'/header.tpl.php');
?>
<link rel="stylesheet" href="<?=TPLURL?>/css/zhide-css.css"/>
<script>
$(function(){
	$('.J-expend-trigger').click();
})
</script>
<style>

</style>
<div id="zhidemaiad"> </div>
    <div class="zdm-body yahei" id="zdm-body">
      <div class="zhidecontainer">
        <div id="J-zdm-article" class="zdm-article" data-pagename="index">
          <?php include(TPLPATH.'/zhidemai/top.tpl.php')?>
          <div class="zdm-list">
          <div id="J_zdm_list">
              <div class="zdm-list-item J-item-wrap item-no-expired" data-id="<?=$zhidemai['id']?>" style="position:relative">
              <?php if($row['shuxing_id']>0){?><i class='<?=$zhidemai['shuxing_class']?>'><?=$zhidemai['shuxing']?></i><?php }?>
                <h4 class="t"><a class="J-item-track nodelog" href="<?=$zhidemai['jump']?>" target="_blank"><?=$zhidemai['title']?><span class="red t-sub"><?=$zhidemai['subtitle']?></span></a></h4>
                <div class="item-img">
                  <a href="<?=$zhidemai['jump']?>"class="J-item-track img nodelog" target="_blank"><img src="<?=$zhidemai['img']?>" alt="<?=$zhidemai['title']?>" /></a>
                  <a href="<?=$zhidemai['jump']?>" class="btn-zdm-goshop J-item-track nodelog" target="_blank">直接返利模式购买</a>
                </div>
                <div class="item-info J-item-info">
                  <div class="item-time"><?=$zhidemai['starttime']?> </div>
                  <div class="item-type">分类：<a href="<?=$zhidemai['caturl']?>" class="nine" target="_blank"><?=$zhidemai['catname']?></a> </div>
                  <?php if($zhidemai['ddusername']!=''){?><div class="item-user">推荐人：<?=$zhidemai['ddusername']?></div><?php }?>
                  <?php if($row['mallname']!=''){?><div class="item-user">所属：<a <?php if($row['mallurl']!=''){?>href="<?=$row['mallurl']?>"<?php }?>><?=$row['mallname']?></a></div><?php }?>
                  <div class="item-content J-item-content nodelog-detail" data-id="<?=$zhidemai['id']?>" style="max-height:none">
                    <div class="item-content-inner J-item-content-inner"><?=$zhidemai['content']?></div>
                  </div>
                  
                  <!--<div class="item-toggle" data-status="0"><a href="javascript:void(0);" class="blue J-item-toggle">展开全文 ∨</a></div>-->
                  
                </div>
                <div class="J-expend-wrap-before item-vote clearfix">
                  <em class="l item-vote-t">评价本文：</em>
                  <a href="javascript:void(0);" class="l item-vote-yes J-item-vote-yes vote" onclick="zhidemaiVote($(this))" data-type="1"data-id="<?=$zhidemai['id']?>"><?=$zhidemai['ding']?></a>
                  <a href="javascript:void(0);" class="l item-vote-no J-item-vote-no vote" onclick="zhidemaiVote($(this))" data-type="0"data-id="<?=$zhidemai['id']?>"><?=$zhidemai['cai']?></a>
                  <span class="l">大家在评论：</span>
                  <a href="javascript:void(0)" class="l item-view-comment J-expend-trigger" onclick="zhidemaiComment($(this))" data-id="<?=$zhidemai['id']?>"><?=$zhidemai['pinglun']?></a>
                </div>
                
                <div class="J-expend-wrap yahei zdm-expand-wrap" style=" display:none">
  <i class="top-arrow"></i>
  <div class="yahei zdm-expand-comment">
    
  </div>
</div>
                

                
              </div>
              
              

              
            </div>
          </div>
          <div id="baoliao_con" style="margin-top:10px;">
	<div id="nav-below" class="baoliao_blo single_navi">
		<div class="nav-previous">
			<span class="meta-nav">上一篇：</span><?php if($last_zdm['title']){?><a href="<?=u('zhidemai','view',array('id'=>$last_zdm['id']))?>"><?=$last_zdm['title']?><?php }else{?>没有了<?php }?></a>
		</div>
		<div class="nav-next">
			<span class="meta-nav">下一篇：</span><?php if($next_zdm['title']){?><a href="<?=u('zhidemai','view',array('id'=>$next_zdm['id']))?>"><?=$next_zdm['title']?><?php }else{?>没有了<?php }?></a>
		</div>
	</div>
	<div class="baoliao_blo">
		<div class="single_declare">
			<strong>声明：</strong><?=WEBNAME?>（<span><?=SITEURL?></span>）是一家中立的，致力于帮助广大网友在网购时能买到性价比更高商品的分享平台，每天为网友们提供丰富、准确、新鲜的网上商品、特价资讯等信息。本站信息大部分来自于网友爆料，如果您发现了优质的商品或好的价格，不妨爆料给我们吧（谢绝任何商业爆料）！<a href="<?=u('zhidemai','baoliao')?>" target="_blank">点此爆料</a>。
		</div>
	</div>
</div>

        </div>
        <div class="zdm-aside" style=" float:left;margin-left:10px"><?php include(TPLPATH.'/zhidemai/left.tpl.php')?></div>      
        </div>
    </div>
<?php include(TPLPATH.'/zhidemai/js.tpl.php')?>
<?php include(TPLPATH.'/zhidemai/cat.tpl.php');?>
<?php
include(TPLPATH.'/footer.tpl.php');
?>