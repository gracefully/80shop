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
      <td width="300px" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a <?php if($tiqu_mini==1){?>title="提取订单后才能导入订单"<?php }else{?>href="<?=u('tradelist',$_act)?>"<?php }?> class="link3">[<?=$_act_name?>]</a> <a href="<?=u(MOD,'addedi')?>" class="link3">[添加订单]</a> <?php if($tiqu_mini==1){?><a href="<?=u(MOD,ACT,array('mini'=>1,'page'=>1))?>" style="color:#F00; font-weight:bold" class="link3">[提取订单号]</a><?php }?>&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[站内列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?> </td>
      <td width="" align="right"><?=select($select_arr,$se,'se')?> <input type="text" name="q" value="<?=$q?>" />
        <?=select($checked_arr,$checked,'checked')?>
	<?php if(TAOTYPE==1){?>
        <?=select($_status_arr,$status,'status')?>
	<?php }else{?>
        <?=select($select2_arr,$se2,'se2')?>
    <?php }?>
        <input type="submit" value="搜索" /></td>
      <td width="125px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="mod" value="<?=MOD?>" />
  <input type="hidden" name="act" value="<?=ACT?>" />
</form>
<form name="form2" method="get" action="" style="margin:0px; padding:0px">
  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <tr>
      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
      <th width="115px">交易号</th>
      <?php if(TAOTYPE==2){?>
      <th width="38px">来源</th>
      <?php }?>
      <th width="">商品名称</th>
      <th width="4%">单价</th>
      <th width="4%">数量</th>
      <th width="5%">成交额</th>
      <th width="5%">比例</th>
      <th width="4%">佣金</th>
      <th width="5%"><?=TBMONEY?></th>
      <th width="4%">积分</th>
      <th width="<?=(TAOTYPE==1)?'70px':'130px'?>"><a href="<?=u(MOD,'list',array('pay_time'=>$listorder))?>">结算时间</a></th>
      <th width="6%">认领</th>
      <?php if(TAOTYPE==1){?>
      <th width="65px">状态</th>
      <th width="70px"><a href="<?=u(MOD,'list',array('create_time'=>$listorder))?>">下单时间</a></th>
      <?php }?>
      <th width="7%">会员</th>
      <th width="5%">操作</th>
    </tr>
    <?php foreach ($row as $r){?>
    <tr>
      <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
      <td><?=preg_replace('/_\d+/','',$r["trade_id"])?></td>
      <?php if(TAOTYPE==2){?>
      <td title="订单来源"><?=$select2_arr[$r['platform']]?></td>
      <?php }?>
      <td style="padding:0px 3px 0px 3px; text-align:left"><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class="ddnowrap" style="width:200px; " title="<?=$r["title"]?>"><?=$r["item_title"]?></a></td>
      <td><?=$r["pay_price"]?></td>
      <td><?=$r["item_num"]?></td>
      <td><?=$r["real_pay_fee"]>0?$r["real_pay_fee"]:'--'?></td>
      <td <?php if($r["commission_rate"] >= 0.25){ echo 'style="color:red;"';}?>><?=$r["commission_rate"]*100?>%</td>
      <td><?=$r["commission"]>0?$r["commission"]:'--'?></td>
      <td><?=jfb_data_type($r["jifenbao"])>0?jfb_data_type($r["jifenbao"]):'--'?></td>
      <td><?=$r["jifen"]>0?$r["jifen"]:'--'?></td>
      <td><?=(TAOTYPE==1)?$r["pay_time"]?date('Y-m-d',strtotime($r["pay_time"])):'--':$r["pay_time"]?></td>
      <td><?=$checked_arr[$r["checked"]]?></td>
      <?php if(TAOTYPE==1){?>
      <td><?=$status_arr[$r["status"]]?></td>
      <td><?=$r["create_time"]?date('Y-m-d',strtotime($r["create_time"])):'--'?></td>
      <?php }?>
      <td><a href="<?=u('mingxi','list',array('uname'=>$r["uname"]))?>">
        <?=$r["uname"]?>
        </a></td>
      <td>
	  <?php if(TAOTYPE==1){?>
	    <?php if($r["checked"]==1){?>
        <a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>审核</a>
        <?php }else{?>
        <a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>
        <?php if($r["checked"]==2){?>
        退款
        <?php }elseif($r["checked"]==3){?>
        结算
        <?php }elseif($r["checked"]==1){?>
        审核
        <?php }elseif($r["checked"]==0){?>
        返现
        <?php }elseif($r["checked"]==-1){?>
        查看
        <?php }?>
        </a>
        <?php }?>
      <?php }elseif(TAOTYPE==2){?>
        <a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>
        <?php if($r["checked"]==2){?>
        退款
        <?php }elseif($r["checked"]==1){?>
        审核
        <?php }elseif($r["checked"]==0){?>
        返现
        <?php }elseif($r["checked"]==-1){?>
        查看
        <?php }?>
        </a>
      <?php }?>
      </td>
    </tr>
    <?php }?>
  </table>
  <div style="position:relative; padding-bottom:10px">
    <input type="hidden" name="mod" value="<?=MOD?>" />
    <input type="hidden" name="act" value="del" />
    <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <?php }else{?>
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <?php }?>
    <div class="megas512" style=" margin-top:15px;">
      <?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?>
    </div>
  </div>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>