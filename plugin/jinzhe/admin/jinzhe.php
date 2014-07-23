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
	
	$url='http://www.vip800.com/api/open?type=json&rate=no&frw=duoduo$fr='.$_SERVER['HTTP_HOST'];
	
	$data=file_get_contents($url);
	$data=json_decode($data,true);
	
	$class_table_name='plugin_jinzhe_class';
	$class_array=$duoduo->select_all('plugin_jinzhe_class','id,bind_id','1=1');
	
	$_class_array=array();
	
	foreach($class_array as $val){
		$_class_array[$val['bind_id']]=$val['id'];
	}	
	
	$table_name='plugin_jinzhe';
	$num=0;
	foreach($data as $val){
		$plugin_data=array();
		$val['num_iid']=trim($val['num_iid']);
		$plugin_data['cid']=$_class_array[$val['cate_id']];
		$plugin_data['iid']=$val['num_iid'];
		$plugin_data['pic_url']=$val['pic_url'];
		$plugin_data['price']=$val['coupon_price'];
		$plugin_data['price_original']=$val['price'];
		$plugin_data['title']=$val['title'];
		$plugin_data['commission_rate']=$val['commission_rate'];
		$plugin_data['volume']=$val['volume'];
		$plugin_data['baoyou']=1;
		$plugin_data['shop_type']=($val['shop_type']=='C')?1:0;
		$plugin_data['sort']=$val['ordid'];
		$plugin_data['starttime']=$val['coupon_start_time'];
		$plugin_data['endtime']=$val['coupon_end_time'];
		$plugin_data['addtime']=time();
		$plugin_data['status']=1;
		$res='';

		$res=$duoduo->insert($table_name,$plugin_data);
		
		
		
		if($res && is_int($res)){
			echo 'num_iid：'.$val['num_iid'].'&nbsp;添加成功<br />';
			$num++;
		}else{
			echo 'num_iid：'.$val['num_iid'].'&nbsp;<span style="color:red">添加失败，商品可能已经存在</span><br />';
		}
	}
	exit('一键获取结束，总共成功获取了 '.$num.' 款商品');
?>