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

if(isset($_GET['sub']) && $_GET['sub']!=''){
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=20;
	$frmnum=($page-1)*$pagesize;
	
	$ids=$_GET['ids'];
	$do=$_GET['do'];
	
	if($do=='sms'){
		$ddopen=fs('ddopen');
		$ddopen->sms_ini($webset['sms']['pwd']);
		
		if(empty($ids)){
			$users=$duoduo->select_all('user_temp as a,user as b','a.id,b.mobile,b.ddusername','a.id=b.id limit '.$pagesize);
			if(empty($users)){
				jump(u(MOD,'list',array('do'=>$do)),'发送完毕');
			}
		}
		else{
			$id_str=implode(',',$ids);
			$users=$duoduo->select_all('user_temp as a,user as b','a.id,b.mobile,b.ddusername','a.id=b.id and a.id in('.$id_str.')');
		}
		
		foreach($users as $jishu=>$row){
			$temp=$webset['sms']['content'];
			$temp=str_replace('{name}',$row['ddusername'],$temp);
			$re=$ddopen->sms_send($row['mobile'],$temp,1000);
			//$re=array('s'=>1);
			if($re['s']==0){
				$data=array('msg'=>$re['r']);
				$duoduo->update('user_temp',$data,'id='.$row['id']);
				jump(u(MOD,'list'),$re['r'].'<br>手机号码：'.$row['mobile']);
			}
			else{
				$duoduo->delete(MOD,'id='.$row['id']);
			}
		}	
	}
	if(empty($ids)){
		$page++;
		$url=u(MOD,ACT,array('page'=>$page,'do'=>$do,'sub'=>1));
		putInfo('<b style="color:red">已发送会员【'.($jishu+1).'】。。。</b><br/><img src="../images/wait2.gif" /><br/><a href="'.$url.'">如果浏览器没有跳转，请点击这里</a>',$url);
	}
	else{
		jump(-1,'发送完毕');
	}
}
?>