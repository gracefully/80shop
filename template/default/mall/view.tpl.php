<?php
$parameter=act_mall_view();
extract($parameter);
	
$css[]=TPLURL."/css/malllist.css";
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
<div class="mainbody1000"> 
<div class="fuleft">
<!--返利步骤开始-->
<?php include(TPLPATH."/inc/top1.tpl.php");?>
<!--返利步骤结束-->


<div class="gouwufanxian biaozhun1">
<div class="gwbiaoti"><h3><div class="shutiao"></div><?=$mall['title']?></h3> </div>

<?php include(TPLPATH."/mall/mallinfo.tpl.php");?>

<a name="<?=$do?>"></a>
<DIV class=mall2lan>
<DIV class=mall2lan-n>
<UL>
<LI class=current><A href="<?=u('mall','view',array('id'=>$id,'do'=>$do))?>#<?=$do?>"><?=$do_arr[$do]?></A></LI>
<?php
unset($do_arr[$do]);
foreach($do_arr as $k=>$v){?>
<LI><A href="<?=u('mall','view',array('id'=>$id,'do'=>$k))?>#<?=$k?>"><?=$v?></A></LI>
<?php }?>
</UL></DIV></DIV>

<?php if($do=='content'){?>
<div class="mall2txt">
<div class="mall2txtl"><div class="mall2txtlk"><span>返<?=$mall['fan']?><br/><?=$fanli_type[$mall['type']]?></span></div></div>
<div class="mall2txtr"><?=$mall['content']?></div>
</div>
<div class="cleandd">  &nbsp;</div>

<DIV class=mall2lan>
<DIV class=mall2lan-n>
<UL>
  <LI class=current><A href="javascript:;" name="pjdf">评价打分</A> </LI>
  </UL></DIV></DIV>
  

<div class="mall2pinglun">
<DIV style="BORDER-BOTTOM: #ccc 1px solid; BORDER-LEFT: #ccc 1px solid; WIDTH: 690px; HEIGHT: 70px; BORDER-TOP: #ccc 1px solid; BORDER-RIGHT: #ccc 1px solid">
<DIV style="MARGIN-TOP: 13px; WIDTH: 110px; FLOAT: left; HEIGHT: 50px; MARGIN-LEFT: 80px; _margin-left: 40px">
<DIV style="COLOR: #333">商城打分</DIV>
<DIV>
<DIV style="FLOAT: left; COLOR: #f30; FONT-SIZE: 32px"><?=$pjf?></DIV>
<DIV style="FLOAT: left">
<DIV>&nbsp;</DIV>
<DIV style="TEXT-ALIGN: left"><SPAN style="COLOR: #f60">(<?=$mall_comment_total?>)</SPAN>次评价</DIV></DIV></DIV></DIV>
<DIV style="MARGIN-TOP: 13px; WIDTH: 440px; FLOAT: right; MARGIN-RIGHT: 40px">
<DIV>
<DIV style="TEXT-ALIGN: center; WIDTH: 30px; BACKGROUND: url(<?=TPLURL?>/images/youbiao.png) 30px 0px; HEIGHT: 21px; COLOR: #fff; MARGIN-LEFT: <?=79*$pjf?>px"><?=$pjf?></DIV></DIV>
<DIV style="WIDTH: 400px; BACKGROUND: url(<?=TPLURL?>/images/youbiao.png); HEIGHT: 14px; MARGIN-LEFT: 15px"></DIV>
<DIV style="MARGIN-LEFT: 15px">
<UL style="margin:0; padding:0;">
  <LI style="FLOAT: left; MARGIN-LEFT: 48px; _margin-left: 24px">非常不满意 </LI>
  <LI style="FLOAT: left; MARGIN-LEFT: 31px">不满意 </LI>
  <LI style="FLOAT: left; MARGIN-LEFT: 49px">一般 </LI>
  <LI style="FLOAT: left; MARGIN-LEFT: 59px">满意 </LI>
  <LI style="FLOAT: left; MARGIN-LEFT: 43px">非常满意 </LI></UL></DIV></DIV></DIV>
<DIV id=mall_comment>
    
    <?php foreach($mall_comment as $arr){?>
    <div class="n_shang_3_4_101">
      <div class="t_p">
        <table width="682" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" height="25" style="text-align:left">会员：<?=$arr['ddusername']?></td>
            <td width="49%" height="25" style="text-align:right; padding-right:5px"><span class="color_19"><?=date('Y-m-d H:i:s',$arr['addtime'])?></span></td>
            <td width="1%"></td>
          </tr>
        </table>
      </div>
      <div class="t_p_t">
        <table width="628" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" style="width:628px;word-break : break-all; overflow:hidden;">
              评论内容：<?=$arr['content']?>
            </td>
          </tr>
          <tr>
            <td width="23" height="20">
              <img src="<?=TPLURL?>/images/icon_151.gif" width="14" height="13" />
            </td>
            <td width="605" height="20">
              <span class="color_19">
                评分等级：
                <?php for($i=0;$i<$arr['fen'];$i++){?>
				<img src="<?=TPLURL?>/images/i_394.jpg" width="24" height="23" />
				<?php }?>
              </span>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <?php }?>
    <div class="megas512">
	<?=pageft($mall_comment_total,$pagesize,u(MOD,ACT,array('id'=>$id,'do'=>$do)),WJT)?>
		</div>
<DIV style="HEIGHT: 1px; CLEAR: both"></DIV>
<DIV style="MARGIN-TOP: 10px; WIDTH: 690px">
<DIV class=p1_11_1>
<DIV class=p1_11_1_a>
<TABLE cellSpacing=0 cellPadding=0 width=680>
  <TBODY>
  <TR>
    <TD height=25 width=21 align=right><a name="comment"></a><IMG  src="<?=TPLURL?>/images/icon_155.gif" width=19 height=19> </TD>
    <TD height=25 width=159><SPAN class=color_4>小提示：点击星星就能打分了 </SPAN></TD>
    <TD height=25 width=146><IMG  src="<?=TPLURL?>/images/i_393.jpg" width=96 height=19> </TD></TR></TBODY></TABLE></DIV>
<DIV class=p1_11_1_b>
<TABLE>
  <TBODY>
  <TR>
    <TD height=30 width=85 align=right><SPAN class=color_1>*</SPAN>商城打分：</TD>
    <TD id=quality height=30 width=200>
      <DIV style="CURSOR: pointer" onMouseUp="setstar(1,'quality',0)"  class=pl_11_xx onMouseOver="setdesc(1,'quality')"><IMG src="<?=TPLURL?>/images/i_396.jpg" width=24 height=23> </DIV>
      <DIV style="CURSOR: pointer" onMouseUp="setstar(2,'quality',0)" class=pl_11_xx onMouseOver="setdesc(2,'quality')"><IMG src="<?=TPLURL?>/images/i_396.jpg" width=24 height=23> </DIV>
      <DIV style="CURSOR: pointer" onMouseUp="setstar(3,'quality',0)" class=pl_11_xx onMouseOver="setdesc(3,'quality')"><IMG src="<?=TPLURL?>/images/i_396.jpg" width=24 height=23> </DIV>
      <DIV style="CURSOR: pointer" onMouseUp="setstar(4,'quality',0)" class=pl_11_xx onMouseOver="setdesc(4,'quality')"><IMG src="<?=TPLURL?>/images/i_396.jpg" width=24 height=23> </DIV>
      <DIV style="CURSOR: pointer" onMouseUp="setstar(5,'quality',0)" class=pl_11_xx onMouseOver="setdesc(5,'quality')"><IMG src="<?=TPLURL?>/images/i_396.jpg" width=24 height=23> </DIV>
    </TD>
    <TD height=30><SPAN id=quality_desc class=color_4></SPAN><INPUT  id=qualityScore name=qualityScore value=5 type=hidden> 
</TD></TR></TBODY></TABLE></DIV>
</DIV>
<DIV style="CLEAR: both">
</DIV>
</DIV>
<DIV class=n_shang_3_4_101 name="comment">
<TABLE id=pmenu1 cellSpacing=0 cellPadding=0 width=648>
  <TBODY>
  <TR>
    <TD>
      <DIV class=t_p_b>&nbsp;&nbsp;&nbsp;&nbsp;把您在【<?=$mall['title']?>】的购物经历写下来，请具体指出【<?=$mall['title']?>】做的好或不好之处，您真实的体会将给大家带来十分有价值的参考。<?=WEBNAME?>感谢您的积极参与！</DIV></TD></TR>
  <TR>
    <TD><TEXTAREA style="WIDTH: 680px" id=comment class=input_53 name=comment></TEXTAREA></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=680>
  <TBODY>
  <TR>
    <TD height=80 align=center><INPUT class=button_36 <?php if($dduser['name']==''){?> onclick="alert('登陆后才能评论！');window.location='<?=u('user','login')?>&url='+encodeURIComponent(window.location.href)" <?php }else{?>onclick="saveComment()"<?php }?> name=Submit2 value="评 论" type=submit></TD></TR></TBODY></TABLE></DIV></DIV>
</div>
<?php }elseif($do=='huodong'){?>
<div class="cx2_js">

<?php include(TPLPATH.'/huodong/huodong.tpl.php');?>    
        </div>
<?php }elseif($do=='goods'){?>
<?php if($total>0){?>
<div class="cx2_js">
<?php include(TPLPATH."/mall/goods2.tpl.php");?> 
</div>
<?php }else{?>
<p style=" width:150px; text-align:center; margin:auto; margin-top:20px; color:#F00; font-size:16px"><b>暂无数据</b></p>
<?php }?>
<?php }?>

<div class="cleandd"></div>

</div>

</div>
<!--购物返现结束-->
<div class="furight">
<?php include(TPLPATH.'/mall/right.tpl.php');?>
<?=AD(6)?>
</div>

<div class="cleandd"></div>

</div>
</div>
<script>
qualityDwsc = new Array();
qualityDwsc[1] = '别跟我提<?=$mall['title']?>，谁提我跟谁急';
qualityDwsc[2] = '有那么一点小失望';
qualityDwsc[3] = '还行吧，没什么值得说的';
qualityDwsc[4] = '不错不错，不错不错';
qualityDwsc[5] = '这地方太好了，下次一准还在这里买';
function setstar(val, o, flag) {
    var x = document.getElementById(o);
    x.innerHTML = "";
    var i = 1;
    if (val < 3) {
        for (; i <= val; i++) {
            x.innerHTML = x.innerHTML + ('<div class="pl_11_xx" style="cursor:pointer" onmouseover="setdesc(' + i + ',\'' + o + '\',1)" onmouseup="setstar(' + i + ',\'' + o + '\',1)" ><img src="<?=TPLURL?>/images/i_395.jpg" width="24" height="23" /></div>');
        }
    } 
	else {
        for (; i <= val; i++) {
            x.innerHTML = x.innerHTML + ('<div class="pl_11_xx" style="cursor:pointer" onmouseover="setdesc(' + i + ',\'' + o + '\',1)" onmouseup="setstar(' + i + ',\'' + o + '\',1)" ><img src="<?=TPLURL?>/images/i_394.jpg" width="24" height="23" /></div>');
        }
    }
    for (var j = i; j <= 5; j++) {
        var html = x.innerHTML;
        x.innerHTML = x.innerHTML + ('<div class="pl_11_xx" style="cursor:pointer" onmouseover="setdesc(' + j + ',\'' + o + '\',1)"  onmouseup="setstar(' + j + ',\'' + o + '\',1)"><img src="<?=TPLURL?>/images/i_396.jpg" width="24" height="23" /></div>');
    }
    $('#qualityScore').val(val);
}
function setdesc(val, o) {
    $('#' + o + '_desc').html(qualityDwsc[val]);
}

function saveComment(){
    var fen=parseInt($('#qualityScore').val());
	var comment=$('#comment').val();
	var mallId=<?=$id?>;
	htmlFen='';
	$.ajax({
		url: '<?=u('ajax','mall_comment')?>',
		data:{'mall_id':mallId,'fen':fen,'comment':comment},
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){//alert(data);
			if(data.s==0){
			    alert(errorArr[data.id]);
				if(data.id==33){
				    helpWindows('两次评论间隔要大于<?=$webset['comment_interval']/3600?>小时','<?=$webset['webnick']?>小助手');
				}
			}
			else if(data.s==1){
				alert('评论成功');
			    location.replace(location.href);
			}
		}
	});
}
</script>
<?php include(TPLPATH."/footer.tpl.php");?>