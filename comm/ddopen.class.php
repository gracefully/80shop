<?php //多多平台接口
class ddopen{
	public $openname='';
	public $openpwd='';
	public $open_sms_pwd='';
	public $openurl='/api/';
	public $format='json';
	public $mod='jifenbao';
	
	function __construct(){
		$this->openurl=DD_OPEN_URL.$this->openurl;
	}
	
	function ini(){
		$openpwd=get_cookie('ddopenpwd');
		$checksum=get_cookie('checksum');
		$this->openname=get_domain(URL);
		$this->openpwd=md5($openpwd);
		$this->checksum=md5($checksum);
		return 1;
	}
	
	function sms_ini($open_sms_pwd){
		$this->openname=get_domain();
		if($open_sms_pwd==''){
			return 0;
		}
		$this->open_sms_pwd=$open_sms_pwd;
		return 1;
	}
	
	function sms_send($mobile,$content,$msgset_id=0){
		if(is_array($content)){
			$content=json_encode($content);
		}
		$content=base64_encode($content);
		$mod='sms';
		$act='send';
		$parame=array('mod'=>$mod,'act'=>$act,'mobile'=>$mobile,'content'=>$content,'msgset_id'=>$msgset_id,'version'=>2);
		$row=$this->get($parame);
		return $row;
	}
	
	function sms_content_check($content){
		$black_words=dd_get(DD_OPEN_URL.'/data/black_words.txt');
		$black_words=explode(';',$black_words);
		unset($black_words[0]);
		foreach($black_words as $v){
			if(strpos($content,$v)!==false){
				$re=array('s'=>1,'r'=>$v);
				return $re;
			}
		}
		return array('s'=>0);
	}
	
	function pay_jifenbao($alipay,$num,$txid,$realname,$mobile){
		$mod='jifenbao';
		$act='pay';
		$parame=array('mod'=>$mod,'act'=>$act,'alipay'=>$alipay,'num'=>(int)$num,'txid'=>$txid,'url'=>URL,'realname'=>$realname,'mobile'=>$mobile,'version'=>2);
		$row=$this->get($parame);
		return $row;
	}
	
	function cancel_jifenbao($txid){
		$mod='jifenbao';
		$act='cancel';
		$parame=array('mod'=>$mod,'act'=>$act,'txid'=>$txid,'url'=>URL);
		$row=$this->get($parame);
		return $row;
	}
	
	function get_user_info($tag='',$checksum=''){ //send_email发送邮件校验码  send_sms发送手机校验码  from_sms通过校验码获取基本信息  from_pwd为空通过帐号密码获取基本信息
		$mod='user';
		$act='get_info';
		$parame=array('mod'=>$mod,'act'=>$act,'tag'=>$tag,'checksum'=>$checksum,'version'=>2);
		$row=$this->get($parame);
		return $row;
	}
	
	function get_user_sms(){
		$mod='sms';
		$act='get_user_num';
		$parame=array('mod'=>$mod,'act'=>$act);
		$row=$this->get($parame);
		return $row;
	}
	
	function get($parame){
		$parame['openname']=$this->openname;
		if($parame['mod']=='sms'){
			$parame['open_sms_pwd']=$this->open_sms_pwd;
		}
		else{
			if($parame['mod']=='jifenbao' && $parame['act']=='pay'){
				$parame['checksum']=$this->checksum;
			}
			else{
				$parame['openpwd']=$this->openpwd;
			}
		}
		
		$parame['format']=$this->format;
		$parame['client_url']=URL;
		if($parame['mod']=='jifenbao' && $parame['act']=='pay'){
			//echo $url=$this->openurl.'?'.http_build_query($parame);exit;
		}
		
		$url=$this->openurl.'?'.http_build_query($parame);
		//file_put_contents(DDROOT.'/a.txt',$url."\r\n",FILE_APPEND);
		if($this->format=='xml'){
			$row=dd_get_xml($url);
		}
		elseif($this->format=='json'){
			$row=dd_get_json($url);
		}
		return $row;
	}
}
?>