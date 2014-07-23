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
<style>
html { overflow-x:hidden; }
</style>
<script src="<?=TPLURL?>/js/gametask/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script src="<?=DD_YUN_URL?>/Public/plugin/js/<?=MOD?>.js" type="text/javascript"></script>
<script>
  	function ScrollImgLeft(){
		var speed=30
		var scroll_begin = document.getElementById("scroll_begin");
		var scroll_end = document.getElementById("scroll_end");
		var scroll_div = document.getElementById("scroll_div");		
			
		if(scroll_begin.offsetWidth < scroll_div.offsetWidth){
				
      	return false;	
    	}else{
		  scroll_end.innerHTML=scroll_begin.innerHTML;
		  function Marquee(){
			if(scroll_end.offsetWidth-scroll_div.scrollLeft<=0)
			  scroll_div.scrollLeft-=scroll_begin.offsetWidth
			else
			  scroll_div.scrollLeft++
		  }
		  var MyMar=setInterval(Marquee,speed)
		  scroll_div.onmouseover=function() {clearInterval(MyMar)}
		  scroll_div.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
				
		}
			
	  }
	function Autohide(){
		$('#ajax_goods_loading').hide();
	}
	setTimeout('Autohide()',3000);
</script>
<link rel="stylesheet" href="<?=TPLURL?>/css/gametask/offer_css.css" />
<div class="mainbody" style="height:2030px; width:1020px">
    <div class="wrap-task">
        <div class="ad-banner">
           <div class="l aside">
            <div class="status">
            <div style="float:left; width:200px; height:60px; padding:10px;"><img src="<?=a($user['id'],'middle')?>" width="48" height="48" style="background:#FFF; margin-left:-5px; border:1px solid #CCC; padding:3px; float:left;" alt="<?=$user['name']?>"/>
                <div class="user-msg six">您好，
					<?=$dduser['name']?></div>
                    </div>
                    
                <div class="fanli-msg" style="float:left;">
                    <em style="text-indent:1em;">余额：<?=(float)$dduser['money']?>元</em>
                    <p>（已获游戏返利：<?=(float)$total?>元）</p>
                </div>
            </div>
            
            <div class="ad2">
                <a <?php if($offer['url']!=''){?>href="<?=$offer['url']?>"<?php }?> target="_blank"><img src="<?=$offer['img']?>" width="700" height="120" alt="<?=$offer['title']?>"/></a>
            </div>
        </div>
        </div>
        <div class="others">
                <p class="six" style="float:left;"></p>
                    <div class="scroll_div" id="scroll_div">
                    <?php if(!empty($info)){?>
                    <div id="scroll_begin">
                    <?php foreach($info as $r){?>
                    	<?=utf_substr($r['ddusername'],2).'***'?>完成<em><?=$r['programname']?></em>获得<span><?=(float)$r['point']?></span>元任务返利&nbsp;&nbsp;    
                     <?php }?>
                     </div>
                      <?php }else{?>
                      <div id="scroll_begin">&nbsp;&nbsp;暂时没有数据哦！赶紧行动吧！</div>
                      <?php }?>
                      <div id="scroll_end"></div>
                    </div>
                <script type="text/javascript">
                  ScrollImgLeft();
                </script>
            </div>
            <div style="width:945px; height:60px; border:1px solid #f0d7c1; background:#feeedf; float:left; padding:10px; font-family:宋体;">
            	<h3 style="color:#bb0504;">注意</h3>
                <p style="line-height:20px;">1、状态"已参与" 的，表示点击了，需等待最终完成任务并确认后获得"佣金"。请注意关注每个游戏的审核时间。状态"已完成"，说明"佣金"已发放，请自行查收！</p>
                <p style="line-height:20px;">2、若已超过游戏的审核时间，游戏还是待审状态，请联系游戏返利QQ客服详细咨询。<span style="color:#bb0504; font-weight:bold;"> QQ：1787430654</span></p>
            </div>
        <div class="r main" style="margin-left:-16px; width:auto;">
            <div id="ajax_goods_loading" style="background:#999; color:#000;filter:alpha(Opacity=30);width:1000px; height:1670px;padding:15px 0;margin:auto;text-align:center; z-index:555; position:absolute; font-size:16px; font-weight:bolder"><img src="<?=TPLURL?>/images/ajax_loader.gif" style="margin-bottom:-2px" />&nbsp;&nbsp;正在拼命加载中</div>
            <div class="iframe">
                <iframe src="http://list.offer99.com/index.php?action=offerlist&pid=n464214ca19c91a2d274eea2410a1223&userid=<?=$memberid?>&type=-1" style='width:1000px; height:1700px;' frameborder='no' border='0'></iframe>
            </div>
        </div>
    </div>
</div>
<!--新的U站插件版本20140225-->
<?php include(TPLPATH.'/footer.tpl.php');?>