<div class="goodslist_main" id="splistbox">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a class="taopic" href="<?=$row["go_view"]?>" target="_blank" pic="<?=base64_encode($row["pic_url"].'_310x310.jpg')?>"><?=html_img($row["pic_url"],1,$row["title"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" href="<?=$row["go_view"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>近期售出<span><?php echo $row["volume"] ?> </span>件 </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<?=$row["nick"]?> <?=wangwang($row["nick"])?><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a zhangguiid='<?=$row["nick"]?>' url="&auctionNumId=<?=$row["iid"]?>&userNumId=<?=$row["user_id"]?>" goto="<?=$row['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span <?php if($row['is_promotion']==1){?>style="text-decoration:line-through; color:#666"<?php }?>><?=$row["price"]?></span> 元 </p> 

                            <p class="fxje" title="<?=TBFLTIP?>"> 可返<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p> 
                           
                            <p>&nbsp;<a target="_blank" href="<?=$row["go_view"]?>">详情</a></p>
                            <?php if($row['is_promotion']==1){?>
                            <p class="tbcuxiao" style="clear:both; margin-top:5px; width:150px;"><i><?=$row['promotion_name']?></i>：<b><?=$row['promotion_price']?></b> 元</p>
                            <?php }?>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" class="fanlitip" rel="nofollow" href="<?=$row['go_view']?>"><div class="goodslist_main_right_buy">去淘宝购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }?>
                    </ul>
                </div>
<?php include(TPLPATH.'/tao/listjs.tpl.php')?>