<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

class plugin{
	public $duoduo;
	public $plugin;
	public $table='plugin';
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
		
		$plugin=$this->duoduo->select($this->table,'*','code="'.MY_PLUGIN_CODE.'"');
		$this->plugin=$plugin;
	}
	
	function install($sql){
		$plugin=$this->plugin;
		
		if($plugin['tag']!=''){
			$alias_mod_act_arr=dd_get_cache('alias');
			if(!isset($alias_mod_act_arr[$plugin['mod'].'/'.$plugin['act']])){
				$alias_mod_act_arr[$plugin['mod'].'/'.$plugin['act']]=array($plugin['mod'],$plugin['act']);
				dd_set_cache('alias',$alias_mod_act_arr);
			}
			$nav_id=$this->duoduo->select('nav','id','`mod`="'.$plugin['mod'].'" and `act`="'.$plugin['act'].'"');
			if(!$nav_id){
				$data=array('title'=>$plugin['title'],'tip'=>0,'sort'=>999,'hide'=>0,'type'=>0,'auto'=>0,'target'=>0,'custom'=>'','url'=>'','mod'=>$plugin['mod'],'act'=>$plugin['act'],'tag'=>$plugin['tag'],'addtime'=>TIME,'pid'=>0,'alt'=>'','sys'=>0);
				$this->duoduo->insert('nav',$data);
			}
			$seo_id=$this->duoduo->select('seo','id','`mod`="'.$plugin['mod'].'" and `act`="'.$plugin['act'].'"');
			if(!$seo_id){
				$data=array('title'=>$plugin['title'].' - {WEBNAME}','mod'=>$plugin['mod'],'act'=>$plugin['act'],'keyword'=>$plugin['title'].' - {WEBNAME}','desc'=>$plugin['title'].' - {WEBNAME}','label'=>'{WEBNAME}-网站名称','sys'=>0,'addtime'=>TIME);
				$this->duoduo->insert('seo',$data);
			
				$title=template_parse(str_replace("\'","'",$plugin['title'].' - {WEBNAME}'));
				$keyword=template_parse(str_replace("\'","'",$plugin['keyword'].' - {WEBNAME}'));
				$desc=template_parse(str_replace("\'","'",$plugin['desc'].' - {WEBNAME}'));
	
				$page_title='<title>'.$title."</title> <!--网站标题-->\r\n";
    			$page_title.='<meta name="keywords" content="'.$keyword.'" />'."\r\n";
    			$page_title.='<meta name="description" content="'.$desc.'" />'."\r\n";
				$pagetag=$plugin['mod'].'_'.$plugin['act'];
				create_file(DDROOT.'/data/title/'.$pagetag.'.title.php',$page_title);
			}
			$plugin_tag=dd_get_cache('plugin_tag');
			if(!in_array($plugin['tag'],$plugin_tag)){
				$plugin_tag[]=$plugin['tag'];
			}
			dd_set_cache('plugin_tag',$plugin_tag);
		}
		
		if($plugin['admin_set']==1 && $plugin['mod']!='' && $plugin['act']!=''){
			$data=array('parent_id'=>72,'node'=>'plug','mod'=>$plugin['mod'],'act'=>$plugin['act'],'listorder'=>'0','sort'=>'0','title'=>$plugin['title'],'hide'=>1,'sys'=>0);
			add_menu($data);
		}
		
		if($plugin['search_open']==1){
			$a=dd_get_cache('plugin_nav_search');
			if(empty($a)){
				$a=array();
			}
			$a[$plugin['code']]=array('mod'=>$plugin['mod'],'act'=>$plugin['act'],'name'=>$plugin['search_name'],'value'=>$plugin['search_tip'],'width'=>$plugin['search_width']);
			dd_set_cache('plugin_nav_search',$a);
		}
		else{
			$a=dd_get_cache('plugin_nav_search');
			if(isset($a[$plugin['code']])){
				unset($a[$plugin['code']]);
			}
			dd_set_cache('plugin_nav_search',$a);
		}
		
		if($plugin['need_include']==1){
			$plugin_include=dd_get_cache('plugin_include');
			if(!in_array($plugin['code'],$plugin_include)){
				$plugin_include[]=$plugin['code'];
			}
			dd_set_cache('plugin_include',$plugin_include);
		}
		
		$plugin_set=dd_get_cache('plugin');
		$plugin_set[$plugin['code']]=1;
		dd_set_cache('plugin',$plugin_set);
		
		$plugin_mod_act=dd_get_cache('plugin_mod_act');
		
		$tag=1;
		foreach($plugin_mod_act as $k=>$row){
			if($row['mod']==$plugin['mod'] && $row['act']==$plugin['act']){
				$tag=0;
			}
		}
		if($tag==1){
			$plugin_mod_act[]=array('mod'=>$plugin['mod'],'act'=>$plugin['act']);
			dd_set_cache('plugin_mod_act',$plugin_mod_act);
		}
		
		$data=array('install'=>1,'status'=>1);
		$this->duoduo->update('plugin',$data,'id="'.$plugin['id'].'"');
		
		if($sql!=''){
			$sql_arr=explode(';',$sql);
			foreach($sql_arr as $sql){
				$this->duoduo->query($sql);
			}
		}
	}
	
	function uninstall($sql){
		$plugin=$this->plugin;
		
		if($plugin['tag']!=''){
			$alias_mod_act_arr=dd_get_cache('alias');
			if(isset($alias_mod_act_arr[$plugin['mod'].'/'.$plugin['act']])){
				unset($alias_mod_act_arr[$plugin['mod'].'/'.$plugin['act']]);
				dd_set_cache('alias',$alias_mod_act_arr);
			}
			$nav_id=$this->duoduo->select('nav','id','`mod`="'.$plugin['mod'].'" and `act`="'.$plugin['act'].'"');
			if($nav_id>0){
				$this->duoduo->delete('nav','`mod`="'.$plugin['mod'].'" and `act`="'.$plugin['act'].'"');
			}
			$seo_id=$this->duoduo->select('seo','id','`mod`="'.$plugin['mod'].'" and `act`="'.$plugin['act'].'"');
			if($seo_id>0){
				$this->duoduo->delete('seo','`mod`="'.$plugin['mod'].'" and `act`="'.$plugin['act'].'"');
				$pagetag=$plugin['mod'].'_'.$plugin['act'];
				unlink(DDROOT.'/data/title/'.$pagetag.'.title.php');
			}
			
			$plugin_tag=dd_get_cache('plugin_tag');
			if(in_array($plugin['tag'],$plugin_tag)){
				unset($plugin_tag[$plugin['tag']]);
			}
			dd_set_cache('plugin_tag',$plugin_tag);
		}
		
		if($plugin['admin_set']==1 && $plugin['mod']!='' && $plugin['act']!=''){
			del_menu($plugin['mod'],$plugin['act']);
		}
		
		if($plugin['search_open']==1){
			$a=dd_get_cache('plugin_nav_search');
			unset($a[$plugin['code']]);
			dd_set_cache('plugin_nav_search',$a);
		}
		
		if($plugin['need_include']==1){
			$plugin_include=dd_get_cache('plugin_include');
			foreach($plugin_include as $k=>$v){
				if($v==$plugin['code']) unset($plugin_include[$k]);
			}
			dd_set_cache('plugin_include',$plugin_include);
		}
		
		$plugin_set=dd_get_cache('plugin');
		unset($plugin_set[$plugin['code']]);
		dd_set_cache('plugin',$plugin_set);
		
		$plugin_mod_act=dd_get_cache('plugin_mod_act');
		foreach($plugin_mod_act as $k=>$row){
			if($row['mod']==$plugin['mod'] && $row['act']==$plugin['act']){
				unset($plugin_mod_act[$k]);
			}
		}
		dd_set_cache('plugin_mod_act',$plugin_mod_act);
		
		$data=array('install'=>0,'status'=>0);
		$this->duoduo->update('plugin',$data,'id="'.$plugin['id'].'"');
		
		if($sql!=''){
			$sql_arr=explode(';',$sql);
			foreach($sql_arr as $sql){
				$this->duoduo->query($sql);
			}
		}
	}
}
?>