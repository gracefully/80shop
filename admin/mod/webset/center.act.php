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

if(file_exists(DDROOT.'/update.php')){?>
<table width="700" border="0" align="center" style="border:#999999 1px solid;color:#FF0000; font-size:12px; padding-left:10px;">
<tr>
<td width="75" height="14"><img src="images/ipsecurity.gif" /></td>
<td width="613" height="26">您好，你的网站还没有升级完整，请点击 &quot;继续升级&quot; 以完成最后一步。<a href="../update.php" style="text-decoration:none; font-weight:bold; "> 继续升级</a><br>如果点击后还无法进入后台，请登录FTP删除根目录内的update.php文件即可！</td>
</tr>
</table>
<?php exit;}?>

<?php

if(file_exists(DDROOT."/kindeditor")){
	if(iswriteable(DDROOT."/kindeditor")==0){
		exit('后台目录没有可写权限，请先设置为可写权限，成功进入后台中心后，可再将后台目录修改权限');
	}
	rename(DDROOT."/kindeditor",DDROOT.'/'.ADMIN_NAME.'/kindeditor');
}

if(file_exists(DDROOT."/data/upload_json.php")){
	unlink(DDROOT.'/'.ADMIN_NAME.'/kindeditor/php/upload_json.php');
	rename(DDROOT."/data/upload_json.php",DDROOT.'/'.ADMIN_NAME.'/kindeditor/php/upload_json.php');
}

if(isset($_GET['zsy'])){
	$_GET['time']=TIME;
	unset($_GET['mod']);
	unset($_GET['act']);
	unset($_GET['go_mod']);
	unset($_GET['go_act']);
	$data['val']=serialize($_GET);
	$duoduo->update('webset',$data,'var="admintempdata"');
	dd_exit(date('Y-m-d H:i:s',TIME));
}

$admin_name=ADMIN_NAME;
$install=0;
$install=file_exists('../install');
$banben=include(DDROOT.'/data/banben.php');

$admin_log=$duoduo->select_all('adminlog','*','1=1 order by id desc limit 5');

//提现总额
$tixian_sum=round($duoduo->sum('tixian','money','type=1 and status=1')/TBMONEYBL,2)+$duoduo->sum('tixian','money','type=2 and status=1');

//兑换总额
$huan_sum=round($duoduo->sum('duihuan','spend','mode=1 and status=1')/TBMONEYBL,2);

//总支出
$zhizhu_sum=$tixian_sum+$huan_sum;

//会员数量
$user_sum=$duoduo->count('user');

//需要支付
$need_to_pay=$duoduo->sum('user','money')+round($duoduo->sum('user','jifenbao')/TBMONEYBL,2);

//淘宝联盟
$tao_goods_sum=$duoduo->sum('tradelist','pay_price');
$taobao_zsy=$duoduo->sum('tradelist','commission');
$taobao_tradenum=$duoduo->count('tradelist');
$tradenum_ok=$duoduo->count('tradelist','checked=2');

//拍拍联盟
$pai_goods_sum=$duoduo->sum('paipai_order','careAmount');
$paipai_zsy=$duoduo->sum('paipai_order','commission');
$paipai_tradenum=$duoduo->count('paipai_order');
$paipai_tradenum_ok=$duoduo->count('paipai_order','checked=2');

//商城联盟
$mall_goods_sum=$duoduo->sum('mall_order','sales','status=1');
$mall_zsy=$duoduo->sum('mall_order','commission','status=1');
$mall_tradenum=$duoduo->count('mall_order');
$mall_order_ok=$duoduo->count('mall_order','status=1');
$mall_order_no=$duoduo->count('mall_order','status=0');
$mall_no_user=$duoduo->count('mall_order','uid=0');

//待审核订单
$checked_trade_num=$duoduo->count('tradelist','checked=1');
//待回复站内信
$wait_see_msg_num=$duoduo->count('msg','see=0 and uid=0');
//待处理兑换
$wait_do_duihuan_num=$duoduo->count('duihuan','status=0');
//待处理体现
$wait_do_tixian_num=$duoduo->count('tixian','status=0');

//游戏返利
$gameyj=$duoduo->sum('gametask','money,point','1');
$gamenum=$duoduo->count('gametask','1');
$gamesy=$gameyj['money']-$gameyj['point'];

//任务返利
$taskyj=$duoduo->sum('task','point,commission','(immediate="1" or immediate="2")');
$tasknum=$duoduo->count('task','1');
$tasknum_1=$duoduo->count('task','(immediate="1" or immediate="2")');
$tasksy=$taskyj['commission']-$taskyj['point'];

$web_zsy=$taobao_zsy+$mall_zsy+$paipai_zsy+$gamesy;

$admintempdata=unserialize($duoduo->select('webset','val','var="admintempdata"'));

//设置向导
if(!defined('DDYUNKEY') || DDYUNKEY=='' || $webset['siteid']=='' ){
	jump(u('webset','set'),'请先设置：通信密钥，站点id 保证网站的正常运行');
}

$ddyunkey=defined('DDYUNKEY')?DDYUNKEY:'';
$url=DD_U_URL.'/?g=Home&m=DdApi&a=getweb&key='.$ddyunkey.'&url='.urlencode(URL);
$ddyun=dd_get_json($url);

if($ddyun['r']=='密钥不对！'){
	jump(u('webset','set'),'通信密钥错误请重新获取下 保证网站的正常运行');
}
if($ddyun['r']['alipay']=='' || $ddyun['r']['realname']==''){
	jump(u('webset','set'),'请先设置：支付宝账号，支付宝名称 便于结算任务返利和游戏返利佣金');
}
if($webset['taodianjin_pid']==''){
	jump(u('tradelist','set'),'请先设置：淘点金 保证网站的正常运行');	
}
$ddmall_id=$duoduo->select('ddmall','id','1');
$mall_id=$duoduo->select('mall','id','1');
if(!defined('DDMALL') ){
	jump(u('mall','set'),'请先设置联盟');
}
if((DDMALL==0 && empty($ddmall_id)) || (DDMALL==1 && empty($mall_id))){
	jump(u('mall','list'),'请先添加商城');
}
?>