<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

if(!class_exists('zhidemai')){
	include(DDROOT.'/comm/zhidemai.class.php');
	$zhidemai_class=new zhidemai($duoduo);
}
$zhidemai_hot=$zhidemai_class->hot(10);

?>
<?php if(MOD=='zhidemai'){?>
<div class="zdm-pub-box" id="baoliao">
            <h3 class="yahei" style="font-weight:normal">折扣信息 有奖征集</h3><p>看过？买过？用过？研究过？</p>
            <a style=" color:#FFF; font-size:16px" href="<?=u('zhidemai','baoliao')?>" class="btn-zdm-red btn-aside-pub">我要爆料</a>
            <a style=" color:#FFF; font-size:16px" href="<?=u('zhidemai','index',array('cid'=>0,'do'=>'my','page'=>1))?>" class="btn-zdm-red btn-aside-pub">我通过的爆料</a>
            <ul class="zdm-pub-list">
              <!--<?php if($webset['zhidemai']['jiangli_value']>0){?>
              <li>每个有效爆料奖励<br/>
              <?php if($webset['zhidemai']['jiangli_huobi']==1){?>
              金额：<strong><?=$webset['zhidemai']['jiangli_value']?></strong>元
              <?php }elseif($webset['zhidemai']['jiangli_huobi']==2){?>
              <?=TBMONEY?>：<strong><?=$webset['zhidemai']['jiangli_value']?></strong><?=TBMONEYUNIT?>
              <?php }else{?>
              积分：<strong><?=$webset['zhidemai']['jiangli_value']?></strong>点
              <?php }?>
              </li>
              <?php }?>
              
              <?php if($webset['zhidemai']['jiangli_bili']>0){?>
              <li>每个有效购买奖励<br/>比例：<strong><?=$webset['zhidemai']['jiangli_bili']*100?></strong>%</li>
			  <?php }?>-->
            </ul>
               </div>
<script>
fixDiv('#baoliao',0);
</script>
<?php }?>
                      <div class="zdm-box">
            <div class="hd aside-ranking clearfix">
              <h3 class="l money">
                <i></i>最火爆料
              </h3>
            </div>
            <div class="bd J-item-wrap" data-boxname="pingce">
              <ul>
              <?php foreach($zhidemai_hot as $row){?>
                              <li class="aside-ranking-item">
                  <a href="<?=$row['view']?>" class="J-item-track" title="<?=$row['title']?>" target="_blank" >
                    <p><img src="<?=$row['img']?>" width="120" height="120" alt="<?=$row['title']?>"/></p>
                    <p class="text"><?=$row['title']?></p>
                  </a>
                  <div class="comment-num">
                    <i>
                    </i>
                    <?=$row['ding']?>                  </div>
                </li>
                <?php }?>
                                
                              </ul>
            </div>
          </div>