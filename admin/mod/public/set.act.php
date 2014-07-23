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

if(!defined('ADMIN')){
	exit('Access Denied');
}

if(isset($_POST['sub']) && $_POST['sub']!=''){
	$webset_field=$duoduo->select_2_field('webset','id,var','1=1');
	
	if(MOD=='template'){
		unset($_POST['sub']);
		$ddgoodslanmu_arr=array('jiu'=>'九元购','shijiu'=>'十九元购','zhidemai'=>'值得买','tejia'=>'天天特价','zhuanxiang'=>'手机专享');
		asort($_POST['num'],SORT_NUMERIC);
		foreach($_POST['num'] as $k =>$v){
			if($_POST['name'][$k]==''){
				jump(-1,'栏目必须设置，不能为空！');
			}
			$_POST['ddgoodslanmu'][$k]=$_POST['name'][$k];
		}
		unset($_POST['name']);
		unset($_POST['num']);
	}
	
	if(MOD=='user'){
		$level_name=$_POST['level_name'];
		$jishu_arr=array();
		foreach($level_name as $v){
			if(in_array($v,$jishu_arr)){
				jump(-1,'会员等级名称不能相同');
			}
			$jishu_arr[]=$v;
		}
		$level_dengji=$_POST['level_dengji'];
		$jishu_arr=array();
		foreach($level_dengji as $v){
			if(in_array($v,$jishu_arr)){
				jump(-1,'会员等级级别不能相同');
			}
			$jishu_arr[]=$v;
		}
	
		for($i=0;$i<4;$i++){
			$level[$level_dengji[$i]]=$level_name[$i];
		}
		$_POST['level']=$level;
	}
	
	if(MOD=='tuiguang' && ACT=='fanli'){
		print_r($_POST);exit;
		$_POST['jifenbl']=round($_POST['jifenbl']/100,2);
		$level_dengji=$_POST['level_dengji'];
		$fxbl=$_POST['fxbl'];
		$mallfxbl=$_POST['mallfxbl'];
		$paipaifxbl=$_POST['paipaifxbl'];
		for($i=0;$i<4;$i++){
			$fxbl_arr[$level_dengji[3-$i]]=round($fxbl[3-$i]/100,2);
			$mallfxbl_arr[$level_dengji[3-$i]]=round($mallfxbl[3-$i]/100,2);
			$paipaifxbl_arr[$level_dengji[3-$i]]=round($paipaifxbl[3-$i]/100,2);
		}
		krsort($fxbl_arr);
		krsort($mallfxbl_arr);
		krsort($paipaifxbl_arr);
		dd_string($fxbl_arr);  //小数在序列化后会产生多位，转化成字符型数据
		dd_string($mallfxbl_arr);
		dd_string($paipaifxbl_arr);
		$_POST['fxbl']=$fxbl_arr;
		$_POST['mallfxbl']=$mallfxbl_arr;
		$_POST['paipaifxbl']=$paipaifxbl_arr;
		
	}
	
	if(MOD=='tradelist'){
		$taodianjin_pid=$_POST['taodianjin_pid'];
		if(!$taodianjin_pid){
			jump(-1,'淘点金代码解析错误');
		}
	}
	$diff_arr=array('level_name','level_dengji','sub');
	$_POST=logout_key($_POST, $diff_arr);
	foreach($_POST as $k=>$v){
		if(MOD=='user' && $k=='user'){
			$ips=str_replace('.','\.',$v['limit_ip']);
			dd_set_cache('user_limit_ip',strtoarray($ips));
			//continue;
		}
		if($k=='user' || $k=='taoapi' || $k=='baobei' || $k=='paipai' || $k=='yiqifaapi' || $k=='wujiumiaoapi' || $k=='ucenter' || $k=='phpwind' || $k=='tixian'){
			$post_arr = $duoduo->webset_part($k,$v);
			foreach($post_arr as $m=>$n){
				$duoduo->set_webset($m,$n);
			}
		}else{
			$duoduo->set_webset($k,$v);
		}
	}
	$duoduo->webset(); //配置缓存
	jump('-1','保存成功');
}
else{
	if(MOD=='tuiguang' && ACT=='fanli'){
		ksort($webset['fxbl']);
		ksort($webset['mallfxbl']);
		ksort($webset['paipaifxbl']);
	}
	if(MOD=='tradelist'){
		$taodianjin_set=file_get_contents(DDROOT.'/comm/tdj_tpl.php');
		$taodianjin_set=str_replace('<?=$webset[\'taodianjin_pid\']?>',$webset['taodianjin_pid'],$taodianjin_set);
		$taodianjin_set=preg_replace('/appkey: "\d+",/','appkey: "",',$taodianjin_set);
		$taodianjin_set=str_replace('<?=$dduser[\'id\']?>','',$taodianjin_set);
		$taodianjin_set=str_replace('<?=SITEURL?>',SITEURL,$taodianjin_set);
	}
	if(MOD=='template'){
		$webset['ddgoodslanmu'];
		$i=1;
		foreach($webset['ddgoodslanmu'] as $k=>$v){
			$lanmu['num'][$k]=$i;
			$lanmu['name'][$k]=$v;
			$i++;
		}
	}
}