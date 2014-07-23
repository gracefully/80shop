<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

if(!class_exists('ddgoods')){
	include(DDROOT.'/comm/ddgoods.class.php');
	$ddgoods_class=new ddgoods($duoduo);
}

if(isset($shuju_code) && $shuju_code!=''){
	$code=$shuju_code;
}
else{
	$shuju_code=$code=MOD;
}

$pagesize=$webset['ddgoodsnum'][$code]?$webset['ddgoodsnum'][$code]:60;
$page=(int)$_GET['page'];
if($page==0) $page=1;
$page=($page-1)*($ajax_load_num+1)+1;

if(isset($order_by)){
	$order_by='sort asc,id desc';
}
if(!isset($cur_cid)){
	$cur_cid=(int)$_GET['cid'];
}
if(isset($cur_sort)){
	$cur_sort=$_GET['sort'];
}

$where='code="'.$code.'"';
$url_arr=array();

$url_arr['cid']=$cur_cid;
if($cur_cid>0){
	$where.=' and cid="'.$cur_cid.'"';
}
$url_arr['sort']=$cur_sort;
if($cur_sort!=''){
	if($cur_sort=='price'){
		$order_by='discount_price asc,sort asc,id desc';
	}
	elseif($cur_sort=='sell'){
		$order_by='sell desc,sort asc,id desc';
	}
	elseif($cur_sort=='rate'){
		$order_by='rate asc,sort asc,id desc';
	}
}

$data=$ddgoods_class->index_list($pagesize,$page,$where,$ddgoods_total,$order_by);
if($ddgoods_total==1){
	$total=$data['total'];
	$ddgoods_list=$data['data'];
}
else{
	$ddgoods_list=$data;
}
?>
<?php if(empty($ddgoods_list) && VIEW_PAGE==1){include(TPLPATH.'/inc/nonetip.tpl.php');}?>
<?php foreach($ddgoods_list as $k=>$row){?>
	<div class="goods <?php if($k%4!=0){?>good<?php }?>">
		<div class="goods_info">
			<a href="<?=$row['view']?>" class="target_url" target="_blank"><?=dd_html_img($row['img'].'_b.jpg',$row['title'])?></a>
			<div class="fanli_num" style="margin:0; right:20px; top:0;"></div>
            <?php if($page==1){?>
            <div class="grew_new"></div>
            <?php }?>
			<div class="goods_title"><?=$row['title']?></div>
			<div class="buy_info">
				<div class="price_info">
					<div class="price">
						￥<span><?=$row['discount_price']?></span>
					</div>
					<div class="pays">
						<span class="C_FF9997">原价￥<?=$row['price']?></span>
					</div>
				</div>
				<a href="<?=$row['view']?>" class="target_url" target="_blank">
				<div class="buy_btn">
				</div>
				</a>
			</div>
		</div>
	</div>
    <?php }
	if(!defined('VIEW_PAGE')){exit;}
	?>