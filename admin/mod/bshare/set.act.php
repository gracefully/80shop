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

if($_POST['sub']!=''){
    $bindtype=$_POST['bindtype'];
	$do=$_POST['do'];
	$bshare=$_POST['bshare'];
	unset($bshare['pwd2']);
	if($do=='login'){
	    $url = "http://api.bshare.cn/analytics/reguuid.json?email=".rawurlencode($bshare['user'])."&password=".rawurlencode($bshare['pwd'])."&domain=".rawurlencode($bshare['url'])."&source=duoduo";
		$re=file_get_contents($url);
		$arr=json_decode($re,1);
		if(!isset($arr['uuid']) || $arr['uuid']=='' || $arr['secret']==''){
		    jump(-1,$re);
		}
		$bshare['uuid']=$arr['uuid'];
		$bshare['secretKey']=$arr['secret'];
		$style='<div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到豆瓣" class="bshare-douban"></a><a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid='.$bshare['uuid'].'&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>';
		$style=addslashes($style);
		$a['bshare_code']=$style;
		$webset_field=$duoduo->select_2_field('webset','id,var','1=1');
		$a['bshare']=$bshare;
	    foreach($a as $k=>$v){
		    if(is_array($v)){$v=serialize($v);$is_arr=1;}
		    if(in_array($k,$webset_field)){
			    $data=array('val'=>$v);
	            $duoduo->update('webset',$data,'var="'.$k.'"');
		    }
		    else{
			    $data=array('var'=>$k,'val'=>$v);
			    if($is_arr==1){
			        $data['type']=1;
			    }
		        $duoduo->insert('webset',$data);
		    }
	    }
	    $duoduo->webset(); //配置缓存
	    jump(u(MOD,'code'),'保存成功');
	}
}