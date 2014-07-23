<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$parameter=act_tao_view();
extract($parameter);

$css[]=TPLURL."/css/view.css";
$js[]="js/jQuery.autoIMG.js";
include(TPLPATH.'/header.tpl.php');
?>
<script>
function getComment(){
	$('#shopit_txt .shopit_txt_ms').hide();
	$('.goodscomment').show();
	$.ajax({
	        url: '<?=u('ajax','goods_comment')?>',
		    data:{'comment_url':'<?=$comment_url?>'},
		    dataType:'jsonp',
			jsonp:"callback",
		    success: function(data){
			    if(data.rateListInfo.paginator.items>0){
			        var commentScore=parseFloat(data.scoreInfo.merchandisScore);  //评价得分
					var commentItems=parseInt(data.rateListInfo.paginator.items);  //评价数量
					var commentTotal=parseInt(data.scoreInfo.merchandisTotal);  //评价总次数
					
					num=commentScore*10;
					x2 = Math.floor(num%10); 
					num /= 10; 
                    x1 = Math.floor(num%10); 

					$('.pingjianum').html(commentItems); 
		            $('#pjdfnum').html(commentTotal);
		            $('.ajaxpjdf').html(commentScore);
		            var biaochi=parseInt(commentScore/5*380);
		            $('#biaochi').css('margin-left',biaochi+'px');
			        $('#getpling').hide();
			        $('#plcontent').show();
					$('.goodscomment .ov5hx').css('width',commentScore*20)
					
					jsonData=data.rateListInfo.rateList;
					c=jsonData.length;
					for(var i=0;i<c;i++){
						if(jsonData[i]['displayRatePic']=='') jsonData[i]['displayRatePic']='b_red_1.gif';
                        jsonLi='<li><div class="commnetleft">'+jsonData[i]['rateContent']+'<br><span>['+jsonData[i]['rateDate']+']</span></div><div class="commnetright">买家：'+jsonData[i]['displayUserNick']+'<br><img src="images/'+jsonData[i]['displayRatePic']+'" /></div></li>';
						$('#comment').append(jsonLi+'<div style="clear:both"></div>');
                    }
			    }
			    else{
			        //alert('评论加载失败');
			    }
		     }
	    });
}

$(function(){
		   
	<?php if($webset['taoapi']['goods_comment']==1 && WEBTYPE==0){?>
	getComment();
	<?php }?>
	
	var pic_url='<?=$goods['pic_url']?>';
	if(pic_url.indexOf('taobaocdn.com')>0){
		pic_url=pic_url+'_310x310.jpg';
	}
	$('#goodspic').attr('src',pic_url);
	$(".shopright .shopitem_main_l").imgAutoSize(310,310);
});
</script>
<div class="mainbody">
	<div class="mainbody1000">
      <div class="shopright" style=" *margin-bottom:-10px;">
      <div class="biaozhun1" style="float:none;">
      <div class="bz_first"> <h3><div class="shutiao"></div><?=$goods['title']?><?php if(TAOTYPE==2){?>&nbsp;&nbsp;<span style="font-size:12px; font-family:宋体">【<a style="color:#F60;" href="<?=u('tao','list',array('cid'=>0,'q'=>$goods['title']))?>" target="_blank">查看同款商品</a>】</span><?php }?></h3></div>
      
      <div class="shopitem_main" style="*padding-bottom:15px;">
                    <div class="shopitem_main_l"><a a_jump_click="<?=$goods['jump']?>" href="<?=$goods['click_url']?>" onclick="return tao_perfect_click($(this));" target="_blank"><img id="goodspic" src="images/310.gif" alt="<?=$goods['title']?>" /></a></div>
                    <div class="shopitem_main_r" style="position:relative;">
                    	<div class="shopitem_main_r_1"><img src="images/baozhang.gif" ></div>

                        <div class="shopitem_main_r_3" style="margin-top:10px"><span id="price_name" style="font-family:宋体"><?=$price_name?></span>：<span class="price"> <?=$goods['price']?></span> 元<?php if(isset($goods['yuanjia']) && $goods['yuanjia']>0){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="yuanjia">原价：<span style="text-decoration:line-through"><?=$goods['yuanjia']?></span> 元</span><?php }?></div>
                        
                        <div class="shopitem_main_r_3" style="margin-top:10px"><?php if($has_fanli*$allow_fanli==0){?><span id="zuigaofan">温馨提示：</span> <img src="<?=TPLURL?>/images/rebate_txt_no.png" alt="无返利" title="该商品无返利"><?php }else{?>
                        <!--<span id="zuigaofan">商品返利：</span> -->
                        <p class="rate-text" title="根据淘宝最新规则，查询返利时将不再显示具体返利金额，但返利仍会正常发放，具体金额以到账时为准">商品返利：</p> 
                        <!--<span style="color:#060">实际返利以成交价为准</span>-->
						<?php }?></div>
                        <div class="shopitem_main_r_3" style="margin-top:10px">近期销量： <?=$goods['volume']?> 件 </div>
                        <?php if($tao_coupon_str!=''){echo $tao_coupon_str;}?>
                        <div class="shopitem_main_r_3" style="margin-top:10px">掌柜名称： <?=$goods['nick']?> <?=wangwang($goods['nick'])?> </div>
                        <div class="shopitem_main_r_5" style="margin-top:10px">温馨提示：<span> 虚拟商品如话费，游戏，机票等无返利哦！</span> </div>
                        <div class="shopitem_main_r_4" style="margin-top:15px">

                        <a a_jump_click="<?=$goods['jump']?>" href="<?=$goods['click_url']?>" onclick="return tao_perfect_click($(this));" target="_blank"><img alt="立刻去购买" src="<?=TPLURL?>/images/gomai.gif" /></a> 
                        <a a_jump_click="<?=$shop['jump']?>" href="<?=$shop['click_url']?>" onclick="return tao_perfect_click($(this));" target="_blank"><img alt="逛逛掌柜店铺" src="<?=TPLURL?>/images/gozhanggui.gif" /></a>
                        </div>
                        <div class="shopitem_main_r_6"><p>宝贝分享：</p>
                            <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone">QQ</a>
<a title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a>
<a title="分享到人人网" class="bshare-renren">人人</a>
<a title="分享到腾讯微博" class="bshare-qqmb">腾讯</a>
<a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=<?=$webset['bshare']['uuid']?>&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                        </div>
                        <?php if($zhuanxiang==1){?>
                        <div style="width:90px; height:90px;  position:absolute; top:120px; left:273px;"><img src="<?=$qrcode?>" style="width:95%; height:95%; display:block" alt="二维码" /></div>
                        <?php }?>
                    </div>
                    <div style="float:right; margin-right:25px;">
                    	<?=AD(7)?>
                    </div>
                </div>
      
      </div>
      <div class="" style="float:none; margin-top:10px; *margin-top:0px;">
      <div class="shopit_txt" style="width:1000px; margin-bottom:10px; margin-left:0px;">
        <ul style="width:1000px;">
        <li><a href="<?=u($tuijian_lanmu_code,'index')?>"><?=$tuijian_lanmu_title?></a> </li>
        </ul>
    <div class="shopit_txt_ms" style="background:#fff; padding-bottom:10px;">
        <div class="goods_list" style="margin-top:10px; margin-left:12px;">
        <?php foreach($tuijian_lanmu_goods as $row){?>
        <div class="goods ">
            <div class="goods_info">
                <div class="fanli_num"><div></div></div>
                <a href="<?=u('tao','view',array('iid'=>$row['iid']))?>" target="_blank"><img alt="<?=$row['title']?>" src="<?=$row['img']?>_200x200.jpg"></a>
                <div class="goods_title"><?=$row['title']?></div>
                <div class="buy_info">
                    <div class="price_info">
                        <div class="price">
                            ￥<span><?=$row['discount_price']?></span>
                        </div>
                        <div class="pays">
                            <span class="C_FF9997">原价￥<?=$row['price']?></span>
                        </div>
                    </div>
                    <a href="<?=u('tao','view',array('iid'=>$row['iid']))?>" target="_blank">
                    <div class="buy_btn">
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    </div>
</div>
</div>
       	
            </div>
            <?=AD(108)?>
        </div> 
	</div>
<div class="clear"></div>
<?php include(TPLPATH.'/footer.tpl.php');?>