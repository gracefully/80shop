<div class="goodslist_main_2" id="splistbox">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a href="<?=$row["go_view"]?>" target="_blank"><?=html_img($row["pic_url"],2,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" href="<?=$row["go_view"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_seller_2"><p>卖家：<?=$row["nick"]?> <?=wangwang($row["nick"],2)?></p>
                            </div>
                            <?php if($row['promotion_price']>0){?>
                            <p class="tbcuxiao"><i>特价促销</i>：<b><?=$row["promotion_price"]?></b> 元 </p> 
                            <?php }else{?>
                            <p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <?php }?>
                        	
                            <?php if($row["fxje"]>0){?>
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返：<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p>
                            <?php }else{?>
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao">淘宝热卖商品</p>
                            <?php }?>
                            <div class="goodslist_main_right_tb_2"><a rel="nofollow" href="<?=$row['go_view']?>" target="_blank" ><div class="goodslist_main_right_buy">去淘宝购买</div></a></div>
                        </li>  
                     <?php }?> 
                                 
                    </ul>
                </div>	
<?php include(TPLPATH.'/tao/listjs.tpl.php')?>