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
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="20%" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /> <a href="<?=u(MOD,'addedi')?>" class="link3">[添加店铺]</a> &nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[站内列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
              <td width="" align="right">掌柜或店铺名称：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="125px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="150px">掌柜名称</th>
                      <th width="" bgcolor="#F2F2F2" align=center class="bigtext">店铺名称</th>
                      <th width="140px">店铺等级 </th>
					  <th width="115px">商品数量</th>
                      <th width="7%">logo</th>
                      <th width="6%"><a href="<?=u(MOD,'list',array('sort'=>desc))?>">排序</a></th>
                      <th width="6%">推荐</th>
                      <th width="140px">采集时间</th>
                      <th width="8%">执行操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["nick"]?></td>
						<td><?=$r["title"]?></td>
						<td><img src="../images/level_<?=$r["level"]?>.gif" /></td>
                        <td><?=$r["auction_count"]?></td>
                        <td class="showpic" pic="<?=TAOLOGO?><?=$r['pic_path']?>">查看</td>
                         <td class="input" field='sort' w='50' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]==DEFAULT_SORT?'——':$r["sort"]?></td>
                        <td><?=$shifou_arr[$r["top"]]?></td>
                        <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>查看</a></td>
					  </tr>
					<?php }?>
                  </table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <?php }else{?>
            <div style="position:absolute; left:5px; top:10px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <?php }?>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>