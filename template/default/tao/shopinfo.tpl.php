<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
?>
<div class="shopmessage" style="text-align:center; padding:10px 0px">
<?php if(TAODATATPL==2){?>
<div style="width:140px; margin:auto">
<a data-type="1" biz-sellerid="<?=$shop['user_id']?>" data-tmpl="140x190" data-tmplid="3" data-rd="1" data-style="2" data-border="1" href="#"></a>
</div>
<?php }else{?>
                <div class="shopname">
                	<h3><?=$shop['shop_title']?></h3>
                </div>
                <div class="shoplogo">
                    <div class="shoplogo-img"><a <?=tdj_click($shop['jump'],$shop['user_id'],'shop')?> style="cursor:pointer" target="_blank"><?=html_img($shop['pic_url'],0,$shop['title'],'',80,80,$shop['onerror'])?></a></div>
                    <div class="shoplogo-font"><?=$shop['seller_nick']?></div>
                </div>
                <div style="clear:both">&nbsp;</div>
                <?php }?>
            </div>