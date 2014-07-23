<?php  //淘宝商品列表
if(!defined('INDEX')){
	exit('Access Denied');
}

$css[]=TPLURL."/css/goods.css";
$css[]=TPLURL."/css/list.css";
$js[]="js/md5.js";
$js[]="js/jssdk.js";
include(TPLPATH."/header.tpl.php");

$tdj_jump=preg_replace('/onclick="(.*)"/','',tdj_click($goods['jump'],$goods['num_iid']));
?>
<div class="mainbody">
	<div class="mainbody1000">
        <div class="small_big" id="layerPic">
			<div class="sell_bg"></div>
			<div class="photo"></div>
		 </div>
         
        <div class="goodsleft">
        
        <?php if($cat_list[0]!=''){?>
        <div class="goodslist" style="margin-bottom:10px;">
    <div class="morecat">
      <ul>
      <?php foreach($cat_list as $k=>$v){?>
      <li><a href="<?=u('tao','list',array('cid'=>$v['cid']))?>" <?php if($v['cid']==$cid){?> style="font-weight:bold; color:#F00" <?php }?>)><?=$v['name']?></a></li>
      <?php }?>
      </ul>
      <div style="clear:both"></div>
    </div>
    </div>
    <?php }?>
        	<div class="goodslist">
                <div class="goodslist_main" id="splistbox" style="overflow:hidden">
                    <ul>
                    <div style="height:20px; font-weight:bold; font-size:14px; color:#F30;">当前查询商品</div>
                    <li class="info">
                        <div class="goodslist_main_left" style="filter:gray; -moz-opacity:.5;opacity:0.5">
                        	<div class="goodslist_main_left_img"><a pic="<?=base64_encode($goods["pic_url"].'_310x310.jpg')?>"><?=html_img($goods["pic_url"],1,$goods["title"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a><s><?=$goods["title"]?></s></a></div>
                            <div class="goodslist_main_left_sell"><p>近期销量<?=$goods["volume"]?> 件  </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<?=$goods["nick"]?> <?=wangwang($goods["nick"])?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span style="color:#999"><?=$goods["price"]?></span> 元 </p> 
                            <p> <span class="greenfont">暂无返利</span> </p>
                            <p></p>
                            <p id="<?=$goods["num_iid"]?>" class="tbcuxiao" style="clear:both; margin-top:5px; width:150px;"></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                            <?php if(TAODATATPL==2){?>
                            <div style="margin-top:-10px;"><a data-type="0" biz-itemid="<?=$goods['num_iid']?>" data-tmpl="192x40" data-tmplid="225" data-rd="1" data-style="2" data-border="1"></a></div>
                            <?php }else{?>
                            <a <?php if($goods['click_url']!=''){?>a_jump_click="<?=$goods['jump']?>" href="<?=$goods['click_url']?>" onclick="return tao_perfect_click($(this));"<?php }else{?> <?=$tdj_jump?><?php }?>  target="_blank" class="pointer" rel="nofollow"><div class="goodslist_main_right_buy" style="background-position:-110px -625px; background-color:#999; text-decoration:none">无返利购买</div></a>
                            <?php }?>
                            </div>
                        </div>
                        </li>
                    <li style="height:20px; overflow:hidden; font-weight:bold; font-size:14px; color:#F30;">&nbsp;推荐商品</li>
                    <?php foreach($guanlian_goods as $row) {?>
                    	<li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a href="<?=$row["go_view"]?>" target="_blank" pic="<?=base64_encode($row["pic_url"].'_310x310.jpg')?>"><?=html_img($row["pic_url"],1,$row["name"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank"  href="<?=$row["go_view"]?>"><s><?=$row["title"]?></s></a></div>
                            <div class="goodslist_main_left_sell"><p>近期销量<?=$row["volume"]?> 件  </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<?=$row["nick"]?> <?=wangwang($row["nick"])?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <p>&nbsp;<a target="_blank" href="<?=$row["go_view"]?>">详情</a></p>
                            <p></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=$row['go_view']?>"><div class="goodslist_main_right_buy">看商品详情</div></a>
                            </div>
                        </div>
                        </li>
                    
                    
                        
                    <?php }?>
                    </ul>
                </div>
                
                
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
<?php include(TPLPATH.'/footer.tpl.php');?>