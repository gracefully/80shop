<div class="goodslist_top">
                    <div class="goodslist_hot1"> 
                    
                    <div class="fufenlei">
    <ul>
    	<li style="border:1px solid #FFF; font-size:12px; background:none">推荐分类：</li>
        <?php $j=0; foreach($goods_type as $k=>$v){if($j==8) break;?>
        <li>
            <a <?php if($cid==$k){?> class="current" <?php }?> href="<?=u('tao','list',array('cid'=>$k))?>"><?=$v?></a>
        </li>
 		<?php $j++;}unset($j);?>
    </ul>
</div>
                    </div>
                    <div class="goodslist_xs">
                        <a href="<?=$showpic_list1?>" class="noline"><img src="<?=TPLURL?>/images/list1<?=$list?>.gif" alt="小图片模式"  /></a>&nbsp;&nbsp;<a href="<?=$showpic_list2?>" class="noline"><img src="<?=TPLURL?>/images/list2<?=$list?>.gif" alt="大图片模式"  /></a>
                    </div>
                </div>