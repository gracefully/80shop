<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

include(ADMINTPL.'/header.tpl.php');
?>
<link href="css/bshare.css" rel="stylesheet" type="text/css">
<div class="explain-col">请您注册或登录bShare，以便享用bShare强大的数据统计功能！ <a href="<?=u(MOD,'set',array('do'=>'set'))?>">填写账号</a> <a href="<?=u(MOD,'code')?>">设置代码</a> <a href="<?=u(MOD,'count')?>">查看统计</a> <a href="http://www.bshare.cn" target="_blank">官网</a>
  </div>
<br />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<tr><td>
<div id="accountModule" class="module" style="font-size: 14px; padding-bottom:0px">
			<div class="section left" style="width: 640px;">
				<table style="width: 400px;">
					<tr>
						<td class="heading2" colspan="3">
							<div class="text-orange">
								您已链接bShare服务
							</div>
							<div class="verticalradio-spacer"></div>
						</td>
					</tr>
					<tr>
						<td class="cellTitle">
						用户名
						</td><td class="cellColon">
						：
						</td>
						<td id="userP">
							<?=$webset['bshare']['user']?>
						</td>
					</tr>
					<tr>
						<td class="cellTitle">
							UUID
						</td>
						<td class="cellColon">
							：
						</td>
						<td id="uuidP">
							<?=$webset['bshare']['uuid']?>
						</td>
					</tr>
				</table>
			</div>
			<div class="section left" style="width: 300px;">
				<form action="index.php?mod=<?=MOD?>&act=set&do=set" method="post">
					<input type="submit" id="switchShare" value="更换帐号" class="bButton-gray right" style="padding: 5px 40px; margin: 20px 30px 0; *background: #e9e9e9;" />
				</form>
			</div>
		</div>
<div id="styleModule" class="module" style=" padding-top:0px">
			<div class="heading">按钮安装设置</div>
			<div class="section border-orange" style="padding-bottom: 30px; display: inline-block;height:auto; width:987px">
				<div style="font-weight: bold; margin: 20px 0pt; font-size: 14px; text-align:left;">
					<p style="color:#000000">
						<font color="red">注意</font>：在模板页面中添加如下代码后前台页面才会显示按钮，具体操作请参考：【<a style="cursor: pointer;text-decoration:underline;" id="simg">安装向导</a>】<br/><br/>
						<code id="code1">&lt;?=$webset['bshare_code']?&gt;</code>
					</p>
				</div>
				<div id="guideInstall">
					<div id="closeGuide" style="background: url(images/button-close.png) no-repeat 0px 0px;"></div>
					<p style="color:#F60; line-height:20px">
					&nbsp;&nbsp;<font color="#000000">参考案例：将按钮添加到购物资讯页面的底部，操作步骤如下：<br/>&nbsp;&nbsp;步骤一：打开模板文件,文件路径为：/template/default/read.tpl.php<br/>&nbsp;&nbsp;步骤二：按下图所示，添加如下代码到相应模板页面</font><br/>
					<br/>&nbsp;&nbsp;<code id="code1">&lt;?=$webset['bshare_code']?&gt;</code><br/>
					</p>
					   <img id="setimg"  src="images/help.jpg" />
					 	
				</div>
            
				<div class="verticalradio-spacer"></div>
            
				<ul class="tabs left">
					<li id="lifirst"><a title="简单样式" class="current">简单样式</a></li>
					<li id="lisecond"><a title="自定义样式">自定义样式</a></li>
				</ul>
				<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post">
					<div class="panes left">
						<div id="paneStyle" class="panediv" style="display:block">
							<div class="left" style="width: 450px;height:">
								<input type="radio" class="buttonStyle" name="poststyle" id="buttonStyleC1:false:x" value="C1:false:x" /><label for="buttonStyleC1:false:x"><img src="images/custom-c1.gif" /></label>
								<div class="verticalradio-spacer"></div>
								<input type="radio" class="buttonStyle" name="poststyle" id="buttonStyleC2:x:x" value="C2:x:x" /><label for="buttonStyleC2:x:x"><img src="images/custom-c2.gif" /></label>
								<div class="verticalradio-spacer"></div>
								<input type="radio" class="buttonStyle" name="poststyle" id="buttonStyleC2P:x:x" value="C2P:x:x" /><label for="buttonStyleC2P:x:x"><img src="images/custom-c2p.gif" /></label>
								<div class="verticalradio-spacer"></div>
								<input type="radio" class="buttonStyle" name="poststyle" id="buttonStyle2:false:true" value="2:false:true" /><label for="buttonStyle2:false:true"><img src="images/style2-name-zh.gif" /></label>
								<div class="verticalradio-spacer"></div>
							</div>
							<div class="left" style="width: 220px;">
								<input type="radio" class="buttonStyle" name="poststyle" id="buttonStyle3:DarkOrange:x" value="3:DarkOrange:x" /><label for="buttonStyle3:DarkOrange:x"><img src="images/button_custom3-zh-DarkOrange.gif" /></label>
								<input type="radio" class="buttonStyle" name="poststyle" id="buttonStyle3:Blue:x" value="3:Blue:x" /><label for="buttonStyle3:Blue:x"><img src="images/button_custom3-zh-Blue.gif" /></label>
								<input type="radio" class="buttonStyle" name="poststyle" id="buttonStyle3:Grey:x" value="3:Grey:x" /><label for="buttonStyle3:Grey:x"><img src="images/button_custom3-zh-Grey.gif" /></label>
								<div class="clear"></div>
							</div>
						</div>
                
						<div class="panediv" id="paneStyleMore" style="display:none;">
							<div>
								<p>您可以通过修改下框中的代码来修改按钮样式，更多样式代码请参考<a target="_blank" href="http://www.bshare.cn/moreStyles" class="highlight" style="text-decoration: underline;">bShare网站</a>。<span class="text-orange">(注：选择完样式不要忘记粘贴到下面保存哦)</span></p>
								<div class="verticalradio-spacer"></div>
							</div>
							<div>
								<textarea name="bscode" id="bscode" rows="10" cols="98"><?=$webset['bshare_code']?></textarea>
								<div class="verticalradio-spacer"></div>
							</div>
							<div>
								<p style="color: green; line-height:20px"><b>UUID</b>：
								追踪分享数据必须提供此选项，如果您没有设置该参数，您目前登录的uuid将被设置在代码中。<br/>
								查找uuid方法：<br/>
                      			①登录后见此页面上方UUID<br/>
                     			②登录bShare官方网站站长后台【<a class="highlight" style="text-decoration: underline;" href="http://www.bshare.cn/websiteManage" target="_blank">管理中心</a>】查看</p>
							</div>
						</div>			
					</div>
					<div class="right">
						<input type="submit" name="sub" id="setStyles" value="保存样式" class="bButton-orange" style="padding: 6px 40px; margin-right: 18px; *background: #FF9D29;" />
					</div>
				</form>
			</div>
         
			<div style=" margin-top:10px">	
			在安装或使用中，如有任何问题需要<a class="text-orange" href="http://www.bshare.cn/help/installCms" target="_blank">帮助与咨询</a>，欢迎随时联系<a class="text-orange" href="http://wpa.qq.com/msgrd?v=3&uin=800087176&site=qq&menu=yes" target="_blank">bShare客服QQ</a>：800087176 或来信到<a class="text-orange" href="mailto:feedback@bshare.cn" target="_blank">feedback@bshare.cn.</a>
			</div>
		</div>
</td></tr>
</table>
<script>
uuid='<?=$webset['bshare']['uuid']?>';
$(function(){	
	$("#lifirst").click(function(){
		$("#paneStyle").show();
		$("#paneStyleMore").hide();
		$("#lifirst >a").addClass("current");
		$("#lisecond >a").removeClass("current");
    });
	$("#lisecond").click(function(){
		$("#paneStyle").hide();
		$("#paneStyleMore").show();
		$("#lisecond >a").addClass("current");
		$("#lifirst >a").removeClass("current");
	});
	
	$("#simg").click(function(){
		if($("#guideInstall").css('display') == 'none'){
			$("#guideInstall").show();
		}else{
			$("#guideInstall").hide();
		}
	});	
	$("#closeGuide").click(function(){
		if($("#guideInstall").css('display') == 'block'){
			$("#guideInstall").hide();
		}
	});
	
	var stylesMap = {
	    'C1:false:x': '%3Cdiv%20class%3D%22bshare-custom%22%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0QQ%E7%A9%BA%E9%97%B4%22%20class%3D%22bshare-qzone%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E6%96%B0%E6%B5%AA%E5%BE%AE%E5%8D%9A%22%20class%3D%22bshare-sinaminiblog%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E4%BA%BA%E4%BA%BA%E7%BD%91%22%20class%3D%22bshare-renren%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E8%85%BE%E8%AE%AF%E5%BE%AE%E5%8D%9A%22%20class%3D%22bshare-qqmb%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E8%B1%86%E7%93%A3%22%20class%3D%22bshare-douban%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E6%9B%B4%E5%A4%9A%E5%B9%B3%E5%8F%B0%22%20class%3D%22bshare-more%20bshare-more-icon%22%3E%3C%2Fa%3E%3Cspan%20class%3D%22BSHARE_COUNT%20bshare-share-count%22%3E0%3C%2Fspan%3E%3C%2Fdiv%3E%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbuttonLite.js%23style%3D-1%26amp%3Buuid%3D%26amp%3Bpophcol%3D2%26amp%3Blang%3Dzh%22%3E%3C%2Fscript%3E%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbshareC0.js%22%3E%3C%2Fscript%3E',
			
		'C2:x:x': '%3Cdiv%20class%3D%22bshare-custom%22%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0QQ%E7%A9%BA%E9%97%B4%22%20class%3D%22bshare-qzone%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E6%96%B0%E6%B5%AA%E5%BE%AE%E5%8D%9A%22%20class%3D%22bshare-sinaminiblog%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E4%BA%BA%E4%BA%BA%E7%BD%91%22%20class%3D%22bshare-renren%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E8%85%BE%E8%AE%AF%E5%BE%AE%E5%8D%9A%22%20class%3D%22bshare-qqmb%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E8%B1%86%E7%93%A3%22%20class%3D%22bshare-douban%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E6%9B%B4%E5%A4%9A%E5%B9%B3%E5%8F%B0%22%20class%3D%22bshare-more%20bshare-more-icon%22%3E%3C%2Fa%3E%3Cspan%20class%3D%22BSHARE_COUNT%20bshare-share-count%22%3E0%3C%2Fspan%3E%3C%2Fdiv%3E%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbuttonLite.js%23style%3D-1%26amp%3Buuid%3D%26amp%3Bpophcol%3D2%26amp%3Blang%3Dzh%22%3E%3C%2Fscript%3E%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbshareC2.js%22%3E%3C%2Fscript%3E',
			
		'C2P:x:x': '%3Cdiv%20class%3D%22bshare-custom%22%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0QQ%E7%A9%BA%E9%97%B4%22%20class%3D%22bshare-qzone%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E6%96%B0%E6%B5%AA%E5%BE%AE%E5%8D%9A%22%20class%3D%22bshare-sinaminiblog%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E4%BA%BA%E4%BA%BA%E7%BD%91%22%20class%3D%22bshare-renren%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E8%85%BE%E8%AE%AF%E5%BE%AE%E5%8D%9A%22%20class%3D%22bshare-qqmb%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E5%88%86%E4%BA%AB%E5%88%B0%E8%B1%86%E7%93%A3%22%20class%3D%22bshare-douban%22%3E%3C%2Fa%3E%3Ca%20title%3D%22%E6%9B%B4%E5%A4%9A%E5%B9%B3%E5%8F%B0%22%20class%3D%22bshare-more%20bshare-more-icon%22%3E%3C%2Fa%3E%3Cspan%20class%3D%22BSHARE_COUNT%20bshare-share-count%22%3E0%3C%2Fspan%3E%3C%2Fdiv%3E%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbuttonLite.js%23style%3D-1%26amp%3Buuid%3D%26amp%3Bpophcol%3D2%26amp%3Blang%3Dzh%22%3E%3C%2Fscript%3E%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbshareC2P.js%22%3E%3C%2Fscript%3E',
			
		'2:false:true': '%3Ca%20class%3D%22bshareDiv%22%20href%3D%22http%3A%2F%2Fwww.bshare.cn%2Fshare%22%3E%E5%88%86%E4%BA%AB%E6%8C%89%E9%92%AE%3C%2Fa%3E%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbuttonLite.js%23uuid%3D%26amp%3Bstyle%3D2%26amp%3Btextcolor%3D%23000%26amp%3Bbgcolor%3Dnone%26amp%3Bbp%3Dsinaminiblog%2Cqzone%2Crenren%2Cqqmb%26amp%3Bssc%3Dfalse%26amp%3Bsn%3Dtrue%26amp%3Btext%3D%E5%88%86%E4%BA%AB%E5%88%B0%22%3E%3C%2Fscript%3E',
			
		'3:DarkOrange:x': '%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbuttonLite.js%23uuid%3D%26amp%3Bstyle%3D3%26amp%3Bfs%3D4%26amp%3Btextcolor%3D%23fff%26amp%3Bbgcolor%3D%23F60%26amp%3Btext%3D%E5%88%86%E4%BA%AB%E5%88%B0...%22%3E%3C%2Fscript%3E',
			
		'3:Blue:x': '%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbuttonLite.js%23uuid%3D%26amp%3Bstyle%3D3%26amp%3Bfs%3D4%26amp%3Btextcolor%3D%23fff%26amp%3Bbgcolor%3D%2306C%26amp%3Btext%3D%E5%88%86%E4%BA%AB%E5%88%B0...%22%3E%3C%2Fscript%3E',
			
		'3:Grey:x': '%3Cscript%20type%3D%22text%2Fjavascript%22%20charset%3D%22utf-8%22%20src%3D%22http%3A%2F%2Fstatic.bshare.cn%2Fb%2FbuttonLite.js%23uuid%3D%26amp%3Bstyle%3D3%26amp%3Bfs%3D4%26amp%3Btextcolor%3D%23000%26amp%3Bbgcolor%3D%23DDD%26amp%3Btext%3D%E5%88%86%E4%BA%AB%E5%88%B0...%22%3E%3C%2Fscript%3E'
	};
	$('input.buttonStyle').click(function () {
		var name = $('input.buttonStyle:checked').val();
		var style = decodeURIComponent(stylesMap[name].replace(/\+/g,  ' '));
		$('input#option').val(name);
		style=style.replace("uuid=","uuid="+uuid);   
		$('#bscode').val(style);
	});
})
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>