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
include(ADMINROOT.'/mod/public/set.act.php');
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
    $('input[name="yinxiangma[open]"]').click(function(){
        if($(this).val()==1){
		    $('.yinxiangmakey').show();
		}
		else if($(this).val()==0){
		    $('.yinxiangmakey').hide();
		}
	});
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
   <?php foreach($webset['level'] as $k=>$v){?>
    <input name="level_dengji[]" type="hidden"  value="<?=$k?>"  />
    <?php }?>
      <td align="right" width="120">淘宝返现比率：</td>
    <td>&nbsp;
      <?php
      $level_c=count($webset['fxbl']);
      if($level_c<WEB_USER_LEVEL){
          for($i=0;$i<WEB_USER_LEVEL-$level_c;$i++){
              $web_fxbl_level[$i]=0.5;
          }
          $webset['fxbl']=$web_fxbl_level+$webset['fxbl'];
      }
      ?>
    <?php foreach($webset['fxbl'] as $k=>$v){?>
    <?=$webset['level'][$k]?><input name="fxbl[]" type="text" id="fxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
    <?php }?>
    <span class="zhushi"><a href="http://bbs.duoduo123.com/read.php?tid=4417" target="_blank" >什么是会员等级？</a></span></td>
    </tr>
    <tr>
      <td align="right">商城返现比率：</td>
    <td>&nbsp;
      <?php
      $level_c=count($webset['mallfxbl']);
      if($level_c<WEB_USER_LEVEL){
          for($i=0;$i<WEB_USER_LEVEL-$level_c;$i++){
              $web_mallfxbl_level[$i]=0.5;
          }
          $webset['mallfxbl']=$web_mallfxbl_level+$webset['mallfxbl'];
      }
      ?>
    <?php foreach($webset['mallfxbl'] as $k=>$v){?>
    <?=$webset['level'][$k]?$webset['level'][$k]:'普通会员'?><input name="mallfxbl[]" type="text" id="mallfxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
    <?php }?>
    </td>
    </tr>
    <tr>
      <td align="right">拍拍返现比率：</td>
    <td>&nbsp;
      <?php
      $level_c=count($webset['paipaifxbl']);
      if($level_c<WEB_USER_LEVEL){
          for($i=0;$i<WEB_USER_LEVEL-$level_c;$i++){
              $web_paipaifxbl_level[$i]=0.5;
          }
          $webset['paipaifxbl']=$web_paipaifxbl_level+$webset['paipaifxbl'];
      }
      ?>
    <?php foreach($webset['paipaifxbl'] as $k=>$v){?>
    <?=$webset['level'][$k]?$webset['level'][$k]:'普通会员'?><input name="paipaifxbl[]" type="text" id="paipaifxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
    <?php }?>
    </td>
    </tr>
    <tr>
      <td align="right">返积分比例：</td>
      <td>&nbsp;<input name="jifenbl" type="text" id="jifenbl" value="<?php echo $webset['jifenbl']*100;?>"  class="required" num="y" style="width:50px" />% <span class="zhushi">返利同时赠送一定比例的积分，按照实际给会员的返利计算，取整。例如比例为1000%，返利0.1元，积分就是1</span></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
<td>&nbsp;
        <input type="submit" class="myself" name="sub" value=" 保 存 设 置 " /> 
        </td>
    </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>