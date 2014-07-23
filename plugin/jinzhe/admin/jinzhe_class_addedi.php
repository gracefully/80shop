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
	$id=intval($_GET['id']);
	$msg='';
	$post=isset($_POST['post'])?$_POST['post']:'';
	if($post=='post'){
		$data['title']=$_POST['title'];
		$data['sort']=intval($_POST['sort']);
		$data['bind_id']=intval($_POST['bind_id']);
		if($id){
			$duoduo->update($table_name,$data,'id='.$id);
			$msg='成功修改';
		}else{
			$duoduo->insert($table_name,$data);
			$msg='成功添加';
		}
	}
	
	if($id){
		$plugin_data=$duoduo->select($table_name,'id,title,sort,bind_id','id='.$id.'');
	}else{
		$plugin_data=array();
	}
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$do?>&plugin_id=<?=$plugin_id?>&id=<?=$id?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php
	if($id){
?>
  <tr>
    <td width="115px" align="right">id：</td>
    <td>&nbsp;<?=$plugin_data['id']?></td>
  </tr>
<? }?>
  <tr>
    <td align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" value="<?=$plugin_data['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">绑定采集分类：</td>
    <td>&nbsp;<select name="bind_id">
			<? foreach($_bind_cate_array as $key=>$val){?>
			<option value="<?=$key?>" <? if($key==$plugin_data['bind_id']){?>selected="selected"<? ;}?>><?=$val?></option>
			<? }?>
		</select>	
	</td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" value="<?=$plugin_data['sort']?>"/> <em style="color:#FF0000;">备注：只能是数字，数字越小越排前面</em></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="post" value="post" /><input type="submit" class="sub" name="sub" value=" 保 存 " /><span style="margin-left:12px; color:red;"><?=$msg?></span></td>
  </tr>
</table>
</form>