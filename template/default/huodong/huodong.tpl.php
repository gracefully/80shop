<?php if($total==0){?>
             <p style=" width:150px; text-align:center; margin:auto; margin-top:20px; color:#F00; font-size:16px"><b>暂无促销活动</b></p>
<?php }else{?>
<script src="js/jQuery.autoIMG.js"></script>
<script>
$(function(){
    $(".cxleft .imgborder").imgAutoSize(450,210); 
})
</script>
<?php foreach($huodong as $row){?>
    <div class="cxmain">
        <div class="cxleft"><div class="imgborder"><a  target="_blank" href="<?=$row['goto']?>"><img alt="<?=$row['title']?>" style="display:none" src="<?=$row['img']?>" /></a></div></div>
        <div class="cxright">
            <div class="cxright_logo">
                <a href="<?=u('mall','view',array('id'=>$row['mall_id']))?>"><img alt="<?=$row['mallname']?>" src="<?=$row['logo']?>" /></a>
                <div class="cxright_logo_2"><p><?=$row['mallname']?></p><p><span>最高返:<?=$row['fan']?></span></p> </div>
            </div>
            <div class="cxright_bt">  <a href="<?=$row['goto']?>"><?=$row['title']?></a></div>
            <div class="cxright_button">
                 <A href="<?=$row['goto']?>" target=_blank>
                 <DIV class=cx_button1 onMouseOver="this.className='cx_button1_h';" onmouseout="this.className='cx_button1';"></DIV>
                 </A>
            </div>
            <div class="cxright_time">活动时间：<?=date('Y-m-d',$row['sdate'])?> - <?=date('Y-m-d',$row['edate'])?></div>
            <div class="cxright_share">
            <p>活动分享：</p>
                <div class="cxright_share_2" >
                    <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到豆瓣" class="bshare-douban"></a><a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=<?=$webset['bshare']['uuid']?>&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
<div><div class="megas512"><?=pageft($total,$pagesize,$page_url,WJT)?></div></div>
<?php }?>