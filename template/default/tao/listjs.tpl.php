<script src="<?=TPLURL?>/js/bigpic.js"></script>
<script>
function suanfanli(v){
	f=fan*v/price;
    $('#jumpbox .text_f').text(dataType(f,<?=TBMONEYTYPE?>));
}
$(function(){
	<?php if(TAOTYPE==2 && $webset['taoapi']['fanlitip']==1){?> 
    $('#splistbox .info .fanlitip').jumpBox({  
	    title: '这是您刚刚查看的商品：',
		titlebg:1,
		LightBox:'show',
		easyClose:0,
		jsCode:"param2=parse_str(ajaxUrl);pic_url=decode64(param2['pic']);title=$(this).parents('.info').find('.title').find('a').text();price=param2['price'];fan=param2['fan'];contain = contain.replace(/{pic_url}/, pic_url).replace(/{title}/, title).replace(/{price}/, price).replace(/{back}/, fan);",
		contain:'<div class="alert_go_tao"><div class="info"><table width=""border="0"><tr><td width="62"rowspan="3"><div class="pic"><img src="{pic_url}"/></div></td><td width="219"><span class="tit">{title}</span></td></tr><tr><td><span class="price">淘宝价格：{price}元</span><span class="fan">　返：{back}<?=TBMONEY?></span></td></tr><tr><td><span class="price_r">实付价格：</span><input type="text"class="text_p"value=""  onkeyup="suanfanli(this.value)"/><span class="fan_r">实返：</span><span class="text_f">？</span></td></tr></table><div style="clear:both"></div><div class="alert_notice"><em></em><div class="notice_content">输入最终购买价格(不含邮费)，算一下最终返<?=TBMONEY?>有多少？</div></div></div><p><span>●</span><a>虚拟商品无返利</a><span>●</span><a>实际返利与成交价有关</a><span>●</span><a>确认收货后才能查询返利</a></p><div style=" margin-top:3px"><a href="<?=u('help','index')?>'+
'" style="color:#03F" target="_blank">●用“<?=WEBNAME?>”去“淘宝网”购物 省钱方法详解【点击】</a></div></div>',
		height:240,
		width:520,
		a:1
    });
	<?php }?>
	
	$('#splistbox .seecomment').live('click',function(){
	    var url=$(this).attr('url');
		var goto=$(this).attr('goto');
		var commentUrl="http://rate.taobao.com/detail_rate.htm?"+url+"&showContent=2&currentPage=1&ismore=1&siteID=7";
		jumpboxOpen('<div id="comment"><div><div class="commentleft">评论</div><div class="commentright">评价人</div></div><div style=" clear:both; overflow-y:scroll; height:380px" id="commentc"><ul style=" margin-top:120px; text-align:center;">正在加载评价……<br/><img alt="等待加载评论" src="images/wait2.gif" /></ul></div>',446,830);
		$.ajax({
	        url: '<?=u('ajax','goods_comment')?>',
		    dataType:'jsonp',
			jsonp:"callback",
		    data:{'comment_url':commentUrl},
		    success: function(data){
			    if(data.rateListInfo.paginator.items>0){
					jsonData=data.rateListInfo.rateList;
					c=jsonData.length;
					$('#commentc').html('');
					for(var i=0;i<c;i++){
						if(jsonData[i]['displayRatePic']=='') jsonData[i]['displayRatePic']='b_red_1.gif';
                        jsonLi='<li><div class="commnetleft">'+jsonData[i]['rateContent']+'<br><span>['+jsonData[i]['rateDate']+']</span></div><div class="commnetright">买家：'+jsonData[i]['displayUserNick']+'<br><img alt="信用" src="images/'+jsonData[i]['displayRatePic']+'" /></div><div style=" clear:both"></div<></li>';
						$('#commentc').append(jsonLi);
                    }
			    }
			    else{
			        alert('无评价');
					jumpboxClose();
			    }
		     },
			 error: function(XMLHttpRequest,textStatus, errorThrown){
                 alert('评论内容获取失败');
				 //alert(XMLHttpRequest.status);
                 //alert(XMLHttpRequest.readyState);
				 //alert(textStatus);
				 jumpboxClose();
             }
	    });
	});
});
</script>