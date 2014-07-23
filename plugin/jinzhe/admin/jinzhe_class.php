<?php 
	/**
	 * ============================================================================
	 * 版权所有 2008-2012 多多科技，并保留所有权利。
	 * 网站地址: http://soft.duoduo123.com；
	 * ----------------------------------------------------------------------------
	 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
	 * 使用；不允许对程序代码以任何形式任何目的的再发布。
	 * ============================================================================
	*/
	
	if(!defined('ADMIN')){
		exit('Access Denied');
	}

	$_bind_cate_array=array(
		'10'=>'时尚女装',
		'1'=>'时尚男装',
		'2'=>'数码家电',
		'3'=>'箱包鞋靴',
		'4'=>'食品酒水',
		'5'=>'配饰百货',
		'6'=>'化妆护理',
		'7'=>'文娱体育',
		'8'=>'母婴玩具',
		'9'=>'生活周边'
	);

	$table_name='plugin_jinzhe_class';
	$where=' 1=1';
	$order=' order by sort asc,id desc';
	$total=$duoduo->count($table_name,$where);
	$plugin_data=$duoduo->select_all($table_name,'id,title,sort,bind_id',$where.$order);
?>
	<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
		<tr>
			<td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,ACT,array('do'=>'jinzhe_class_addedi','id'=>0,'plugin_id'=>$plugin_id))?>" class="link3">[新增]</a> </td>
			<td width="" align="right"></td>
			<td width="150px" align="right">共有 <b><?=$total?></b> 条记录&nbsp;&nbsp;</td>
		</tr>
	</table>
	<table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
		<tr>
			<td width="5%">id</td>
			<td width="">标题</td>
			<td width="">绑定采集分类</td>
			<td width="8%">排序 </td>
			<td width="10%">操作</td>
		</tr>
		<?php foreach ($plugin_data as $r){?>
		<tr>
			<td><?=$r["id"]?></td>
			<td><?=$r["title"]?></td>
			<td><?=$_bind_cate_array[$r["bind_id"]]?></td>
			<td><?=$r["sort"]?></td>
			<td>
				<a href="<?=u(MOD,ACT,array('do'=>'jinzhe_class_addedi','id'=>$r['id'],'plugin_id'=>$plugin_id))?>" class=link4>修改</a>&nbsp;&nbsp;
				<a href="<?=u(MOD,ACT,array('do'=>'jinzhe_class_del','id'=>$r['id'],'plugin_id'=>$plugin_id))?>" class=link4>删除</a>
			</td>
		</tr>
		<?php }?>
	</table>
