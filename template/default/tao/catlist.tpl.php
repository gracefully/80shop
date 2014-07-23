<div class="goodsleft">
        <?php 
		foreach($goods_type as $k=>$v){ if($k==8) break;
			$tao_goods=$dd_tao_class->dd_tao_goods(array('num'=>4,'cid'=>$k));
		?>
                    	<div class="goodslist">
                            <div class="goodslist_main_2">
                            <div class="content">
                    <div class="content_left">
                        <h3><b><?=$v?></b><a class="more" href="<?=u('tao','list',array('cid'=>$k))?>" target="_blank">更多&gt;&gt;</a></h3>
                    </div>
        		</div>
                	<div id="m_cat" style="border:0px">
                                <ul>
                                  <?php foreach($tao_goods as $data){?>
                                    <li class="info">
                                        <div class="goodslist_main_left_img_2">
                                            <a href="<?=$data['go_view']?>" target="_blank">
                                            <?=html_img($data["pic_url"],2,$data["title"],'',160,160)?>
                                            </a>
                                        </div>
                                        <div class="goodslist_main_left_bt_2 title">
                                            <a target="_blank" href="<?=$data['go_view']?>">
                                               <?=$data['title']?>
                                            </a>
                                        </div>
                                        <p class="price">淘宝价：<span><?=$data['promotion_price']=='0'?$data['price']:$data['promotion_price']?></span>元</p>
                                        <p class="fxje">可返：<span class="greenfont"><?=$data['fxje']?></span><?=TBMONEYUNIT?><?=TBMONEY?></p>
                                        <div class="goodslist_main_right_tb_2">
                                            <a rel="nofollow" class="fanlitip" href="<?=$data['go_view']?>" target="_blank"><div class="goodslist_main_right_buy">去淘宝购买</div></a>
                                            <div class="seecomment" style="color:#F60">
                                            <?php if($data['promotion_name']!=''){?>
                                                【<?=utf_substr($data['promotion_name'],8)?>】
                                             <?php }?>
                                            </div>
                                        </div>
                                    </li>
                                <?php }?> 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>