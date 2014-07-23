<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
//$close_after['zhidemai']=',setSidebarTop';
$banner_color=array('jiu'=>'#fff9bc','shijiu'=>'#fbec85','tejia'=>'#ffbb04','zhuanxiang'=>'#238df1','zhidemai'=>'#fdf528');
$ad_close=(int)$_COOKIE[MOD.'adClose'];
$arr=dd_get_cache('ad/'.MOD);
?>

<div id="<?=MOD?>ad" class="yunad" style="text-align:center; background:<?=$arr['bgcolor']==''?$banner_color[MOD]:$arr['bgcolor']?>; height:200px; position:relative; <?php if($ad_close==1){?>height:0<?php }?>">

<div id="ad_a" <?php if($ad_close==1){?>style="display:none"<?php }?>>
<img src="<?=$arr['img_url']==''?TPLURL.'/ad/'.MOD.'.png':$arr['img_url']?>" />
<div style="position:absolute; right:5px; top:5px; cursor:pointer" onclick="closeAd($(this))"><img title="关闭" src="<?=TPLURL?>/images/ad_close.png" /></div>
</div>

<div id="ad_b" <?php if($ad_close!=1){?>style="display:none"<?php }?>><div h="200px" style="position:absolute;right:5px; top:5px; cursor:pointer;" title="打开" onclick="openAd($(this))"><img title="打开" src="<?=TPLURL?>/images/ad_open.png" /></div></div>
</div>

<div style=" height:0px; overflow:hidden">&nbsp;</div>