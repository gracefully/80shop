<?php
$tuijian_goods=$dd_tao_class->dd_tao_goods(array('num'=>5,'cid'=>'a'));
?>
<div class="cxtuijian biaozhun1">
<div class="cxtuijian_bt"> <h3><div class="shutiao"></div>推荐商品</h3></div>

<div class="shopxiangguan">

            <ul>
            <?php foreach($tuijian_goods as $row){?>
                <li>
                    <a target="_blank" href="<?=$row['go_view']?>">
                        <?=html_img($row["pic_url"],2,$row["title"],'',220,220)?>
                    </a>
                    <p><?=$row['title']?></p>
                    <p><span>淘宝价:￥<?=$row['price']?> 元</span></p>
                    <p>返：<b><?=$row['fxje']?></b><?=TBMONEYUNIT?><?=TBMONEY?>
                    </p>
                </li>
                <?php }?>
            </ul>
        </div>
        </div>