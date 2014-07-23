<div class="goodslist_top">
                    <div class="goodslist_hot"> 
                        <ul> 
                        <li><h3>热门搜索:</h3></li>
                        <?php foreach($webset['hotword'] as $v){?>
                        <li><a href="<?=u('tao','list',array('cid'=>'','q'=>$v,'list'=>$list,'page'=>1))?>"><?=$v?></a></li>
                        <?php }?>
                        </ul>
                    </div>
                    <div class="goodslist_xs">
                        <a href="<?=$showpic_list1?>" class="noline"><img src="<?=TPLURL?>/images/list1<?=$list?>.gif" alt="小图片模式"  /></a>&nbsp;&nbsp;<a href="<?=$showpic_list2?>" class="noline"><img src="<?=TPLURL?>/images/list2<?=$list?>.gif" alt="大图片模式"  /></a>
                    </div>
                </div>