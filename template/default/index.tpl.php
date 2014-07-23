<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
define('VIEW_PAGE',1);
//幻灯片
$slides=dd_slides($duoduo,10);

//商城
include(DDROOT.'/comm/mall.class.php');
$mall_class=new mall($duoduo);
$paipai=array('view'=>u('paipai','index'),'view_jump'=>u('paipai','index'),'title'=>'拍拍网','fan'=>'30%','img'=>'images/paipai.jpg','des'=>'京东旗下大型、安全网上交易平台，提供各类服饰、美容、家居、数码、母婴、珠宝');
$malls=$mall_class->index(10,$paipai);

/*if($webset['taoapi']['taobao_chongzhi_pid']!='' && $webset['taoapi']['taobao_chongzhi_pid']!=$webset['taodianjin_pid']){
	$chongzhi_url=SITEURL.'/page/chongzhi.php?pid='.$webset['taoapi']['taobao_chongzhi_pid'].'&uid='.$dduser['id'];
}
else{
	$chongzhi_url=$ddTaoapi->tdj_zujian(1,$dduser['id']);
}*/
$chongzhi_url=$ddTaoapi->tdj_zujian(1,$dduser['id']);

//数据栏目
$ddgoodslanmu=$webset['ddgoodslanmu'];

$lanmu=$ddgoodslanmu;
$i=0;
foreach($lanmu as $k=>$v){
	if($i==0){
		$first_code=$k;
		$div_status[$k]='show="1" style=" display:block"';
	}
	else{
		$div_status[$k]='show="0"';
	}
	$i++;
}

//友情链接
$yqlj=dd_link($duoduo,30,0);

//合作伙伴
$hzhb=dd_link($duoduo,30,1);

$ajax_load_num=5;

$css[]=TPLURL."/css/index.css";
$css[]=TPLURL."/css/zhide-css.css";
$css[]=TPLURL."/css/jiu.css";
$css[]=TPLURL."/css/tejia.css";
$css[]=TPLURL."/css/zhuanxiang.css";
$css[]=TPLURL."/css/malllist.css";
include(TPLPATH.'/header.tpl.php');
?>
<script src="<?=TPLURL?>/js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<script>
var scrollPaginationPage=1;
var ajaxLoadNum=<?=$ajax_load_num?>;
<?php
foreach($lanmu as $k=>$v){
	$indexAjaxCodeObj[$k]=1;
}
?>
var indexAjaxCodeObj=<?=dd_json_encode($indexAjaxCodeObj)?>;
$(function(){
	$("#KinSlideshow").KinSlideshow({
		isHasTitleFont:false,
		isHasTitleBar:false,
		moveStyle:'up',
		btn:{btn_fontHoverColor:"#FFFFFF"}
	});
	
	$(function(){
		$('.clearfix ul li').hover(function(){
			$(this).css('position','relative');
			$(this).find('.fuxuanting').show();
		},function(){
			$(this).css('position','static');
			$(this).find('.fuxuanting').hide();
		});
	})
	
	indexAjaxLoad('<?=$first_code?>');
	
	var $homeTabLi=$('.home-tab li');
	$homeTabLi.click(function(){
		scroller('ddlanmu',500,50);
		$homeTabLi.removeClass('current');
		$(this).addClass('current');
		var code=$(this).attr('code');
		var $indexGoods=$('#index-goods');
		$indexGoods.find('.ddgoods').hide();
		$indexGoods.find('#'+code+'Div').show();
		var show=$indexGoods.find('#'+code+'Div').attr('show');
		$('#ajax_goods_loading').html('<img src="<?=TPLURL?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品').hide();
		if(show==0){
			$indexGoods.find('.'+code+'_goods_list').html('<div id="ajax_goods_loading" style=" display:block"><img src="<?=TPLURL?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>');
			$indexGoods.find('#'+code+'Div').attr('show',1);
			setTimeout(function(){
				changelanmu(code);
			},500);
		}
	});
	fixDiv('#ddlanmu ul',0);
});

function indexAjaxLoad(code){
	eval(code+'LazyLoad()');
	for(var i in indexAjaxCodeObj){
		if(i!=code){
			$('.'+i+'_goods_list').stopScrollPagination();
		}
	}
	ajaxLoad('.'+code+'_goods_list','',ajaxLoadNum,u(code,'data'),{"code":code},500,window[code+'LazyLoad']);
}

function changelanmu(code,first){
	var url=u(code,'data');
	$.get(url,function(data){
		$('.'+code+'_goods_list').html(data);
		indexAjaxLoad(code);
	});
}
</script>
<div class="mainbody">
<div class="mainbody1000 aa"> 
<div id="KinSlideshow" style="margin-top:10px; height:90px; overflow:hidden; background:url(<?=$slides[0]['img']?>)">
<?php foreach($slides as $row){?>
<a href="<?=$row['url']?>" target="_blank"><img src="<?=$row['img']?>" alt="<?=$row['title']?>" width="1000" height="90" /></a>
<?php }?>
</div>
<div class="w1000">
	<div class="home_left home-shop">
    	<div class="clearfix" style="height:198px;border:1px solid #dfdfdf;background:#FFF; position:relative;">
            <ul style="margin-left:8px;margin-top:15px">
            <?php foreach($malls as $row){?>
            	<li style="float:left;width:113px;padding-top:8px;text-align:center;color:#999;height:68px;margin:0 11px 7px 0; z-index:999;">
                    <a href="<?=$row['view']?>" target="_blank">
                    	<img class="img_1" alt="<?=$row['title']?>" src="<?=$row['img']?>" style="width:90px;height:40px; display:block;margin:5px auto;"></a>
                    最高返<?=$row['fan']?>
                    <div class="fuxuanting" style="height:125px; border:1px solid #dfdfdf; background:#fff;">
                        <div class="fuxt01"><div class="fuxt01b"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></div><div class="fuxt01a">返 <span><?=$row['fan']?></span></div></div>
                        <div class="fuxt02">
                          <ul>
                            <li><a href="<?=$row['view']?>"><img alt="返现详情" src="<?=TPLURL?>/images/fx01.png" /></a></li>
                            <li><a target="_blank" href="<?=$row['view_jump']?>"><img alt="直接购买" src="<?=TPLURL?>/images/fx02.png" /></a></li>
                          </ul>
                        </div>
                        <div class="fuxt03" style="border:0 none; background:#fff;"><?=utf_substr($row['des'],46)?>...</div>
                    </div>
                </li>
            <?php }?>
            </ul>
            <a class="arrow-shop-list simsun" href="<?=u('mall','list')?>" target="_blank">></a>
        </div>
    </div>
    
    <div class="chongzhi"><iframe frameborder="0" style="height:200px; width:210px" src="<?=$chongzhi_url?>"></iframe></div>
    <div style="clear:both; height:10px">&nbsp;</div>
    <div id="ddlanmu">
    	<ul class="home-tab clearfix">
        <?php $i=0; foreach($lanmu as $k=>$v){$i++;?>
        <li code="<?=$k?>" <?php if($i==1){?>class="current"<?php }?>><span class="home-tab-super" code="<?=$k?>"><strong><?=$v?></strong></span></li>
        <?php }?>
        </ul>
    </div>
</div>

<?php if(BROWSER==1){?>
<div id="index-goods" style="min-height:800px">
<?php if(isset($ddgoodslanmu['zhidemai'])){?>
<div class="zhidecontainer ddgoods" <?=$div_status['zhidemai']?> id="zhidemaiDiv">
  <div id="J-zdm-article" class="zdm-article" data-pagename="index">
    <div class="zdm-list zhidemai_goods_list">
    <?php if($first_code=='zhidemai'){include(TPLPATH.'/zhidemai/data.tpl.php');}?>
    </div>
  </div>
  <div class="zdm-aside" style=" float:left;margin-left:10px"><?php include(TPLPATH.'/zhidemai/left.tpl.php')?></div>   
  <?php include(TPLPATH.'/zhidemai/js.tpl.php')?>
</div>
<?php }?>

<?php if(isset($ddgoodslanmu['jiu'])){?>
<div id="jiuDiv" class="ddgoods goods_list jiu_goods_list" <?=$div_status['jiu']?>>
<?php if($first_code=='jiu'){$shuju_code=$first_code; include(TPLPATH.'/jiu/data.tpl.php');}?>
</div>
<?php }?>

<?php if(isset($ddgoodslanmu['shijiu'])){?>
<div id="shijiuDiv" class="ddgoods goods_list shijiu_goods_list" <?=$div_status['shijiu']?>>
<?php if($first_code=='shijiu'){$shuju_code=$first_code; include(TPLPATH.'/shijiu/data.tpl.php');}?>
</div>
<?php }?>

<?php if(isset($ddgoodslanmu['tejia'])){?>
<div id="tejiaDiv" class="ddgoods tejia_goods_list" <?=$div_status['tejia']?>>
<?php if($first_code=='tejia'){$shuju_code=$first_code; include(TPLPATH.'/tejia/data.tpl.php');}?>
</div>
<?php }?>

<?php if(isset($ddgoodslanmu['zhuanxiang'])){?>
<div id="zhuanxiangDiv" class="ddgoods zhuanxiang_goods_list" <?=$div_status['zhuanxiang']?>>
<?php if($first_code=='zhuanxiang'){$shuju_code=$first_code; include(TPLPATH.'/zhuanxiang/data.tpl.php');}?>
</div>
<?php include(TPLPATH.'/zhuanxiang/jumpbox.tpl.php');?>
<?php }?>

<div style="clear:both"></div>
<div id="ajax_goods_loading"><img src="<?=TPLURL?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
</div>
<?php }?>


<div class="links">
<div class="links01"> 
<div style=" width:70px; float:left; padding-left:10px"><b>友情链接:</b></div>
<ul style="float:left; width:785px">
<?php foreach($yqlj as $row){?>
<li><a href="<?=$row['url']?>" target="_blank"><?=$row['title']?></a></li>
<?php }?>
</ul></div>
<div class="linksline"> <img alt="间隔线" src="<?=TPLURL?>/images/line02.gif" style="width:900px; height:10px" /></div>
<div class="links02"> 
<div style=" width:70px; float:left; padding-left:10px"><h3>合作伙伴:</h3></div>
<ul style="float:left; width:785px">
<?php foreach($hzhb as $row){?>
<li><a href="<?=$row['url']?>" target="_blank"><img alt="<?=$row['title']?>" style="width:95px; height:33px" src="<?=$row['img']?>" /></a></li>
<?php }?>
</ul></div>
<div style="clear:both"></div>
</div>
<div class="cleandd"></div>
</div>
</div>
<?php include(TPLPATH.'/footer.tpl.php');?>