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
$where='code="'.$shuju_code.'"';

$data=$ddgoods_class->index_list($pagesize,$page,$where,$ddgoods_total);

if($ddgoods_total==1){
	$total=$data['total'];
	$ddgoods_list=$data['data'];
}
else{
	$ddgoods_list=$data;
}
$phone_app=dd_get_cache('plugin/phone_app');
if(isset($phone_app['status']) && $phone_app['status']==1){
	$phone_app_status=$phone_app['status'];
}
else{
	$phone_app_status=0;
}
?>
<?php if(empty($ddgoods_list) && VIEW_PAGE==1){include(TPLPATH.'/inc/nonetip.tpl.php');}?>
<?php foreach($ddgoods_list as $row){?>
						<li class="cell" id="<?=$row['id']?>" url="<?=$row['view']?>" youhui="<?=$row['discount_price']-$row['shouji_price']?>">
						<p class="goods-name"><a title="<?=$row['title']?>"><?=$row['title']?></a></p>
						<a class="img-link" title="<?=$row['title']?>"><?=dd_html_img($row['img'].'_200x200.jpg',$row['title'])?>
                        <?php if($page==1){?>
                        <div class="gnew"></div>
                        <?php }?>
                        <?php if($phone_app_status==1){?>
						<div class="shoujitip" title="手机专享商品"></div>
                        <?php }?>
                        </a>
						<p class="goods-price">
							<span class="new-price"><span style="font-size:12px">手机专享：</span>¥<?=$row['shouji_price']?></span><del>¥<?=$row['discount_price']?></del>
						</p>
						<div class="goods-txt-btn">
							<p class="goods-info">
								<span class="sign red" title="有返利">返</span><span class="goods-info-txt">已售：<span><?=$row['sell']?></span>件</span>
							</p>
							<p class="goods-info"><?=$row['nick']?></p>
                            <div class="erweima" title="二维码"></div>
							<a class="spr goods-btn" title="<?=$row['title']?>">抢购</a>
						</div>
						</li>
                        <?php }if(!defined('VIEW_PAGE')){exit;}?>