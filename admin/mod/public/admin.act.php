<?php
/**
 * ============================================================================
 * 版权所有 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

/*公共数据*/
$shifou_arr=array(0=>'否',1=>'是');
$zhuangtai_arr=array(0=>'关闭',1=>'开启');

switch (MOD) {
	case 'ad' :
		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				unlink(DDROOT . '/data/ad/' . $v . '.js');
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}
	break;
	
	case 'api':
	    $open_arr=array(0=>'关闭',1=>'开启');
		if(ACT=='addedi' && isset($_POST['sub'])){
			$qq_meta=$_POST['qq_meta'];
			unset($_POST['qq_meta']);
			$data=array('val'=>$qq_meta);
			$duoduo->update('webset',$data,'var="qq_meta"');
		}
	break;
	
	case 'baobei';
	    $cat1=array('0'=>'全部');
        $cat2=$webset['baobei']['cat'];
        $cat=$cat1+$cat2;
	break;
	
	case 'city';
	    $status=array(0=>'显示',1=>'隐藏');
	break;
	
	case 'data';
	    get2var();
        post2var();
		define('DDBACKUPDATA', DDROOT . '/data/bdata');

		if (empty ($dopost)) {
			$dopost = '';
		}

		//跳转到一下页的JS
		$gotojs = "function GotoNextPage(){
			document.gonext." . "submit();
		}" . "\r\nset" . "Timeout('GotoNextPage()',500);";

		$dojs = "<script language='javascript'>$gotojs</script>";

		$phpstart = PHP_EXIT."\r\n";
	break;
	
	case 'duihuan';
	    $status_arr=array(0=>'<span style="color:#ff3300">兑换待审核</span>',1=>'<span style="color:#009900">兑换成功</span>',2=>'<span style="color:#333333">兑换失败</span>');
	break;
	
	case 'huan_goods';
	    $status[1] = '隐藏';
		$status[0] = '显示';

		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}

		if (ACT == 'addedi' && $_POST['sub'] != '') {
			$arr = array (
				'jifenbao',
				'jifen',
				'num',
				'limit',
			);
			empty2zero($_POST, $arr);
		}
		
		$malls1[0]='无';
		$sql="select id,title,pinyin from ".BIAOTOU."mall order by pinyin asc";
		$query=$duoduo->query($sql);
		while($arr=$duoduo->fetch_array($query)){
		    $malls2[$arr['id']]='('.substr($arr['pinyin'],0,1).')'.$arr['title'];
		}
		if(empty($malls2)){$malls2=array();}
        $malls=$malls1+$malls2;
		if(ACT=='addedi'){
		    $mall_id=$_GET['mall_id'];
		}
		
	break;
	
	case 'huodong';
        if(ACT=='addedi' && $_POST['sub']!=''){
			if((int)$_POST['mall_id']==0){
				jump(-1,'商城必须选择');
			}
		}
		else{
			$malls=mall_pinyin($duoduo);
		}
		if(ACT=='addedi'){
		    $mall_id=$_GET['mall_id'];
		}
	break;
	
	case 'link':
	    $type=array(1=>'图片链接',0=>'文字链接',);
	break;
	
	case 'mall':
	    $lianmeng=include(DDROOT.'/data/lm.php');
		foreach($lianmeng as $k=>$row){
		    $lm[$k]=$row['title'];
		}

		if ($_POST['sub'] != '' && ACT == 'addedi') {
			$array=array('yiqifaid','duomaiid','weiyiid','wujiumiaoid','chanetid','chanet_draftid','edate','merchantId');
			empty2zero($_POST,$array);
		}

		if ($_GET['mallid'] > 0 && $_GET['api_city'] != '') {
			include (DDROOT . '/comm/ddTuan.class.php');
			$tuan = new tuan;
			$tuan->init();
			$arr = dd_get_xml($_GET['api_city']);
			$tuan->get_tuan_city($arr, $_GET['mallid'], $_GET['rule']);
			echo script('alert("获取完毕");window.close()');
			exit;
		}
		
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['chanet']['pwd']==DEFAULTPWD)){
		    $_POST['chanet']['pwd']=$webset['chanet']['pwd'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['chanet']['key']==DEFAULTPWD)){
		    $_POST['chanet']['key']=$webset['chanet']['key'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['duomai']['key']==DEFAULTPWD)){
		    $_POST['duomai']['key']=$webset['duomai']['key'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['linktech']['pwd']==DEFAULTPWD)){
		    $_POST['linktech']['pwd']=$webset['linktech']['pwd'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['yiqifa']['key']==DEFAULTPWD)){
		    $_POST['yiqifa']['key']=$webset['yiqifa']['key'];
		}
		
	break;
	
	case 'mall_comment':
		if(ACT=='addedi' && $_POST['sub']!=''){
			if((int)$_POST['mall_id']==0){
				jump(-1,'商城必须选择');
			}
		}
		else{
			$malls=mall_pinyin($duoduo);
		}
        
	break;
	
	case 'nav':
	    $status=array(0=>'显示',1=>'隐藏');
        $target=array(0=>'原窗口',1=>'新窗口');
		$type=array(0=>'无',1=>'new',2=>'hot');
		$nav_arr1=(array)$duoduo->select_2_field('nav');
		$nav_arr=array(0=>'无')+$nav_arr1;
		$nav_tag=$duoduo->select_2_field('nav','id,tag');
	break;
	
	case 'service':
	    $type=array(1=>'QQ客服',2=>'旺旺客服');
	break;
	
	case 'slides':
	    $status[1] = '隐藏';
		$status[0] = '显示';
		
		$category=dd_get_cache('slides','array');

		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}
	break;
	
	case 'smtp':
	    $status = array (
			0 => '关闭',
			1 => '开启'
		);
		if (isset($_POST['smtphost']) && $_POST['smtphost'] != '') {
			$from = $_POST['smtpuser'];
			$to = $_POST['test_email'];
			$usepassword = $_POST['smtppwd']==DEFAULTPWD?$webset['smtp']['pwd']:$_POST['smtppwd'];
			$smtp = $_POST['smtphost'];
			$type = $_POST['type'];
			$title = $_POST['title'];
			$html = del_magic_quotes_gpc($_POST['html']);
			echo mail_send($to, $title, $html, $from, $usepassword, $smtp,$type);
			exit;
		}

		if(ACT=='set' && isset($_POST['sub']) && (!isset($_POST['smtp']['pwd']) || $_POST['smtp']['pwd']==DEFAULTPWD)){
		    $_POST['smtp']['pwd']=$webset['smtp']['pwd'];
		}
	break;
	
	case 'tradelist':
	    $checked_arr=include(DDROOT.'/data/checked_arr.php'); //订单会员状态
		$checked_arr=array(''=>'全部')+$checked_arr;
		
	    if(TAOTYPE==1){ //只有淘点金模式下订单才有状态，api模式下，订单全部是核对有效的
			$status_arr=include(DDROOT.'/data/status_arr.php');//订单状态
			foreach($status_arr as $k=>$v){
				$_status_arr[$k]=strip_tags($v);
			}
	    }
	break;
	
	case 'paipai_order':
	    $checked_status=array(0=>'未核对',2=>'有效',-1=>'退款');
	break;
	
	case 'mall_order':
		$lianmeng=include(DDROOT.'/data/lm.php');
	    $status_arr2=array(0=>'未确认',1=>'确认',-1=>'无效');
		$lianmeng=include(DDROOT.'/data/lm.php');
		foreach($lianmeng as $k=>$row){
		    $lm_arr[$k]=$row['title'];
		}
		$lm_arr[100]='综合';
	break;
	
	case 'tuan_goods':
	    $malls1[0]='全部';
		$sql="select id,title,pinyin from ".BIAOTOU."mall where cid=21 order by pinyin asc";
		$query=$duoduo->query($sql);
		while($arr=$duoduo->fetch_array($query)){
		    $malls2[$arr['id']]='('.substr($arr['pinyin'],0,1).')'.$arr['title'];
		}
		if(empty($malls2)){$malls2=array();}
        $malls=$malls1+$malls2;
        $cat=$duoduo->select_2_field('tuan_type');
	break;
	
	case 'user':
	    if(ACT=='set'){
		    if($_POST['sub']!=''){
				if((float)$_POST['user']['auto_increment']>$webset['user']['auto_increment']){
				    $sql="ALTER TABLE `".BIAOTOU."user` AUTO_INCREMENT =".(float)$_POST['user']['auto_increment']."";
				    $duoduo->query($sql);
				}
			}
			else{
			    $result = $duoduo->query("show table status like '".BIAOTOU."user'");
                $auto_increment = mysql_result($result, 0, 'Auto_increment');
			}
		}
	    $tixian_status=array('0'=>'未提现','1'=>'提现中');
        $duihuan_status=array('0'=>'未兑换','1'=>'兑换中');
        $jihuo_status=array('0'=>'未激活','1'=>'已激活');
        $fxb_status=array('0'=>'禁用','1'=>'可用');
		
		if(ACT=='set' && isset($_POST['sub']) && !isset($_POST['user']['auto_increment'])){
		    $_POST['user']['auto_increment']=$webset['user']['auto_increment'];
		}
	break;
	
	case 'duoduo2010':
	    $role_arr=$duoduo->select_2_field('role','id,title','1=1');
	break;
	
	case 'menu':
	    if(!isset($_POST['sub'])){
		    $node1_arr=$duoduo->select_2_field('menu','id,title','`mod`="" and `act`=""');
		    $node2_arr=array(0=>'无');
            $node_arr=$node2_arr+$node1_arr;
		}
	    
		$hide_arr=array(0=>'显示',1=>'隐藏');
		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$duoduo->delete('menu_access','id="'.$v.'"');
			}
		}
	break;
	
	case 'tuan_goods':
	    $malls=$duoduo->select_2_field(get_mall_table_name(),'id,title','cid="'.$webset['tuan']['mall_cid'].'" and  api_url is not null and api_url<>"" and api_rule<>"" and api_rule is not null order by sort desc');
        $cat=$duoduo->select_2_field('tuan_type');
	break;
	
	case 'shop':
		$shop_type = include (DDROOT . '/data/tao_shop_cid.php');
	break;
	
	case 'article':
		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}
	break;
}
?>