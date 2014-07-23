<?php
$parameter=act_huodong_list();
extract($parameter);
$css[]=TPLURL.'/css/malllist.css';
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
<div class="mainbody1000"> 

<div class="fuleft">
<!--商家特卖促销活动开始-->
<div class="cxall biaozhun5">
<div class="cxtop"> 
    <div class="leimutop">
    <div class="biaoti3 bz_first">
      	<h3><div class="shutiao"></div>商家特卖促销活动</h3>
      </div>
      <div class="search23">
    <form action="<?=SITEURL.'/index.php'?>">
        <div id="searchtu2">
        <input type="text" class="kuang01" name="title" onfocus="this.value=''" value="请输入要找的活动名称" />
        </div>
        <div id="searchtu">
        <input type="submit" style="background:url(<?=TPLURL?>/images/search02.gif); border:0px; width:23px; height:23px" value="" />
        <input type="hidden" name="mod" value="huodong" />
        <input type="hidden" name="act" value="list" />
        </div>
        </form>
    </div>
    </div>
    
</div>

<?php include(TPLPATH.'/huodong/huodong.tpl.php');?>

</div>
<!--商家特卖促销活动结束-->
</div>
<!--购物返现结束-->
<div class="furight">

<?php include(TPLPATH.'/mall/right.tpl.php');?>
<?=AD(5)?>
</div>
<div class="cleandd"></div>
</div>
</div>
	<?php include(TPLPATH."/footer.tpl.php");?>
