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
<style>
ul{ list-style:none; padding:0px; margin:0px; margin-top:20px}
ul li{ margin-bottom:5px; font-size:14px}
</style>
<div style="width:100%; padding-left:20px">
<div style="width:420px; margin-top:20px; font-size:20px; font-weight:bold; color:#990000; ">多多返利系统专用木马查杀器 V1.0</div>
<form action="" method="get" >
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="<?=ACT?>" />
<div>
<ul>
<?php if($_GET['sub']!=''){?>
  <?php if(empty($record_arr )){echo '<b>当前所查文件夹无木马文件！</b>';}?>
  <?php foreach($record_arr as $row){?>
  <li><span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=str_replace(DDROOT,'',$row['filename'])?> &nbsp;&nbsp;检测关键字：<?=$row['danger']?> &nbsp;&nbsp;&nbsp;&nbsp; <a onclick='return confirm("确定要删除?")' href="<?=u('scan','do',array('del'=>1,'filename'=>$row['filename']))?>">删除</a> <a href="<?=u('scan','do',array('see'=>1,'filename'=>$row['filename']))?>">查看</a></li>
  <?php }?>
<?php }else{?>
  <li><input type="checkbox" onClick="checkAll(this,'dir[]')" /> 选择<span class="zhushi">（一次不要选择太多的文件夹，否则会因为文件过多而造成程序无法正常运行）</span></li>
  <?php foreach($filelists1 as $filename){?>
  <li><input type="checkbox" name="dir[]" value="<?=DDROOT.'/'.$filename?>" /><span style="font-size:12px;font-family:wingdings">1</span>&nbsp;<?=$filename?></li>
  <?php }?>
  <?php foreach($filelists2 as $filename){?>
  <li><input type="checkbox" name="dir[]" value="<?=DDROOT.'/'.$filename?>" /><span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=$filename?></li>
  <?php }?>
  <input type="submit" name="sub" value="提交" />
<?php }?>

</ul>
</div>
</form>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>