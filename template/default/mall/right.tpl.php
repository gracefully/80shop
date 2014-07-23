<?php
if(!isset($mall_class)){
	include(DDROOT.'/comm/mall.class.php');
	$mall_class=new mall($duoduo);
}
$malls=$mall_class->select("1 order by sort asc limit 10");
$huodongs=$duoduo->select_all('huodong','id,title,relate_id','edate>"'.TIME.'" order by sort desc limit 7');
foreach($huodongs as $k=>$row){
	if($row['relate_id']>0){
		$huodongs[$k]['goto']=u('huan','view',array('id'=>$row['relate_id']));
	}
	else{
		$huodongs[$k]['goto']=u('huodong','view',array('id'=>$row['id']));
	}
}
?>
<?php if(!empty($huodongs)){?>
<!--促销TOP10开始-->
<div class="fuchuxiao">
<div class="fuchuxiaobt"> <h3>优惠促销</h3></div>
<ul>
<?php foreach($huodongs as $row){?>
<li><a title="<?=$row['title']?>" target="_blank" href="<?=$row['goto']?>"><?=$row['title']?></a></li>
<?php }?>
</ul>
</div>
<!--促销TOP10结束-->
<?php }?>

<!--促销TOP10开始-->
<div class="cxtuijian biaozhun1">
<div class="cxtuijian_bt"> <h3><div class="shutiao"></div>推荐商家</h3></div>
<ul>
<?php foreach($malls as $row){?>
<li><a title="<?=$row['title']?>" target="_blank" href="<?=u('mall','view',array('id'=>$row['id']))?>"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></a></li>
<?php }?>
</ul>
</div>