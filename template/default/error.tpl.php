<?php
if($type==1){
	if(TAOTYPE==2){
		$ddTaoapi = new ddTaoapi;
		$ddTaoapi->dduser=$dduser;
		$ddTaoapi->webset=$webset;
		$ddTaoapi->nowords=$no_words;

		$Tapparams['keyword']=$webset['hotword'][1]; //关键字或栏目ID必填一项
    	$Tapparams['page_size']=5;
    	$tao_goods=$ddTaoapi->taobao_tbk_items_get($Tapparams);
	}
	else{
		if(MOD=='tao'){
			global $dd_tao_class;
			$tao_goods=$dd_tao_class->dd_tao_goods(array('num'=>5,'frmnum'=>5));
		}
	}
}
$css[]=TPLURL."/css/error.css";
include(TPLPATH.'/header.tpl.php');
include(DDROOT.'/comm/tdj_tpl.php');
?>
<div class="mainbody">
<div class="mainbody1000"> 
<DIV class="wrap link biaozhun5" style="margin:5px auto;  background:#FFF;min-height:200px; padding-bottom:50px">
<div class="aaa">
<div class="regIgnore" style="margin-top:50px">
<p class="f14 mb10" style="color:#F00"><?=$error_msg?></p><p class="f14">
<?php if($goto==-1){?>
<a onClick="history.go(-1);" class="s4 cp" tabindex="20" id="showback"><u>返回前一页</u></a>
<?php }elseif($goto==0){?>
<a onClick="window.location.reload();" class="s4 cp" tabindex="20" id="showback"><u>刷新当前页面</u></a>
<?php }elseif(is_numeric($goto) && $goto>0){?>
页面关闭（<b id="daojishi" style="color:red"><?=$goto?></b>秒）
<script>
function CloseWin(){ 
	window.opener=null; window.open('','_self'); window.close(); 
}
time=<?=$goto?>;
function timing(){
    time=time-1;
	$('#daojishi').text(time);
	if(time==0){
		CloseWin();
		clearInterval(startTiming);
	}
}

startTiming=setInterval("timing()", 1000);
</script>
<?php }?>
，或者 <a id="showindex" onClick="window.location='<?=SITEURL?>'" tabindex="20" class="s4 cp"><u>返回首页</u></a></p>
								</div>
<?php if($type==1 && is_array($tao_goods)){?>
<div class="tuijian">
<div style="font-size:14px; padding-left:20px; color:#F60; font-weight:bold; text-align:left; padding-top:15px; padding-bottom:10px">今日推荐</div>
<table border="0">
  <tr>
  <?php foreach($tao_goods as $row){?>
      <td>
    <div class="timg"><a href="<?=$row['gourl']?>" target="_blank"><?=html_img($row['pic_url'],2,$row['name'])?></a></div>
    <div class="ttitle"><a  style="font-family:宋体; line-height:15px" href="<?=$row['gourl']?>" target="_blank"><?=$row['title']?></a></div>
    <div class="tfan">原价：<b><?=$row['price']?></b> 元</div>
    <?php if($row['fxje']>0){?>
    <div class="tprice">返：<b><?=$row['fxje']?></b> <?=TBMONEY?></div>
    <?php }?>
    </td>
      <?php }?>
    </tr>
</table>
 
</div>
<?php }?>
</div>
</DIV>
</div>
</div>
<?php
include(TPLPATH.'/footer.tpl.php');
?>