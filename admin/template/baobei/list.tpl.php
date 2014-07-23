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
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="500">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[站内列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
              <td width=""></td>
              <td width="700" align="right"><?=select($select_arr,$se,'se')?>：<input type="text" name="q" value="<?=$_GET['q']?>" />&nbsp;<?=select($cat,$cid,'cid')?>&nbsp;<input type="submit" value="搜索" />&nbsp;&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="">商品名</th>
                      <th width="8%">会员</th>
                      <th width="5%">分类</th>
                      <th width="5%">图片</th>
                      <th width="8%">商品id</th>
                      <th width="5%">价格</th>
                      <!--<th width="5%">佣金</th>-->
                      <th width="5%">红心</th>
                      <th width="5%">排序</th>
                      <th width="140px">添加时间</th>                     
                      <th width="5%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class="ddnowrap" style="width:250px; " title="<?=$r["title"]?>"><?=$r["title"]?></a></td>
						<td><?=$r["ddusername"]?></td>
                        <td><?=$cat[$r["cid"]]?></td>
                        <td class="showpic" pic="<?=$r["img"]?>">查看</td>
						<td><?=$r["tao_id"]?></td>
                        <td><?=$r["price"]?></td>
                        <!--<td><?=$r["commission"]?></td>-->
                        <td><?=$r["hart"]?></td>
                         <td class="input" field='sort' w='50' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]==DEFAULT_SORT?'——':$r["sort"]?></td>
                        <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">查看</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <?php }else{?>
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <?php }?>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>