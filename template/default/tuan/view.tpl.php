<?php
$parameter=act_tuan_view();
extract($parameter);
$css[]=TPLURL.'/css/tuangoufanli.css';
$css[]=TPLURL.'/css/tuangoujs.css';
include(TPLPATH."/header.tpl.php");
?>
<script>
function clickDiv(div){
   div.style.display="block";
   var b = window.event?window.event:arguments.callee.caller.arguments[0];
   b.cancelBubble = true;
}
function open_city(id,evt){
    jQuery(".tuangouflsy_pf").show();
	jQuery("#select2").hide();
	var b = window.event?window.event:arguments.callee.caller.arguments[0]
    b.cancelBubble = true;
    changeCity("A");
 
}
function close_city(){
	jQuery(".tuangouflsy_pf").hide();
	jQuery("#select2").show();
	var b = window.event?window.event:arguments.callee.caller.arguments[0]
    b.cancelBubble = true;
}
function changeCity(id){
	$("div[id^=city_span_]").each(function(){
		$(this).css("display","none");
	});
	$("a[id^=city_a_]").each(function(){
		$(this).removeClass("sekuai");
	});
	$("#city_a_"+id).addClass("sekuai");
	$("#city_span_"+id).css("display","inline");
}
function countDown(maxtime, fn) {
    var timer = setInterval(function() {
        if (maxtime >= 0) {
		    d=parseInt(maxtime/3600/24);
            h=parseInt((maxtime/3600)%24);
            m=parseInt((maxtime/60)%60);
            s=parseInt(maxtime%60);
            msg = "还有" + d + "天" + h + "小时" + m + "分" + s + "秒结束";
            fn(msg);
            if (maxtime == 5 * 60) alert('注意，还有5分钟!'); --maxtime;
        } else {
            clearInterval(timer);
            fn("时间到，结束!");
        }
    },1000);
}
</script>
<div class="biaozhun5" style="width:1000px; background:#FFF; margin:auto; margin-top:10px; padding-top:10px">
<div style="width:950px; margin:auto;">
<?=AD(12)?>
  <div class="tuangoujs_mianbaox" style="height:30px; text-align:left; margin-top:10px">
  <img align="absmiddle" class="pic" src="template/<?=MOBAN?>/images/details_03.jpg">&nbsp;团购详细&nbsp;&nbsp;
  </div>
  <div style=" clear:both"></div>
  <div class="tuangoujs_content">
    <div class="tuangoujs_content_left">
      <div class="tuangoujs_content_tuijian">
         <div class="tuangoujs_content_tuijian_text"><a href="<?=u('mall','view',array('id'=>$goods['mall_id']))?>" style="font-size:24px;font-family:'黑体'" target="_blank">【<?=$goods['mall_name']?>】返利<?=$goods['fan']?> </a>【<?=$goods['city']?>】<?=$goods['title']?></div>
         <div class="tuangoujs_content_tuijian_content">
            <div class="tuangoujs_content_tuijian_pic">
			<img height="265" width="422" src="<?=$goods['img']?>" alt='<?=$goods['title']?>' />
			</div>
		<div class="tuangoujs_content_tuijian_jiage">
               <ul>
                 <li><span class="tuangoujs_content_tuijian_jiage_span1"><span class="tuangoujs_color1">￥</span><span class="tuangoujs_color2"><?=$goods['price']?></span></span>
                   <span class="tuangoujs_content_tuijian_jiage_jiantou">最高返<span class="tuangoujs_color3"><?=$goods['fan']?></span></span>
                 </li>
                 <li>原价：￥<?=$goods['value']?> &nbsp;&nbsp;折扣：<?=$goods['rebate']?>折</li>
                 <li><a href="<?=$goods['jump']?>" target="_blank"><img src="template/<?=MOBAN?>/images/tuangoujs_23.jpg" width="217" height="61" /></a></li>
                 <li class="juzhong">已买：<strong><?=$goods['bought']?>人</strong>已买</li>
                 <li class="bj">
                   <p><img src="template/<?=MOBAN?>/images/tuangoujs_31.jpg" width="17" height="18" style="position:relative;top:3px;"/>&nbsp;该团购倒计时</p>
                   <p id="time"></p>
                   <script>
			  countDown(<?=$goods['edatetime']-TIME?>,
      function(msg) {
        document.getElementById('time').innerHTML = msg;
      });
			  </script>
                 </li>
               </ul>
               <div style="clear:both"></div>
           </div>
            <div style="clear:both"></div>
         </div>
      </div>
      <div class="tuangoujs_content_bendanxq">

		<table cellpadding="0" cellspacing="0" width="667">
				<tr>
			<td>查看此产品详情，请【<a href="<?=$goods['jump']?>" class="checkLogin" target="_blank">点击</a>】</td>
		</tr>
		        </table>
      </div>
    </div>
    <div class="tuangoujs_content_right">
      <div class="tuangoujs_content_tuangousssc">
        <div class="tuangoujs_content_tuangousssc_h1">团购所属商城</div>
        <div class="tuangoujs_content_tuangousssc_content">
          <ul>
            <li><a href="<?=u('mall','view',array('id'=>$goods['mall_id']))?>" target="_blank"> <img width="120" src="<?=$goods['mall_logo']?>" /></a></li>
            <li>
			<a href="<?=u('mall','view',array('id'=>$goods['mall_id']))?>" target="_blank">
			<img src="template/<?=MOBAN?>/images/details_19.jpg" width="148" height="27" /></a>
			</li>        </ul>
          <div style="clear:both"></div>
        </div>
      </div>
      <div class="tuangoujs_content_tuangousssc">
        <div class="tuangoujs_content_shanghaijrtg_h1" style="margin-left:0px; font-family:'宋体'">当地热团购</div>
        <div class="tuangoujs_content_shanghaijrtg" style="margin-left:0px">
          <ul>
          <?php foreach($state_goods as $row){?>
		    <li>
              <p class="gao"><a href="<?=u('mall','view',array('id'=>$row['mall_id']))?>" style="color:#333;">[<?=$row['mall_name']?>]</a><a href="<?=u('tuan','view',array('id'=>$row['id']))?>" target="_blank"><?=$row['title']?></a></p><p>
                <span class="tuangoujs_content_shanghaijrtg_span1">团购价：<span class="tuangoujs_color4"><?=$row['price']?></span></span>
                <span class="tuangoujs_content_shanghaijrtg_jiantou">最高返<span class="tuangoujs_color4"><?=$row['fan']?></span></span>
                <span style="clear:both;"></span>
              </p>
            </li>
            <?php }?>
            <div class="clear"></div>
          </ul>
        </div>
      </div>
      
    </div>
    <div style=" clear:both"></div>
  </div>
  <div style="clear:both;"></div>
</div>
</div>
<?php include(TPLPATH."/footer.tpl.php");?>