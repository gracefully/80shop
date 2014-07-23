<div class="goodslist_main" id="splistbox">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">                        
                        	<div class="goodslist_main_left_img"><a class="taopic" href="<?=$row["go_view"]?>" target="_blank" pic="<?=base64_encode($row["pic_url"].'_310x310.jpg')?>"><?=html_img($row["pic_url"],1,$row["name"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" href="<?=$row["go_view"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>本期已售出<span><?php echo $row["volume"] ?> </span>件 <img zhanggui='<?=$row["nick"]?>' alt="等级" src="images/dian.png" align="absmiddle" /> </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<?=$row["nick"]?> <?=wangwang($row["nick"])?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span <?php if($row['promotion_price']>0){?> style="text-decoration:line-through"<?php }?>><?=$row["price"]?></span> 元 </p>
                            
                            <?php if($row["fxje"]>0){?>
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p> 
                            <?php }?>
                            
                            <p>&nbsp;<a target="_blank" href="<?=$row["go_view"]?>">详情</a></p>
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao" style="clear:both; margin-top:5px; width:150px;">
                            <?php if($row['promotion_price']>0){?>
                            <i>特价促销</i>：<b><?=$row['promotion_price']?></b> 元
                            <?php }?>
                            </p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=u('tao','list',array('cid'=>0,'q'=>$row["name"]))?>"><div class="goodslist_main_right_bj"></div></a>
                                <a target="_blank" class="fanlitip" rel="nofollow" href="<?=$row['go_view']?>"><div class="goodslist_main_right_buy">去淘宝购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }?>
                    </ul>
                </div>
<?php include(TPLPATH.'/tao/listjs.tpl.php')?>