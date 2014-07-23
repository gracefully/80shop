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

//首页控制器
if($webset['static']['index']['random']==1){
	$tao_hot_page=rand(1,5);
	$pai_hot_page=rand(1,5);
	$tuan_start_num=rand(1,5)*5;
	$tao_zhe_page=rand(1,5);
}
else{
	$tao_hot_page=1;
	$pai_hot_page=1;
	$tuan_start_num=0;
	$tao_zhe_page=1;
}

//幻灯片
function dd_slides($duoduo,$num=10,$fileds='img,url,title'){
	$slides=$duoduo->select_all('slides',$fileds,'hide=0 and cid=1 order by sort asc limit 0,'.$num);
	return $slides;
}

//网站前台公告
function dd_article($duoduo,$cid,$num=4,$fileds='id,title'){
	$article=$duoduo->select_all('article',$fileds,'cid="'.$cid.'" and del=0 order by sort asc,id desc limit 0,'.$num);
	return $article;
}

//商城
function dd_mall($duoduo,$num,$fileds='cid,title,id,img,fan'){
	$shangcheng=$duoduo->select_all('mall',$fileds , '1=1 order by sort desc limit '.$num);
	foreach($shangcheng as $i=>$row){
		$row['url']=u('mall','view',array('id'=>$row['id']));
		$row['jump']=u('jump','mall',array('mid'=>$row['id']));
		$shangcheng[$i]=$row;
	}
	return $shangcheng;
}

//淘宝热卖
function dd_index_tao_goods($duoduo,$webset,$dduser,$ddTaoapi,$tao_hot_page,$num){
	
	if(TAOTYPE==1){
		include(DDROOT.'/mod/tao/fun.class.php');
		$dd_tao_class=new dd_tao_class($duoduo);
		$tao_goods=$dd_tao_class->dd_tao_goods(array('num'=>$num));
	}
	else{
		if($webset['taoapi']['goods_show']==0){
			$Tapparams['keyword']=$webset['hotword'][0]; //关键字或栏目ID必填一项
    		$Tapparams['page_size']=$num;
			$Tapparams['outer_code']=$dduser['id'];
			$Tapparams['page_no']=$tao_hot_page;
    		$tao_goods=$ddTaoapi->taobao_tbk_items_get($Tapparams);
		}
		else{
    		include(DDROOT.'/mod/tao/fun.class.php');
			$dd_tao_class=new dd_tao_class($duoduo);
			$tao_goods1=$dd_tao_class->dd_tao_goods(array('num'=>$num));
			$c=count($tao_goods1);
			if($c<$num){
				$Tapparams['keyword']=$webset['hotword'][0]; //关键字或栏目ID必填一项
    			$Tapparams['page_size']=$num-$c;
    			$tao_goods2=$ddTaoapi->taobao_tbk_items_get($Tapparams);
			}
			else{
				$tao_goods2=array();
			}
    		$tao_goods=array_merge($tao_goods1,$tao_goods2);
		}	
		$tao_goods=def('tao_hot_goods',$tao_goods,array('fxbl'=>$webset['fxbl'],'user_level'=>$dduser['level']));
		
		foreach($tao_goods as $k=>$row){
			if(isset($row['num_iid']) && $row['num_iid']!=''){
				$tao_goods[$k]['iid']=$row['num_iid'];
			} 
		}
	}
	return $tao_goods;
}

function dd_paipai($paipai_set,$dduser,$pai_hot_page){
	$paipai=new paipai($dduser,$paipai_set);
	$parame['keyWord']=$paipai_set['keyWord'];
	$parame['pageIndex']=$pai_hot_page;
	$parame['pageSize']=5;
	$paipai_goods=$paipai->cpsCommSearch($parame);
	unset($paipai_goods['total']);
	return $paipai_goods;
}

//大家正在省
function dd_index_dingdan($duoduo,$webset,$dduser,$ddTaoapi,$num=10){
	$num_iids='';
	$dingdaning=$duoduo->select_all('tradelist as a,user as b','a.id,a.item_title,a.num_iid,a.fxje,a.jifenbao,a.pay_price as price,a.commission_rate,a.uid,a.pic_url as img,b.ddusername','a.uid=b.id and a.fxje>0 order by a.id desc limit '.$num);
	if(!empty($dingdaning)){
		foreach($dingdaning as $k=>$row){
    		$dingdaning[$k]['name']=utf_substr($row['ddusername'],2).'***';
			if(!empty($dduser)){
		    	$dingdaning[$k]['commission_rate']=fenduan($row['commission_rate'],$webset['fxbl'],$dduser['level'])*100;
			}
			if($row['jifenbao']==0){
				$dingdaning[$k]['jifenbao']=jfb_data_type($row['fxje']*TBMONEYBL);
			}
			$dingdaning[$k]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
			if($row['img']==''){
				if(strlen($row['num_iid'])>7){
					$num_iids.=$row['num_iid'].',';
				}
			}
		}
		$iids=preg_replace('/,$/','',$num_iids);
		if($iids!=''){
			$a=$ddTaoapi->taobao_tbk_items_detail_get($iids);
			
			if(!isset($a[1])){
				$c[0]=$a;
				$a=$c;
			}
		
			foreach($a as $row){
				$b[(string)$row['num_iid']]=$row['pic_url'];
			}
		}
		
		foreach($dingdaning as $row){
			if($row['img']!=''){
				$b[(string)$row['num_iid']]=$row['img'];
			}
		}

		foreach($dingdaning as $k=>$row){
			$img=$b[(string)$row['num_iid']];
			if($img!=''){
				$dingdaning[$k]['img']=$img;
				if($row['img']==''){
					$data=array('pic_url'=>$img);
					$duoduo->update('tradelist',$data,'id='.$row['id']);
				}
			}
			else{
				unset($dingdaning[$k]);
			}
		}
	}

	if(count($dingdaning)<5){ //数据不足调用默认数据
		$a=dd_get_cache('dingdan','array');
		$b=rand(0,57);
		$c=count($dingdaning);
		for($i=$b;$i<$b+$num-$c-1;$i++){
			$a[$i]['gourl']=u('tao','view',array('iid'=>$a[$i]['num_iid']));
			$a[$i]['jifenbao']=$a[$i]['jifenbao']*TBMONEYBL;
	    	$dingdaning[]=$a[$i];
		}
		$dingdaning=def('dingdaning',$dingdaning);
	}
	
	return $dingdaning;
}

//淘宝打折
function dd_tao_zhe($tao_zhe,$ddTaoapi,$tao_zhe_page,$fxbl,$user_level){	
	$Tapparams['keyword']=$tao_zhe['keyword']; 
	$Tapparams['page_size']=5; 
	$Tapparams['page_no']=$tao_zhe_page;
	$goods=$ddTaoapi->taobao_taobaoke_items_coupon_get($Tapparams);
	$goods=def('tao_zhe_goods',$goods,array('fxbl'=>$fxbl,'user_level'=>$user_level));
	return $goods;
}

//团购商品
function dd_tuan($duoduo,$tuan_start_num,$num){
	$tuan_goods=$duoduo->select_all('tuan_goods as a,mall as b','a.title,a.img,a.price,a.value,a.rebate,a.id,b.fan,b.title as mall_name','a.mall_id=b.id and a.edatetime>"'.TIME.'" and city="全国" order by a.sort asc,a.salt desc limit '.$tuan_start_num.','.$num);
	return $tuan_goods;
}

//热门分享
function dd_baobei($duoduo,$num=5,$fileds='img,title,id,hart'){
	$baobei=$duoduo->select_all('baobei',$fileds,'1=1 order by sort asc,id desc limit '.$num);
	return $baobei;
}

//友情链接
function dd_link($duoduo,$num=30,$type=0,$fileds='id,url,title'){
	if($type==1){$fileds.=',img';}
	$yqlj=$duoduo->select_all('link',$fileds,'type='.$type.' order by sort asc limit '.$num);
	return $yqlj;
}
?>