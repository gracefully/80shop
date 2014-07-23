<?php 
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

if(isset($_POST['sub'])){
	//添加逻辑代码
	jump(-1,'设置完成');
}
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$do?>&plugin_id=<?=$plugin_id?>" method="post" name="form1">
	<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
		<?php include(ADMINROOT.'/template/plugin/dd_set.tpl.php');?>
		<tr>
			<td align="right">微信账号：</td>
			<td>&nbsp;
				<input style="width:110px;" type="text" name="user" value="<?=$plugin_data["user"]?>" />
				&nbsp;&nbsp;请填写微信账号
		</tr>
		<tr>
			<td align="right">二维码图片：</td>
			<td>&nbsp;
				<input style="width:300px;" type="text" id="img" name="img" value="<?=$plugin_data["img"]?>" />
				<input class="sub" type="button" value="上传二维码图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" />
				&nbsp;&nbsp;二维码图片，图片大小245*245
			</td>
		</tr>
		<tr>
			<td align="right">头部LOGO：</td>
			<td>&nbsp;
				<input type="text" name="logo" id="logo" value="<?=$plugin_data["logo"]?>" style="width:300px" /> 
				<input class="sub" type="button" value="上传logo" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'logo','sid'=>session_id()))?>','upload','450','350')" />
				&nbsp;&nbsp;左上角网站logo，大小136*55
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;
				<input type="submit" name="sub" value=" 保 存 " /></td>
		</tr>
	</table>
</form>
