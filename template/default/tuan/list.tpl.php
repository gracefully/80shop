<?php
$parameter=act_tuan_list();
extract($parameter);
$css[]=TPLURL.'/css/tuangoufanli.css';
include(TPLPATH."/header.tpl.php");
?>
<script language="javascript" type="text/javascript" > 
window.onscroll=function(){
	var top=jQuery(document).scrollTop();
	if(top>450){
		jQuery("#fudong").css("display","");
	}else{
		jQuery("#fudong").css("display","none");
	}
}
 
jQuery(document).ready(function($){
	jQuery("#allshop").data("flag","close");
	$('.submit1').click(function(){
		$('.tuangouflsy_pf').hide();
	    $(this).next('.tuangouflsy_pf').show();
		jQuery("#select2").hide();
		var b = window.event?window.event:arguments.callee.caller.arguments[0]
    	b.cancelBubble = true;
    	changeCity("A");
	});
});
function showAllShop(obj)
{
	if(jQuery("#allshop").data("flag")=="close"){
		var hang_num=7;
		jQuery("#allshop").animate({"height":hang_num*34},500);
		jQuery("#allshop").data("flag","open");
		$(obj).attr("src","template/<?=MOBAN?>/images/more1_2.jpg");
	}else{
		jQuery("#allshop").animate({"height":64},500);
		jQuery("#allshop").data("flag","close");
		$(obj).attr("src","template/<?=MOBAN?>/images/more1_1.jpg");
	}
}
function change_bg1(id){
	//alert(id);
	jQuery("#"+id).css({ background: "#e2eaff" });
}
function change_bg2(id){
	//alert(id);
	jQuery("#"+id).css({ background: "#ffffff" });
}
function close_city(){
	jQuery(".tuangouflsy_pf").hide();
	jQuery("#select2").show();
	var b = window.event?window.event:arguments.callee.caller.arguments[0]
    b.cancelBubble = true;
}
function show_sx(id){
	jQuery("#"+id).show();
	var b = window.event?window.event:arguments.callee.caller.arguments[0]
	b.cancelBubble = true;
}
function hide_sx(id){
	jQuery("#"+id).hide();
	var b = window.event?window.event:arguments.callee.caller.arguments[0]
	b.cancelBubble = true;
}
 
function clickDiv(div){
   div.style.display="block";
   var b = window.event?window.event:arguments.callee.caller.arguments[0];
   b.cancelBubble = true;
}
function add_boder(obj){
	$(obj).addClass("border");
}
function move_border(obj){
	$(obj).removeClass("border");
}
function closeBanner(){
	$("#tgBanner").remove();
	$.cookie('tgbanshow', 0, {expires:120});
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
            msg = d + "天" + h + "小时" + m + "分" + s + "秒结束";
            fn(msg);
            --maxtime;
        } else {
            clearInterval(timer);
            fn("时间到，结束!");
        }
    },1000);
}
</script>
<div class="biaozhun5" style="width:1000px; background:#FFF; margin:auto; margin-top:10px; padding-top:10px">
<div class="tuangouflsy_top">
<?=AD(12)?>
  <div class="tuangoufl_mingzhan">
  <div class="tuangoufl_mingzhan_biaotifd"><img alt="团购返利站" src="template/default/images/tuangoufl_jia_07.png"/></div>
	<div class="tuangoufl_mingzhan_content" id="allshop">
	  <ul>
        <li><span>&nbsp;</span></li>
        <?php foreach($malls as $k=>$row){?>
        <li><a href="<?=tuan_url('mall_id',$row['id'])?>"<?php if($mall_id==$row['id']){?> style="font-weight:bold; color:red"<?php }?>><?=$row['title']?></a> | 返利<span class="textcolor1"><?=$row['fan']?></span></li>
        <?php }?>	
      </ul>
	  <div style="clear:both;"></div>
	</div>
	<div class="tuangoufl_mingzhan_more"><img alt="团购商家" src="template/default/images/more1_1.jpg" onclick="showAllShop(this);" style="cursor:pointer;"/></div>
</div>
<!-- daohang start -->
<div class="tuangouflsy_daohang">
	<div class="tuangouflsy_daohang_left">
	  <ul>		
      <?php foreach($tuan_cat as $k=>$row){?>
      <?php if($k==$cid){?>
      <li  class="sekuai2"><span class="tuangouflsy_daohang_span1"><?=$row['title']?></span></li>
      <?php }else{?>
      <li><a href="<?=tuan_url('cid',$k)?>"><?=$row['title']?></a></li>
      <?php }?>
      <?php }?>
      </ul>
	</div>	
	<div style="clear:both"></div>
</div>
<!-- daohang end -->
<!-- search condition start -->
<div class="tuangouflsy_daohang_paixu" style="clear:both" >
    <span class="tuangouflsy_daohang_paixu_span1">一共有 <strong><?=$total?></strong> 件团购商品</span>
    <span class="tuangouflsy_daohang_paixu_span2">
      <span class="tuangouflsy_daohang_paixu_span1" style="margin-right:5px;">排序:</span>
        <?php $j=2;?>
		<?php foreach($sort_arr as $k=>$v){$j++?>
        <?php if($k==$sort){?>
		<span class="tuangouflsy_daohang_paixu_span<?=$j?>" style="color:#ffffff; font-weight:bold"><?=$v?></span>
        <?php }else{?>
        <span class="tuangouflsy_daohang_paixu_span<?=$j?>"><a href="<?=tuan_url('sort',$k)?>"><?=$v?></a></span>
        <?php }?>
        <?php }?>
       </span>
</div>
<!-- search condition end -->
<!-- header end -->
<!-- items start -->

<?php if($goods){?>
<?php foreach($goods as $k=>$v){?>
<div class="tuangouflsy_chanpin">
	  <div class="tuangouflsy_chanpin_top">
		<span class="tuangouflsy_chanpin_span1" style="float:left"><span class="tuangouflsy_chanpin_span3"><?=$tuan_cat[$k]['title']?></span>【<?=$city_title?>】</span><span style="float:left">
      
        <div class="tuangouflsy_logo_span2">
       <span class="tuangouflsy_logo_span3">
       <input class="submit1" type="button" name="button" value="" />
       <div class="tuangouflsy_pf citydiv" style="display:none;" onclick="clickDiv(this)"><span class="tuangouflsy_pf_guanbi"><a href="javascript:void(0)" onclick="close_city()">关闭</a></span>
   <div class="tuangouflsy_pf_zhongdian">
     <ul>
       <li>
          <span class="tuangouflsy_pf_span1">核心城市</span>
          <span class="tuangouflsy_pf_span2">
          <?php foreach($city as $city_k=>$city_v){?>
          	<span class="tuangouflsy_pf_span3"><a href="<?=tuan_url('city_id',$city_k)?>"><?=$city_v?></a></span>
          <?php }?>
          </span>
       </li>
        <li style="margin-bottom:10px;"><span class="textcolor1" >请按照拼音首字母来选择城市</span></li>
     </ul>
      <div style="clear:both"></div>
   </div>
   <div class="tuangouflsy_pf_xuanqu">
      <div class="tuangouflsy_pf_yinwen">
      <a href="javascript:void(0)" onclick="changeCity('a')" id="city_a_a" class="sekuai">A</a>
      <a href="javascript:void(0)" onclick="changeCity('b')" id="city_a_b" class="sekuai">B</a>
      <a href="javascript:void(0)" onclick="changeCity('c')" id="city_a_c" class="sekuai">C</a>
      <a href="javascript:void(0)" onclick="changeCity('d')" id="city_a_d" class="sekuai">D</a>
      <a href="javascript:void(0)" onclick="changeCity('e')" id="city_a_e" class="sekuai">E</a>
      <a href="javascript:void(0)" onclick="changeCity('f')" id="city_a_f" class="sekuai">F</a>
      <a href="javascript:void(0)" onclick="changeCity('g')" id="city_a_g" class="sekuai">G</a>
      <a href="javascript:void(0)" onclick="changeCity('h')" id="city_a_h" class="sekuai">H</a>
      <a href="javascript:void(0)" onclick="changeCity('j')" id="city_a_j" class="sekuai">J</a>
      <a href="javascript:void(0)" onclick="changeCity('k')" id="city_a_k" class="sekuai">K</a>
      <a href="javascript:void(0)" onclick="changeCity('l')" id="city_a_l" class="sekuai">L</a>
      <a href="javascript:void(0)" onclick="changeCity('m')" id="city_a_m" class="sekuai">M</a>
      <a href="javascript:void(0)" onclick="changeCity('n')" id="city_a_n" class="sekuai">N</a>
      <a href="javascript:void(0)" onclick="changeCity('p')" id="city_a_p" class="sekuai">P</a>
      <a href="javascript:void(0)" onclick="changeCity('q')" id="city_a_q" class="sekuai">Q</a>
      <a href="javascript:void(0)" onclick="changeCity('r')" id="city_a_r" class="sekuai">R</a>
      <a href="javascript:void(0)" onclick="changeCity('s')" id="city_a_s" class="sekuai">S</a>
      <a href="javascript:void(0)" onclick="changeCity('t')" id="city_a_t" class="sekuai">T</a>
      <a href="javascript:void(0)" onclick="changeCity('w')" id="city_a_w" class="sekuai">W</a>
      <a href="javascript:void(0)" onclick="changeCity('x')" id="city_a_x" class="sekuai">X</a>
      <a href="javascript:void(0)" onclick="changeCity('y')" id="city_a_y" class="sekuai">Y</a>
      <a href="javascript:void(0)" onclick="changeCity('z')" id="city_a_z" class="sekuai">Z</a>      
      </div>
      <?php foreach($city_word_arr as $city_word_k=>$city_word_v){?>
      <div id="city_span_<?=$city_word_k?>" class="tuangouflsy_pf_chengshi" >
          <?php foreach($city_word_v as $city_word_key=>$city_word_val){?>
      		<a href="<?=tuan_url('city_id',$city_word_val)?>" ><?=$city[$city_word_val]?></a>
          <?php }?>
      </div>
      <?php }?>
            <div style="clear:both"></div>
   </div>
</div>
       </span>
       <div style="clear:both"></div>
    </div>

    </span>
		<span class="tuangouflsy_chanpin_span2" style="font-size:14px">
			<a href="<?=tuan_url('cid',$k)?>"  name="img_1"><?=$tuan_cat[$k]['title']?> >></a>
		</span>
		<div style="clear:both;"></div>
	  </div>
      </div>
	  <div class="tuangouflsy_chanpin_content">
      <?php $n=0;$i=0;?>
      <?php foreach($v as $row){$n++;?>
		<dl onmouseover="javascript:add_boder(this)" onmouseout="javascript:move_border(this)" <?php if($n%3==0){?> class="wu"<?php }?>>
			  <dt>
				<p class="jiacu"><a href="<?=u('mall','view',array('id'=>$row['mall_id']))?>">【<?=$row['mall_name']?>】返利<?=$row['fan']?></a>
				<a href="<?=u('tuan','view',array('id'=>$row['id']))?>" style="color:#373737" target="_blank" title="<?=$row['title']?>"><?=$row['title']?></a>
				</p>
			  </dt>
			  <dd><a href="<?=u('tuan','view',array('id'=>$row['id']))?>" style="color:#373737" target="_blank">
				<img src="<?=$row['img']?>" onerror="this.onerror=function(){this.src='template/<?=MOBAN?>/images/default.jpg';}" width="283px" height="173px" alt="<?=$row['title']?>" />				</a>
			<?php if($row['edatetime']-TIME<0){?>
            <span class="tuangouflsy_chanpin_maiguanl"></span>
            <?php }elseif(TIME-$row['sdatetime']<8400){?>
            <span class="tuangouflsy_chanpin_maiguanl2"></span>
            <?php }?>
            </dd>
			  <dt>
				<p><span class="chanpin_content_jiage"> <span class="chanpin_content_span1">￥</span> <span class="chanpin_content_span3"><?=subnum($row['price'])?></span></span>
                <span class="chanpin_content_fanli">最高返<span class="textcolor3"><?=$row['fan']?></span></span>
				  <span class="chanpin_content_diqu"><?=$row['bought']?>人已买</span>				</p>
				<div style="clear:both"></div>
				<p class="bj"> <span class="chanpin_content_span4">原价：<span class="chanpin_content_span6">￥<?=$row['value']?></span> <span class="textcolor4">(<?=$row['rebate']?>折)</span><br />
				  <span id="time<?=$row['id']?>">倒计时</span></span> <span class="chanpin_content_span5"><a href="<?=u('tuan','view',array('id'=>$row['id']))?>" target="_blank"><img alt="去团购，拿返利" src="template/<?=MOBAN?>/images/anniu_03.jpg" /></a></span> </p>
			  </dt>
              <script>
			  countDown(<?=$row['edatetime']-TIME?>,
      function(msg) {
        document.getElementById('time<?=$row['id']?>').innerHTML = msg;
      });
			  </script>
			  </dl>
            <?php }?>

	  <div style="clear:both"></div>
	</div>
	<div style="clear:both"></div>
    <?php if($cid==0){?>
    <div style="width:960px; margin:auto">
	<div class="tuangouflsy_chanpin_more"> 
		<span class="tuangouflsy_chanpin_more_span1">
		还有<span class="textcolor1">更多</span><?=$tuan_cat[$k]['title']?>类团购&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=tuan_url('cid',$k)?>" >点击更多&nbsp;<img src="template/<?=MOBAN?>/images/sanjia_03.jpg" id="img_more_1" alt="更多" /></a>
		</span>
	</div>
    </div>
    <?php }?>
    <?php }?>
    <?php }else{?>
    <div style="height:60px; padding-top:40px">
    对不起，没有您想要查询的团购项目
    </div>
    <?php }?>
    <div class="megas512"><?php if($cid>0){echo pageft($total,$pagesize,tuan_url('cid',$cid,1),WJT);}?></div>
                
	<!-- items end -->
</div>
</div>
<?php include(TPLPATH."/footer.tpl.php");?>