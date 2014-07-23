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
$do=$_GET['do']=='default'?'default':'';
$sort_arr=include(DDROOT.'/data/paipai_sort.php');
if($do=='default'){
	$top_nav_name=array(array('id'=>'default_form','name'=>'首页设置'),array('id'=>'paipai_form','name'=>'拍拍设置'),array('id'=>'shai_form','name'=>'晒单设置'));
	$lanmu_arr=array(1=>1,2,3,4,5);
}else{
	$url=DD_YUN_URL.'/?m=api&a=auth_list&type=2&only=1&siteurl='.urlencode(get_domain(URL)).'&key='.md5(DDYUNKEY);
	$goumai_arr=dd_json_decode(dd_get($url),1);
	if(isset($goumai_arr['s']) && $goumai_arr['s']==0){
		$goumai_arr=array();
	}
	$url=DD_YUN_URL.'/?m=api&a=auth_list&type=2&siteurl='.urlencode(get_domain(URL));
	$tpl_arr=dd_json_decode(dd_get($url),1);
}

include(ADMINTPL.'/header.tpl.php');
?>
<?php if(empty($do)){?>
<div class="explain-col">生成静态页面后，更新缓存便可更新首页。
  </div>
<br />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">生成静态页：</td>
    <td>&nbsp;<label><input <?php if($webset['static']['index']['index']==1){?> checked="checked"<?php }?> name="static[index][index]" type="checkbox" value="1"/> 首页</label>&nbsp;<span class="zhushi">（暂时只支持首页）</span></td>
  </tr>
  <tr>
                        <td align="right">选择模版：</td>
                      <td>&nbsp;
                     <select name="MOBAN">
<?php 
$dir = "../template/";  // 文件夹的名称 

if (is_dir($dir)){ 
    if ($dh = opendir($dir)){ 
        while (($file = readdir($dh)) !== false){ 
            if($file!="."&&$file!="..")
			{
				if(MOBAN==$file){
				echo "<option value=".$file." selected>$file</option>";}
				else
				{echo "<option value=".$file.">$file</option>";}
			}
        } 
        closedir($dh); 
    } 
} 
?>     
                          </select></td>
                      </tr>
  <tr>
    <td width="150px" align="right">管理模版：</td>
    <td>
     <div style="width:220px; height:250px; float:left;">
    <div style="padding:10px; padding-bottom:0; width:170px; margin:auto"><a href="<?=u(MOD,ACT,array('do'=>'default'))?>"><img src="images/default.jpg" style="width:170px; height:185px" /></a></div>
    <div style="padding:10px; padding-top:0; text-align:center"><label><br /> 默认模版</label><br/><br/><b style="color:green">系统默认</b>&nbsp;&nbsp;<a href="<?=u(MOD,ACT,array('do'=>'default'))?>">管理</a> </div>
    </div>
    <?php foreach($goumai_arr as $row){ 
		$in=$duoduo->select('plugin','install','code="'.$row['code'].'"');
		$word='已购买';
		if($in==1){ $word='已安装';}
		if(MOBAN==$row['code']){ $word='已选择';}?>
    <div style="width:220px; height:250px; float:left;">
    <div style="padding:10px; padding-bottom:0; width:170px; margin:auto"><a href="<?=u('plugin','admin',array('code'=>$row['code']))?>"><img src="<?=DD_YUN_URL.$row['img']?>" style="width:170px; height:185px" /></a></div>
    <div style="padding:10px; padding-top:0; text-align:center"><label> <br /><?=utf_substr($row['name'],24)?></label><br/><br/><b style="color:green"><?=$word?></b>&nbsp;&nbsp;<a href="<?=u('plugin','admin',array('code'=>$row['code']))?>">管理</a> <a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$row['code']?>">说明</a></div>
    </div>
    <?php }?>
    </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  <tr>
    <td width="150px" align="right">推荐模版：</td>
    <td>
    <?php foreach($tpl_arr as $k=>$row){ if($row['shouquan']==1){ continue;} if($k >6){break;}?>
    <div style="width:220px; height:250px; float:left;">
    <div style="padding:10px; padding-bottom:0; width:170px; margin:auto"><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$row['code']?>"><img src="<?=DD_YUN_URL.$row['img']?>" style="width:170px; height:185px" /></a></div>
    <div style="padding:10px; padding-top:0; text-align:center; margin-top:5px;"><label><?=utf_substr($row['name'],24)?></label><?php if($row['shouquan']==1){?><br/><br/><b style="color:green">已购买</b><?php }else{?><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$row['code']?>"><br/><br/><b style="color:red;">未购买</b></a><?php }?> <a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$row['code']?>">说明</a></div>
    </div>
    <?php }?>
     <div style="width:220px; height:250px; float:left;">
    <div style="padding:10px; padding-bottom:0; width:170px; margin:auto"><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=index&type=2"><img src="../plugin/wap/images/gengduo.png" style="width:170px; height:185px" /></a></div>
  <div style="text-align:center; margin-top:20px;"><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=index&type=2">更多模版</a>&nbsp;&nbsp;<a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=index&type=2">去看看</a></div>
    </div>
    </td>
  </tr>
  </form>
</table>
<?php }else{?>
<div style="display:block" class="from_table" id="default_form">
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
	<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
        <td align="right" width="150">栏目1：</span>
        </td>
        <td >&nbsp;<input style="width:100px"  name="name[jiu]" value="<?=$lanmu['name']['jiu']?>" />&nbsp;排序：<?=select($lanmu_arr,$lanmu['num']['jiu'],'num[jiu]')?> <span class="zhushi">栏目1为九元购，数字越小显示越前</span></td>
      </tr>
      <tr>
        <td align="right" >栏目2：</td>
        <td >&nbsp;<input style="width:100px" name="name[shijiu]" value="<?=$lanmu['name']['shijiu']?>" />&nbsp;排序：<?=select($lanmu_arr,$lanmu['num']['shijiu'],'num[shijiu]')?> <span class="zhushi">栏目2为十九元购，数字越小显示越前</span></td>
      </tr>
       <tr>
        <td align="right" >栏目3：</td>
        <td >&nbsp;<input style="width:100px" name="name[zhidemai]" value="<?=$lanmu['name']['zhidemai']?>" />&nbsp;排序：<?=select($lanmu_arr,$lanmu['num']['zhidemai'],'num[zhidemai]')?> <span class="zhushi">栏目3为值得买，数字越小显示越前</span></td>
      </tr>
       <tr>
        <td align="right" >栏目4：</td>
        <td >&nbsp;<input style="width:100px" name="name[tejia]" value="<?=$lanmu['name']['tejia']?>" />&nbsp;排序：<?=select($lanmu_arr,$lanmu['num']['tejia'],'num[tejia]')?> <span class="zhushi">栏目4为特价促销，数字越小显示越前</span></td>
      </tr>
       <tr>
        <td align="right" >栏目5：</td>
        <td >&nbsp;<input style="width:100px" name="name[zhuanxiang]" value="<?=$lanmu['name']['zhuanxiang']?>" />&nbsp;排序：<?=select($lanmu_arr,$lanmu['num']['zhuanxiang'],'num[zhuanxiang]')?> <span class="zhushi">栏目5为手机专享，数字越小显示越前</span></td>
      </tr>
  <tr>
	<td align="right"></td>
	<td>&nbsp;<input type="submit" name="sub" class="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
</div>
<div class="from_table" id="paipai_form">
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
	<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td align="right" width="150">拍拍默认关键词：</td>
    <td >&nbsp;<input name="paipai[keyWord]" value="<?=$webset['paipai']['keyWord']?>" />&nbsp;<span class="zhushi">必须填写，否则没有默认数据</span></td>
  </tr>
  <tr>
    <td align="right" >拍拍显示商品数量：</td>
    <td >&nbsp;<input name="paipai[pageSize]" value="<?=$webset['paipai']['pageSize']?>" />&nbsp;<span class="zhushi">最多40个</span></td>
  </tr>
  <tr>
    <td align="right" >拍拍排序：</td>
    <td >&nbsp;<?=select($sort_arr,$webset['paipai']['sort'],'paipai[sort]')?>&nbsp;</td>
  </tr>
  <tr>
	<td align="right"></td>
	<td>&nbsp;<input type="submit" name="sub" class="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
</div>
<div class="from_table" id="shai_form">
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
	<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
     
  <tr >
    <td  align="right" width="150">晒单栏目设置：</td>
    <td style="padding-top:3px;">&nbsp;<?php foreach($webset['baobei']['cat'] as $k=>$v){?><input style="width:40px;" name="baobei[cat][<?=$k?>]" value="<?=$v?>"/>&nbsp;<?php }?> <br /><span class="zhushi" style="line-height:20px; height:20px;">&nbsp;注意：只能进行同义词修改，比如“上衣”改成“上装”</span></td>
  </tr>
  <tr>
	<td align="right"></td>
	<td>&nbsp;<input type="submit" name="sub" class="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
</div>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>