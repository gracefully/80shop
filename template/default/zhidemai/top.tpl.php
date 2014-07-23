<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$top=$zhidemai_class->top();
if(!empty($top)){
?>

<div class="zdm-top-promote">
            <ul><li><a  target="_blank" href="<?=u('zhidemai','view',array('id'=>$top['id']))?>" class="three nodelog"><?=$top['title']?><span class="red"><?=$top['subtitle']?></span></a><i class="dot"></i></li></ul><i class="label"></i>
          </div>
<?php }?>