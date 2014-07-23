<!DOCTYPE html PUBliC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="author" content="duoduo_v8.1(<?=BANBEN?>)" />
<?php if($webset['qq_meta']!=''){echo $webset['qq_meta']."\r\n";}?>
<?php if(is_file(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php')){?>
<?php include(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php');?>
<?php }else{?>
<title><?=WEBNAME?></title>
<meta name="keywords" content="<?=WEBNAME?>" />
<meta name="description" content="<?=WEBNAME?>" />
<?php }?>
<?php include(TPLPATH.'/inc/js.config.tpl.php')?>
<base href="<?=SITEURL?>/" />
<?php
$css[]="css/jumpbox.css";
$css[]="css/helpWindows.css";
$css[]="css/kefu.css";
$css[]=TPLURL."/css/hf.css";
$css[]=TPLURL."/css/default.css";
$css[]=TPLURL."/css/common.css";
echo css($css);
unset($css);

$js['a']='js/jquery.js';
$js[]='js/fun.js';
$js[]=TPLURL.'/js/fun.js';
$js[]='js/base64.js';
$js[]='js/jquery.lazyload.js';
$js[]='data/error.js';
$js[]='data/noWordArr.js';
$js[]='js/jumpbox.js';
$js[]=TPLURL.'/js/taokey.js';
echo js($js);
unset($js);
?>
<?php if($dd_have_tdj==1){include(DDROOT.'/comm/tdj_tpl.php');}?>
</head>

<body>
<div class="container dddefault">
  <div class="top">
    <div class="top1000">
      <div class="topleft" style="display:none">
        <div class="topleftA">您好，欢迎来到<?=WEBNAME?>！  请<a href="<?=u('user','login')?>">登录</a> / <a href="<?=u('user','register')?>">免费注册</a> <?php if($app_show==1){?>或使用<?php }?></div>
        <?php if($app_show==1){?>
        <div class=loginWays onmouseover=showLogin() onmouseout=showLogin()>
          <SPAN id=weibo_login class=firstWay>
            <A style="CURSOR: pointer" href="<?=u('api',$apps[0]['code'],array('do'=>'go'))?>"><img style="width:16px; height:16px" alt="用<?=$apps[0]['code']?>号登录" src="<?=TPLURL?>/images/login/<?=$apps[0]['code']?>_1.gif"><?=$apps[0]['title']?>登陆</A><SPAN class=icon-down></SPAN>
          </SPAN>
        <div style="DISPLAY: none" id=menu_weibo_login class=pw_menu>
        <ul class=menuList>
          <?php foreach($apps as $k=>$row){?>
          <li><A href="<?=u('api','do',array('code'=>$row['code'],'do'=>'go'))?>"><img style="width:16px; height:16px" alt='使用<?=$row['title']?>帐号登录' src="<?=TPLURL?>/images/login/<?=$row['code']?>_1.gif" /><?=$row['title']?>帐户登录</A></li>
          <?php }?>
        </ul>
      </div>
    </div>
    <?php }?>
  </div>
<script>
function topHtml() {/*<div class="topleftA" style="padding-top:10px;">
	<a href="<?=u('user')?>">{$name}</a> 
	<a href="<?=u('user','msg')?>">{$msgsrc}</a>&nbsp;&nbsp;|&nbsp;&nbsp;余额：<a href="<?=u('user','mingxi')?>">￥{$money}</a>
	&nbsp;&nbsp;<?=TBMONEY?>：<a href="<?=u('user','mingxi')?>">{$jifenbao}</a> 
	<?=TBMONEYUNIT?>&nbsp;&nbsp;|&nbsp;&nbsp;
</div>
<div class=loginWays1 onmouseover=showHide('menu_usernav') onmouseout=showHide('menu_usernav')>
          <SPAN>
            我的账户<img src="<?=TPLURL?>/images/downarrow.gif" alt="箭头" />
          </SPAN>
          <div id=menu_usernav>
            <div class="wode">我的账户<img src="<?=TPLURL?>/images/toparrow.gif" alt="箭头" /></div>
            <ul>
              <li><A href="<?=u('user','tradelist')?>">我的订单管理</A></li>
              <li><A href="<?=u('user','mingxi')?>">我的账户明细</A></li>
			  <?php if($webset['user']['shoutu']==1){?>
              <li><A href="<?=u('user','shoutu')?>">我的徒弟奖励</A></li>
			  <?php }?>
              <li><A href="<?=u('user','info')?>">我的账户设置</A></li>
            </ul>
          </div>
        </div>
		<div class"fl" style=" margin-top:10px">|&nbsp;&nbsp;&nbsp;<a href="<?=u('user','exit',array('t'=>TIME))?>">退出</a></div>*/;}

$.ajax({
	url: '<?=l('ajax','userinfo')?>',
	dataType:'jsonp',
	jsonp:"callback",
	success: function(data){
		if(data.s==1){
			topHtml=getTplObj(topHtml,data.user);
			$('.container .topleft').html(topHtml).show();
		}
		else{
			$('.container .topleft').show();
		}
	}
});
</script>
  <div class="topright"> 
    <ul>
      <li> <a href="javascript:;" onClick="AddFavorite('<?=SITEURL?>','<?=WEBNAME?>')">收藏本站</a> </li>  
      <li> <a href="comm/shortcut.php">快捷桌面 </a></li>  
      <?php if(TAOTYPE==2){?>   
      <li> <a href="<?=u('sitemap','index')?>">淘宝分类 </a></li>
      <?php }?>
      <li> <a href="<?=u('help','index')?>">网站帮助</a>   </li>
      <li id="fonta"> <a style="color:#F00" href="<?=u('zhannei','baoming')?>">掌柜报名</a>   </li>  
    </ul>
  </div>
</div>
</div>
<div class="search">
<div class="search1000">

<div class="logo">

  <a href="<?=SITEURL?>"><img src="<?=LOGO?>" alt="<?=WEBNAME?>" height="70" /></a></div>

<div class="searchR"><div class='searchbox' id="searchbox">
<div style="TEXT-AliGN: left;">

<FORM style="FLOAT: left" class='frombox' method='get' name='formname' action='index.php' target="_blank" autocomplete="off">
<input type="hidden" id="mod" name="mod" value="check" class="mod" />
<SPAN class=box-middle>
<INPUT id=s-txt class=s-txt name='q' value='请输入商城名，关键词查询' placeholder="请输入商城名，关键词查询"/>

<INPUT class=sbutton type=submit value="查询返利">
</SPAN> 
<SPAN class=box-right></SPAN>
</FORM>
<p></p>
</div>
</div></div>
<div class="header-fa">
<?php
$phone_app=dd_get_cache('plugin/phone_app');
if(isset($phone_app['status']) && $phone_app['status']==1){
	$phone_url='href="'.p('phone_app','index').'" target="_blank"';
}
else{
	$phone_url='href="javascript:alert(\'开发中，敬请期待\');"';
}
?>
<a class="fa-link" <?=$phone_url?> ><img src="<?=TPLURL?>/images/right_sj.png" /></a>
</div>
</div>
</div>
<div class="daohang" id="navdaohang">
  <div class="daohang1000">
    <ul class="ulnav">
    <?php 
	$nav_c=count($nav);
	$nav_num=10; //导航个数
	$nav_c=$nav_c>=$nav_num?$nav_num:$nav_c;
	
	for($i=0;$i<$nav_c;$i++){
		$have_child_class='';
	    if ($nav[$i]['tag'] == PAGETAG) {
		    $dom_id = "id='fontc'";
	    } else {
		    $dom_id = "";
	    }
		if(!empty($nav[$i]['child'])){
			$have_child_class=' have_child';
			$em='<em></em>';
		}
		else{
			$have_child_id='';
			$em='';
		}
		if($i==$nav_c-1){
			$lastclass=' last';
		}
		else{
			$lastclass=' ';
		}
	?>
      <li class="linav<?=$have_child_class?><?=$lastclass?>" <?=$dom_id?>> <a <?=$nav[$i]['target']?> class="anav" href="<?=$nav[$i]['link']?>"><?=$nav[$i]['title']?><?=$nav[$i]['type_img']?><?=$em?></a>
      <?php if($em!=''){?>
      <ul class="n-h-list">
        <?php foreach($nav[$i]['child'] as $row){?>
        <li><a <?=$row['target']?> href="<?=$row['link']?>"><?=$row['title']?> <?=$row['alt']?></a> </li>
        <?php }?>
	  </ul>
      <?php }?>
      </li>
    <?php }?>
      
    </ul></div>
</div>
<script>
var sousuoxiala=new Array();
<?php if(BIJIA>0){?>
sousuoxiala[0]=new Array("mall","goods","全网比价");
<?php }?>
<?php if($webset['paipai']['open']==1){?>
sousuoxiala[1]=new Array("paipai","list","拍拍相关宝贝"); 
<?php }?>
<?php if($webset['taoapi']['s8']==1){?>
sousuoxiala[2]=new Array("tao","view","淘宝相关宝贝"); 
<?php }?>
/*sousuoxiala[3]=new Array("zhannei","index","站内精选宝贝"); 
sousuoxiala[4]=new Array("zhidemai","index","值得买精选宝贝"); */

$searchInput=$("#s-txt");

$(".have_child").hover(function() {
	thisId=$(this).attr('id');
	$(this).attr('id','navc');
    $(this).find("a").eq(0).addClass("sub_on").removeClass("sub");
    $(this).find("ul").show();
},function() {
	if(typeof(thisId) == "undefined"){
		thisId='';	
	}
	$(this).attr('id',thisId);
    $(this).find("a").eq(0).addClass("sub").removeClass("sub_on");
    $(this).find("ul").hide()
});

$('.frombox').submit(function(){
	if($searchInput.val()==$searchInput.attr('placeholder')){
		$searchInput.val('');
	}
	if($searchInput.val()==''){
		alert('请输入查询内容');
		return false;
	}
});

$(function(){
	$searchInput.focusClear();
})
</script>

<div id="header-bottom" style="height:0px; overflow:hidden"></div>