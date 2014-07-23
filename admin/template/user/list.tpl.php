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
              <td width="320px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<?php if($webset['taoapi']['auto_fanli']==1){?><a href="<?=u(MOD,ACT,array('trade_uid'=>1,'page'=>1))?>" class="link3">[提取淘宝订单会员id]</a> <a class="link3" href="<?=u('buy_log','list')?>">[淘宝浏览记录]</a><?php }?>&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[站内列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?>
               </td>
              <td width="" align="right">&nbsp;<?=select($select3_arr,$se3,'se3')?> <?=select($select1_arr,$se1,'se1')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($select2_arr,$se2,'se2')?>：<input type="text" style="width:30px" name="linput" value="<?=$linput?>" />-<input type="text" style="width:30px" name="hinput" value="<?=$hinput?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="4%">id</th>
                      <th width="35px">来源</th>
                      <th width="">用户名</th>
                      <th width="6%">推荐人ID</th>
                      <th width="120px">注册时间</th>
                      <th width="120px"><a href="<?=u(MOD,'list',array('lastlogintime'=>$listorder))?>">最近登录</a></th>
                      <th width="150px">邮箱</th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('loginnum'=>$listorder))?>">登录次数</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('level'=>$listorder))?>">等级</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('money'=>$listorder))?>">金额</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('jifenbao'=>$listorder))?>"><?=TBMONEY?></a></th>                     
                      <th width="5%"><a href="<?=u(MOD,'list',array('jifen'=>$listorder))?>">积分</a></th>
                      <th width="78px">QQ</th>
                      <th width="115px">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["id"]?></td>
                        <td title="注册来源"><?=$select3_arr[$r['platform']]?></td>
                        <td><?=$r["ddusername"]?></td>
						<td><?=$r["tjr"]?></td>
                        <td><?=date('Y-m-d H:i',strtotime($r["regtime"]))?></td>
                        <td><?=date('Y-m-d H:i',strtotime($r["lastlogintime"]))?></td>
                        <td><?=$r["email"]?></td>
                        <td><?=$r["loginnum"]?></td>
                        <td><?=$r["level"]?></td>
                        <td><?=$r["money"]?></td>
                        <td><?=jfb_data_type($r["jifenbao"])?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=qq($r["qq"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">查看</a>&nbsp;<a href="<?=u('mingxi','list',array('uname'=>$r['ddusername']))?>">明细</a>&nbsp;<a href="<?=u(MOD,'award',array('id'=>$r['id']))?>">奖励</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" id="act" value="del" />
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