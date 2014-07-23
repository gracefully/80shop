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

include(ADMINROOT.'/mod/public/part_set.act.php');
include(ADMINTPL.'/header.tpl.php');

if(!defined('TAOTYPE')){
	define(TAOTYPE,1);
}
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td align="right" width="115px">淘宝缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="taoapi[cache_time]" value="<?=$webset['taoapi']['cache_time']?>" />&nbsp;<span class="zhushi">单位(小时)，设为为0即为不缓存，目录为data/temp/taoapi。</span></td>
  </tr>
  <tr>
    <td align="right">淘宝缓存监控：</td>
    <td>&nbsp;<input style="width:30px"  name="taoapi[cache_monitor]" value="<?=$webset['taoapi']['cache_monitor']?>" />&nbsp;<span class="zhushi">单位(M)，设为为0即为不监控。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'tao'))?>','upload','450','350')" /></td>
  </tr>
<tr>
    <td align="right">拍拍缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="paipai[cache_time]" value="<?=$webset['paipai']['cache_time']?>" />&nbsp;<span class="zhushi">单位(小时)，设为为0即为不缓存，目录为data/temp/paipai。</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'paipai'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">亿起发缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="yiqifaapi[cache_time]" value="<?=$webset['yiqifaapi']['cache_time']?>" />&nbsp;<span class="zhushi">单位(小时)，设为为0即为不缓存，目录为data/temp/yiqifaapi。</span>   &nbsp;&nbsp;&nbsp;<input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'yiqifa'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">59秒缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="wujiumiaoapi[cache_time]" value="<?=$webset['wujiumiaoapi']['cache_time']?>" />&nbsp;<span class="zhushi">单位(小时)，设为为0即为不缓存，目录为data/temp/wujiumiaoapi。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'wujiumiao'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">综合比价缓存：</td>
    <td>&nbsp;<span class="zhushi">目录为data/temp/bijia。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'bijia'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">临时缓存：</td>
    <td>&nbsp;<span class="zhushi">目录为data/temp/session。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'linshi'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">网站缓存：</td>
    <td>&nbsp;<input type="button" value="更新缓存" onclick="javascript:openpic('<?=u('fun','cache')?>','upload','450','350')" /></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>z