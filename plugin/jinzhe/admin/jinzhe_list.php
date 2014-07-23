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
	
	$get['search_type']=isset($_GET['search_type'])?trim($_GET['search_type']):'';
	$get['search_keywords']=isset($_GET['search_keywords'])?trim($_GET['search_keywords']):'';
	$get['search_status']=isset($_GET['search_status'])?trim($_GET['search_status']):'0';

	$table_name='plugin_jinzhe';
	
	if(isset($_GET['del_all']) && $_GET['del_all']=='del_all'){
		$duoduo->delete($table_name,'(status!=1 or endtime<'.time().')');
	}
	
	if(isset($_POST['pldel']) && $_POST['pldel']){
		$pldel_type=isset($_POST['pldel_type'])?$_POST['pldel_type']:'';		
		$ids_array=isset($_POST['ids'])?$_POST['ids']:array();
		$ids_array_count=count($ids_array);
		$ids='';
		if($ids_array_count>0){
			$ids.='(';
			for($i=0;$i<$ids_array_count;$i++){
				if($i!=$ids_array_count-1){
					$ids.=$ids_array[$i].',';
				}else{
					$ids.=$ids_array[$i];
				}
			}
			$ids.=')';
		}
		if($ids){
			switch($pldel_type){
				case 'xiajia':
					$data['status']=0;
					$data['addtime']=time();
					$duoduo->update($table_name,$data,'id in '.$ids,'');
					break;
				case 'chongxinshangjia':
					$data['status']=1;
					$duoduo->update($table_name,$data,'id in '.$ids,'');
					break;
				case 'shanchu':
					$duoduo->delete($table_name,'id in '.$ids);
					break;
			}
		}		
	}

	
	
	$where=' 1=1';	
	
	if(!empty($get['search_keywords'])){
		switch($get['search_type']){
			case 'id':
				$where.=' and id='.intval($get['search_keywords']);
				break;
			case 'iid':
				$where.=' and iid like \'%'.trim($get['search_keywords']).'%\'';
				break;
			case 'title':
				$where.=' and title like \'%'.trim($get['search_keywords']).'%\'';
				break;
		}
	}
	
	if($get['search_status']==1){
		$where.=' and status=1 and endtime>='.time().'';
	}else if($get['search_status']==2){
		$where.=' and (status!=1 or endtime<'.time().')';
	}
	
	$order=' order by sort asc,id desc';
	$page=isset($_GET['page'])?intval($_GET['page']):1;
	$pagesize=30;
	$limit=' limit '.($page-1)*$pagesize.',30';
	$total=$duoduo->count($table_name,$where);
	$plugin_data=$duoduo->select_all($table_name,'*',$where.$order.$limit);
?>
	<form name="form1" action="" method="get">
		<table cellspacing="0" width="100%" style="border:1px solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
			<tr>
				<td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,ACT,array('do'=>'jinzhe_list_addedi','id'=>0,'plugin_id'=>$plugin_id))?>" class="link3" target="_blank">[新增]</a> </td>
				<td width="" align="right">
					搜索：
					<select name="search_type">
						<option value="id"<? if($get['search_type']=='id'){ echo ' selected="selected"';}?>>id</option>
						<option value="iid"<? if($get['search_type']=='iid'){ echo ' selected="selected"';}?>>num_iid</option>
						<option value="title"<? if($get['search_type']=='title'){ echo ' selected="selected"';}?>>标题</option>
					</select>
					
					<input name="mod" type="hidden" value="<?=MOD;?>" />
					<input name="act" type="hidden" value="<?=ACT;?>" />
					<input name="do" type="hidden" value="<?=$do;?>" />
					<input name="plugin_id" type="hidden" value="<?=$plugin_id;?>" />
					<input type="text" name="search_keywords" value="<?=$get['search_keywords']?>" />&nbsp;
					
					<select name="search_status">
						<option value="0"<? if($get['search_status']==0){ echo ' selected="selected"';}?>>无视上下架</option>
						<option value="1"<? if($get['search_status']==1){ echo ' selected="selected"';}?>>上架中</option>
						<option value="2"<? if($get['search_status']==2){ echo ' selected="selected"';}?>>下架了</option>
					</select>

					&nbsp;<input type="submit" value="搜索" />
				</td>
				<td width="260px" align="right">
					共有 <b><?=$total?></b> 条记录&nbsp;&nbsp;
					<a href="<?=u(MOD,ACT,array('do'=>$do,'del_all'=>'del_all','plugin_id'=>$plugin_id))?>" onclick="javascript:return confirm('确定要删除所有已下架商品吗？');">点击删除所有已下架商品</a>				
				</td>
			</tr>
		</table>
    </form>
    <form name="form2" method="post" action="<?=u(MOD,ACT,array('do'=>$do,'plugin_id'=>$plugin_id,'page'=>$page,'search_type'=>$get['search_type'],'search_keywords'=>$get['search_keywords']))?>" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <td width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></td>
                      <td width="8%">图片</td>
                      <td width="4%">id</td>
					  <td width="8%">num_iid</td>
                      <td width="">标题</td>
                      <td width="9%">价格</td>
                      <td width="4%">销量</td>
                      <td width="4%">排序</td>
                      <td width="7%">开始时间</td>
                      <td width="7%">结束时间</td>
                      <td width="5%">状态</td>
                      <td width="4%">操作</td>
                    </tr>
					<?php foreach ($plugin_data as $val){
						if($val['shop_type']==1){
							$url='http://detail.tmall.com/item.htm?id='.$val['iid'];
						}else{
							$url='http://item.taobao.com/item.htm?id='.$val['iid'];
						}
					?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$val["id"]?>' id='content_<?=$val["id"]?>' /></td>
						<td style="padding:8px;"><a href="<?=$url?>" target="_blank"><img src="<?=$val['pic_url']?>" width="75" height="75" /></a></td>
                        <td><?=$val["id"]?></td>
						<td><?=$val["iid"]?></td>
						<td style="padding:4px;"><a href="<?=$url?>" target="_blank"><?=$val["title"]?></a></td>
						<td style="padding:4px;">
							<em style="color:#111111;text-decoration:line-through;"><?=$val['price_original']?></em>
							<em style="color:#FF0000; font-size:14px; list-style:none; font-weight:bold; margin-left:6px;"><?=$val['price']?></em>
						</td>
						<td style="padding:4px;"><?=$val["volume"]?></td>
						<td style="padding:4px;"><?=$val["sort"]?></td>
						<td style="padding:4px;"><?=date('Y-m-d H:i:s',$val["starttime"])?></td>
						<td style="padding:4px;"><?=date('Y-m-d H:i:s',$val["endtime"])?></td>
						<td style="padding:4px;"><?
							if($val['status']==1 && $val['endtime']>=time()){
								echo '上架中';
							}else{
								echo '下架中';
							}
						?></td>
						<td style="padding:4px;"><a href="<?=u(MOD,ACT,array('do'=>'jinzhe_list_addedi','id'=>$val['id'],'plugin_id'=>$plugin_id))?>" target="_blank" class=link4>修改</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <div style="position:absolute; left:7px; top:5px">
			<input name="pldel" type="hidden" value="yes" />
			<input name="pldel_type" id="J_pldel_type" type="hidden" value="" />
			
			<input type="checkbox" onClick="checkAll(this,'ids[]')" />&nbsp;
			<input type="submit" value="删除" class="myself" onclick='$("#J_pldel_type").val("shanchu");return confirm("确定要删除?")'/>
			<input type="submit" value="下架" class="myself" onclick='$("#J_pldel_type").val("xiajia");return confirm("确定要下架?")'/>
			<input type="submit" value="重新上架" class="myself" onclick='$("#J_pldel_type").val("chongxinshangjia");return confirm("确定要重新上架?")'/>
		</div>
            <div class="megas512" style=" margin-top:5px; float:right;"><?=pageft($total,$pagesize,u(MOD,ACT,array('do'=>$do,'plugin_id'=>$plugin_id,'search_type'=>$get['search_type'],'search_keywords'=>$get['search_keywords'])));?></div>
            </div>
       </form>