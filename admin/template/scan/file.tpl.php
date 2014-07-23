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
<div class="explain-col">在线对比文件MD5校验码。&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=u('scan','file')?>">返回</a></div>
<div style="width:100%; padding-left:20px">
<div style="width:420px; margin-top:20px; font-size:20px; font-weight:bold; color:#990000; ">多多返利系统文件校对器 V1.0</div>
<form action="" method="get" >
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="<?=ACT?>" />
<div>
<ul>
<?php if($_GET['sub']!=''){?>
  <?php if(empty($record_arr )){echo '<b>当前所查文件夹文件没有变化！</b>';}?>
  <?php foreach($record_arr as $row){?>
  <li><span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=$row['path']?> &nbsp;&nbsp;<?=$row['msg']?></li>
  <?php }?>
<?php }else{?>
  <li><input type="checkbox" onClick="checkAll(this,'dir[]')" /> 选择<span class="zhushi">（选择您要校对的文件夹，不支持中文）</span></li>
  <?php foreach($filelists1 as $filename){?>
  <li><input type="checkbox" name="dir[]" value="<?=DDROOT.'/'.$filename?>" /><span style="font-size:12px;font-family:wingdings">1</span>&nbsp;<?=$filename?></li>
  <?php }?>
  <?php foreach($filelists2 as $filename){?>
  <li><input type="checkbox" name="dir[]" value="<?=DDROOT.'/'.$filename?>" /><span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=$filename?></li>
  <?php }?>
  <input type="submit" name="sub" id="sub" value="提交" /> 
  <?php if(get_domain()=='localhost'){?>
  <label><input type="checkbox" value="1" name="update" /> 更新文件记录</label>
  <?php }?>
<?php }?>

</ul>
</div>
</form>
</div>
<script>
<?php if($update==1 && get_domain()!='localhost'){?>
$('#sub').attr('disabled','disabled').after(' <span class="zhushi">当前版本对比文件不存在，可能是官方还有没此版本的文件信息</span>');
<?php }?>
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>