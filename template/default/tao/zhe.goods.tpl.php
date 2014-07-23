<?php foreach($goods as $row){?>
<div class="item clearfix">
	<div class="goodstop"></div>
    <div class="t_a">
        <div class="img lazy-img-loader">            
            <a href="<?=$row['go_view']?>" class="redirect-tbk" target="_blank">
			<?php if($ajax_loading==1){?>
			<img src="<?=$row["pic_url"]?>_b.jpg" alt="<?=$row["name"]?>" >
            <?php }else{?>
            <?=html_img($row["pic_url"],2,$row["name"],'','','')?>
            <?php }?>
            </a>
        </div>
        <div class="price-info">
            <div class="discount"><s class="l"></s><em><?=round($row['coupon_rate']/1000,1)?></em>折</div>
            <div class="price-now"><span class="cny">￥</span><em><?=$row['coupon_price']?></em></div>
            <div class="price-ori">原价: <span class="cny">￥</span><em class="strike"><?=$row['price']?></em></div>
        </div>
        <div class="title">
            <a href="<?=$row['go_view']?>" class="blue_link redirect-tbk" target="_blank"><?=$row["title"]?></a>
        </div>
        <div style="padding-left:5px; padding-bottom:5px">结束时间：<?=tranTime($row["coupon_end_time"])?></div>
        <div class="rebate" >
			<span>
            <?php if($row["coupon_fxje"]>0){?>
            折后返<em><?=$row["coupon_fxje"]?></em><?=TBMONEY?>，
			<?php }?>
			<?=$row['volume']?>人已购买</span>
		</div>
        
    </div>
    <div class="t_b"></div>
</div>
<?php }?>