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
$code='zhidemai';
include(ADMINTPL.'/header.tpl.php');
?>
<form name="form1" action="" method="get">
<div style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
<div class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /> <a href="<?=u(MOD,'iframe',array('a'=>'add','code'=>$code))?>" class="link3">[添加爆料]</a> <a href="<?=u(MOD,'iframe',array('a'=>'index','type'=>'me','code'=>$code))?>" class="link3">[我的云库爆料]</a> <a href="<?=u(MOD,'iframe',array('a'=>'index','type'=>'yun','code'=>$code))?>" class="link3">[云库爆料]</a> <a href="<?=u(MOD,'set')?>" class="link3">[奖励设置]</a></div>
<div>&nbsp;主标题：<input type="text" name="title" value="<?=$title?>" />&nbsp;报料人：<input type="text" name="ddusername" style="width:80px" value="<?=$ddusername?>" />&nbsp;<?=select($cid_arr,$cid,'cid')?><input type="submit" value="筛选" /> 共有 <b><?php echo $total;?></b> 条记录</div>
</div>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
          <th width="40px" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th width="260px">主标题</th>
          <th width="60px">副标题</th>
          <th width="50px">图片</th>
          <th width="50px">顶</th>
		  <th width="50px">踩</th>
          <th width="50px">排序</th>
          <th width="50px">置顶</th>
          <th width="50px">评论</th>
          <th width="70px">分类</th>
          <th width="100px">爆料人</th>
          <th width="80px">审核人</th>
          <th width="150px">添加时间</th>
          <th width="">操作</th>
        </tr>
		<?php foreach ($zhidemai_data as $r){?>
	    <tr>
          <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
          <td><a href="<?=$r['url']?>" target="_blank" class="ddnowrap" style="width:250px; " title="<?=$r["title"]?>"><?=$r["title"]?></a></td>
          <td><span class="ddnowrap" style="width:50px" title="<?=$r["subtitle"]?>"><?=$r["subtitle"]?></span></td>
		  <td class="showpic" pic="<?=$r['img']?>">查看</td>
		  <td><?=$r["ding"]?></td>
          <td><?=$r["cai"]?></td>
          <td><?=$r["sort"]?></td>
          <td><?=$r["top"]?></td>
          <td><a href=""><?=$r["pinglun"]?></a></td>
          <td><?=$r["catname"]?></td>
          <td><?=$r["ddusername"]?></td>
          <td><?=$r["auditor"]?></td>
          <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
		  <td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
		</tr>
		<?php }?>
        </table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" /><input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$url_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>