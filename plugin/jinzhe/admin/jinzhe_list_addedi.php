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

	$table_name='plugin_jinzhe';
	$id=intval($_GET['id']);
	$msg='';
	$post=isset($_POST['post'])?$_POST['post']:'';
	if($post=='post'){
		$data=$_POST;
		$data['starttime']=strtotime($data['starttime']);
		$data['endtime']=strtotime($data['endtime']);
		
		unset($data['sub']);
		unset($data['post']);
		if($id){
			$duoduo->update($table_name,$data,'id='.$id);
			$msg='成功修改';
		}else{
			$duoduo->insert($table_name,$data);
			$msg='成功添加';
		}
	}
	
	if($id){
		$plugin_data=$duoduo->select($table_name,'*','id='.$id);
	}else{
		$plugin_data=array();
		$plugin_data['starttime']=time();
		$plugin_data['endtime']=time()+5*24*3600;
		$plugin_data['status']=1;
	}
	
	$plugin_data_class=$duoduo->select_all('plugin_jinzhe_class','*','1=1 order by sort asc,id desc');
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
    <td align="right">商品标题：</td>
    <td>&nbsp;<input name="title" type="text" value="<?=$plugin_data['title']?>" style="width:450px;"/></td>
  </tr>
  <tr>
    <td align="right">商品分类：</td>
    <td>&nbsp;<select name="cid">
			<? foreach($plugin_data_class as $val){ ?>
			<option value="<?=$val['id']?>"<? if($val['id']==$plugin_data['cid']){ echo 'selected="selected"';}?>><?=$val['title']?></option>
			<? }?>
		</select>
	</td>
  </tr>
  <tr>
    <td align="right">淘宝num_iid：</td>
    <td>&nbsp;<input name="iid" type="text" value="<?=$plugin_data['iid']?>" style="width:120px;" /></td>
  </tr>
  <tr>
    <td align="right">图片地址：</td>
    <td>&nbsp;<input name="pic_url" type="text" value="<?=$plugin_data['pic_url']?>" style="width:650px;" /></td>
  </tr>
  <tr>
    <td align="right">折扣价格：</td>
    <td>&nbsp;<input name="price" type="text" value="<?=$plugin_data['price']?>" style="width:70px;" /></td>
  </tr>
  <tr>
    <td align="right">商品原价：</td>
    <td>&nbsp;<input name="price_original" type="text" value="<?=$plugin_data['price_original']?>" style="width:70px;" /></td>
  </tr>
  <tr>
    <td align="right">返利比率：</td>
    <td>&nbsp;<input name="commission_rate" type="text" value="<?=$plugin_data['commission_rate']?>" style="width:45px;" />%</td>
  </tr>
  <tr>
    <td align="right">销量：</td>
    <td>&nbsp;<input name="volume" type="text" value="<?=$plugin_data['volume']?>" style="width:45px;" /></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" value="<?=$plugin_data['sort']?>" style="width:45px;" />  <em style="color:#FF0000;">备注：只能是数字，数字越小越排前面</em></td>
  </tr>
  <tr>
    <td align="right">包邮：</td>
    <td>&nbsp;<input name="baoyou" type="checkbox" value="1" <? if($plugin_data['baoyou']==1) { echo 'checked="checked"';}?> /></td>
  </tr>
  <tr>
    <td align="right">是否淘宝商城：</td>
    <td>&nbsp;<input name="shop_type" type="checkbox" value="1" <? if($plugin_data['shop_type']==1) { echo 'checked="checked"';}?> /></td>
  </tr>


  <tr>
    <td align="right">开始时间：</td>
    <td>&nbsp;<input name="starttime" type="text" value="<?=date('Y-m-d H:i:s',$plugin_data['starttime'])?>" style="width:180px;" /></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>&nbsp;<input name="endtime" type="text" value="<?=date('Y-m-d H:i:s',$plugin_data['endtime'])?>" style="width:180px;" /></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<label><input name="status" type="checkbox" value="0" <? if($plugin_data['status']==0) { echo 'checked="checked"';}?> />下架商品</label></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="post" value="post" /><input type="submit" class="sub" name="sub" value=" 保 存 " /><span style="margin-left:12px; color:red;"><?=$msg?></span></td>
  </tr>
</table>
</form>