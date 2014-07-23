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

if(!defined('INDEX')){
	exit('Access Denied');
}

function tao_item_cat($cid,$ddTaoapi){
	$TaobaokeData=$ddTaoapi->taobao_itemcat_msg($cid);
	$parent_cid=$TaobaokeData['parent_cid'];
	global $shai_cat_id_temp;
	$shai_cat_id_temp=in_tao_cat($parent_cid);
	if($shai_cat_id!=999){
		return false;
	}
	else{
	    tao_item_cat($parent_cid,$ddTaoapi);
	}
}

switch($act){
    case 'check_user':
	    echo $duoduo->check_user($_POST['username'],$_POST['type']);
	break;
	
	case 'check_oldpass':
	    echo $duoduo->check_oldpass($_POST['oldpass'],$_POST['dduserid']);
	break;
	
	case 'check_my_email':
	    $id=$duoduo->check_my_email($_POST['email'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_alipay':
	    $id=$duoduo->check_my_field('alipay',$_POST['alipay'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_tenpay':
	    $id=$duoduo->check_my_field('tenpay',$_POST['tenpay'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_bank_code':
	    $id=$duoduo->check_my_field('bank_code',$_POST['bank_code'],$_POST['bank_code']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_email':
	    echo $duoduo->check_email($_POST['email']);
	break;
	
	case 'check_alipay':
	    echo $duoduo->check_alipay($_POST['alipay']);
	break;
	
	case 'check_captcha':
	    dd_session_start();
	    if($_POST['captcha']==$_SESSION["captcha"]){
	        echo 'true';
	    }
	    else{
	        echo 'false';
	    }
	break;
	
	case 'check_tbnick':
		$tbnick=$_POST['tbnick'];
		$a=get_4_tradeid($tbnick);
		if($a[0]==0){
			echo 'false';
		}
		else{
			echo 'true';
		}
	break;
	
	case 'get_msg':
	    $id = (int)$_GET['id'];
	    if($dduser['id']>0){
			$info=$duoduo->select('msg','uid,senduser,see','id="'.$id.'"');
			if($dduser['id']==$info['uid'] || $dduser['id']==$info['senduser']){
			    if($info['uid']==$dduser['id'] && $info['see']==0){
			        $data=array('see'=>1);
			        $duoduo->update('msg',$data,'id="'.$id.'"');
			    }
	            echo $msg='<p style=" line-height:20px;">'.$duoduo->select('msg','content','id="'.$id.'"',2).'</p>';
			}
			else{
			    $re=dd_json_encode(array('s'=>0,'id'=>10));
		        echo $re;
			}
	    }
		else{
		    $re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;
		}
	break;
	
	case 'userinfo':
	    if($dduser['id']>0){
			if($msgnum==0){ 
	            $msgsrc="<img src=\"template/".MOBAN."/images/msg1.gif\" border=\"0\" alt=\"短消息\" />";
            }else{
	            $msgsrc="<img src=\"template/".MOBAN."/images/msg0.gif\" border=\"0\" alt=\"您有新的短消息\" /> (".$msgnum.")";
            }
			$userinfo=array('name'=>$dduser['name'],'id'=>$dduser['id'],'money'=>$dduser['money'],'jifenbao'=>$dduser['jifenbao'],'jifen'=>$dduser['jifen'],'level'=>$dduser['level'],'msgsrc'=>$msgsrc,'avatar'=>a($dduser['id']));
			$re=array('s'=>1,'user'=>$userinfo);
		    echo dd_json_encode($re);
		}
		else{
		    $re=array('s'=>0);
		    echo dd_json_encode($re);
		}
	break;
	
	case 'mall_comment':
	    if($dduser['id']==''){
			$re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		$comment=reg_content($_GET['comment']);
		$mall_id=(int)$_GET['mall_id'];
		$fen=(int)$_GET['fen'];
		if($mall_id==0 || $fen==0 || $comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		$lasttime=$duoduo->select('mall_comment','addtime',"uid=".$dduser['id']." and mall_id='".$mall_id."'"); //上次评论时间
	    if(TIME-$lasttime<$webset['comment_interval']){
	        $re=dd_json_encode(array('s'=>0,'id'=>33));
		    echo $re;continue;
	    }
		$fen=$fen==0?5:$fen;
		$field_arr=array('mall_id'=>$mall_id,'uid'=>$dduser['id'],'fen'=>$fen,'content'=>$comment,'addtime'=>TIME);
		$duoduo->insert('mall_comment',$field_arr);
		$re=dd_json_encode(array('s'=>1,'id'=>0));
		echo $re;
	break;
	
	case 'getTaoItem':
	    $url=$_GET['url'];
		$admin=$_GET['admin'];
		$is_mobile=$_GET['is_mobile'];
		if(preg_match('/(taobao\.com|tmall\.com)/',$url)!=1){
		    $re=array('s'=>0,'id'=>49);
			echo dd_json_encode($re);continue;
		}
		$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
		$iid=get_tao_id($url,$tao_id_arr); //获取商品id
		if($iid==''){
		    $re=array('s'=>0,'id'=>22);
			echo dd_json_encode($re);continue;
		}
		if($admin==1){ //后台获取商品信息
		    dd_session_start();
			if($_SESSION['ddadmin']['name']==''){
			    echo dd_json_encode($re);continue;
			}
			$dduser['level']=9999; 
		}
		elseif($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		if($webset['share_limit_level']>$dduser['level']){ //验证分享所需等级
		    $re=array('s'=>0,'id'=>21);
			echo dd_json_encode($re);continue;
		}

		$goods=$ddTaoapi->taobao_tbk_items_detail_get($iid);
		if($goods['title']==''){
		    $re=array('s'=>0,'id'=>18);
			echo dd_json_encode($re);continue;
		}
		$nick=$goods['nick'];
		$shop=$ddTaoapi->taobao_tbk_shops_detail_get($nick);
		$goods['user_id']=$shop['user_id'];
		$goods['shop_title']=$shop['shop_title'];
		$goods['logo']=$shop['pic_url'];
		$goods['tao_id']=$iid;
		$re=array('s'=>1,'re'=>$goods);
		echo dd_json_encode($re);
	break;
	
	case 'save_share':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
	    $array=array('title','commission','tao_id','image','comment','cid','click_url','nick','shop_title','user_id','logo');
	    if(get2var($array)==0){
		    $re=array('s'=>0,'id'=>11);
			echo dd_json_encode($re);continue;
		}

		if($trade_id==0){ //订单id为0表示分享
		    if($dduser['level']<$webset['baobei']['share_level']){
			    $re=array('s'=>0,'id'=>21);
			    echo dd_json_encode($re);continue;
		    }
		}
		else{ //表示晒单，验证订单是否是自己的
		    $tao_trade=$duoduo->select('tradelist','num_iid,uid','uid="'.$dduser['id'].'" and num_iid="'.$_GET['tao_id'].'"');
			$tao_id=$tao_trade['num_iid'];
			if($dduser['id']!=$tao_trade['uid']){
			    $re=array('s'=>0,'id'=>42);
			    echo dd_json_encode($re);continue;
			}
		}
		
		if($keywords!=''){
		    $keywords_arr = preg_split('/[\n\r\t\s]+/i', trim($keywords));
		    if(count($keywords_arr)>5){
	            $re=array('s'=>0,'id'=>28);
			    echo dd_json_encode($re);continue;
	        }
		}
		if(str_utf8_mix_word_count($comment)>$webset['baobei']['word_num']){
		    $re=array('s'=>0,'id'=>26);
			echo dd_json_encode($re);continue;
		}
		
		$id=$duoduo->select('baobei','id','uid="'.$dduser['id'].'" and tao_id="'.$tao_id.'"');
		if($id>0){
		    $re=array('s'=>0,'id'=>31);
			echo dd_json_encode($re);continue;
		}
		
		$id=$duoduo->select('baobei_blacklist','id','tao_id="'.$tao_id.'"');
		if($id>0){
		    $re=array('s'=>0,'id'=>56);
			echo dd_json_encode($re);continue;
		}
		
		if($trade_id==0){ //分享积分
		    $jifen=(int)$webset['baobei']['share_jifen'];
			$jifenbao=(float)$webset['baobei']['share_jifenbao'];
			$shijian=5;
		}
		elseif($trade_id>0){  //晒单积分
		    $jifen=(int)$webset['baobei']['shai_jifen'];
			$jifenbao=(float)$webset['baobei']['shai_jifenbao'];
			$shijian=7;
		}

		$comment=reg_content($comment);
		if($comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		
		$field_arr=array('uid'=>$dduser['id'],'tao_id'=>$tao_id,'trade_id'=>$trade_id,'img'=>$image,'title'=>$title,'nick'=>$nick,'price'=>$price,'shop_title'=>$shop_title,'user_id'=>$user_id,'logo'=>$logo,'jifen'=>$jifen,'jifenbao'=>$jifenbao,'cid'=>$cid,'keywords'=>$keywords,'content'=>$comment,'addtime'=>TIME);
		$id=$duoduo->insert('baobei',$field_arr);
		
		if($jifen>0 || $jifenbao>0){
			$user_update=array(array('f'=>'jifen','e'=>'+','v'=>$jifen),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
			$duoduo->update_user_mingxi($user_update,$dduser['id'],$shijian,$id);
		}
		
		$re=array('s'=>1,'r'=>$id);
		echo dd_json_encode($re);
		
	break;
	
	case 'like':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		$baobei_id=intval($_GET['id']);
		$uid=$dduser['id'];
		$baobei_hart_id=$duoduo->select('baobei_hart','id','uid="'.$uid.'" and baobei_id="'.$baobei_id.'"');
		if($baobei_hart_id>0){
		    $re=array('s'=>0,'id'=>30);
			echo dd_json_encode($re);continue;
		}
		$duoduo->update('baobei',array('f'=>'hart','e'=>'+','v'=>1),'id='.$baobei_id);
		$duoduo->insert('baobei_hart',array('baobei_id'=>$baobei_id,'uid'=>$uid,'addtime'=>TIME));
		$baobei_user_id=$duoduo->select('baobei','uid','id="'.$baobei_id.'"');
		
		$user_update=array(array('f'=>'jifen','e'=>'+','v'=>(int)$webset['baobei']['hart_jifen']),array('f'=>'jifenbao','e'=>'+','v'=>(int)$webset['baobei']['hart_jifenbao']),array('f'=>'hart','e'=>'+','v'=>1));
		$duoduo->update_user_mingxi($user_update,$baobei_user_id,16,$baobei_id);
		
		$re=array('s'=>1);
		echo dd_json_encode($re);
	break;
	
	case 'save_share_comment':
	    $comment=$_GET['comment']?htmlspecialchars($_GET['comment']):'';
		$id=$_GET['id']?intval($_GET['id']):0;
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		if($dduser['level']<$webset['baobei']['comment_level']){
			$re=array('s'=>0,'id'=>21);
			echo dd_json_encode($re);continue;
		}
		if($comment==''){
		    $re=array('s'=>0,'id'=>27);
			echo dd_json_encode($re);continue;
		}
		if($id==0){
		    $re=array('s'=>0,'id'=>32);
			echo dd_json_encode($re);continue;
		}
		if(str_utf8_mix_word_count($comment)>$webset['baobei']['comment_word_num']){
		    $re=array('s'=>0,'id'=>26);
			echo dd_json_encode($re);continue;
		}
		$time=$duoduo->select('baobei_comment','addtime','uid="'.$dduser['id'].'" and baobei_id="'.$id.'"');
		if(TIME-$time<$webset['comment_interval']){
		    $re=array('s'=>0,'id'=>33);
			echo dd_json_encode($re);continue;
		}
		$comment=reg_content($comment);
		if($comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		$data=array('baobei_id'=>$id,'uid'=>$dduser['id'],'comment'=>$comment,'addtime'=>TIME);
		$duoduo->insert('baobei_comment',$data);
		$re=array('s'=>1);
		echo dd_json_encode($re);
	break;
	
	case 'huan':
	    $s=1;
		$id=(int)$_GET['id'];
		$realname=htmlspecialchars($_GET['realname']);
		$address=htmlspecialchars($_GET['address']);
		$mode=(int)$_GET['mode'];
		$num=(int)$_GET['num'];
		if($dduser['alipay']!=''){
			$alipay=$dduser['alipay'];
		}else{
			$alipay=$_GET['alipay'];
		}
		if($dduser['mobile']!=''){
			$mobile=$dduser['mobile'];
		}else{
			$mobile=(float)$_GET['mobile'];
		}
		if($dduser['realname']!=''){
			$realname=$dduser['realname'];
		}else{
			$realname=htmlspecialchars($_GET['realname']);
		}
		if($dduser['email']!=''){
			$email=$dduser['email'];
		}else{
			$email=$_GET['email'];
		}
		if($dduser['qq']!=''){
			$qq=$dduser['qq'];
		}else{
			$qq=$_GET['qq'];
		}
		$content=htmlspecialchars($_GET['content']);
		
		if($mobile!=0 && reg_mobile($mobile)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>36));
		    echo $re;continue;
		}
		
		if($email!='' && reg_email($email)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>7));
		    echo $re;continue;
		}
		
		if($aliapy!='' && reg_aliapy($aliapy)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>35));
		    echo $re;continue;
		}
		
		if($qq!='' && reg_qq($qq)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>9));
		    echo $re;continue;
		}
		
		$user_data=array('alipay'=>$alipay,'mobile'=>$mobile,'realname'=>$realname,'qq'=>$qq);
		$duoduo->update('user',$user_data,'id='.$dduser['id']);
		
	    if($dduser['name']==''){  //未登录
		    $re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		if($id==0 || $mode==0){ //缺少必要参数
		    $re=dd_json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		if($dduser['dhstate']==1){  //正在处于兑换状态
		    $re=dd_json_encode(array('s'=>0,'id'=>16));
		    echo $re;continue;
		}
		$huan=$duoduo->select('huan_goods','id,title,num,jifenbao,jifen,auto,array,edate,`limit`','id="'.$id.'" and hide="0"');
		if($huan['num']<$num || $num<=0){ //数量不够
		    $re=dd_json_encode(array('s'=>0,'id'=>66));
		    echo $re;continue;
		}
		elseif($huan['title']==''){ //商品不存在
		    $re=dd_json_encode(array('s'=>0,'id'=>17));
		    echo $re;continue;
		}
		elseif($huan['num']<=0){  //商品已下架
		    $re=dd_json_encode(array('s'=>0,'id'=>18));
		    echo $re;continue;
		}
		elseif($huan['edate']<TIME && $huan['edate']>0){  //商品已到期
		    $re=dd_json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		elseif($huan['sdate']>TIME){  //兑换未开始
		    $re=dd_json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		$code_arr=unserialize($huan['array']);
		if($huan['auto']==1 && (empty($code_arr) || count($code_arr)<$num)){
			$re=dd_json_encode(array('s'=>0,'id'=>66));//数量不够
			echo $re;continue;
		}
			
		if($huan['limit']>0){
			if($huan['limit']<$num){  //兑换受限制
		    	$re=dd_json_encode(array('s'=>0,'id'=>52));
		    	echo $re;continue;
			}

			$sdatetime=strtotime(date('Y-m-d').' 00:00:00');
			$edatetime=strtotime(date('Y-m-d').' 23:59:59');
			$duihuan_num=$duoduo->count('duihuan','uid="'.$dduser['id'].'" and huan_goods_id="'.$id.'" and addtime>="'.$sdatetime.'" and addtime<="'.$edatetime.'"');
			if($duihuan_num>=$huan['limit']){
		    	$re=dd_json_encode(array('s'=>0,'id'=>52));  //兑换受限
		    	echo $re;continue;
			}
		}
		
		if($mode==1){  
		    if($huan['jifenbao']==0){
			    $re=dd_json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_jifenbao']<$huan['jifenbao']*$num){  //金额不足
			    $re=dd_json_encode(array('s'=>0,'id'=>19));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'jifenbao','e'=>'-','v'=>$huan['jifenbao']*$num),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(float)($huan['jifenbao']*$num);
			}
		}
		elseif($mode==2){  
		    if($huan['jifen']==0){
			    $re=dd_json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_jifen']<$huan['jifen']*$num){  //积分不足
			    $re=dd_json_encode(array('s'=>0,'id'=>20));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'jifen','e'=>'-','v'=>$huan['jifen']*$num),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(int)($huan['jifen']*$num);
			}
		}
		else{
		    continue;
		}

	    $info['uid']=$dduser['id'];
	    $info['ip']=get_client_ip();
	    $info['huan_goods_id']=$id;
		$info['spend']=$spend;
	    $info['realname']=$realname;
	    $info['address']=$address;
	    $info['email']=$email;
	    $info['mobile']=$mobile;
	    $info['qq']=$qq;
	    $info['content']=$content;
	    $info['addtime']=TIME;
		$info['num']=$num;
		$info['alipay']=$alipay;
		if($huan['auto']==1){
		    $info['shoptime']=TIME;
	        $info['status']=1;
			unset($data[1]);  //自动发货，不改变会员的兑换状态
		}
		else{
		    $info['shoptime']=0;
	        $info['status']=0;
		}
	    
	    $info['mode']=$mode;
	    $id=$duoduo->insert('duihuan', $info);
		
		if($id>0){
			
			$duoduo->update('user', $data, 'id="'.$dduser['id'].'"');
			
			$user=$duoduo->select('user','mobile,mobile_test','id="'.$dduser['id'].'"');
			$duihuan_data=array('goods_id'=>$huan['id'],'uid'=>$dduser['id'],'email'=>$info['email'],'mobile'=>$huan['mobile'],'jifenbao'=>$huan['jifenbao']*$num,'jifen'=>$huan['jifen']*num,'title'=>$huan['title'],'array'=>$huan['array'],'auto'=>$huan['auto'],'mode'=>$mode,'num'=>$num,'alipay'=>$alipay);
			
			$duihuan_data['mobile']=$mobile;
			$duihuan_data['dh_id']=$id;
			$s=$duoduo->duihuan($duihuan_data,0);
		}
		$re=dd_json_encode(array('s'=>$s,'id'=>0));
		echo $re;
	break;
	
	case 'sign':
	    if($webset['sign']['open']==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>43));
		    echo $re;continue;
		}
		
		$todaytime=strtotime(date('Y-m-d 00:00:00'))+$webset['corrent_time'];
		$webset['sign']['money']=(float)$webset['sign']['money'];
		$webset['sign']['jifenbao']=(float)$webset['sign']['jifenbao'];
		$webset['sign']['jifen']=(float)$webset['sign']['jifen'];
		if($dduser['signtime']<$todaytime){
		    $data=array(array('f'=>'money','e'=>'+','v'=>$webset['sign']['money']),array('f'=>'jifenbao','e'=>'+','v'=>$webset['sign']['jifenbao']),array('f'=>'jifen','e'=>'+','v'=>$webset['sign']['jifen']),array('f'=>'signtime','e'=>'=','v'=>TIME));
		    $duoduo->update('user',$data,'id="'.$dduser['id'].'"');
			$data=array('uid'=>$dduser['id'],'shijian'=>4,'money'=>$webset['sign']['money'],'jifenbao'=>$webset['sign']['jifenbao'],'jifen'=>$webset['sign']['jifen']);
		    $duoduo->mingxi_insert($data);
		    $re=dd_json_encode(array('s'=>1));
		    echo $re;
		}
		else{
			$re=dd_json_encode(array('s'=>0,'id'=>44));
		    echo $re;
		}
	break;
	
	case 'get_size':
	    echo round((directory_size($_GET['dir']) / (1024*1024)), 2);
	break;
	
	case 'goods_comment':
	    if($webset['taoapi']['goods_comment']==0){return;}
	    $comment_url=$_GET['comment_url'];
		$s=dd_get($comment_url);
        $s=str_replace('TB.detailRate = ','',$s);
        $s=trim(iconv("gb2312","utf-8//IGNORE",$s));
        $arr=dd_json_decode($s,1);
		echo dd_json_encode($arr);
	break;
	
	case 'pinyin':
	    $title=$_POST['title'];
		if(!class_exists('pinyin')){include(DDROOT.'/comm/pinyin.class.php');}
		echo $pinyin=fs('pinyin')->re($title);
	break;
	
	case 'tao_cuxiao':
		if(isset($_GET['iid'])){
			$iid=(float)$_GET['iid'];
			echo $ddTaoapi->taobao_ump_promotion_get($iid,'json');
		}
	    elseif(isset($_GET['iids'])){
			$iids=$_GET['iids'];
			$iid_arr=explode(',',$iids);
			$data=array();
			foreach($iid_arr as $iid){
				$iid=(float)$iid;
				if($iid>0){
					$a=$ddTaoapi->taobao_ump_promotion_get($iid,'array');
					if($a['price']>0){
						$data[]=$a;
					}
				}
			}

			echo dd_json_encode($data);
		}
	break;
	
	case 'chanet':
	    dd_session_start();
		if($_SESSION['ddadmin']['name']==''){
			$re=array('err'=>1,'msg'=>'未登录');
			echo dd_json_encode($re);continue;
		}
		$do=$_GET['do'];
        if($do=='get_key'){
            $url=CHANET_GET_KEY_URL."?".$_SERVER['QUERY_STRING'];
	        echo dd_get($url);
		}
	    elseif($do=='get_info'){
		    $url=$_POST['url'];
	        $url=DUODUO_URL.'/getchanet.php?act=chanetid&url='.urlencode($url);
	        echo dd_get($url);
		}
	break;
	
	case 'weiyi':
	    dd_session_start();
		if($_SESSION['ddadmin']['name']==''){
			$re=array('err'=>1,'msg'=>'未登录');
			echo dd_json_encode($re);continue;
		}
		$do=$_GET['do'];
        if($do=='get_info'){
		    $url=$_POST['url'];
	        $url=DUODUO_URL.'/getweiyi.php?act=weiyi&url='.urlencode($url);
	        echo dd_get($url);
		}
	break;
	
	case 'send_mail':
		$email=trim($_GET['email']);
		$title=trim($_GET['title']);
		$content=trim($_GET['content']);
		$content=del_magic_quotes_gpc($content);
		echo mail_send($email, $title, $content);
	break;
	
	case 'get_59miao_mall':
		$sid=(int)$_POST['sid'];
		include(DDROOT.'/comm/59miao.config.php');
		$re=$dd59miao->shops_get(array('sids'=>$sid));
		echo dd_json_encode($re);
	break;
	
	case 'huanqian':
		$money=(float)$_GET['money'];
		$dduser['id']=(int)$dduser['id'];
		if($webset['taoapi']['m2j']==0){
			$re=array('s'=>0,'id'=>999);
		}
		else{
			if($dduser['id']==0){
				$re=array('s'=>0,'id'=>10);
			}
			if($money<=0 || $money>$dduser['live_money']){
				$re=array('s'=>0,'id'=>19);
			}
			else{
				$jifenbao=jfb_data_type($money*TBMONEYBL);
				$jifenbao=data_type($jifenbao/(1+JFB_FEE),TBMONEYTYPE);

				$data=array(array('f'=>'money','e'=>'+','v'=>-$money),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
				$duoduo->update_user_mingxi($data,$dduser['id'],22);
				$re=array('s'=>1);
			}
		}
		echo dd_json_encode($re);
	break;
	
	case 'cron':
		$duoduo->cron();
	break;
	
	case 'ddgoods':
		if(isset($_GET['url'])){
			$iid=(float)get_tao_id($_GET['url']);
		}
		else{
			$iid=$_GET['iid'];
		}
		
		$goods['url']='http://item.taobao.com/item.htm?id='.$iid;
		$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
		$goods['discount_price']=$a['ds_discount_price'];
		$goods['rate']=$a['ds_discount_rate'];
		$goods['img']=$a['ds_img']['src'];
		$goods['iid']=$a['ds_nid'];
		$goods['diqu']=$a['ds_provcity'];
		$goods['price']=$a['ds_reserve_price'];
		$goods['sell']=$a['ds_sell'];
		$goods['title']=$a['ds_title'];
		$goods['user_id']=$a['ds_user_id'];
		$goods['taoke']=$a['ds_taoke'];
		$goods['click_url']=$a['ds_item_click'];
		$goods['baoyou']=$a['ds_postfee']>0?0:1;
		
		$a=$ddTaoapi->taobao_tbk_tdj_get($goods['user_id'],2,1);
		$goods['logo']=$a['ds_img']['src'];
		$goods['shopname']=$a['ds_shopname'];
		$goods['keywords']=$a['ds_vidname'];
		$goods['dsr_mas']=$a['ds_dsr_mas'];
		$goods['dsr_sas']=$a['ds_dsr_sas'];
		$goods['dsr_cas']=$a['ds_dsr_cas'];
		$goods['nick']=$a['ds_nick'];
		if($a['ds_istmall']==1){
			$a['ds_rank']=21;
		}
		$goods['level']=$a['ds_rank'];
		
		echo dd_json_encode($goods);
		
	break;
	
	case 'callback_search':
		$q=$_GET['q'];
		$table_name=get_mall_table_name();
		$mid_arr = $duoduo->select_all($table_name,'title,fan,id,img','title like "%'.$q.'%"');
		if($q==''){
			$mid_arr = array();
		}
		echo dd_json_encode($mid_arr);
	break;
	
	case 'delseelog':
		$index=$_GET['index'];
		del_browsing_history($index);
	break;
	
	case 'get_domain':
		$url=$_GET['url'];
		echo get_domain($url);
	break;
}
$duoduo->close();
unset($duoduo);
unset($ddTaoapi);
unset($webset);
exit;
?>