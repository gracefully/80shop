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

if($code=='jiu'){
	$t='9.9包邮';
}
elseif($code=='shijiu'){
	$t='19.9包邮';
}
elseif($code=='tejia'){
	$t='特价促销';
}
elseif($code=='zhuanxiang'){
	$t='手机专享';
}

$top_nav_name=array(array('id'=>'a','name'=>$t));

include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	<?php if($reycle==1){?>
	var a=$('.autol span b').html();
	$('.autol span b').html(a+'回收站');
	<?php }?>
});
</script>

<form name="form1" action="" method="get">

<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="500" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'iframe',array('a'=>'add','code'=>$code))?>" class="link3">[添加商品]</a> <a href="<?=u(MOD,'iframe',array('a'=>'index','code'=>$code,'type'=>'me'))?>" class="link3">[我的云库商品]</a> <a href="<?=u(MOD,'iframe',array('a'=>'index','code'=>$code,'type'=>'yun'))?>" class="link3">[云库商品]</a> <?php if($reycle==1){?><a href="<?=u(MOD,ACT,array('code'=>$code))?>" class="link3">[站内列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('code'=>$code,'reycle'=>1))?>" class="link3">[回收站]</a><?php }?> <a href="<?=u(MOD,ACT,array('code'=>$code,'guoqi'=>1))?>" class="link3" onclick="return confirm('确认要删除到期数据？');">[删除到期数据]</a></td>
              <td width=""></td>
              <td width="700" align="right" class="bigtext">商品名：<input type="text" name="title" value="<?=$title?>" />&nbsp;<?php if($code!='zhuanxiang'){?><?=select($cid_arr,$cid,'cid')?><?php }?>&nbsp;<input type="submit" value="筛选" />&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>

      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      <input type="hidden" name="code" value="<?=$code?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px;">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
          <th width="40px" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th width="360px">商品名</th>
		  <?php if($code!='zhuanxiang'){?><th width="100px">分类</th><?php }?>
          <th width="50px">图片</th>
          <th width="50px">原价</th>
		  <th width="50px"><?php if($code!='zhuanxiang'){?>促销价<?php }else{?>专享价<?php }?></th>
          <th width="50px">排序</th>
          <th width="100px">掌柜</th>
          <th width="100px">审核人</th>
          <th width="150px">开始时间</th>
          <th width="">操作</th>
        </tr>
		<?php foreach ($zhidemai_data as $r){?>
	    <tr>
          <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
          <td><a href="<?=$r['url']?>" target="_blank" class="ddnowrap" style="width:350px; " title="<?=$r["title"]?>"><?=$r["title"]?></a></td>
		  <?php if($code!='zhuanxiang'){?><td><?=$r["catname"]?></td><? }?>
		  <td class="showpic" pic="<?=$r['img']?>_b.jpg">查看</td>
		  <td><?=$r["price"]?></td>
          <td><?php if($code!='zhuanxiang'){?><?=$r["discount_price"]?><?php }else{?><?=$r["shouji_price"]?><?php }?></td>
          <td class="input" field='sort' url='<?=u(MOD,ACT,array('update'=>'sort'))?>' w='40' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]?></td>
          <td><span class="ddnowrap" style="width:90px" title="<?=$r["nick"]?>"><?=$r["nick"]?></span></td>
          <td><?=$r["auditor"]?></td>
          
          <?php
			$yulan=0;
			$s='';
			if($r["starttime"]>SJ){
				$s='style="color:#090" title="未开始"';
				$yulan=1;
			}
			
			if($r["endtime"]>0 && $r["endtime"]<=SJ){
				$s='style="color:#F00" title="已到期"';
			}
			?>
          
          <td><span <?=$s?>><?=$r["starttime"]?></span></td>
		  <td><?php if($yulan==1){?><a target="_blank" href="<?=SITEURL.'/?mod=tao&act=view&id='.$r['id']?>" class=link4>预览</a> <?php }?><a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'code'=>$code))?>" class=link4>修改</a></td>
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
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>