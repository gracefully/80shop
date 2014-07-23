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

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$total=$duoduo->count('type',"`title` like '%$q%' and tag='".$mod_tag."'");

//获取栏目列表信息
function getCategoryList($id = 0, $level = 0,$page=0,$frmnum=20) {
	global $duoduo;
	global $mod_tag;
	global $q;
	global $frmnum;
	global $pagesize;
	$category_arr = $duoduo->select_all('type','*','pid="'.$id.'" and tag="'.$mod_tag.'" and title like "%'.$q.'%" order by id asc limit '.$frmnum.','.$pagesize);
	for($lev = 0; $lev < $level; $lev ++) {
		$level_nbsp .= "&nbsp;&nbsp;";
	}
	$level++;
	$level_nbsp .= "<span style=\"font-size:12px;font-family:wingdings\">".$level."</span>";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['title'];
		$category ['sort'] = $category['sort']==DEFAULT_SORT?'——':$category['sort'];
		if($category['sys']==1){
            $tip='title="系统数据，不准删除"  disabled="disabled"';
		}
		else{
		    $tip='';
		}
		echo "
<tr>
  <td><input ".$tip." type='checkbox' name='ids[]' value='".$id."' /></td>
  <td style='text-align:left; padding-left:5px'>" . $level_nbsp . "&nbsp;" . $name . "(cid: $id)</td>
  <td>" . getArticleNumOfCategory ( $id ) . "&nbsp;</td>
  <td class='input' field='sort' w='50' tableid='".$id."' status='a' title='双击编辑'>" . $category ['sort'] . "&nbsp;</td>
  <td><a href='".u(MOD,'addedi',array('id'=>$id,'do'=>'add'))."'>添加子栏目</a> |&nbsp;<a href='".u($mod_tag,'addedi',array('cid'=>$id))."'>添加内容</a> |&nbsp;<a href='".u(MOD,'addedi',array('id'=>$id,'do'=>'edi'))."'>修改栏目</a></td>
</tr> ";
		getCategoryList ( $id, $level );
	}
}

//栏目下数量
function getArticleNumOfCategory($cid) {
	global $duoduo;
	global $mod_tag;
	return $duoduo->count($mod_tag,'cid="'.$cid.'"');
}