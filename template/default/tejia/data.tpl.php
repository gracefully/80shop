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
$cid=(int)$_GET['cid'];
$rate=(int)$_GET['rate'];
$page=(int)$_GET['page'];
if($page==0) $page=1;
$page=($page-1)*($ajax_load_num+1)+1;
$url_arr=array();
$where='code="'.$code.'"';
$url_arr['cid']=$cid;
if($cid>0){
	$where.=' and cid="'.$cid.'"';
}
$url_arr['rate']=$rate;
if($rate>0){
	$where.=' and rate<"'.$rate.'" and rate>"'.($rate-1).'"';
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
<?php foreach($ddgoods_list as $row){?>
			<li class="par-item">
			<dl class="to-item" data-id="<?=$row['data_id']?>">
				<dt>
				<a href="<?=$row['view']?>" target="_blank"><?=dd_html_img($row['img'].'_210x210.jpg',$row['title'])?></a>
                <?php if($page==1){?>
                <div class="gnew">&nbsp;</div>
                <?php }?>
                <?php if($row['rate']<=1){?>
                <span class="remain" style="filter:alpha(opacity=30);opacity: 0.3; -moz-opacity:0.3;"></span>
                <div style=" position:absolute;bottom:2px;left:0; text-align:center; color:#FF0; width:100%;"><b>一</b>折热卖</div>
				</dt>
                <?php }?>
				<dd class="title"><a href="<?=$row['view']?>" target="_blank"><?=$row['title']?></a></dd>
				<dd><strong><?=$row['discount_price']?></strong><?=$row['baoyou']?'包邮':''?><span class="discount"><?=round($row['rate'],1)?>折</span><span class="sold-out">抢光了</span><span class="will-start">即将开始</span></dd>
				<dd><del><?=$row['price']?></del>|<span>已售<em><?=$row['sell']?></em>件</span><span class="youfanli" title="有返利">&nbsp;&nbsp;&nbsp;&nbsp;</span></dd>
			</dl>
			</li>
            <?php }?>
<?php if(!empty($ddgoods_list)){?><div style="clear:both"></div><?php }?>
<?php
if(!defined('VIEW_PAGE')){exit;}
?>