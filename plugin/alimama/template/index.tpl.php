<?php 
$js[]="js/md5.js";
$js[]="js/jssdk.js";
$js[]="js/jQuery.autoIMG.js";
$dd_jssdk_mod_act['alimama']=array('index'=>1); //添加调用jssdk说明
include(TPLPATH.'/header.tpl.php');
$search_tip='请输入淘宝订单编号到这里查询';
$alimama_data=$webset['alimama'];
$alimama_class=fs('alimama');
$yzm=$alimama_class->getyzm($webset['alimama']['username'],$webset['alimama']['password']);
if(preg_match('/blank\.gif$/',$yzm)){$yzm='';}
?>    	
<link rel="stylesheet" href="<?=PLUGIN_TPLURL?>css/index.css" type="text/css" />
<script>
var goodsMoney=0;
var fxje=0;
$(function(){
	$('#alimama_form').submit(function(){
		var tid=$('#search_tip').val();
		if(isNaN(tid)==true){
			alert('订单号格式错误');
			return false;
		}
		var yzm=$("#yzm").val();
		$('#wait_loading').show();
		$('#tip_word').hide();
		$('#baoqian').hide();
		$('#have_goods').hide();
		<?php if($yzm){?>
		$('#yzm_div').hide();
		<?php }?>

		$.ajax({
			url: '<?=p(MOD,'ajax')?>&t=<?=TIME?>&tid='+tid+"&yzm="+yzm,
			dataType:'json',
			success: function(data){
				$('#wait_loading').hide();
				
				if(data.s==0){
					$("#baoqian_msg").html(data.r);
					$('#baoqian').show();
					<?php if($yzm){?>
					$('#yzm_div').show();
					$("#yzm_img").click();
					<?php }?>
				}
				else{
					$('#trade_id').html(data.r.trade_id);
					$('#trade_status').html(data.r.status);
					$('#trade_item_title a').html(data.r.item_title);
					$('.trade_url').attr('href',data.r.url);
					$('#have_goods').show();
					$('#spjg').html(data.r.pay_price*data.r.item_num);
					if(data.r.fxje>0){
						$('#ddFxje').html(data.r.fxje);
						fxje=data.r.fxje;
						goodsMoney=data.r.pay_price*data.r.item_num;
						$('#yincang').show();
					}
				}
			}
		});
		return false;
	});
});
function checkform(){
	return false;
}
function jisuanqian(){
	var a=dataType($('#sjzf').val()/goodsMoney*fxje,<?=TBMONEYTYPE?>);
	$('#ddFxje').html(a);
	alert('返利约：'+a+'<?=TBMONEYUNIT?><?=TBMONEY?>');
}
</script>

<form action="index.php" onSubmit="return checkform();" id="alimama_form" >
    <div class="clear_div n_shop_center" style="position: relative; *position: static; z-index: 100; min-height:310px">
        <div class="n_shop_950" style="position: relative; *position: static; z-index: 99">
        
            <div class="clear_div n_center_list" style="background: none;" id="item_content">
            
            <?php if($alimama_data['open']==0){?>
				<dl class="clear_div china green_link taobao_note" style="color: #FF6600; font-weight: bold;margin-top: 10px;">
                    <dd style="font-size:16px; text-align:center"><?=$alimama_data['close_tip']?$alimama_data['close_tip']:'温馨提示：订单跟踪暂不可用！'?></dd>
                </dl>
			<?php }else{?>
                <dl class="clear_div china green_link taobao_note" style="color: #FF6600; font-weight: bold;margin-top: -10px;">
                    <dd>温馨提示：为了避免丢单，请查询您的淘宝订单是否跟踪到，并等淘宝订单跟踪到后再进行支付！</dd>
                </dl>
                      <dl class="shop_search" >
                    <dd>
                <input name="search" type="text" id="search_tip" class="shop_text input_search_text" value="<?=$search_tip?>" onFocus="javascript:if(this.value=='<?=$search_tip?>') this.value=''; else this.select();" onBlur="javascript:if(this.value=='') this.value='<?=$search_tip?>';" style="border:none;" /></dd>
                    <dt>
                        <input type="submit" value="立即查询" class="shop_btn" style="border:none;" /></dt>
                </dl>
                <div class="clear_div shop_ok">
                <?php if($yzm){?>
                <div id="yzm_div" style="margin-left:210px;width:550px;height:35px; margin-top:20px">
                <span style="font-size:14px;font:bold">请输入查询验证码：</span>
                <input value="" name="yzm" id="yzm" type="text"  style="width:80px;height:20px;line-height:20px"/>
                 <img id="yzm_img" src="<?=$yzm?>" style="height:35px;line-height:35px;cursor:pointer; margin-bottom:-13px" title="看不清，换一张"/>
                </div>
                <?php }?>
                    <div class="clear_div fan_tishi">
                        <dl class="clear_div orange_link shop_ok" style="width: 550px;" id="tip_word">

						           <dd style="width: 98%;">
                                <div style='text-align: left; color: #000000; font-weight: normal; font-size: 14px; line-height: 30px;'>亲！在拍下后（付款前）的1-5分钟内可搜索到订单，超过30分钟未查询到订单，请清除Cookie和更换浏览器后再重新下单，直到订单跟踪到！如有疑问请咨询在线客服。</div>
                            </dd>
                        </dl>
                    
							<div id="have_goods" style="display:none; padding-top:10px">
						    <dl class="clear_div orange_link shop_ok" style="margin:0px auto 0px auto; width:550px"><dt> <a target="_blank" class="trade_url" href=""><img style="padding:1px; border:1px solid #999" id="pic_url" src="<?=PLUGIN_TPLURL?>css/images/face.png"/> </a></dt>
							<dd>
							恭喜！您搜索的订单号已跟踪到！
							<p>订单号：<span id="trade_id" class="orange_text"></span></p>
							<p>交易状态：<span id="trade_status" class="orange_text"></span></p>
							<p>商品：<span id="trade_item_title" class="orange_text"><a class="trade_url" href="" target="_blank" ></a></span></p>
							<p>商品价格：<span id="spjg" style="color:#060; font-size:14px; font-weight:bold"></span>元</p>
							<div style="display:none" id="yincang">
                            <p>预计返利：<span class="orange_text"><span id="ddFxje" style="color:#F30; font-size:14px; font-weight:bold"></span><?=TBMONEYUNIT?><?=TBMONEY?></span>（实际以收货后淘宝返回数据为准）</p>
							<p>实际支付：<input type="text" id="sjzf" style="width:60px; height:20px; line-height:20px" /> 元 <input type="button" value="计算返利" id="jisuan" onclick="jisuanqian();return false;" /></p>
						    </div>
                            </dd>
							</dl><dl class="clear_div orange_link shop_ok" style="margin:0px auto 30px auto; width:550px"><dd style="padding-top:15px;float:none;width:100%;">
							<p>温馨提示：</p>
							<p>1、如果一个订单包含多个商品，这里仅显示其中一件商品的标题</p>
							<p>2、建议您下单前清空Cookie后再按流程去下单，不要点击其他人的推广链接。</p></dd></dl>
                            </div>
                            </div>
                            <div id="wait_loading" style="display:none; text-align:center; padding-top:50px"><img src="<?=PLUGIN_TPLURL?>css/images/wait.gif" /></div>
                            <dl id="baoqian" class="clear_div orange_link shop_ok" style="width:550px; display:none"><dt><img src="<?=PLUGIN_TPLURL?>css/images/face2.png" title="errow" /></dt><dd><b id="baoqian_msg">很抱歉，未查询到您的订单！</b><p>建议您下单后1-5分钟后再搜索查询。</p><p>如超过1个小时还未搜索到，则该订单可能未跟踪到，</p><p>建议您重新按正确流程下单或咨询在线客服，谢谢！</p></dd></dl>
                    </div>
					
					<?php }?>
                    </div>

                </div>
                <!--end提示框-->
            </div>
            <!--结束列表-->

    </form>

<div style="clear:both"></div>
<?php if($yzm){?>
<script>
$("#yzm_img").click(function(){
	$(this).attr("src",$(this).attr("src"));
});
</script>
<?php }?>
<?php include(TPLPATH.'/footer.tpl.php');?>