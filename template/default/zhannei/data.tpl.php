<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

if(!class_exists('ddgoods')){
	include(DDROOT.'/comm/ddgoods.class.php');
	$ddgoods_class=new ddgoods($duoduo);
}

$code=$shuju_code=MOD;
$pagesize=8;
$page=(int)$_GET['page'];
$q=$_GET['q'];
if($page==0) $page=1;
$page=($page-1)*($ajax_load_num+1)+1;
$where='1';

if($q!=''){
	$where.=' and title like"%'.$q.'%"';
	$url_arr['q']=$q;
}

$data=$ddgoods_class->index_list($pagesize,$page,$where,$ddgoods_total);
$ddgoods_list=$data['data'];
$total=$data['total'];
?>
<?php if(empty($ddgoods_list) && VIEW_PAGE==1){include(TPLPATH.'/inc/nonetip.tpl.php');}?>
<?php foreach($ddgoods_list as $row){?>


<li <?php if($row['code']=='zhuanxiang'){?>iid="<?=$row['iid']?>" url="<?=$row['view']?>" youhui="<?=$row['discount_price']-$row['shouji_price']?>" class="cell"<?php }?>>
         <div class="hover_f">
                                    <h6 class="J_tklink_tmall">【<a href="<?=$row['lanmuurl']?>"><?=$row['lanmuname']?></a>】<a href="<?=$row['view']?>"  target="_blank"><?=$row['title']?></a></h6>
                                    <div class="tuan_img">
                                        <a href="<?=$row['view']?>" target="_blank">
                                            <img width="210" height="210" title="<?=$row['title']?>" alt="<?=$row['title']?>" src="images/blank.png"  data-original="<?=$row['img']?>_b.jpg" class="lazy">
                                        </a>
                                    </div>
                                    <div class="money clear">
                                        <i class="yerrow left number"><bdo class="font20">&yen;</bdo><b><?=$row['discount_price']?></b></i>
                                        <a class="right tuangotobuy J_tklink_tmall" href="<?=$row['view']?>" target="_blank">去购买</a>
                                    </div>
                                    <div class="time clear">
                                        <span class="green left"><s class="yuan"></s><?=$row['price']?>元</span>
                                        <span class="yerrow left"><s class="sale"></s><?=$row['rate']?>折</span>
                                        <span class="gray left"><s class="go" title="有返利"></s></span>
                                    </div>
                                </div>
                            </li>
                        <?php }if(!defined('VIEW_PAGE')){exit;}?>