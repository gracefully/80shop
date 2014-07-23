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
$top_nav_name=array(array('url'=>u('mall','list'),'name'=>'知名商城'),array('url'=>u('huodong','list'),'name'=>'商城活动'));
include(ADMINTPL.'/header.tpl.php');
?>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增活动]</a> </td>
              <td width="" align="right">名称：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($malls,$mall_id,'mall_id')?>&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="5%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
					  <th width="">名称</th>
                      <th width="115px">商城</th>
                      <th width="8%">图片</th>
                      <th width="140px">开始时间</th>
                      <th width="140px"><a href="<?=u(MOD,'list',array('edate'=>$listorder))?>">结束时间</a></th>
                      <th width="5%">排序</th>
                      <th width="150px">添加时间</th>
                      <th width="6%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["title"]?></td>
						<td><?=$malls[$r["mall_id"]]?></td>
                        <td class="showpic" pic="<?=$r["img"]?>">查看</td>
                        <td><?=date('Y-m-d',$r["sdate"])?></td>
                        <td><?=date('Y-m-d',$r["edate"])?></td>
                        <td class="input" field='sort' w='50' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]==DEFAULT_SORT?'——':$r["sort"]?></td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'mall_id'=>$mall_id,'edate'=>$_GET['edate'])));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>