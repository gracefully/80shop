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
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	unset($_POST['moshi']);
	$edate=$_POST['edate']=(int)strtotime($_POST['edate']);
	$width=(int)$_POST['width'];
	$height=(int)$_POST['height'];
	$tag=trim($_POST['tag']);
	$bgcolor=trim($_POST['bgcolor']);
	if($tag!=''){
		$tid=$duoduo->select('ad','id','tag="'.$tag.'" and id<>"'.$id.'"');
		if($tid>0){
			jump(-1,'广告标识已被占用');
		}
	}
	if($id==0){
		$_POST['addtime']=TIME;
	    $id=$duoduo->insert('ad',$_POST);
		$word='保存成功';
	}
	else{
		$_POST['id']=$_POST['ad_id'];
		unset($_POST['ad_id']);
	    $duoduo->update('ad',$_POST,'id="'.$id.'"');
		$word='修改成功';
	}
	$adtag=$tag!=''?$tag:$id;
	
	if($_POST['content']==''){
		$c='<a target="_blank" ';
		if($_POST['link']!=''){
			$c.='href="'.$_POST['link'].'"';
		}
		$c.='><img src="'.$_POST['img'].'" ';
		if($_POST['height']!=''){
			$c.='height="'.$_POST['height'].'" ';
		}
		if($_POST['width']!=''){
			$c.='width="'.$_POST['width'].'" ';
		}
		$c.='alt="'.$_POST['title'].'" /></a>';
		
		if($_POST['type']==1){
			$js="document.write('".$c."')";
			create_file(DDROOT.'/data/ad/'.$adtag.'.js',$js);
		}
		else{
			$ad_content=$c;
		}
    }
	else{
		if($_POST['type']==1){
			$a=explode("\r\n",$_POST['content']);
			foreach($a as $v){
				$v=preg_replace('#\s+\/\/(.*)#','',$v);
				$v=str_replace('<!--','',$v);
				$js_ad=$js_ad.' '.$v;
			}
			$js='document.write("'.$js_ad.'")';
			create_file(DDROOT.'/data/ad/'.$adtag.'.js',$js);
		}
		else{
			$ad_content=$_POST['content'];
			$ad_content=strtr($ad_content,array('\"'=>'"',"\'"=>"'"));
		}
	}
	
	$data=array('edate'=>$edate,'width'=>$width,'bgcolor'=>$bgcolor,'id'=>$id,'height'=>$height,'img'=>$_POST['img']?1:0,'img_url'=>$_POST['img'],'content'=>$_POST['content']?1:0,);
	if($_POST['type']==2){
		$data['ad_content']=$ad_content;
	}
	dd_set_cache('ad/'.$adtag,$data);
	jump('-2',$word);
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select('ad','*','id="'.$id.'"');
	}
}