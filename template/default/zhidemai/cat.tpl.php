<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

	$catname=$zhidemai_class->catname();
	unset($catname['']);
	?>
    <div id="J-zdm-sidebar" class="zdm-sidebar" style="display:none;">
      <h3 class="hd">
        <span class="hd-cat">
          分类筛选
        </span>
      </h3>
      <ul>
      <?php foreach($catname as $k=>$v){?>
       <li <?php if($k==$_GET['cid']){?> class="current"<?php }?>><a href="<?=u('zhidemai','index',array('cid'=>$k))?>" class="ico<?=$k?> six"><?=$v?></a></li>
      <?php }?>
      </ul>
    </div>
<script>
function setSidebarTop(){
	var $header = $('#zhidemaiad');
	var sidebarTop = $header.offset().top+ 10;
	$('#J-zdm-sidebar').css({
		'top': sidebarTop + 'px'
	}).sidebar({
		min: 0,
		ieOffset: sidebarTop,
		position: 'top',
		relative: true,
		relativeWidth: -1260,
		backToTop: false
	});
}
setSidebarTop();
</script>