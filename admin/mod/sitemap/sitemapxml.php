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
$malls=$duoduo->select_all(get_mall_table_name(),'id,title','1');
$paipai=$duoduo->select_all('pai_words','id,wordName','1 order by addtime desc');
$nav=dd_get_cache('nav');
$article=$duoduo->select_all('article','id,title','1');

foreach($nav as $k=>$row){
	if($row['link']==''){
		$nav[$k]['url']=SITEURL.'/index.php';
	}elseif(strpos($row['link'],'http//')){
		$nav[$k]['url']=$row['link'];
	}else{
		$nav[$k]['url']=SITEURL.'/'.u($row['mod'],$row['act']);
	}
}
$zhidemai=$duoduo->select_all('ddzhidemai','*','del="0" order by addtime limit 500');
$jiu=$duoduo->select_all('ddgoods','*','del="0" and code="jiu" order by addtime limit 500');
$shijiu=$duoduo->select_all('ddgoods','*','del="0" and code="shijiu" order by addtime limit 500');
$tejia=$duoduo->select_all('ddgoods','*','del="0" and code="tejia" order by addtime limit 500');
$zhuanxiang=$duoduo->select_all('ddgoods','*','del="0" and code="zhuanxiang" order by addtime limit 500');
?>
<?php 
$xml.= '<?xml version="1.0" encoding="utf-8"?>';
$xml.= '<urlset>';
foreach($nav as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',$row['url']).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>1</priority>';
	$xml.= '</url>';
}
foreach($zhidemai as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('zhidemai','view',array('id'=>$row['id']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.8</priority>';
	$xml.= '</url>';
}
foreach($jiu as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('tao','view',array('iid'=>$row['iid']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.8</priority>';
	$xml.= '</url>';
}
foreach($shijiu as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('tao','view',array('iid'=>$row['iid']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.8</priority>';
	$xml.= '</url>';
}
foreach($tejia as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('tao','view',array('iid'=>$row['iid']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.8</priority>';
	$xml.= '</url>';
}
foreach($zhuanxiang as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('tao','view',array('iid'=>$row['iid']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.8</priority>';
	$xml.= '</url>';
}
foreach($paipai as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('paipai','list',array('q'=>$row['wordName']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.8</priority>';
	$xml.= '</url>';
}
foreach($malls as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('mall','view',array('id'=>$row['id']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.7</priority>';
	$xml.= '</url>';
}
foreach($article as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',SITEURL.'/'.u('article','view',array('id'=>$row['id']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.6</priority>';
	$xml.= '</url>';
}
$xml.= '</urlset>';
return $xml;
?>

