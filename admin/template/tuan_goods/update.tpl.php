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
<div style="float:left; width:340px; margin-left:30px">
                  <form id="form1" name="form1" method="post" action="<?=u(MOD,ACT)?>" style="position:relative;top:5px">
                  <div style="float:left">
                  <select name="mallid[]" multiple style="height:300px">
                    <?php foreach($malls as $key=>$val){?>
                    <option value="<?=$key?>"><?=$val?></option>
                    <?php }?>
                      </select>
                  </div>
                  <div style="float:left;margin-left:10px">
                  <div style=" height:250px; font-weight:bold; color:#F00; font-size:14px; width:150px; line-height:25px">注意：美团，拉手带有城市api的网站，需要在保存商城后，修改网站，点击生成城市缓存，否则无法采集！</div>
                  <div><input type="submit" value="采集提交" name="sub" /></div>
                  </div>
                    
                  </form>
                  <div style="clear:both; height:10px">&nbsp;</div>
                  <div>按住ctrl或者shift可多选</div>
                  </div>
                  <div style="float:left">
                  <form id="form1" name="form1" method="post" action="<?=u(MOD,ACT)?>" style="position:relative;top:5px">
                  <div style="float:left">
                  <select name="mallid[]" multiple style="height:300px">
                    <?php foreach($malls as $key=>$val){?>
                    <option value="<?=$key?>"><?=$val?></option>
                    <?php }?>
                      </select>
                  </div>
                  <div style="float:left;margin-left:10px">
                  <div style=" height:250px; font-weight:bold; color:#F00; font-size:14px; width:150px; line-height:25px">选中商城，删除此商城的团购商品。</div>
                  <div><input type="hidden" name="del" value="1" /><input type="submit" value="删除提交" name="sub" /></div>
                  </div>
                    
                  </form>
                  <div style="clear:both; height:10px">&nbsp;</div>
                  <div>按住ctrl或者shift可多选</div>
                  </div>
<?php include(ADMINTPL.'/footer.tpl.php');?>