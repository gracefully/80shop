<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}
include(TPLPATH.'/header.tpl.php');
?>
<script src="<?=TPLURL?>/js/offer/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script src="<?=TPLURL?>/js/offer/index.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=TPLURL?>/css/offer/offer_css.css" />
<div class="mainbody">
    <div class="wrap-task">
        <div class="ad-banner">
           <a <?php if($offer['url']!=''){?>href="<?=$offer['url']?>"<?php }?> target="_blank"><img src="<?=$offer['img']?>" alt="<?=$offer['title']?>" width="960" height="128"></a>
        </div>
        <div class="r main">
            <div class="iframe">
                <iframe src="http://www.offer-wow.com/affiliate/wall/open.do?websiteid=1103&styleIndex=<?=$offer['type']?>&memberid=<?=$memberid?>" style='width:720px; height:535px;' scrolling='no' frameborder='no' border='0'></iframe>
            </div>
        </div>
        <div class="l aside">
            <div class="status">
                <p class="user-msg six" title="新插件">您好，<?=$dduser['name']?></p>
                <div class="fanli-msg">
                    <em style="text-indent:1em;">返利余额：<?=(float)$dduser['money']?>元</em>
                    <p>（已获任务返利：<?=(float)$total?>元）</p>
                </div>
            </div>
            <div class="others">
                <p class="six">
                </p>
                <div class="jCarouselLite" style="position:relative;">
                    <ul id="gundong" style="position:absolute">
                    <?php if(!empty($task)){?>
						<?php foreach($task as $r){?>
                            <li><?=utf_substr($r['ddusername'],2).'***'?>获得<span><?=(float)$r['point']?></span>元任务返利<br />
                            (<em><?=$r['programname']?></em>)
                            </li>
                        <?php }?>
                    <?php }else{?>
                    	暂无任务返利，继续努力吧!
                    <?php }?>
                    </ul>
                </div>
            </div>
            <div class="ad2">
                <img src="<?=TPLURL?>/images/rwfl.png" width="217" height="140"/>
            </div>
        </div>
    </div>
</div>
<!--新的U站插件版本20140225-->
<?php include(TPLPATH.'/footer.tpl.php');?>