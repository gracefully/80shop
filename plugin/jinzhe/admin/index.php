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

/*if(isset($_POST['sub'])){
	//添加逻辑代码
	//jump(-1,'设置完成');
}*/
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$do?>&plugin_id=<?=$plugin_id?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <?php include(ADMINROOT.'/template/plugin/dd_set.tpl.php');?>
<!--  <tr>
    <td align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$plugin_data['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$plugin_data['img']?>" style="width:300px" /> <input type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> 可直接添加网络地址</td>
  </tr>
  <tr>
    <td align="right">高度：</td>
    <td>&nbsp;<input name="height" type="text" id="height" value="<?=$plugin_data['height']?>" size="5" /> px(单位：像素)</td>
  </tr>
  <tr>
    <td align="right">宽度：</td>
    <td>&nbsp;<input name="width" type="text" id="width" value="<?=$plugin_data['width']?>" size="5" /> px(单位：像素)</td>
  </tr>
  <tr>
    <td align="right">连接：</td>
    <td>&nbsp;<input name="link" type="text" id="link" value="<?=$plugin_data['link']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">说明：</td>
    <td>&nbsp;<input name="adtype" type="text" id="adtype" value="<?=$plugin_data['adtype']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">自定义代码：</td>
    <td><div style="float:left">&nbsp;<textarea name="content" id="content" cols="40" rows="5" style="width:700px; height:200px;"><?=$plugin_data['content']?></textarea></div>
    </td>
  </tr>-->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<input type="submit" name="sub" value=" 保 存 " /></td>
  </tr>
<!--  <tr>
    <td align="right">使用说明：</td>
    <td><ul>
    <li>1、标题作为图片广告的alt属性</li>
    <li>2、宽度和高度可以限制图片大小</li>
    <li>3、链接表示这个图片广告的链接</li>
    <li>4、说明在广告中不起到具体的作用,只是便于自己记忆广告位置</li>
    <li>5、自定义代码指的是，如果单纯的图片广告无法满足你的要求，可以自定义代码</li>
    <li>6、添加完成后，每个广告都会有一个调用代码，形如：&lt?=AD(1)?&gt;，其中的数字表示广告id</li>
    </ul></td>
  </tr>
--></table>
</form>