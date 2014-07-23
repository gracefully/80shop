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

if (!defined('INDEX')) {
	exit ('Access Denied');
}

if(TAOTYPE==1){
	if($webset['alimama']['open']==1 || isset ($_GET['show'])){

		$code = $_GET['code'];
		$num = (int)$_GET['num'];
		$sday = $_GET['sday'] ? date('Y-m-d', strtotime($_GET['sday'])) : date('Y-m-d');
		$eday = $_GET['eday'] ? date('Y-m-d', strtotime($_GET['eday'])) : date('Y-m-d');
		if ($eday > date('Y-m-d')) {
			$eday = date('Y-m-d');
		}
		if (isset ($_GET['show']) && authcode($_GET['show'], 'DECODE') == 1) {
			$admin = 1;
			$day=$sday;
			
		} else {
			if (TIME - authcode($code, 'DECODE', DDKEY) > 60) {
				PutInfo('访问超时');
			}
			$admin = 0;
			if($webset['alimama']['day']<date('Ymd')){
				$day=date("Y-m-d",strtotime("-1 days"));
			}
			else{
				$day=date('Y-m-d');
			}
		}
		
		$a=$duoduo->select('tradelist','trade_id','1 order by id asc');
		$b=$duoduo->select('tradelist','trade_id','1 order by id desc');
		if(($a!='' && preg_match('/_\d{1,12}/',$a)==0) || ($b!='' && preg_match('/_\d{1,12}/',$b)==0)){
			if($admin==1){
				PutInfo('请从新提取订单号');
			}
			else{
				exit;
			}
		}
		
		$alimama_class=fs('alimama');
		$alimama_class->set_name_pwd($webset['alimama']['username'],$webset['alimama']['password'],$_GET['yzm']);
		
		if(!isset($_GET['paystatus'])){//0和3状态随机获取
			$pay_array=array('0'=>0,'1'=>3);
			$paystatus=$pay_array[array_rand($pay_array)];
		}
		else{
			$paystatus=(int)$_GET['paystatus'];
		}

		$excel=$alimama_class->get_excel($day,$day,$paystatus);
		if($alimama_class->error==1){
			$duoduo->update_serialize('alimama','error_msg',$excel['r'].':'.SJ);
			/*if(isset($excel['yzm'])){
				$duoduo->update_serialize('alimama','open',0);
			}*/
			$duoduo->webset();
			exit($excel['r']);
		}
			
		include DDROOT . '/comm/readxls.php';
		$data = new Spreadsheet_Excel_Reader();
    	$data->setOutputEncoding('utf-8');
		$data->read($excel,2);
		$result['update_num'] = 0;
    	$result['insert_num'] = 0;
		$result['delete_num'] = 0;

    	$result=$duoduo->trade_import($data->sheets[0]['cells'],$result);
		$num+=$result['total'];
		
		if($admin==0){
			$duoduo->update_serialize('alimama','day',date('Ymd'));
			$duoduo->set_webset('tao_report_time', TIME);
			$duoduo->webset();
		}
		else{
			$sday = date('Y-m-d', strtotime($sday . ' +1 day'));
			if($sday>$eday){
				PutInfo('共获取订单'.$num.'条（其中失效订单不导入）');
			}
			else{
				$url = u('tao', 'report').'&sday=' . $sday . '&eday=' . $eday . '&num=' . $num.'&show=' . urlencode(authcode(1, 'ENCODE')).'&paystatus='.$paystatus;
				PutInfo('<b style="color:red">'.$sday.' 订单获取中，不要操作浏览器！</b><br/><br/><img src="images/wait2.gif" />', $url);
			}
		}	
	}
}
elseif (TAO_REPORT_GET_NUM == 100) {
	if(!defined('SJ')){
		define('SJ',date('Y-m-d H:i:s'));
	}
	$total = 0;
	$i = 0; //插入订单
	$j = 0; //返利订单
	$n = 0; //本次处理订单
	$code = $_GET['code'];
	$sdatetime = $_GET['sdatetime'] ? $_GET['sdatetime'] : date('Y-m-d').' 00:00:00';
	$edatetime = $_GET['edatetime'] ? $_GET['edatetime'] : SJ;
	if ($edatetime > SJ) {
		$edatetime = SJ;
	}
	$page_no = $_GET['page_no'] ? intval($_GET['page_no']) : 1;

	if (isset ($_GET['show']) && authcode($_GET['show'], 'DECODE') == 1) {
		$admin = 1;
		$start_time = $_GET['start_time'] ? $_GET['start_time'] : $sdatetime;
	} else {
		$admin = 0;
		if (TIME - authcode($code, 'DECODE', DDKEY) > 60) {
			//PutInfo('访问超时');
		}
		if (isset ($_GET['start_time'])) {
			$start_time = $_GET['start_time'];
			if($start_time>SJ){
				$start_time=SJ;
			}
		} else {
			$time = $duoduo->select('webset', 'val', 'var="tao_report_time"');
			$t=strtotime($time); //检测时间格式，转成时间戳
			if($t>0){
				$time=$t;
			}

			if($time<strtotime(date('Y-m-d',strtotime("-1 day")))){ //如果上次获取时间小于昨天，那么就从今天开始获取
				$start_time=date('Y-m-d').' 00:00:00';
			}
			elseif($time>TIME){
				$start_time=date('Y-m-d H:i:s');
			}
			else{
				$start_time = date('Y-m-d H:i:s',$time);
			}
		}
	}

	$num = $_GET['num'] ? intval($_GET['num']) : 0;
	$url = u('tao', 'report');
	$collect = new collect;
	
	$time=$start_time;
	$data = $ddTaoapi->taobao_taobaoke_rebate_report_get($start_time);
	$c = count($data);

	if ($c > 0) {
		foreach ($data as $row) {
			$duoduo->do_report($row);
			$n++;
		}
	}

	$time=strtotime($start_time)+3600;
	if($time>TIME){
		$time=TIME;
	}

	if ($admin == 0) {
		$time-=300;
		//echo date('Y-m-d H:i:s',$time);exit;
		$duoduo->set_webset('tao_report_time', $time);
		$webset['tao_report_time']=$time;
		dd_set_cache('webset',$webset);

	} else {
		$start_time=date('Y-m-d H:i:s',$time);
		$num = $n + $num;
		$msg = $start_time . " | 本次获取订单" . $n . '条！<br/><b style="color:red">订单获取中，不要操作浏览器！</b><br/><img src="images/wait2.gif" />';

		if ($edatetime < SJ) {
			$over_time = $edatetime;
		} else {
			$over_time = SJ;
		}
		if ($start_time < $over_time) {
			$param = '&sdatetime=' . urlencode($sdatetime) . '&edatetime=' . urlencode($edatetime) . '&start_time=' . urlencode($start_time) . '&num=' . $num;
			$param .= '&show=' . urlencode(authcode(1, 'ENCODE'));
			$url = $url . $param;
			PutInfo($msg, $url);
		} else {
			$msg = "<b style='color:red'>获取订单完毕！</b><br/>共有订单" . $num . '条';
			PutInfo($msg);
		}
	}
}
elseif (TAO_REPORT_GET_NUM == 40) {
	$total = 0;
	$i = 0; //插入订单
	$j = 0; //返利订单
	$n = 0; //本次处理订单
	$code = $_GET['code'];
	$sday = $_GET['sday'] ? $_GET['sday'] : date('Ymd');
	$eday = $_GET['eday'] ? $_GET['eday'] : date('Ymd');
	if ($eday > date('Ymd')) {
		$eday = date('Ymd');
	}
	$page_no = $_GET['page_no'] ? intval($_GET['page_no']) : 1;

	if (isset ($_GET['show']) && authcode($_GET['show'], 'DECODE') == 1) {
		$admin = 1;
	} else {
		$admin = 0;
		if (TIME - authcode($code, 'DECODE', DDKEY) > 60) {
			PutInfo('访问超时');
		}
	}

	$num = $_GET['num'] ? intval($_GET['num']) : 0;
	$url = u('tao', 'report');
	$collect = new collect;
	if ($page_no == 1) {
		if (file_exists($ddTaoapi->ApiConfig->CachePath . '/taobao.taobaoke.report.get')) {
			deldir($ddTaoapi->ApiConfig->CachePath . '/taobao.taobaoke.report.get');
		}
	}
	if ($admin == 1 || $admin == 0) {
		$data = $ddTaoapi->taobao_taobaoke_report_get($sday, $page_no);
		$c = count($data);

		if ($c > 0) {
			foreach ($data as $row) {
				$duoduo->do_report($row);
				$n++;
			}
		}

		if (BACKSTAGE == 0 && $admin == 0) {
			for ($page_no = 2; $page_no <= 999; $page_no++) {
				$data = $ddTaoapi->taobao_taobaoke_report_get($sday, $page_no);
				if (count($data) > 0) {
					foreach ($data as $row) {
						$duoduo->do_report($row);
						$n++;
					}
				} else {
					$page_no = 1000;
				}
			}
		} else {
			$num = $n + $num;
			$msg = date('Y-m-d', strtotime($sday)) . " | 本次获取订单" . $n . '条！<br/><b style="color:red">订单获取中，不要操作浏览器！</b><br/><img src="images/wait2.gif" />';
			if ($c == TAO_REPORT_GET_NUM) {
				$page_no++;
				$param = '&sday=' . $sday . '&eday=' . $eday . '&page_no=' . $page_no . '&num=' . $num . '&n=' . $n;
				if ($admin == 0) {
					$param .= '&code=' . urlencode(authcode(TIME, 'ENCODE', DDKEY));
					only_send(SITEURL . '/' . $url . $param);
				} else {
					$param .= '&show=' . urlencode(authcode(1, 'ENCODE'));
					$url = $url . $param;
					PutInfo($msg, $url);
				}
			}
			elseif ($c <= TAO_REPORT_GET_NUM && $sday < $eday) {
				$sday = date('Ymd', strtotime($sday . ' +1 day'));
				$param = '&sday=' . $sday . '&eday=' . $eday . '&page_no=1&num=' . $num;
				if ($admin == 0) {
					$param .= '&code=' . urlencode(authcode(TIME, 'ENCODE', DDKEY));
					only_send(SITEURL . '/' . $url . $param);
				} else {
					$param .= '&show=' . urlencode(authcode(1, 'ENCODE'));
					$url = $url . $param;
					PutInfo($msg, $url);
				}
			} else {
				if ($admin == 1) {
					$msg = "<b style='color:red'>获取订单完毕！</b><br/>共有订单" . $num . '条';
					PutInfo($msg);
				} else {
					//自动获取结束，无操作
				}
			}
		}
	}
}
?>