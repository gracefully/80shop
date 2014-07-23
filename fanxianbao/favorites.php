<?php
include('header.php');

$browser_cur = browser();     

$broswer_arr=array('IE','Firefox','Chrome','Opera','Safari');
$broswer=$_GET['broswer']?$_GET['broswer']:$browser_cur;

foreach($broswer_arr as $v){
	if(strtolower($v)==strtolower($broswer)){
		$broswer=$v;
		break;
	}
}

$css[]="fanxianbao/css/fanxianbao.css";
include(TPLPATH."/header.tpl.php");
?>
<script>
function loginTips() {
	alert('请先登录后才能正确安装！');
	window.location.href='<?=u('user','login')?>&url='+encodeURIComponent(document.URL);
	return false;
}
</script>
<div style="width:1000px; background:#FFF; border:#D0210C 1px solid; margin:auto; margin-top:10px; padding-bottom:10px">
<div style="height:5px; clear:both"></div>
<div class="select_fan">
<ul>
<li><a class="normal" href="fanxianbao/index.php"><h2>右键版</h2><span>适用：IE内核，360安全浏览器，世界之窗等</span><b>下载安装，无需登录，一键返现！</b></a></li>
<li style="margin-right:0"><a class="cur" href="fanxianbao/favorites.php"><h2>收藏版</h2><span>适用：所有浏览器，360急速浏览器，Firefox，Chrome，Opera等</span><b>只需收藏，安全方便，一键返现！</b></a></li>
</ul>
</div>
<div id="main" style="width:946px;margin: 0 auto;">
<div class="left">
<ul>
<?php foreach($broswer_arr as $v){?>
<li><a <?php if(strtolower($v)==strtolower($broswer)){?> class="cur"<?php }else{?> class="normal" <?php }?> href="fanxianbao/favorites.php?broswer=<?=strtolower($v)?>"><span class="<?=strtolower($v)?>"></span><?=$v?>浏览器</a></li>
<?php }?>
</ul>
</div>
<div class="right"><div class="clearfix"><div class="yixia">
<a title="<?=$webset['fxb']['name']?>" style="color:#FFF" <?php if($dduser['name']==''){echo "onmousedown=loginTips()";}else {echo "";}?> href="<?=$shoucang_code?>"><?=$webset['fxb']['name']?></a>
<div class="fan_ico"><img src="fanxianbao/images/yixia_ico.gif"/></div></div>  <div class="fs14"><div class="yixia_ico"></div><em class="red">右键点击“添加到收藏夹”</em>，如下图所示，添加到“链接”的文件夹。<br>
            <span>如果出现安全警报：“您正在添加一个可能不安全的收藏页。是否继续？”选择“是”。</span></div>
          </div>
          <div class="step">第1步：收藏“<?=$webset['fxb']['name']?>” > 第2步：随时随地查返现</div>
<div class="hon">
<div class="title">
<h4>A1. <?=$broswer?> 浏览器安装方法<?php if(strtolower($broswer)=='ie'){?>（注：其他IE内核的浏览器也可以用这个方法，当然也可以用拖动的方式^_^）<?php }?></h4>
</div>
<div>
<p><img src="fanxianbao/images/<?=strtolower($broswer)?>.jpg" /></p>
<p><img src="fanxianbao/images/02.jpg" /></p>
<p><img src="fanxianbao/images/03.jpg" /></p>
<p><img src="fanxianbao/images/04.jpg" /></p>
<div class="use_fanxianbao">
<h4>右键点击“<?=$webset['fxb']['name']?>”选择添加至收藏夹！（如上图所示）</h4>
<span>当你在逛淘宝网时，看到喜欢的宝贝，只需点击此按钮，便可轻松查看商品返现。</span>
</div>
<div class="clear"></div>
</div>
<div class="hon">
<div class="title"><h4>A2. 如何使用一键返现（收藏版）</h4></div>
<p>1、逛淘宝看到喜欢的商品，点击收藏栏的“淘宝返现宝”即可轻松查看淘宝返现！</p>
<p><img src="fanxianbao/images/05.jpg" /></p>
<p>2、在当前页面会弹出窗口，帮你找到淘宝网上相关宝贝的价格及返现情况，点击购物拿返现到淘宝网购买即可轻松拿返现！</p>
<p><img src="fanxianbao/images/06.jpg" /></p>
<p><img src="fanxianbao/images/07.jpg" /></p>
</div>
</div>
</div>
</div>
</div>
<?php
include(TPLPATH."/footer.tpl.php");
?>