<?php //短信接口
class sms{
	public $name='';
	public $pwd='';
	public $sms_kind=808; //网关默认808
	public $sms_url='http://61.190.35.51/SmsService/SmsService.asmx';
	public $charset='utf-8';
	
	function md5_16($pwd){
		return substr(md5($pwd),8,16);
	}
	
	function doit($method,$parame=array()){
		switch($method){
			case '/SendEx';
				$parame['LoginName']=$this->name;
				$parame['Password']=$this->md5_16($this->pwd);
				$parame['SmsKind']=$this->sms_kind;
				$parame['ExpSmsId']='';
			break;

			case '/GetBalance';
				$parame['LoginName']=$this->name;
				$parame['Password']=$this->md5_16($this->pwd);
				$parame['SmsKind']=$this->sms_kind;
			break;
			
			case '/SetPassword';
				$parame['LoginName']=$this->name;
				$parame['OldPassword']=$this->md5_16($this->pwd);
			break;
			
			case '/GetBlackWords';
				$parame['SmsKind']=$this->sms_kind;
			break;
			
			case '/SearchBlackWords';
				$parame['SmsKind']=$this->sms_kind;
			break;
		}
		$url=$this->sms_url.$method.'?'.http_build_query($parame);
		return dd_get_xml($url);
	}
	
	function send_ex($sim,$content){
		$method='/SendEx';
		$parame['SendSim']=$sim;
		if($this->charset=='utf-8'){
			$parame['MsgContext']=iconv('utf-8','gbk',$content);
		}
		else{
			$parame['MsgContext']=$content;
		}
		
		return $this->doit($method,$parame);
	}
	
	function get_balance(){
		$method='/GetBalance';
		return $this->doit($method);
	}
	
	function set_password($NewPassword){
		$method='/SetPassword';
		$parame['NewPassword']=$this->md5_16($NewPassword);
		return $this->doit($method,$parame);
	}
	
	function get_black_words(){
		$method='/GetBlackWords';
		return $this->doit($method);
	}
	
	function search_black_words($MsgContext){
		$method='/SearchBlackWords';
		if($this->charset=='utf-8'){
			$parame['MsgContext']=iconv('utf-8','gbk',$MsgContext);
		}
		else{
			$parame['MsgContext']=$MsgContext;
		}
		return $this->doit($method,$parame);
	}
}

function sms_send($name,$pwd,$mobile,$content){
	$sms=fs('sms');
	$sms->name=$name;
	$sms->pwd=$pwd;
	return $sms->send_ex($mobile,$content);
}

function sms_get($name,$pwd){
	$sms=fs('sms');
	$sms->name=$name;
	$sms->pwd=$pwd;
	return $sms->get_balance();
}

function sms_set($name,$pwd,$newpwd){
	$sms=fs('sms');
	$sms->name=$name;
	$sms->pwd=$pwd;
	return $sms->set_password($newpwd);
}

function sms_get_black_words(){
	$sms=fs('sms');
	return $sms->get_black_words();
}

function sms_search_black_words($content){
	$sms=fs('sms');
	return $sms->search_black_words($content);
}

$sms_error=array(-1=>'其他错误',0=>'调用成功',10=>'用户认证失败',11=>'IP 或域名认证失败',12=>'余额不足',13=>'手机号不合格,手机号在黑名单中',14=>'提交的手机号超量',15=>'短信内容含有屏蔽关键字',16=>'由于登录失败超过10 次被临时锁定30 秒');
