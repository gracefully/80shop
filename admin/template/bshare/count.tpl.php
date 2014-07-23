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

if(!defined('ADMIN')){
	exit('Access Denied');
}

include(ADMINTPL.'/header.tpl.php');
?>
<?php
if($webset['bshare']['uuid']=='' || $webset['bshare']['secretKey']==''){
    jump(u(MOD,'set'),'先联通bshare');
}
else{
    $time=  time().'000';	
	$md= md5('ts='.time().'000uuid='.$webset['bshare']['uuid'].$webset['bshare']['secretKey']);
	$bshare_count_iframe='http://www.bshare.cn/publisherStatisticsEmbed?uuid='.$webset['bshare']['uuid'].'&ts='.$time.'&sig='.$md;
}
?>
<div class="explain-col">请您注册或登录bShare，以便享用bShare强大的数据统计功能！ <a href="<?=u(MOD,'set',array('do'=>'set'))?>">填写账号</a> <a href="<?=u(MOD,'code')?>">设置代码</a> <a href="<?=u(MOD,'count')?>">查看统计</a> <a href="http://www.bshare.cn" target="_blank">官网</a>
  </div>
<br />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<tr><td>
<div id="data_div" class="contentList">
			<div id="dataModule" class="module" style="width: 855px;">
				<iframe id="bif" style="width: 823px; height: 2690px;" scrolling="no" frameborder="0" name="bshare" src="<?=$bshare_count_iframe?>"></iframe>
			</div>
			<p style="margin-left:20px;">
				在安装或使用中，如有任何问题需要<a class="text-orange" href="http://www.bshare.cn/help/installCms" target="_blank">帮助与咨询</a>，欢迎随时联系<a class="text-orange" href="http://wpa.qq.com/msgrd?v=3&uin=800087176&site=qq&menu=yes" target="_blank">bShare客服QQ</a>：800087176 或来信到<a class="text-orange" href="mailto:feedback@bshare.cn" target="_blank">feedback@bshare.cn.</a>
			</p>
		</div>
</td></tr>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>