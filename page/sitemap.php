<?php //网站地图
define('INDEX',1);

if(!defined('DDROOT')){
	include ('../comm/dd.config.php');
}
$stop=1;
$malls=$duoduo->select_all('mall','id,title','1');
$nav=dd_get_cache('nav');
$article=$duoduo->select_all('article','id,title','1');
$paipai=$duoduo->select_all('pai_words','id,wordName','1 order by addtime desc');
foreach($nav as $k=>$row){
	if($row['link']==''){
		$nav[$k]['url']=SITEURL.'/index.php';
	}elseif(strpos($row['link'],'http//')){
		$nav[$k]['url']=$row['link'];
	}else{
		$nav[$k]['url']=u($row['mod'],$row['act']);
	}
}
$zhidemai=$duoduo->select_all('ddzhidemai','*','del="0" order by addtime limit 500');
$jiu=$duoduo->select_all('ddgoods','*','del="0" and code="jiu" order by addtime limit 500');
$shijiu=$duoduo->select_all('ddgoods','*','del="0" and code="shijiu" order by addtime limit 500');
$tejia=$duoduo->select_all('ddgoods','*','del="0" and code="tejia" order by addtime limit 500');
$zhuanxiang=$duoduo->select_all('ddgoods','*','del="0" and code="zhuanxiang" order by addtime limit 500');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style> 
html{margin:0;padding:0;border:0;}body,h2,h3,ul,li{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline;}a img{border:none;}:focus{outline:0;}html{font-size:100.01%;}body{font-size:75%;color:#222;background:#fff;font-family:"Helvetica Neue",Arial,Helvetica,sans-serif;}h1,h2,h3,h4,h5,h6{font-weight:normal;color:#111;}h1{font-size:3em;line-height:1;margin-bottom:.5em;}h2{font-size:2em;margin-bottom:.75em;}h3{font-size:1.5em;line-height:1;margin-bottom:1em;}li ul,li ol{margin:0;}ul,ol{margin:0;padding:0;}ul{list-style-type:none;}

.sitemap {
    font-size: 12px;
	padding-left: 20px;
}

.sitemap h2 {
    border-bottom: 1px dotted #DDDDDD;
    font-size: 18px;
    line-height: 2.2;
	height:20px;
    margin-bottom: 15px;
}

.sitemap div h3 {
    float: left;
    font-size: 14px;
    font-weight: bolder;
    width: 70px;
	padding-top:5px;
	clear:both;
	margin:10px 0px;
}

.sitemap div a {
    color: #333333;
    margin: 4px;
	text-decoration:none
}

.sitemap .tags-guang ul {
    clear: both;
    display: block;
    padding-top: 6px;
}

.sitemap .tags-guang li {
    float: left;
    white-space: nowrap;
    width: auto;
}

.sitemap .tags-guang li a {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #CCCCCC;
    border-radius: 3px 3px 3px 3px;
    color: #666666;
    display: block;
    float: left;
    height: 20px;
    line-height: 20px;
    max-width: auto;
    padding: 0 3px;
}

.sitemap .tags-guang li a:hover {
    border: 1px solid #999999;
	
}
.clearfix:after,.container:after{content:"\0020";display:block;height:0;clear:both;visibility:hidden;overflow:hidden;}.clearfix,.container{display:block;}.clear{clear:both;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站地图</title>
</head>

<body>
<div class="container" style="padding: 10px 10px;background:#fff; box-shadow: 0 1px 3px #E1E1E1; width:960px; height:auto; margin:auto">
	<div id="content" class="span-24">
        <div class="sitemap">
            <h2>网站地图</h2>
            <div class="clearfix">
                <h3>主导航</h3><!--调用导航数据 包括隐藏和显示的-->
                    <div class="clear"></div>
                    <ul class="tags-guang">
                    <?php foreach($nav as $row){?>
                        <li><a title="<?=$row['title']?>" href="<?=$row['link']?SITEURL.'/'.$row['link']:u($row['mod'],$row['act'])?>" target="_blank" ><?=$row['title']?></a></li>
                        <?php foreach($row['child'] as $r){?>
                            <li><a title="<?=$r['title']?>" href="<?=$row['link']?SITEURL.'/'.$row['link']:u($row['mod'],$row['act'])?>" target="_blank" ><?=$r['title']?></a></li>
                            <?php }?>
                    <?php }?>
                    </ul>
            </div>
             <div class="clearfix">
                <h3>值得买</h3>
                <div class="clear"></div>
                 <ul class="tags-guang">
					 <?php foreach($zhidemai as $row){?>
                            <li><a title="<?=$row['title']?>" href="<?=u('zhidemai','view',array('id'=>$row['id']))?>" target="_blank" ><?=$row['title']?></a></li>
                     <?php }?>
                 </ul>
            </div>
            <div class="clearfix">
                <h3>9.9包邮</h3>
                <div class="clear"></div>
                 <ul class="tags-guang">
					 <?php foreach($jiu as $row){?>
                            <li><a title="<?=$row['title']?>" href="<?=u('tao','view',array('iid'=>$row['iid']))?>" target="_blank" ><?=$row['title']?></a></li>
                     <?php }?>
                 </ul>
            </div>
             <div class="clearfix">
                <h3>19.9包邮</h3>
                <div class="clear"></div>
                 <ul class="tags-guang">
					 <?php foreach($shijiu as $row){?>
                            <li><a title="<?=$row['title']?>" href="<?=u('tao','view',array('iid'=>$row['iid']))?>" target="_blank" ><?=$row['title']?></a></li>
                     <?php }?>
                 </ul>
            </div>
             <div class="clearfix">
                <h3>特价促销</h3>
                <div class="clear"></div>
                 <ul class="tags-guang">
					 <?php foreach($tejia as $row){?>
                            <li><a title="<?=$row['title']?>" href="<?=u('tao','view',array('iid'=>$row['iid']))?>" target="_blank" ><?=$row['title']?></a></li>
                     <?php }?>
                 </ul>
            </div>
             <div class="clearfix">
                <h3>手机专享</h3>
                <div class="clear"></div>
                 <ul class="tags-guang">
					 <?php foreach($zhuanxiang as $row){?>
                            <li><a title="<?=$row['title']?>" href="<?=u('tao','view',array('iid'=>$row['iid']))?>" target="_blank" ><?=$row['title']?></a></li>
                     <?php }?>
                 </ul>
            </div>
            <div class="clearfix">
                <h3>拍拍返利</h3><!--调用拍拍列表数据-->
                <div class="clear"></div>
                 <ul class="tags-guang">
					 <?php foreach($paipai as $row){?>
                            <li><a title="<?=$row['wordName']?>" href="<?=u('paipai','list',array('q'=>$row['wordName']))?>" target="_blank" ><?=$row['wordName']?></a></li>
                     <?php }?>
                 </ul>
            </div>
            <div class="clearfix">
                <h3>商城返利</h3><!--调用商城列表数据-->
                <div class="clear"></div>
                 <ul class="tags-guang">
					 <?php foreach($malls as $row){?>
                            <li><a title="<?=$row['title']?>" href="<?=u('mall','view',array('id'=>$row['id']))?>" target="_blank" ><?=$row['title']?></a></li>
                     <?php }?>
                 </ul>
            </div>
            <div class="clearfix">
                <h3>站长文章</h3><!--调用文章列表数据-->
                     <div class="clear"></div>
                    <ul class="tags-guang">
                    	<?php foreach($article as $row){?>
                        <li><a title="<?=$row['title']?>" href="<?=u('article','view',array('id'=>$row['id']))?>" target="_blank" ><?=$row['title']?></a></li>
                        <?php }?>
                    </ul>
            </div>
        </div>    		
    </div>
</div>
</body>
</html>
