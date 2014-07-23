<!--Q&A开始-->
<div class="mall2qa biaozhun5">
<div class="mall2qa1"><img src="<?=TPLURL?>/images/qanda.gif" alt="返利问答" /></div>
<div class="mall2qa2">通过本站介绍用户到商城购物获得提成，再将这部分提成返给用户。例如:某网站返现比率是10%，如果您在该网站买100元的商品，我们就给您返10元钱。</div>
<div class="mall2qa3"><a href="<?=u('help','index')?>">查看返现常见问题>></a></div>
</div>
<!--Q&A结束-->
<div class="news_txt_xg biaozhun5">
      <div class="news_txt_xg_bt">
        <div class="shutiao"></div><h3>热门文章</h3>
      </div>
      <ul>
      <?php foreach($hotnews as $row){?>
        <li><a title="<?=$row['title']?>" href="<?=u('article','view',array('id'=>$row['id']))?>"><?=$row['title']?></a></li>
      <?php }?>
      </ul>
      
    </div>
</div>