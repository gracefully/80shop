<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$css[]=TPLURL."/css/view.css";
$js[]="js/md5.js";
$js[]="js/jssdk.js";
$js[]="js/jQuery.autoIMG.js";
include(TPLPATH.'/header.tpl.php');
?>
<div class="mainbody">
	<div class="mainbody1000">
		<div class="shopleft">
		<?php include(TPLPATH.'/tao/shopinfo.tpl.php');?>
            <?=AD(7)?>     
        </div>
      <div class="shopright">
       	<div class="shopitem">
                <h3><?=$goods['title']?><?php if(TAOTYPE==2){?>&nbsp;&nbsp;<span style="font-size:12px; font-family:宋体">【<a style="color:#F60;" href="<?=u('tao','list',array('cid'=>0,'q'=>$goods['title']))?>" target="_blank">查看同款商品</a>】</span><?php }?></h3>
                <div class="shopitem_main">
                    <div class="shopitem_main_l"><a <?php if($goods['click_url']!=''){?>a_jump_click="<?=$goods['jump']?>" href="<?=$goods['click_url']?>" onclick="return tao_perfect_click($(this));"<?php }else{?> <?=tdj_click($goods['jump'],$iid)?><?php }?> target="_blank" class="pointer"><img id="goodspic" src="images/310.gif" alt="<?=$goods['title']?>" /></a></div>
                    <div class="shopitem_main_r">
                    	<div class="shopitem_main_r_1"><img src="images/baozhang.gif" ></div>

                        <div class="shopitem_main_r_3" style="margin-top:10px"><span id="price_name" style="font-family:宋体"><?=$price_name?></span>：<span class="price"> <?=$goods['price']?></span> 元<?php if(isset($goods['yuanjia']) && $goods['yuanjia']>0){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="yuanjia">原价：<span style="text-decoration:line-through"><?=$goods['yuanjia']?></span> 元</span><?php }?></div>
                        
                        <div class="shopitem_main_r_3" style="margin-top:10px"><?php if($hava_fanli==0){?><span id="zuigaofan">温馨提示：</span> <b style="color:#060">该商品无返利</b><?php }else{?><span id="zuigaofan">商品返利：</span> <span class="price"><?=$max_fan?></span> <span style="color:#060">实际返利以成交价为准</span><?php }?></div>
                        <div class="shopitem_main_r_3" style="margin-top:10px">近期销量： <?=$goods['volume']?> 件 </div>
                        <?php if($tao_coupon_str!=''){echo $tao_coupon_str;}?>
                        <div class="shopitem_main_r_3" style="margin-top:10px">掌柜名称： <?=$goods['nick']?> <?=wangwang($goods['nick'])?> </div>
                        <div class="shopitem_main_r_5" style="margin-top:10px">温馨提示：<span> 虚拟商品如话费，游戏，机票等无返利哦！</span> </div>
                        <div class="shopitem_main_r_4" style="margin-top:15px">
                        <?php if(1==2){?>
                        <a data-type="0" biz-itemid="<?=$iid?>" data-tmpl="192x40" data-tmplid="225" data-rd="1" data-style="2" data-border="1"></a>
                        <?php }else{?>
                        <a <?php if($goods['click_url']!=''){?>a_jump_click="<?=$goods['jump']?>" href="<?=$goods['click_url']?>" onclick="return tao_perfect_click($(this));"<?php }else{?> <?=tdj_click($goods['jump'],$iid)?><?php }?> target="_blank" class="pointer"><img alt="立刻去购买" src="<?=TPLURL?>/images/gomai.gif" /></a> <a <?php if($goods['shop_click_url']!=''){?>a_jump_click="<?=$shop['jump']?>" href="<?=$goods['shop_click_url']?>" onclick="return tao_perfect_click($(this));"<?php }else{?> <?=tdj_click($shop['jump'],$shop['user_id'],'shop')?><?php }?> style="cursor:pointer" target="_blank"><img alt="逛逛掌柜店铺" src="<?=TPLURL?>/images/gozhanggui.gif" /></a>
                        <?php }?>
                        </div>
                        <div class="shopitem_main_r_6"><p>宝贝分享：</p>
                            <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone">QQ</a>
<a title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a>
<a title="分享到人人网" class="bshare-renren">人人</a>
<a title="分享到腾讯微博" class="bshare-qqmb">腾讯</a>
<a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=<?=$webset['bshare']['uuid']?>&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                        </div>
                    </div>
                </div>
<script>
function suanfanli(v){
	f=fan*v/price;
    $('#jumpbox .text_f').text(dataType(f,<?=TBMONEYTYPE?>));
}

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
	
<?php if($webset['taoapi']['fanlitip']==1 && TAOTYPE==2){?>
	$('.shopright .shopitem_main_r .fanlitip').jumpBox({  
	    title: '这是您刚刚查看的商品：',
		titlebg:1,
		LightBox:'show',
		easyClose:0,
		jsCode:"param2=parse_str(ajaxUrl);pic_url=param2['pic'];title='<?=$goods['title']?>';if(typeof param2['promotion_price']!='undefined'){price=param2['promotion_price']}else{price=param2['price']};fan=param2['fan'];contain = contain.replace(/{pic_url}/, pic_url).replace(/{title}/, title).replace(/{price}/, price).replace(/{back}/, fan);",
		contain:'<div class="alert_go_tao"><div class="info"><table width=""border="0"><tr><td width="62"rowspan="3"><div class="pic"><img src="{pic_url}"/></div></td><td width="219"><span class="tit">{title}</span></td></tr><tr><td><span class="price">淘宝价格：{price}元</span><span class="fan">　返：{back}<?=TBMONEY?></span></td></tr><tr><td><span class="price_r">实付价格：</span><input type="text"class="text_p"value=""  onkeyup="suanfanli(this.value)"/><span class="fan_r">实返：</span><span class="text_f">？</span></td></tr></table><div style="clear:both"></div><div class="alert_notice"><em></em><div class="notice_content">输入最终购买价格(不含邮费)，算一下最终返<?=TBMONEY?>有多少？</div></div></div><p><span>●</span><a>虚拟商品无返利</a><span>●</span><a>实际返利与成交价有关</a><span>●</span><a>确认收货后才能查询返利</a></p><div style=" margin-top:3px"><a href="<?=u('help','index')?>'+
'" style="color:#03F" target="_blank">●用“<?=WEBNICK?>”去“淘宝网”购物 省钱方法详解【点击】</a></div></div>',
		height:240,
		width:520,
		a:1
    });
<?php }?>
});

</script>
<div class="shopit_txt">
    <ul>
    <li><a href="<?=u('tao','jiu')?>">九元购包邮</a> </li>
    </ul>
    <div class="shopit_txt_ms">
    <script>iframe('<?=DD_YUN_URL?>/index.php?m=shuju&a=jiu&ad=1&cid=<?=$goods['cid']?>&url=<?=urlencode(u('tao','view',array('iid'=>99999999)))?>',720,260)</script>
    </div>
</div>


                <div class="shopit_txt" id="shopit_txt">
                    <ul>
                    <?php if($webset['taoapi']['goods_comment']==1){?>
                    <li><a id="pjan" do="comment" url="">商品评价</a> </li>
                    <?php }?>
                    </ul>
                </div>
                <div class="goodscomment" style=" display:none">
                
                <div class="pjdf">
					<div class="pjleft"><ul>
						<li class="pjfs">店铺的“宝贝与描述相符”得分</li>
						<li class="pjfs2">
                        <div style="float:left"><font class="ajaxpjdf" style="font-size:24px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FF6600">5.0</font> 分</div>
                        <div style="float:left">
                        <DIV class=xx3 style="padding-top:5px">
                        <DIV class="bg5bx">
                    <DIV class="ov5hx" style="WIDTH: 100px;"></DIV>
                    </DIV>
                    </DIV>
                        </div>
                        <div style="clear:both"></div>
                        </li>
						<li class="gdf">(共打分 <font id="pjdfnum" color="#FF6600">100</font> 次)</li>
						</ul>
					</div>
					<div class="pjright">
						<ul>
							<li style="width:380px; height:20px; margin-top:21px;"><div id="biaochi" style="width:28px; height:21px; background:url(template/<?=MOBAN?>/images/pjfs.gif); margin-left:370px; text-align:center;"><font class="ajaxpjdf" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#fff">4.5</font></div></li>
							<li style="background:url(template/<?=MOBAN?>/images/rate_scroller_bar.png) no-repeat; width:400px; height:20px;"></li>
							<li style=" width:420px; background:url(template/<?=MOBAN?>/images/pjfssm.gif) no-repeat; height:45px;"></li>
						</ul>
					</div>
				</div>

                <div class="pingjia">
                    <div class="pingjia_bt">
                    	 <div class="pingjia_bt_l">
                    	 评论
                    	 </div>
                         <div class="pingjia_bt_r">
                    	 评价人
                    	 </div>
                    </div>
                    <div id="comment">
  
                    </div>
                    <div class="pingjia_more">
                     <a <?=tdj_click($goods['jump'],$iid)?> target="_blank" class="pointer"><s>更 多</s></a>
                    </div>
                </div>
                </DIV>
        </div>
            </div>
            <?=AD(108)?>
        </div> 
	</div>
<div class="clear"></div>
<?php include(TPLPATH.'/footer.tpl.php');?>