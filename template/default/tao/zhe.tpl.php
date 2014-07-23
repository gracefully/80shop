<?php
$parameter=act_tao_zhe();
extract($parameter);
$css[]=TPLURL."/css/discount.css";
include(TPLPATH.'/header.tpl.php');
?>
<script type="text/javascript" src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<script type="text/javascript">
scrollPaginationPage=(<?=$ajax_load_num?>-1)*<?=($tao_zhe_page-1)?>+1;
ajaxLoadNum=0;
$(function(){
    backToTop();
	var $container = $('.item-list');
	$container.masonry({
		itemSelector : '.item',
		columnWidth : 230,
		gutterWidth : 10
	});
    <?php if($ajax_load_num>0 && $TotalResults>$tao_zhe['page_size']){?>
	$('.item-list').scrollPagination({
		'contentPage': '<?=CURURL.'/index.php?mod=tao&act=zhe'?>', // the page where you are searching for results
		'contentData': {'cid':<?=$cid?>,'q':'<?=$q?>'}, // you can pass the children().size() to know where is the pagination
		'scrollTarget': $(window), // who gonna scroll? in this example, the full window
		'heightOffset': 500, // how many pixels before reaching end of the page would loading start? positives numbers only please
		'pagingId': 'megas512', // how many pixels before reaching end of the page would loading start? positives numbers only please
		'beforeLoad': function(){ // before load, some function, maybe display a preloader div
			$('#ajax_goods_loading').fadeIn();	
		},
		'afterLoad': function(elementsLoaded){ // after loading, some function to animate results and hide a preloader div
			 $('#ajax_goods_loading').fadeOut();
			 $(elementsLoaded).fadeInWithDelay();
			 $('.item-list').masonry('appended', $(elementsLoaded), false); 
			 /*if ($('#content').children().size() > 4){ // if more than 100 results loaded stop pagination (only for test)
			 	$('#nomoreresults').fadeIn();
				$('#content').stopScrollPagination();
			 }*/
			 ajaxLoadNum++;
			 if(ajaxLoadNum><?=($ajax_load_num-1)?> || $(elementsLoaded).html()=='over'){
			    //$('#ajax_goods_loading').fadeIn().html('暂无商品');
			    $('.megas512').show();
			    $('.item-list').stopScrollPagination();
			}
		}
	});
	
	// code for fade in element by element with delay
	$.fn.fadeInWithDelay = function(){
		var delay = 0;
		return this.each(function(){
			$(this).animate({opacity:1}, 200);
			delay += 100;
		});
	};
	<?php }?>	   
});
</script>
<div id="taozhe" style="width:1000px; background:#FFF; border:#D0210C 1px solid; margin:auto; margin-top:10px; padding-top:10px">
<?=AD(9)?>
<div class="discount-main span-24">
<div class="item-tags" id="item-tags">
<div class="item-tags-list clearfix">
  <?php foreach($tao_zhe_tag['info'] as $k=>$arr){?>
  <div class="tags-field">
    <div class="title<?=$k?>"><?=$tao_zhe_tag['category'][$k]?></div>
    <ul>
      <?php foreach($arr as $row){?>
      <li><a <?php if($row['b']==1){?>class="pink"<?php }?> href="<?=u('tao','zhe',array('q'=>$row['word']))?>"><?=$row['word']?></a></li>
      <?php }?>               
    </ul>
  </div>
  <?php }?>
</div>
    </div>
	<!--标签-->
</div>

<div id="content" class="span-24">
<?php if($TotalResults>0){?>
<div class="item-list infinite-scroll clearfix">
<?php include(TPLPATH.'/tao/zhe.goods.tpl.php');?>
</div>
<div id="ajax_goods_loading" style="background:#999; color:#FFF; width:210px; height:25px; line-height:25px; margin:auto; display:none; text-align:center">
<img src="template/<?=MOBAN?>/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
<div class="megas512" id="megas512" style="text-align:center; margin:15px 0; display:none"><?=pageft($TotalResults,$pagesize,$show_page_url,WJT)?></div>
<!--商品内容结束-->	
<?php }else{?>
<div style="float:left"></div>
<div style="float:right">
<?php include(TPLPATH.'/tuijian.tpl.php');?>
</div>
<?php }?>
</div>
</div>
<?=AD(108)?>
<?php include(TPLPATH.'/footer.tpl.php');?>