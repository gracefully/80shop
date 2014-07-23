<?php //多多
if(!defined('INDEX')){
	exit('Access Denied');
}

function check_tid($duoduo){
	$dduser=$duoduo->dduser;
	$webset=$duoduo->webset;
	
	if($webset['alimama']['open']==0){
		$re=array('s'=>0,'r'=>'查询功能关闭');
		return dd_json_encode($re);
	}
	
	$tid=$_GET['tid'];
	if($tid==''){
		$re=array('s'=>0,'r'=>'订单号不能为空');
		return dd_json_encode($re);
	}
	$yzm=$_GET['yzm'];
	$trade=$duoduo->select('plugin_alimama','*','trade_id="'.$tid.'"');
	if($trade['id']>0){
		if($dduser['id']>0){
			$data=array('uid'=>$dduser['id']);
			$duoduo->update('plugin_alimama',$data,'id="'.$trade['id'].'"');
		}
		$trade['url']=u('tao','view',array('iid'=>$trade['num_iid']));
		$trade['fxje']=jfb_data_type(fenduan($trade['commission'],$webset['fxbl'],$dduser['level'],TBMONEYBL));
		$re=array('s'=>1,'r'=>$trade);
		return dd_json_encode($re);
	}
	
	$alimama_class=fs('alimama');
	$alimama_class->set_name_pwd($webset['alimama']['username'],$webset['alimama']['password'],$yzm);
	
	$excel=$alimama_class->get_excel(date("Y-m-d",strtotime("-1 day")),date('Y-m-d'));
	
	if($alimama_class->error==1){
		$duoduo->update_serialize('alimama','error_msg',$excel['r'].':'.SJ);
		/*if(isset($excel['yzm'])){
			$duoduo->update_serialize('alimama','open',0);
		}*/
		$duoduo->webset();
		$re=array('s'=>0,'r'=>$excel['r']);
		return dd_json_encode($re);
	}
		
	if($alimama_class->error==1){
		$duoduo->update_serialize('alimama','error_msg',$excel['r'].':'.SJ);
		//如果是验证码错误就不关闭
		/*if(isset($excel['yzm'])){
			$duoduo->update_serialize('alimama','open',0);
		}*/
		$duoduo->webset();
		$re=array('s'=>0,'r'=>$excel['r']);
		return dd_json_encode($re);
	}
	else{
		$trade=array();
		include DDROOT . '/comm/readxls.php';
		$data = new Spreadsheet_Excel_Reader();
    	$data->setOutputEncoding('utf-8');
		$data->read($excel,2);
		foreach($data->sheets[0]['cells'] as $k=>$row){
			if($k==1) continue;
			unset($arr);
			$arr['status'] = $row[5];
        	$arr['create_time'] = $row[1];
        	$arr['item_title'] = mysql_real_escape_string($row[2]);
        	$arr['shop_title'] = mysql_real_escape_string($row[13]);
        	$arr['seller_nick'] = mysql_real_escape_string($row[12]);
        	$arr['num_iid'] = $row[11];
        	$arr['item_num'] = $row[3];
        	$arr['pay_price'] = $row[4];
        	$arr['trade_id'] = $row[21];
			$arr['commission_rate'] = round(str_replace('%','',$row[8])/100,2);
			$arr['commission']=round($arr['commission_rate']*$arr['item_num']*$arr['pay_price'],2);
			
			$id=(int)$duoduo->select('plugin_alimama','id','trade_id="'.$arr['trade_id'].'"');
			if($id==0){
				$plugin_alimama_id=$duoduo->insert('plugin_alimama',$arr);
				if($arr['trade_id']==$tid){
					$arr['id']=$plugin_alimama_id;
					$trade=$arr;
				}
			}
		}
		if(empty($trade)){
			$re=array('s'=>0,'r'=>'订单未查到');
			return dd_json_encode($re);
		}
		else{
			if($dduser['id']>0){
				$data=array('uid'=>$dduser['id']);
				$duoduo->update('plugin_alimama',$data,'id="'.$trade['id'].'"');
			}
			$trade['url']=u('tao','view',array('iid'=>$trade['num_iid']));
			$trade['fxje']=jfb_data_type(fenduan($trade['commission'],$webset['fxbl'],$dduser['level'],TBMONEYBL));
			$re=array('s'=>1,'r'=>$trade);
			return dd_json_encode($re);
		}
	}
}
echo check_tid($duoduo);
?>