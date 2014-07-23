<?php
if(!defined('DDROOT')){
	include ('../comm/dd.config.php');
	include (DDROOT.'/comm/checkpostandget.php');
}

/*$_GET=array (
  'p' => 'zhidemai',
);
$_POST=array (
  'data' => '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',
  'key' => 'cb0a418d6dec2d2f452b74421c92d23d',
);*/


class ddget{
	public $duoduo;
	public $check_p_arr=array('taobao','mall');
	
	function __construct($duoduo,$p){
		$get=var_export($_GET, true)."\r\n".var_export($_POST, true)."\r\n";
		$dir =DDROOT.'/data/getdd_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
		create_file($dir,$get,1);
		
		$this->duoduo=$duoduo;
		
		if(in_array($p,$this->check_p_arr)){
			$this->ddget_check_key();
		}
	}
	
	function ddget_check_key(){
		$dkey=DDYUNKEY;
		
		if(md5($dkey)!=$_GET['key']||empty($_GET['key'])){
			$re=array('s'=>0,'r'=>'无法通过认证');
			echo dd_json_encode($re);
			dd_exit();
		}
	}
	
	function ddget_plugin(){
		$code=$_GET['code'];
		$url=DD_YUN_URL.'/index.php?m=Api&a=one&code='.$code.'&url='.urlencode(SITEURL);
		$data=dd_get_json($url);
		if($data['s']==1){
			$plugin_id=$this->duoduo->select('plugin','id','code="'.$code.'"');
			if($data['r']['yongprice']>0){
				$plugin_data['price']=$data['r']['yongprice'];
			}
			elseif($data['r']['nianprice']>0){
				$plugin_data['price']=$data['r']['nianprice'];
			}
			elseif($data['r']['yueprice']>0){
				$plugin_data['price']=$data['r']['nianprice'];
			}
			$plugin_data['key']=$data['r']['ddkey'];
			$plugin_data['code']=$data['r']['code'];
			$plugin_data['title']=$data['r']['title'];
			$plugin_data['toper_name']=$data['r']['username'];
			$plugin_data['toper_qq']=$data['r']['qq'];
			$plugin_data['endtime']=$data['r']['endtime'];
			$plugin_data['addtime']=$data['r']['addtime'];
			$plugin_data['banben']=$data['r']['banben'];
			$plugin_data['version']=$data['r']['version'];
			$plugin_data['jiaocheng']=$data['r']['jiaocheng'];
			$plugin_data['authcode']=$data['r']['authcode'];
			
			$table=$this->duoduo->get_table_struct('plugin');
			if(isset($table['level'])){
				$plugin_data['level']=$data['r']['level'];
			}

			if($plugin_id==0){
				$this->duoduo->insert('plugin',$plugin_data);
			}
			else{
				$this->duoduo->update('plugin',$plugin_data,'id="'.$plugin_id.'"');
			}
		}
	}
	
	function ddget_taobao(){
		$duoduo=$this->duoduo;
		$id=$duoduo->select('tradelist', 'id', 'trade_id="'.$_GET['trade_id'].'"');
		if($id>0){
			$re=array('s'=>0,'r'=>'订单已经存在');
			return dd_json_encode($re);
		}
		$row=array();
		$row['pay_time']=$_GET['pay_time'];
		$row['num_iid']=$_GET['num_iid'];
		$row['pay_price']=$_GET['pay_price'];
		$row['real_pay_fee']=$_GET['real_pay_fee'];
		$row['commission_rate']=$_GET['commission_rate'];
		$row['commission']=$_GET['commission'];
		$row['item_num']=$_GET['item_num'];
		$row['trade_id']=$_GET['trade_id'];
		$row['outer_code']=$_GET['outer_code'];
		$row['category_id']=$_GET['category_id'];
		$row['create_time']=$_GET['create_time'];
		$row['category_name']=$_GET['category_name'];
		$row['platform']=1;//手机来源
		$row['item_title']=urldecode($_GET['item_title']);
		$row['shop_title']=urldecode($_GET['shop_title']);
		$row['seller_nick']=urldecode($_GET['seller_nick']);
		$row['app_key']="";//没有这个值的
		$duoduo->do_report($row);
		$re=array('s'=>1,'r'=>'订单接收成功');
		echo dd_json_encode($re);	
	}
	
	function ddget_mall(){
		$duoduo=$this->duoduo;
		include(DDROOT.'/comm/mall.class.php');
		$mall_class=new mall($duoduo);
		$lm=(int)$_GET['lm'];
		$ads_id=$_GET['ads_id'];//活动ID
		$ads_name=$_GET['ads_name'];
		$site_id=$_GET['site_id'];//网站ID
		$link_id=$_GET['link_id'];//活动链接ID
		$uid=$_GET['euid'];//	网站主设定的反馈标签
		list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
		$order_sn=$_GET['order_sn'];//	订单编号
		$order_time=$_GET['order_time'];//	下单时间
		$orders_price=$_GET['orders_price'];//订单金额
		$unique_id=$_GET['unique_id'];
		$commission=$_GET['confirm_siter_commission']?$_GET['confirm_siter_commission']:$_GET['siter_commission'];//	订单佣金
		$status=$_GET['status'];
		$platform=$_GET['platform'];
		$domain=$_GET['domain'];
		$sales =$orders_price;
		$order_code=$order_sn; //订单编号
		$unique_id=$unique_id?$unique_id:$order_code;  //唯一编号
		
		$mall_id=0;
		$mall_name=$ads_name;
		if($domain!=''){
			$mall=$mall_class->view($domain);
			if(!empty($mall)){
				$mall_name=$mall['title'];
				$mall_id=$mall['id'];
			}
		}
		
		$dduser=$duoduo->select('user','*','id="'.$uid.'"');
		$fxje=fenduan($commission,$this->duoduo->webset['mallfxbl'],$dduser['level']);
		$jifen=round($fxje*$this->duoduo->webset['jifenbl']);
		if($mall['type']==2){ //返积分
			$fxje=0;
		}
		if($dduser['tjr']>0){
			$tgyj=round($fxje*$this->duoduo->webset['tgbl']);
		}
		else{
			$tgyj=0;
		}
		
		$field_arr = array (
			'adid' => $ads_id,
			'lm' => $lm,
			'order_time' => $order_time,
			'mall_name' => $mall_name,
			'mall_id'=>$mall_id,
			'domain'=>$domain,
			'uid' => $uid,
			'order_code' => $order_code,
			'item_count' => 1,
			'item_price' => $sales,
			'sales' => $sales,
			'commission' => $commission,
			'status' => $status,
			'fxje' => $fxje,
			'jifen' => $jifen,
			'tgyj' => $tgyj,
			'addtime'=>TIME,
			'platform'=>$platform,
			'unique_id'=>$unique_id
		);
		
		if($status==1){
    		$field_arr['qrsj']=TIME;
		}
		
		$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code", 'unique_id="'.$unique_id.'"'); //用订单编号查
		if ($mall_order['id'] == '') {
			$insert=$duoduo->insert("mall_order", $field_arr);
			$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
			$duoduo->ddtuiguang_insert($tuiguang_insert_data);
			$field_arr['id']=$insert;
			$re=array('s'=>1,'r'=>'订单接收成功');
		}
		else{
			$duoduo->update('mall_order', $field_arr, "id='".$mall_order['id']."'");
			$field_arr['id']=$mall_order['id'];
			$re=array('s'=>1,'r'=>'订单已存在');
		}
		
		if($mall_order['status']!=1 && $status==1){//给会员结算
			if($dduser['id']>0 && ($fxje>0 || $jifen>0)){
				$duoduo->rebate($dduser,$field_arr,3);
				$re=array('s'=>1,'r'=>'订单结算');
			}
		}
		/*elseif($status!=1 && $mall_order['status']==1 && $dduser['id']>0){ //商城订单退款
			$refund_arr['uid']=$dduser['id'];
			$refund_arr['money']=$fxje;
			$refund_arr['jifen']=$jifen;
			$refund_arr['source']=$mall_name.'返利，订单号'.$order_code;
			$duoduo->dd_refund($refund_arr,23);
			$re=array('s'=>1,'r'=>'订单退款');
		}*/
		
		echo dd_json_encode($re);
	}
	
	function check(){
		$miyue=$_GET['key'];
		if($miyue==''){$miyue=$_POST['key'];}
		if(md5(DDYUNKEY)!=$miyue){
			$re=array('s'=>0,'r'=>'通信密钥错误');
			echo dd_json_encode($re);exit;
		}
		else{
			$re=array('s'=>1,'r'=>'成功');
			$re=dd_json_encode($re);
		}
		return $re;
	}
	
	function ddgoods(){
		$duoduo=$this->duoduo;
		$table_struct=$duoduo->get_table_struct('ddgoods');
		$this->check();
		$shuju=$this->dd_unxuliehua($_POST['data']);
		foreach($shuju as $row){
			$this->ddgoods_insert($row,$table_struct);
		}
		$re=array('s'=>1,'r'=>'成功');
		echo dd_json_encode($re);
	}
	
	function dd_unxuliehua($data){
		$shuju=dd_unxuliehua($data);
		if(!isset($shuju[0])){
			$a[0]=$shuju;
			$shuju=$a;
		}
		return $shuju;
	}
	
	function ddgoods_insert($shuju,$table_struct){
		$duoduo=$this->duoduo;
		
		if($shuju['status']==2){
			$duoduo->delete('ddgoods','iid="'.$shuju['iid'].'"');
			return false;
		}
		
		foreach($shuju as $k=>$v){
			if(isset($table_struct[$k])){
				$data[$k]=$v;
			}
		}
		$data['sort']=DEFAULT_SORT;
		unset($data['id']);
		$id=(float)$duoduo->select('ddgoods','id','iid="'.$data['iid'].'"');
		if($id==0){
			$duoduo->insert('ddgoods',$data);
		}
		if(mysql_error()!=''){
			$re=array('s'=>0,'r'=>mysql_error());
			echo dd_json_encode($re);exit;
		}
		unset($duoduo);
	}
	
	function zhidemai(){
		$duoduo=$this->duoduo;
		$table_struct=$duoduo->get_table_struct('ddzhidemai');
		$this->check();
		$shuju=$this->dd_unxuliehua($_POST['data']);
		foreach($shuju as $row){
			$this->zhidemai_insert($row,$table_struct);
		}
		$re=array('s'=>1,'r'=>'成功');
		unset($duoduo);
		echo dd_json_encode($re);
	}
	
	function zhidemai_insert($shuju,$table_struct){

		$duoduo=$this->duoduo;
		$comment=$shuju['comment'];
		unset($shuju['comment']);
		$shuju['sort']=DEFAULT_SORT;
		$shuju['data_id']=$shuju['id'];
		unset($shuju['id']);
		unset($shuju['uid']);
		
		$my=$shuju['site_shenhe'];
		unset($shuju['site_shenhe']);
		
		if($my==1){ //自己的数据，保留uid
			$shuju['uid']=$shuju['user_uid'];
			if($shuju['status']==2){
				$duoduo->delete('ddzhidemai','data_id="'.$shuju['data_id'].'"');
				return false;
			}
		}
		unset($shuju['user_uid']);
		unset($shuju['id']);
		unset($shuju['pinglun']);
		foreach($shuju as $k=>$v){
			if(isset($table_struct[$k])){
				$data[$k]=$v;
			}
		}

		$id=(float)$duoduo->select('ddzhidemai','id','data_id="'.$data['data_id'].'"');

		if($id==0){
			if($data['web']==1){
				if($data['img']!=''){$data['img']=img_caiji($data['img'],'zhidemai');}
				$domain=get_domain($data['url']);
				$mid=(int)$duoduo->select(get_mall_table_name(),'id','domain="'.$domain.'"');
			}
			else{
				$mid=1;
			}
			if($my==1){$mid=1;}
			if($data['title']!='' && $mid>0){
				$id=(int)$duoduo->insert('ddzhidemai',$data);
			}
			else{
				$id=0;
			}
			if($id>0 && $my==1){
				$webset=$this->duoduo->webset;
				if($webset['zhidemai']['jiangli_value']>0 && $duoduo->select('user','id','id="'.$data['uid'].'"')>0){
					$update_user_data=array();
					if($webset['zhidemai']['jiangli_huobi']==1){
						$update_user_data[]=array('f'=>'money','v'=>$webset['zhidemai']['jiangli_value'],'e'=>'+');
					}
					if($webset['zhidemai']['jiangli_huobi']==2){
						$update_user_data[]=array('f'=>'jifenbao','v'=>$webset['zhidemai']['jiangli_value'],'e'=>'+');
					}
					if($webset['zhidemai']['jiangli_huobi']==3){
						$update_user_data[]=array('f'=>'jifen','v'=>$webset['zhidemai']['jiangli_value'],'e'=>'+');
					}
					$duoduo->update_user_mingxi($update_user_data,$data['uid'],24,$data['title'],0,0,'',$id);
				}
			}
		}
		elseif($my==1){
			$duoduo->update('ddzhidemai',$data,'id="'.$id.'"');
		}
		
		if(mysql_error()!=''){
			$re=array('s'=>0,'r'=>mysql_error());
			echo dd_json_encode($re);exit;
		}
		$pinglun=0;
		if(!empty($comment)){
			foreach($comment as $row){
				unset($row['id']);
				$id=(float)$duoduo->select('ddzhidemai_comment','id','data_id="'.$row['data_id'].'" and username="'.$row['username'].'"');
				if($id==0){
					$duoduo->insert('ddzhidemai_comment',$row);
					$pinglun++;
				}
			}
		}
		if($pinglun>0){
			$update_data=array('f'=>'pinglun','v'=>$pinglun,'e'=>'+');
			$this->duoduo->update('ddzhidemai',$update_data,'data_id="'.$data['data_id'].'"');
		}
		unset($duoduo);
	}
	
	function lanmu(){
		$duoduo=$this->duoduo;
		$this->check();
		$data=dd_unxuliehua($_POST['data']);
		foreach($data as $row){
			$re[$row['code']]=$row['title'];
		}
		$duoduo->set_webset('ddgoodslanmu',$re);
		$duoduo->webset();
		$re=array('s'=>1,'r'=>'成功');
		echo dd_json_encode($re);
	}
	
	function dd_generateSign(){
		if(isset($_POST['pass'])){
			$pass=trim($_POST['pass']);
			$params=$_POST;
		}
		else{
			$pass=trim($_GET['pass']);
			unset($_GET['p']);
			$params=$_GET;
		}
		$key=DDYUNKEY;
		unset($params['pass']);
		ksort($params);
		foreach ($params as $k => $v){
			$stringToBeSigned .=$k.urldecode($v);
		}
		$sign_pass=strtolower(md5($key.$stringToBeSigned.$key));
		if($sign_pass!=$pass){
			$re=array('s'=>0,'r'=>'通信密钥错误');
			echo dd_json_encode($re);
			exit;
		}
	}
}

$p=$_GET['p'];
if(empty($p)){
	$re=array('s'=>0,'r'=>'参数不对');
	echo dd_json_encode($re);
}
else{
	$ddget = new ddget($duoduo,$p);
	if($p=="taobao"){
		$ddget->ddget_taobao();
	}
	elseif($p=="mall"){
		$ddget->ddget_mall();
	}
	elseif($p=="plugin"){
		$ddget->ddget_plugin();
	}
	elseif($p=="check"){
		echo $ddget->check();
	}
	elseif($p=="ddgoods"){
		$ddget->ddgoods();
	}
	elseif($p=="ddzhidemai" || $p=="zhidemai"){
		$ddget->zhidemai();
	}
	elseif($p=="lanmu"){
		$ddget->lanmu();
	}
}
?>