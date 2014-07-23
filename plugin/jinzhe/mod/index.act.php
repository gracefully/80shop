<?php //多多
	$type=isset($_GET['type'])?trim($_GET['type']):'all';
	$cid=isset($_GET['cid'])?intval($_GET['cid']):0;
	$page=isset($_GET['page'])?intval($_GET['page']):1;
	$wft=0;
	
	if(isset($_GET['plugin_query'])){
		$plugin_query=$_GET['plugin_query'];
		$plugin_query_array=explode('-',$plugin_query);
		$type=isset($plugin_query_array[2])?$plugin_query_array[2]:'all';
		$cid=isset($plugin_query_array[3])?intval($plugin_query_array[3]):0;
		$page=isset($plugin_query_array[4])?intval($plugin_query_array[4]):1;
		$_GET['page']=$page;
		$wft=1;
	}

	$pagesize=48;
	$plugin_data_class_list=$duoduo->select_all('plugin_jinzhe_class','*','1=1 order by sort asc,id desc');
	
	$where='status=1 and endtime>='.time().'';
	switch($type){
		case 'baoyou':
			$where.=' and price<=9.9';
			break;
		case 'fengding':
			$where.=' and price>9.9 and price<20';
			break;
		case 'tejia':
			$where.=' and price>=20';
			break;
	}
	if($cid!=0){
		$where.=' and cid='.$cid;
	}
	$total=$duoduo->count('plugin_jinzhe',$where);
	$plugin_data_list=$duoduo->select_all('plugin_jinzhe','*',$where.' order by sort asc,id desc limit '.(($page-1)*$pagesize).','.$pagesize.'');
	
	$nowurl=p(MOD,'index',array('type'=>$type,'cid'=>$cid));
	$pageft=pageft($total,$pagesize,$nowurl,$wft);
?>