<?php
$commentDefaultVal='说说你对这件宝贝的评价吧';
$num=$webset['baobei']['word_num'];
?>
<script src="js/jquery.qqFace.js"></script>
<script language="javascript">
commentDefaultVal='<?=$commentDefaultVal?>';
num=<?=$num?>;
var nick='';
var tao_id='';
var image='';
var title='';
var price='';
var shop_title='';
var user_id='';
var logo='';
regTaobaoUrl = /(.*\.?taobao.com(\/|$))|(.*\.?tmall.com(\/|$))/i;
function getTaoItem(url){
    if(url==''){
		alert('网址不能为空！');
		return false;
	}
	if (!url.match(regTaobaoUrl)){
		alert('这不是一个淘宝网址！');
		return false;
	}

	$('#shareContain #J_ImgBooth').attr('src','images/wait.gif');
	$.ajax({
	    url: "<?=u('ajax','getTaoItem')?>",
		data:{'url':url},
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			if(data.s==0){
			    alert(errorArr[data.id]);
				$('#LightBox,#jumpbox').hide();
				if(data.id==18){
					var tao;
				    helpWindows('商品加载失败或者该商品已下架。<br/>查看商品链接：<a target="_blank" href="'+url+'">'+url+'</a>','<?=WEBNAME?>小助手');
				}
			}
			else if(data.s==1){
			    $('#radio'+data.re.cid).attr("checked",true);
	            $('#title').val(data.re.title);
	            $('#price').val(data.re.price);
	            $('#url').val(url);
	            $('#J_ImgBooth').attr('src',data.re.pic_url+'_100x100.jpg');
	            $('#dopic').hide('normal');
	            clickUrl=data.re.click_url;
	            nick=data.re.nick;
				tao_id=data.re.tao_id;
				image=data.re.pic_url;
				title=data.re.title;
				price=data.re.price;
				shop_title=data.re.shop_title;
				user_id=data.re.user_id;
				logo=data.re.logo;
				$('#subShare').attr('disabled',false);
			}
		 }
	});
}

$(function(){
	$('#subShare').attr('disabled','disabled');
	<?php if(MOD=='user' && ACT=='tradelist'){?> //晒单
	$('.shai').jumpBox({  
		id:'jumpbox_share',
		height:300,
		width:590,
		defaultContain:1,
		button:1,
		jsCode2:"var $parentDiv=$(this).parent('td');taoIid=$parentDiv.attr('iid');taoUrl='http://item.taobao.com/item.htm?id='+taoIid;getTaoItem(taoUrl);trade_id=$parentDiv.attr('trade_id');"
    });
	<?php }else{?>  //直接分享
    $('#startShare').jumpBox({  
		id:'jumpbox_share',
		height:300,
		width:590,
		defaultContain:1,
		button:1,
		jsCode2:"$('#shareContain .funtip .taourl').click();"
    });
	<?php }?>
	$('#openem').qqFace({
		id : 'facebox1', //表情盒子的ID
		assign:'comment', //给那个控件赋值
		path:'images/face/'	//表情存放的路径
	});
	$('#shareContain .funtip .taourl').click(function(){
	    $('#jiantou').css('left','118px');
		$('#tishi').html('在此直接粘贴宝贝的链接地址');
		$('#dopic').show();
		$('#shareContain #tao_url').focus()
	});
	$('#shareContain #dopic #get_tao_img').click(function(){
	    var url=$('#tao_url').val();
		getTaoItem(url);
	});
	$('#comment').bind('focus keyup input paste',function(){  //采用几个事件来触发（已增加鼠标粘贴事件）   
	     $('#num').text(num-$(this).attr("value").length)  //获取评论框字符长度并添加到ID="num"元素上  
	});
	$('#shaiForm').submit(function(){
	    var keywords=$.trim($('#keywords').val());
		var comment=$('#comment').val();
		var cid = $("input[name='shaicat'][type='radio']:checked").val();
        var l=keywords.split(/\s+/).length;
		var num=parseInt($('#num').text());
		if(typeof image=='undefined' || image==''){
		    alert(errorArr[24]);
			return false;
		}
		else if(typeof cid=='undefined'){
		    alert(errorArr[25]);
			return false;
		}
		else if(num<0){
		    alert(errorArr[26]);
			$('#comment').focus();
			return false;
		}
		else if(comment=='' || comment==commentDefaultVal){
		    alert(errorArr[27]);
			$('#comment').focus();
			return false;
		}
		else if(l>5){
		    alert(errorArr[28]);
			$('#keywords').focus();
			return false;
		}
		else{
		    $('#subShare').attr('disabled','disabled');
			if(typeof trade_id=='undefined'){
			    trade_id=0;
			}
			$.ajax({
	            url: "<?=u('ajax','save_share')?>",
		        data:{title:title,tao_id:tao_id,price:price,image:image,commission:0,keywords:keywords,comment:comment,cid:cid,nick:nick,trade_id:trade_id,shop_title:shop_title,user_id:user_id,logo:logo},
		        dataType:'jsonp',
				jsonp:"callback",
		        success: function(data){
			        if(data.s==0){
						$('#subShare').attr('disabled',false);
			            alert(errorArr[data.id]);
			        }
			        else if(data.s==1){
			            alert('提交成功');
					    location.replace(location.href);//closeShare();
			        }
		         }
	        });
			return false;
		}
	});
});
</script>
<div class="LightBox" id="LightBox"></div><div id="jumpbox_share" show="0" class="jumpbox"><div class="top_left"></div><div class="top_center"></div><div class="top_right"></div><div class="middle_left"></div><div class="middle_center"><div class="close"><a></a></div><p style="height:22px"></p><div class="contain">
<div id="shareHtml">
<div id="shareContain">
<form id="shaiForm">
    <div class="share_cat">
      <ul>
        <?php foreach($cat_arr as $k=>$v){?>
        <li><label><input name="shaicat" value="<?=$k?>" type="radio" id="radio<?=$k?>"><?=$v?></label></li>
        <?php }?>
      </ul>
    </div>
    <div class="shareform">
      
      <div id="expression" style=" float:left">
      <ul>
      </ul>
      <!--<div style=" float:left; margin-left:2px;cursor:pointer; width:30px" onclick="$('#expression').fadeOut('slow');">关闭</div>-->
      </div>
        <div class="shareComment">
          <textarea id="comment" onfocus="if(this.value==commentDefaultVal){this.value=''};"><?=$commentDefaultVal?></textarea>
        </div>
        <div class="shareSubmit">
         <input id="subShare" type="submit" value="发 布"/>
        </div>
        <input type="hidden" value="" id="tao_id" name="tao_id" />
        <input type="hidden" value="" id="tao_img" name="tao_img" />
        <input type="hidden" value="" id="click_url" name="click_url" />
        <input type="hidden" value="" id="nick" name="nick" />
        <div style="clear:both"></div>
      
      <div class="funtip">
        <div class="picfunc">
          <a left="19px" id="openem">添加表情</a> 
          <span style="float:left">|</span>  
          <a f="html" left="118px" val="在此直接粘贴宝贝的链接地址" class="taourl" style="">宝贝链接</a> 
        <!-- <a style="float:left; display:block; height:18px; line-height:18px; margin-left:5px" f="jpg" left="178px" val="粘贴图片的链接地址">图片链接</a>-->
        </div>
        <div class="wordtip">还可以输入<b id="num"><?=$num?></b>个字</div>
      </div>
      <div id="dopic">
        <div class="jiantouwaiwei"><div id="jiantou"></div></div>
       <div class="main">
          <div class="main1" style="">
            <div style="height:15px">
              <div id="tishi"></div>
              <div class="tishicha" onclick="$('#dopic').hide('normal');"></div>
            </div>
           <div style="height:25px; margin-top:2px">
              <div style="width:326px; float:left ">
                <input id="tao_url" type="text" />
             </div>
              <div style="float:left; height:25px; margin-left:3px;">
                <input f="html" id="get_tao_img" type="button" value="确定" />
             </div>
            </div>
          </div>
        </div>
     </div>
    </div>
    <div style="clear:both"></div>
    <div id="goodsinfo">
       <div class="pic"><img alt="图片信息" id="J_ImgBooth" src="<?=TPLURL?>/images/no_news.gif"/></div>
        <div class="info">
          <div class="name">名称：<input readonly="readonly" id="title" type="text"/></div>
          <div class="url">链接：<input readonly="readonly" id="url" type="text" /></div>
          <div class="price">价格：<input readonly="readonly" type="text" id="price" /> 元</div>
          <div class="tag">
            <div class="word"><b>打标签：</b>填写商品关键字，用空格隔开</div>
            <div class="input"><input id="keywords" type="text"/></div>
          </div>
        </div>
      </div>
      </form>
    </div>
</div>
</div></div><div class="middle_right"></div><div class="end_left"></div><div class="end_center"></div><div class="end_right"></div></div>