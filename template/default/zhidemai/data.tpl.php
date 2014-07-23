<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

if(!class_exists('zhidemai')){
	include(DDROOT.'/comm/zhidemai.class.php');
	$zhidemai_class=new zhidemai($duoduo);
}
if(isset($shuju_code) && $shuju_code!=''){
	$code=$shuju_code;
}
else{
	$shuju_code=$code=MOD;
}

$pagesize=$webset['ddgoodsnum'][$code]?$webset['ddgoodsnum'][$code]:10;
$cid=(int)$_GET['cid'];
$page=(int)$_GET['page'];
$do=$_GET['do'];
$q=$_GET['q'];
if($page==0) $page=1;
$page=($page-1)*($ajax_load_num+1)+1;
if($page==0) $page=1;
$url_arr=array();
$zhidemai_where='1';

$url_arr['cid']=$cid;
if($cid>0){
	$zhidemai_where.=' and cid="'.$cid.'"';
}
$url_arr['do']=$do;
if($do=='my'){
	$zhidemai_where.=' and uid="'.$dduser['id'].'"';
}
/*$url_arr['q']=$q;
if($q!=''){
	$zhidemai_where.=' and title like "%'.$q.'%"';
}*/

$data=$zhidemai_class->index_list($pagesize,$page,$zhidemai_where,$zhidemai_total);
$zhidemai_list=$data['data'];
$total=$data['total'];
?>
<?php if(empty($zhidemai_list) && VIEW_PAGE==1){include(TPLPATH.'/inc/nonetip.tpl.php');}?>
          
          <?php foreach($zhidemai_list as $row){?>
                      <div id="J_zdm_list" style="position:relative">
              <div class="zdm-list-item J-item-wrap item-no-expired" data-id="<?=$row['id']?>">
              <?php if($row['shuxing_id']>0){?><i class='<?=$row['shuxing_class']?>'><?=$row['shuxing']?></i><?php }?>
                <h4 class="t"><a class="J-item-track nodelog" href="<?=$row['view']?>" target="_blank"><?=$row['title']?><span class="red t-sub"><?=$row['subtitle']?></span></a></h4>
                <div class="item-img">
                  <a href="<?=$row['view']?>"class="J-item-track img nodelog" target="_blank"><?=dd_html_img($row['img'],$row['title'])?></a>
                  <a href="<?=$row['view_jump']?>" class="btn-zdm-goshop J-item-track nodelog" target="_blank">直接返利模式购买</a>
                </div>
                <div class="item-info J-item-info">
                  <div class="item-time"><?=$row['starttime']?> </div>
                  <div class="item-type">分类：<a href="<?=$row['caturl']?>" class="nine" target="_blank"><?=$row['catname']?></a> </div>
                  <?php if($row['ddusername']!=''){?><div class="item-user">推荐人：<?=$row['ddusername']?></div><?php }?>
                  <?php if($row['mallname']!=''){?><div class="item-user">所属：<a <?php if($row['mallurl']!=''){?>href="<?=$row['mallurl']?>"<?php }?>><?=$row['mallname']?></a></div><?php }?>
                  <div class="item-content J-item-content nodelog-detail" data-id="<?=$row['id']?>">
                    <div class="item-content-inner J-item-content-inner"><?=$row['content']?></div>
                  </div>
                  
                  <div class="item-toggle" data-status="0" onclick="zhidemaiItemToggle($(this))"><a href="javascript:void(0);" class="blue J-item-toggle">展开全文 ∨</a></div>
                  
                </div>
                <div class="J-expend-wrap-before item-vote clearfix">
                  <em class="l item-vote-t">评价本文：</em>
                  <a href="javascript:void(0);" class="l item-vote-yes J-item-vote-yes vote" onclick="zhidemaiVote($(this))" data-type="1"data-id="<?=$row['id']?>"><?=$row['ding']?></a>
                  <a href="javascript:void(0);" class="l item-vote-no J-item-vote-no vote" onclick="zhidemaiVote($(this))" data-type="0"data-id="<?=$row['id']?>"><?=$row['cai']?></a>
                  <span class="l">大家在评论：</span>
                  <a href="javascript:void(0)" class="l item-view-comment J-expend-trigger" onclick="zhidemaiComment($(this))" data-id="<?=$row['id']?>"><?=$row['pinglun']?></a>
                </div>
                
                <div class="J-expend-wrap yahei zdm-expand-wrap" style=" display:none">
  <i class="top-arrow"></i>
  <div class="yahei zdm-expand-comment">
    
  </div>
</div>
                

                
              </div>
              
              

              
            </div>
<?php }
if(AJAX==1){exit;}
?>    