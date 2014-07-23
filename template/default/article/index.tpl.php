<?php
$parameter=act_article_index();
extract($parameter);
$css[]=TPLURL.'/css/article.css';
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
<div class="mainbody1000">
<div class="fuleft">
    <div class="news_txt ">
    <?php $i=-1; foreach($articles as $k=>$row){$i++;?>
        <div class="news_txt_<?=($i%2)==0?'l':'r'?> biaozhun5">
            <div class="news_txt_bt">
            <div class="shutiao"></div>
            <h3><?=$article_category[$k]?></h3>
            <div class="new_txt_more"> <a href="<?=u('article','list',array('cid'=>$k))?>"> 更多...</a></div>
        </div>
        <ul>
        <?php foreach($row as $arr){?>
        <li><a href="<?=u('article','view',array('id'=>$arr['id']))?>"><?=$arr['title']?></a> <span><?=date('m-d',$arr['addtime'])?></span></li>
        <?php }?>
        </ul>
        </div>
    <?php }?>
    </div>
   

</div>
<div class="furight">
<?php include TPLPATH."/article/right.tpl.php";?>
</div>
</div>
<?php include TPLPATH."/footer.tpl.php";?>