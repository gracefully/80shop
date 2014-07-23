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
              <td width="50px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /></td>
              <td width="" align="right"><?=select($select1_arr,$se1,'se1')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($select2_arr,$se2,'se2')?>：<input type="text" style="width:30px" name="linput" value="<?=$linput?>" />-<input type="text" style="width:30px" name="hinput" value="<?=$hinput?>" />&nbsp;<input type="submit" value="搜索" /></td>
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
                      <th width="">用户名</th>
                      <th width="6%">推荐人ID</th>
                      <th width="140px">注册时间</th>
                      <th width="150px">手机号码</th>
                      <th width="140px"><a href="<?=u(MOD,'list',array('lastlogintime'=>$listorder))?>">最近登录</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('loginnum'=>$listorder))?>">登录次数</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('level'=>$listorder))?>">等级</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('money'=>$listorder))?>">金额</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('jifenbao'=>$listorder))?>"><?=TBMONEY?></a></th>                     
                      <th width="5%"><a href="<?=u(MOD,'list',array('jifen'=>$listorder))?>">积分</a></th>
                      <th width="9%">QQ</th>
                      <th width="115px">操作</th>
                    </tr>
                    <?php if(empty($row)){?>
                    <tr><td colspan="100" style="height:50px; line-height:50px; color:#000; text-align:left; padding-left:50px">
                    您还没有设置群发条件：
                    <?php foreach($qunfa_arr as $k=>$v){?>
                    <a href="<?=u(MOD,'qunfa_set',array('do'=>$k))?>"><?=$v?>群发设置</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php }?>
                    </td></tr>
                    <?php }?>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["id"]?></td>
                        <td><?=$r["ddusername"]?></td>
						<td><?=$r["tjr"]?></td>
                        <td><?=$r["regtime"]?></td>
                        <td><?=$r["mobile"]?></td>
						<td><?=$r["lastlogintime"]?></td>
                        <td><?=$r["loginnum"]?></td>
                        <td><?=$r["level"]?></td>
                        <td><?=$r["money"]?></td>
                        <td><?=jfb_data_type($r["jifenbao"])?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=qq($r["qq"])?></td>
						<td><a href="<?=u('user','addedi',array('id'=>$r['id']))?>">查看</a>&nbsp;<a href="<?=u('mingxi','list',array('uname'=>$r['ddusername']))?>">明细</a><?php if($r['msg']!=''){?>&nbsp;<a title="<?=$r['msg']?>">说明</a><?php }?></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" id="act" value="del" />
            <div style=" margin-top:15px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="sub" value="群发" onclick='var a=confirm("确定要群发?");if(a==true){$("#act").val("qunfa");return true}else{return false;}'/>&nbsp; <?=html_radio($qunfa_arr,$do,'do')?></div>
            <div class="megas512" style=" margin-top:10px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>