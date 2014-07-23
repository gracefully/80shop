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

//部分模块更新数据文件
if(MOD=='nav' || UPDATECACHE==1){
	define('INDEX',1);
	
	$wjt_mod_act_arr=dd_get_cache('wjt');
	$alias_mod_act_arr=dd_get_cache('alias');
	
	$d=array();
	
	/*$page_tag_arr=dd_get_cache('page_tag','array');
	foreach($page_tag_arr as $row){
		$nav_tag=$duoduo->select('nav','`mod`,act,pid,tag','`mod`="'.$row['mod'].'" and act="'.$row['act'].'"');
		if($nav_tag['pid']==0){
			$d[$row['mod'].'/'.$row['act']]=$row['tag'];
		}
	}*/
	
	$a=$duoduo->select_all_key('nav','*','hide="0" and pid=0 order by sort asc','id');
	$b=$duoduo->select_all('nav','*','hide="0" and pid<>0 order by sort asc');

	foreach($a as $i=>$arr){
		if($arr['tag']!=$arr['mod']){
			$d[$arr['mod'].'/'.$arr['act']]=$arr['tag'];
		}

		if ($a[$i]['target'] == 0) {
		    $a[$i]['target'] = "target='_self'";
	    }
	    elseif ($a[$i]['target'] == 1) {
		    $a[$i]['target'] = "target='_blank'";
	    }
		
	    if($a[$i]['url']!=''){
			if($a[$i]['tip']==1){$a[$i]['url']='index.php?mod=jump&act=s8&url='.base64_encode($a[$i]['url']);}
		    $a[$i]['link']=$a[$i]['url'];
	    }
		elseif($a[$i]['mod'] !='' && $a[$i]['act'] !=''){
			if($a[$i]['plugin']==0){
				$a[$i]['link']=u($a[$i]['mod'],$a[$i]['act']);
			}
		    else{
				$a[$i]['link']=p($a[$i]['mod'],$a[$i]['act']);
			} 
			$a[$i]['link']=str_replace(SITEURL.'/','',$a[$i]['link']); //取消绝对地址
	    }
		
		if ($a[$i]['type'] == 0) {
		    $a[$i]['type_img'] = "";
	    }
		elseif ($a[$i]['type'] == 1) {
		    $a[$i]['type_img'] = '<img style="width:32px; height:22px" src="template/'.MOBAN.'/images/newn.gif" alt="new" />';
	    }
		elseif ($a[$i]['type'] == 2) {
		    $a[$i]['type_img'] = '<img style="width:32px; height:22px" src="template/'.MOBAN.'/images/hotn.gif" alt="hot" />';
	    }
	}
	
	foreach($b as $c){
		if ($c['target'] == 0) {
		    $c['target'] = "target='_self'";
	    }
	    elseif ($c['target'] == 1) {
		    $c['target'] = "target='_blank'";
	    }
		
	    if($c['url']!=''){
			if($c['tip']==1){$c['url']='index.php?mod=jump&act=s8&url='.base64_encode($c['url']);}
		    $c['link']=$c['url'];
	    }
		elseif($c['mod'] !='' && $c['act'] !=''){
			if($c['plugin']==0){
				$c['link']=u($c['mod'],$c['act']);
				$c['link']=str_replace(SITEURL.'/','',$c['link']);
			}
		    else{
				$c['link']=p($c['mod'],$c['act']);
			}
	    }
		
		if($c['alt']!=''){
		    $c['alt']='<span>'.$c['alt'].'</span>';
	    }
		else{
			$c['alt']='';
		}
		
		if(isset($a[$c['pid']])){
			$a[$c['pid']]['child'][]=$c;
		}

		if($c['mod']!=$c['tag']){
			$d[$c['mod'].'/'.$c['act']]=$c['tag'];
		}
	}
	
	foreach($a as $row){
		$e[]=$row;
	}

	dd_set_cache('page_tag',$d);
    dd_set_cache('nav',$e);
}
if(MOD=='api' || UPDATECACHE==1){
    $a=$duoduo->select_all('api','*','open="1" order by sort desc');
    dd_set_cache('apps',$a);
	$duoduo->webset();
}
if(MOD=='service' || UPDATECACHE==1){
    $a=$duoduo->select_all('service','code,title,type','1=1 order by sort desc');
    dd_set_cache('kefu',$a);
}
if(MOD=='noword' || UPDATECACHE==1){
	$a=$duoduo->select_2_field('noword','`title`,`replace`','1=1');
    dd_set_cache('no_words',$a);
	$js = "noWordArr=new Array();";
	$i=0;
	foreach($a as $k=>$v){
	   	$js.= "\r\n";
        $js.= "noWordArr[".$i."]='".$k."';";
		$i++;
    }
    create_file(DDROOT.'/data/noWordArr.js',$js);
	$a=$duoduo->select_all('noword','`title_arr`,`replace`','title_arr is not null and title_arr<>""');
	foreach($a as $k=>$row){
		$a[$k]['title_arr']=$row['title_arr']?unserialize($row['title_arr']):'';
	}
	dd_set_cache('no_words3',$a); //替换模式3专用
}
if(MOD=='city' || UPDATECACHE==1){
    $city_sort=$duoduo->select_2_field('city','id,title','hide=0 order by sort desc');
	dd_set_cache('city/city_sort',$city_sort);
		
	$city=$duoduo->select_all('city','id,first_word','hide=0 order by first_word asc');
	$n=0;
	foreach($city as $row){
		$n++;
		$first_word=$row['first_word'];
		$city_word[$first_word][$n] = $row['id'];
	}
	dd_set_cache('city/city_word',$city_word);
}
if(MOD=='tuan_type' || UPDATECACHE==1){
	$tuan_cat=$duoduo->select_3_field('tuan_type','id,title,content','1=1');
	foreach($tuan_cat as $k=>$row){
		$tuan_cat[$k]['content']=explode(',',$tuan_cat[$k]['content']);
	}
	dd_set_cache('tuan_cat',$tuan_cat);
}
if((preg_match('/_type$/',MOD)==1 && MOD!='tuan_type') || UPDATECACHE==1){
	$sql="select id,title,tag from ".BIAOTOU."type order by sort desc";
	$query=$duoduo->query($sql);
	while($row=$duoduo->fetch_array($query)){
	    $type[$row['tag']][$row['id']]=$row['title'];
	}
	$duoduo->free_result($query);
	dd_set_cache('type',$type);
}
if(MOD=='appkey'){
	$duoduo->webset(1);
}
if(MOD=='msgset' || UPDATECACHE==1){
	$a=$duoduo->select_all_key('msgset','id,title,web,web_open,email,email_open,sms,sms_open');
	dd_set_cache('msgset',$a);
}
if(MOD=='ad' || UPDATECACHE==1){
	$a=$duoduo->select_all('ad','*');
	foreach($a as $v){
		$adtag=$v['tag']!=''?$v['tag']:$v['id'];
		if($v['content']==''){
			$c='<a target="_blank" ';
			if($v['link']!=''){
				$c.='href="'.$v['link'].'"';
			}
			$c.='><img src="'.$v['img'].'" ';
			if($v['height']!=''){
				$c.='height="'.$v['height'].'" ';
			}
			if($v['width']!=''){
				$c.='width="'.$v['width'].'" ';
			}
			$c.='alt="'.$v['title'].'" /></a>';
			
			if($v['type']==1){
				$js="document.write('".$c."')";
				create_file(DDROOT.'/data/ad/'.$adtag.'.js',$js);
			}
			else{
				$ad_content=$c;
			}
		}
		else{
			if($v['type']==1){
				$a=explode("\r\n",$v['content']);
				foreach($a as $v){
					$v=preg_replace('#\s+\/\/(.*)#','',$v);
					$v=str_replace('<!--','',$v);
					$js_ad=$js_ad.' '.$v;
				}
				$js='document.write("'.$js_ad.'")';
				create_file(DDROOT.'/data/ad/'.$adtag.'.js',$js);
			}
			else{
				$ad_content=$v['content'];
				$ad_content=strtr($ad_content,array('\"'=>'"',"\'"=>"'"));
			}
		}
		
		$data=array('edate'=>$v['edate'],'width'=>$v['width'],'bgcolor'=>$v['bgcolor'],'id'=>$v['id'],'height'=>$v['height'],'img'=>$v['img']?1:0,'img_url'=>$v['img'],'content'=>$v['content']?1:0,);
		if($v['type']==2){
			$data['ad_content']=$ad_content;
		}
		
		dd_set_cache('ad/'.$adtag,$data);
	}
}
?>