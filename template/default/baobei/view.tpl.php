<?php
$parameter=act_baobei_view();
extract($parameter);
$css[]=TPLURL.'/css/baobei.css';
$css[]=TPLURL.'/css/shai_c.css';
$css[]='css/qqFace.css';
include(TPLPATH."/header.tpl.php");
$num=$webset['baobei']['comment_word_num'];
$comment_tip='亲，登陆后才可评论哦！';
?>
<script src="js/jquery.qqFace.js"></script>
<script>
num=<?=$num?>;
commentTip='<?=$comment_tip?>';
username='<?=$dduser['name']?>';
$(function(){
	<?php if($dduser['id']==0){?>
	$('#<?=$comment_id?>').attr('disabled',true).attr('title','登陆后才可评价宝贝');
	<?php }elseif($dduser['level']<$webset['baobei']['share_level']){?>
	$('#<?=$comment_id?>').attr('disabled',true).attr('title','等级达到<?=$webset['baobei']['share_level']?>才可评价宝贝');
	<?php }?>
	
    $('#comment').bind('focus keyup input paste',function(){  //采用几个事件来触发（已增加鼠标粘贴事件）   
	     $('#num').text(num-$(this).attr("value").length)  //获取评论框字符长度并添加到ID="num"元素上  
	});
	$('#openem').qqFace({
		id : 'facebox1', //表情盒子的ID
		assign:'comment', //给那个控件赋值
		path:'images/face/'	//表情存放的路径
	});
	$('#noComment').click(function(){
	    alert(errorArr[11]);
		window.location='<?=u('user','login')?>&from='+encodeURIComponent(location.href);
	});
	$('#noLevelComment').click(function(){
	    alert(errorArr[21]);
		helpWindows('每次成功购物级别都可增加<b>1</b>，亲加油吧！','<?=WEBNAME?>小助手');
	});
    $('#noComment').click(function(){
		alert(errorArr[10]);
	});
	$('#noLevelComment').click(function(){
		alert(errorArr[21]);
	});
	$('#StartComment').click(function(){
		var comment=$('#comment').val();
		if(comment==commentTip || comment==''){
		    alert(errorArr[27]);
		}
		else{
			$(this).attr('disabled','disabled');
		    $.ajax({
	            url: "<?=u('ajax','save_share_comment')?>",
		        data:{comment:comment,id:<?=$id?>},
		        dataType:'jsonp',
				jsonp:"callback",
		        success: function(data){
			        if(data.s==0){
						$(this).attr('disabled',false);
			            alert(errorArr[data.id]);
						if(data.id==33){
						    helpWindows('两次评论间隔不小于<?=$webset['comment_interval']/3600?>小时','<?=WEBNAME?>小助手');
						}
			        }
			        else if(data.s==1){
			            alert('提交成功');
					    location.replace(location.href);//closeShare();
			        }
		         }
	        });
		}
	});
})
</script>
<div class="biaozhun5"  style="width:1000px; background:#FFF; margin:auto; margin-top:10px; padding-bottom:10px">
<div class="main">
<?=AD(11)?>
<?php include(TPLPATH."/baobei/topcat.tpl.php");?>
  <?php include(TPLPATH."/baobei/topuser.tpl.php");?>
  <div style="height:2px; overflow:hidden; background:#F0F0F0; border-left:1px solid #ECECEC; border-right:1px solid #ECECEC;">&nbsp;</div>
  <div class="good" style="padding-top:15px">
    <div class="good-left">
      <div class="info">
      <a name="p"></a>
        <div class="img">
        <div id="info_top">
        <h3 style="width:270px;">
        <a target="_blank" title="<?=$baobei['title']?>" href="<?=$baobei['jump']?>" style="font-family:宋体"><?=$baobei['title']?></a>
        </h3>
        <span style="float:left; padding-left:15px; color:#669900; font-family:黑体; font-size:14px" title="<?=TBFLTIP?>">￥<?=$baobei['price']?><?php if($baobei['commission']>0){?>[<span style="font-size:11px">返</span><?=$baobei['fxje']?><span style="font-size:11px"><?=TBMONEY?></span>]<?php }?></span></div>
        <a id="goumai" target="_blank" title="<?=$baobei['title']?>" href="<?=$baobei['jump']?>">购买链接</a>
        <div id="img_pic">
        <div id="shangyige" onclick="tiaozhuan(0)"></div>
        <div id="xiayige" onclick="tiaozhuan(1)"></div>
        <a target="_blank" style="color:#FFF; font-size:14px" href="<?=$baobei['jump']?>">
        <?=html_img($baobei['img'],3,$baobei['title'])?>
        </a>
        </div>
        <div id="info_btm">
        <div id="pinglun">
             <div class="pinglun_s pinglun_s1 like" onclick="like(<?=$baobei['id']?>,'x_<?=$baobei['id']?>')" title="送红心" style="cursor:pointer;"><span></span></div>
             <div class="pinglun_s pinglun_s2"></div>
             <div class="pinglun_s pinglun_s3"><span id="x_<?=$baobei['id']?>"><?=$baobei['hart']?></span></div>
             <div class="pinglun_s pinglun_s4">
             </div>
          </div>
             <div style=" width:370px; height:30px; float:right;overflow:hidden;">
                <table width="370" border="0" cellspacing="0" cellpadding="0">
 <!-- Baidu Button BEGIN -->
    <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone">QQ空间</a>
<a title="分享到新浪微博" class="bshare-sinaminiblog">新浪微博</a>
<a title="分享到人人网" class="bshare-renren">人人网</a>
<a title="分享到腾讯微博" class="bshare-qqmb">腾讯微博</a>
<a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=<?=$webset['bshare']['uuid']?>&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
<!-- Baidu Button END -->
</table>
             </div>
        </div>
        </div>
        <div class="more">
          <div class="comment">
            <div style="margin-top:10px; margin-left:10px">
            <dl>
            	<dt><img src="<?=a($baobei['uid'],'small')?>" /></dt>
                <dd style="color:#e71f8d; font-weight:bold; height:25px; overflow:hidden;"><?=$baobei['ddusername']?></dd>
                <dd><span style="float:left; line-height:20px; color:#333; font-size:12px"><?=$baobei['content']?></span>
                <span style="float:right; font-size:12px;"><?=date('m月d日 H:s',$baobei['addtime'])?></span></dd>
            </dl>
            </div>
          </div>
        </div>
        <div style="clear:both"></div>
      </div>
      <div class="comments">
        <div class="form" style="margin-bottom:10px;">
        <div style="height:37px; text-align:right; padding-right:30px; line-height:37px; vertical-align:middle; overflow:hidden;">还可以输入<span id="num"><?=$num?></span>个字</div>
          <div id="form">
            <textarea class="text" onfocus="if(this.value=='<?=$comment_tip?>')this.value=''" id="comment"><?=$dduser['id']?'':$comment_tip?></textarea>
            <input type="submit" class="submit" value="评论" id="<?=$comment_id?>" />
          </div>
          <div id="biaoqngtianjia" style="">
          <span id="openem">添加表情</span>
          </div>
        </div>
        <div class="clear"></div>
        <div class="morecomments" style="margin-left:5px">
          <ul id="hhnjknjmkd" style="height:auto; overflow:hidden">
          <?php foreach($comment_arr as $row){?>
            <li style="width:630px; height:60px; border-bottom:#a8b190 1 dotted; padding:0; margin:0; margin-top:5px; overflow:hidden;">
              <div style="width:40px; height:55px; text-align:left; float:left; padding-top:5px; overflow:hidden;">
              <a href="<?=u('baobei','user',array('uid'=>$row['uid']))?>">
              <img width="32" height="32" src="<?=a($row['uid'],'small')?>" />
              </a>
              </div>
              <div style=" width:570px; height:60px; line-height:20px; float:left; overflow:hidden;">
              	<span style="color:#ff7fa6; font-size:14px;"><?=$row['ddusername']?><span style="color:#b3b3b3; font-size:12px;">(<?=date('m月d日 H:i',$row['addtime'])?>)</span></span><br />
              	<span style="color:#666666; font-size:12px;"><?=str_replace($face,$face_img,$row['comment'])?></span>
              </div>
            </li>
           <?php }?>
          </ul>
        </div>
        <div class="megas512" style="text-align:center; margin-top:10px; clear:both"><?=pageft($comment_total,$pagesize,$page_url,WJT)?></div>
      </div>
      <div class="clear"></div>
    </div>
    <div class="good-right">
    
    <h3 style=" color:#5a6243;text-indent:18px; padding-top:10px; padding-bottom:10px;">猜你喜欢的其他宝贝</h3>
    <div style="width:290px; height:auto; overflow:hidden;">
      <?php foreach($orther_baobei as $row){?>
        <a href="<?=u('baobei','view',array('id'=>$row['id']))?>"><?=html_img($row['img'],2,$row['title'],'goods','','')?></a>
      <?php }?>
</div>
	<div style="width:290px; height:780px; overflow:hidden; border:none; margin-top:10px">
    <?=AD(16)?>
    </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
</div>
<?php
include(TPLPATH."/footer.tpl.php");
?>