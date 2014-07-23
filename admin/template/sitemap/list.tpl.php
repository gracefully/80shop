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
$top_nav_name=array(array('url'=>u('seo','list'),'name'=>'SEO设置'),array('url'=>u('sitemap','list'),'name'=>'网站地图'),array('url'=>u('seo','arr'),'name'=>'伪静态设置'),array('url'=>u('seo','set'),'name'=>'加密设置'));
include(ADMINTPL.'/header.tpl.php');
?>

<div class="explain-col" style="margin:5px 0 5px 0;">
    <table cellspacing="0" width="600px">
    	<tr>
        	1.第一步点击【采集拍拍】采集拍拍关键词<br />
            2.第二步点击【生成网站地图】生成网站地图<br />
            3.<a target="_blank" href="http://www.baidu.com/#wd=%E5%A6%82%E4%BD%95%E6%8F%90%E4%BA%A4%E7%BD%91%E7%AB%99%E5%9C%B0%E5%9B%BE&rsv_spt=1&issp=1&rsv_bp=0&ie=utf-8&tn=baiduhome_pg&rsv_sug3=16&rsv_sug4=641&rsv_sug1=11&inputT=12094">去搜索引擎提交 </a><br />
            html文件：<?=file_exists(DDROOT.'/sitemap.html')?'<a target="_blank" href="'.SITEURL.'/sitemap.html">'.SITEURL.'/sitemap.html</a>':'请先生成'?><br />
            xml文件：<?=file_exists(DDROOT.'/sitemap.xml')?'<a target="_blank" href="'.SITEURL.'/sitemap.xml">'.SITEURL.'/sitemap.xml</a>':'请先生成'?>
        </tr>
    </table>
</div>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="360px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /><a href="<?=u('sitemap','list',array('do'=>'paicj'))?>" class="link3">【1.采集拍拍】</a>&nbsp;&nbsp;<a href="<?=u('sitemap','list',array('do'=>'jty'))?>" class="link3">【2.生成网站地图】</a><?php if($total > 0){?>&nbsp;&nbsp;<a href="<?=u('sitemap','list',array('do'=>'qingkong'))?>" class="link3">【清空】</a><?php }?></td>
              <td width="" align="right">关键字：<input type="text" name="title" value="<?=$title?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th>拍拍关键词</th>
                      <th>添加日期</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><?=$r["wordName"]?></td>
                        <td><?=$r["addtime"]?></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <!--<div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>-->
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>