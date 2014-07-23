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
<form name="form1" action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$do?>&plugin_id=<?=$plugin_id?>" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
<?php include(ADMINTPL.'/gametask/header.php');?>
        <tr>
              <td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp; </td>
              <td width="" align="right"></td>
              <td width="150px" align="right">共有 <b><?=$total?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      <input type="hidden" name="do" value="<?=$do?>" />
      <input type="hidden" name="plugin_id" value="<?=$plugin_id?>" />
      </form>
      <form name="form2" method="get" action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$do?>&plugin_id=<?=$plugin_id?>" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="12%">时间</th>
                      <th width="10%">收入金额</th>
                      <th width="10%">预代扣税款</th>
                      <th width="10%">剩余金额</th>
                      <th width="10%">状态</th>
                      <th width="">原因</th>        
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><?=date("Y-m-d H:i:s",$r["addtime"])?></td>
                        <td ><?=(float)$r["money"]?>元</td>
                        <td ><?=(float)$r["dues"]?>元</td>
                        <td ><?=(float)$r["now_money"]?>元</td>
                        <td  <?php if($r["status"]==1){?> style="color:#00F" <?php }elseif($r["status"]==2){?> style="color:#F00"<?php }?> ><?=$type[$r["status"]]?> </td>
						<td><?=$r["content"]?></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
          <input type="hidden" name="mod" value="<?=MOD?>" />
          <input type="hidden" name="act" value="<?=ACT?>" />
            <div class="megas512" style=" margin-top:5px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr))?></div>
            <br />
            <div style="color:#F00">注意：每月5-10日自动结算上上个月且大于10元的佣金，请设置正确的支付宝。</div>
            </div>
       </form>
       <?php include(ADMINTPL.'/footer.tpl.php')?>