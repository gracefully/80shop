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

include(ADMINTPL.'/header.tpl.php');
if($webset['taobao_session']['auto']==1){
	$taobao_session_day=30;
}
else{
	$taobao_session_day=1;
}
$session_time_last=24*3600*$taobao_session_day;
?>
<script>
function countDown(maxtime, fn) {
	maxtime=<?=$session_time_last?>-maxtime;
    var timer = setInterval(function() {
        if (maxtime >= 0) {
		    d=parseInt(maxtime/3600/24);
            h=parseInt((maxtime/3600)%24);
            m=parseInt((maxtime/60)%60);
            s=parseInt(maxtime%60);
            msg = "有效期为"+d+"天"+h + "小时" + m + "分" + s + "秒";
            fn(msg);
            --maxtime;
        } else {
            clearInterval(timer);
            fn("已过期!");
        }
    },1000);
}

function tempData(){
	$.get("index.php?mod=webset&act=center&zsy=<?=round($web_zsy,2);?>&tixian=<?=$tixian_sum?>&usermoney=<?=$need_to_pay?>&usernum=<?=$user_sum?>",function(data){
    	alert('完成复位');
		$('#tempdata li b').html(0);
		$('#tempdata .time').html(data);
    })
}
$(function(){
	$('#setup').jumpBox({  
		height:300,
		width:600,
		contain:$('#mydiv').html()
    });	
})
</script>
<div style="width:100%;">
  <div class="c_left">
	<!--安全监控-->
    <?php if($admin_name=='admin'){?><div class="box_a"><span>安全提示：请及时通过FTP更改后台路径目录"admin"为其他名称。</span></div><?php }?>
    <?php if($install==1){?><div class="box_a"><span>安全提示：请及时通过FTP删除install文件夹。</span></div><?php }?>
    <div class="box_l">
        <div class="c_biaoti" >&nbsp;站务快捷  <span style="font-size:12px; font-weight:normal"><a style="color:#FF6600; cursor:pointer" id="setup" >设置向导 </a></span></div>
        <ul>
		  <li><a href="#">官方便捷：</a></li>
          <li><a href="http://bbs.duoduo123.com/thread-htm-fid-85.html" target="_blank">新手帮助</a></li>
		  <li><a href="http://bbs.duoduo123.com/post.php?fid=96#breadCrumb" target="_blank">提交问题</a></li>
		  <li><a href="http://bbs.duoduo123.com/thread-htm-fid-69.html" target="_blank" style="color:#F30">风向标</a></li>
		  <li><a href="http://bbs.duoduo123.com/thread-htm-fid-64.html" target="_blank">多多黑板报</a></li>
		  <li><a href="http://bbs.duoduo123.com/thread-htm-fid-37.html" target="_blank">发展与建议</a></li>
          <li><a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>" style="color:#F30">集分宝平台</a></li>
          <li><a href="<?=u('plugin','bbx')?>" style="color:#F30">百宝箱平台</a></li>
		</ul>	
		<ul>
		  <li><a href="#">站务便捷：</a></li>
		  <li><a href="<?=u('tradelist','list')?>" >淘宝订单</a></li>
		  <li><a href="<?=u('mall_order','list')?>" >商家订单</a></li>
		  <li><a href="<?=u('user','list')?>" >会员列表</a></li>
		  <li><a href="<?=u('tixian','list')?>" >提现列表</a></li>
		  <li><a href="<?=u('duihuan','list')?>" >兑换记录</a></li>
		  <li><a href="<?=u('article','addedi')?>" >添加文章</a></li>
		</ul>
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;站务处理  </div>
        <ul  style="color:#009900">
          <?php if($checked_trade_num==0 && $wait_see_msg_num==0 && $wait_do_duihuan_num==0 && $wait_do_tixian_num==0 ){?>
		  <li>站内暂时无事务处理！</li>
          <?php }else{?>
              <?php if($checked_trade_num>0){?>
			  <li>有<b class="bignum"><?=$checked_trade_num?></b>条订单未审核！<a href="<?=u('tradelist','list',array('checked'=>1))?>">处理</a></li>
              <?php }?>
              <?php if($wait_see_msg_num>0){?>
			  <li>有<b class="bignum"><?=$wait_see_msg_num?></b>条短信未回复！<a href="<?=u('msg','list')?>" >查看</a></li>
              <?php }?>
              <?php if($wait_do_duihuan_num>0){?>
			  <li>有<b class="bignum"><?=$wait_do_duihuan_num?></b>条兑换未处理！<a href="<?=u('duihuan','list')?>" >处理</a></li>
              <?php }?>
              <?php if($wait_do_tixian_num>0){?>
			  <li>有<b class="bignum"><?=$wait_do_tixian_num?></b>条提现未处理！<a href="<?=u('tixian','list',array('status'=>0))?>">处理</a></li>
              <?php }?>
          <?php }?>
		</ul>		
        <div style="clear:both"></div>
      </div>
      <?php if($webset['taoapi']['cache_monitor']>0){?>
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;监控中心  </div>
        <ol>
        <?php if($webset['taoapi']['cache_monitor']>0){?>
          <li>淘宝缓存文件：<span id="cacheSize">正在读取缓存大小...</span></li>
          <script>
          $.get('../<?=u('ajax','get_size')?>&a=<?=TIME?>',{'dir':'<?=DDROOT?>/data/temp/taoapi'},function(data){
	    $('#cacheSize').html(data+' M');
	});
          </script>
       <?php }?>
       </ol>	
        <div style="clear:both"></div>
      </div>
      <?php }?>
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;时段数据统计&nbsp;&nbsp;&nbsp;<span style="color:#274359; font-weight:normal; color:#333">网站某时间段数据变化 <a href="javascript:tempData();" style="color:#FF0000; text-decoration:none" title="临时统计数据将清空为零">复位</a>  (便于站长监控网站运营状态)</span></div>
        <ul id="tempdata">
		  <li>网站收益：<b style="color:#FF6600"><?=round($web_zsy-$admintempdata['zsy'],2);?></b> 元</li>
		  <li>提现金额：<b style="color:#009900"><?=round($tixian_sum-$admintempdata['tixian'],2)?></b> 元</li>
		  <li>会员资金变动：<b style="color:#FF6600"><?=round($need_to_pay-$admintempdata['usermoney'],2)?></b> 元</li>
		  <li>会员数量：<b style="color:#FF6600"><?=$user_sum-$admintempdata['usernum']?></b> 位</li>
          <li>上次复位时间：<span class="time"><?=date('Y-m-d H:i:s',$admintempdata['time'])?></span></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;网站总数据</div>
        <ul class="shuju">
		  <li>总收益：<b style="color:#FF6600"><?=($web_zsy)?> 元</b></li>
		  <li>预计收益：<b style="color:#FF6600" ><?=round($web_zsy-$need_to_pay-$tixian_sum,2)?> 元</b></li>
		  <li>暂时收益：<b style="color:#FF6600"><?=round($web_zsy-$tixian_sum,2)?> 元</b></li>
		  <li>已支出：<b style="color:#009900"><?=$zhizhu_sum?> 元</b></li>
          <li>还需支出：<b style="color:#009900"><?=$need_to_pay?> 元</b></li>
          <li>已提现：<b style="color:#009900"><?=$tixian_sum?> 元</b></li>
          <li>会员量：<b style="color:#009900"><?=$user_sum?> </b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;淘宝联盟</div>
        <ul class="shuju">
		  <li>总交易额：<b style="color:#FF6600"><?=$tao_goods_sum?> 元</b></li>
		  <li>总收益：<b style="color:#FF6600"><?=$taobao_zsy?> 元</b></li>
		  <li>总交易量：<b style="color:#FF6600"><?=$taobao_tradenum?> 条</b></li>
		  <li>已确认订单：<b style="color:#FF6600"><?=$tradenum_ok?> 条</b></li>
		  <li>未认领订单：<b style="color:#FF6600"><?php echo $taobao_tradenum-$tradenum_ok;?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;拍拍联盟</div>
        <ul class="shuju">
		  <li>总交易额：<b style="color:#FF6600"><?=$pai_goods_sum?> 元</b></li>
		  <li>总收益：<b style="color:#FF6600"><?=$paipai_zsy?> 元</b></li>
		  <li>总交易量：<b style="color:#FF6600"><?=$paipai_tradenum?> 条</b></li>
		  <li>已确认订单：<b style="color:#FF6600"><?=$paipai_tradenum_ok?> 条</b></li>
		  <li>未认领订单：<b style="color:#FF6600"><?php echo $paipai_tradenum-$paipai_tradenum_ok;?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;其他联盟</div>
        <ul>
		  <li>总交易额：<b style="color:#FF6600"><?=$mall_goods_sum?> 元</b></li>
		  <li>总收益：<b style="color:#FF6600"><?=$mall_zsy?> 元</b></li>
		  <li>总交易量：<b style="color:#FF6600"><?=$mall_tradenum?> 条</b></li>
		  <li>有效订单：<b style="color:#FF6600"><?=$mall_order_ok?> 条</b></li>
		  <li>未核对订单：<b style="color:#FF6600"><?=$mall_order_no?> 条</b></li>
          <li>未认领订单：<b style="color:#FF6600"><?=$mall_no_user?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;任务返利</div>
        <ul>
		  <li>总佣金：<b style="color:#FF6600"><?=$taskyj['commission']?> 元</b></li>
		  <li>会员收益：<b style="color:#FF6600"><?=$taskyj['point']?> 元</b></li>
          <li>网站收益：<b style="color:#FF6600"><?=$gamesy?> 元</b></li>
		  <li>总订单：<b style="color:#FF6600"><?=$tasknum?> 条</b></li>
		  <li>确认订单：<b style="color:#FF6600"><?=$tasknum_1?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;游戏返利</div>
        <ul>
		  <li>总佣金：<b style="color:#FF6600"><?=$gameyj['money']?> 元</b></li>
		  <li>会员收益：<b style="color:#FF6600"><?=$gameyj['point']?> 元</b></li>
          <li>网站收益：<b style="color:#FF6600"><?=$tasksy?> 元</b></li>
		  <li>总订单：<b style="color:#FF6600"><?=$gamenum?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;最新操作日志 &nbsp; &nbsp;<a href="<?=u('adminlog','list')?>">更多</a></div>
        <table width="100%" border=1 cellpadding=0 cellspacing=0 style="border-collapse: collapse" bordercolor="#DCEAF7">                
          <tr>
            <td width="11%"  height="30" align="center" bgcolor="#F2F2F2" class="bigtext"><strong>管理员</strong></td>
			<td width="19%" align="center"  bgcolor="#F2F2F2" class="bigtext"><strong>操作IP</strong></td>
            <td width="20%" align="center"  bgcolor="#F2F2F2" class="bigtext"><strong>模块</strong></td>
            <td width="20%" align="center"  bgcolor="#F2F2F2" class="bigtext"><strong>操作</strong></td>
            <td width=""  align="center" bgcolor="#F2F2F2" class="bigtext"><strong>执行时间</strong></td>
          </tr>
          <?php foreach($admin_log as $row){?>
          <tr>
            <td height="30" align="center"><?=$row['admin_name']?></td>
            <td align="center"><?=$row['ip']?></td>
            <td align="center"><?=$row['mod']?></td>
            <td align="center"><?=$row['do']?></td>
            <td align="center"><?=date('Y-m-d H:i:s',$row['addtime'])?></td>
          </tr>
          <?php }?>
        </table>
        <div style="clear:both"></div>
      </div>
  </div>
  <div class="c_right">
    <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;版本信息</td>
            </tr>
            <tr>
              <td colspan="2" valign="top"><span class="left_txt" style="color:#F00; font-weight:bold">&nbsp;<img src="images/ts.gif" width="12" height="12" /> 版本：<span class="banben">V8.2</span>_UTF-8 更新日期：</span> <span class="S3" style="color:#F00; font-weight:bold"><?=BANBEN?></span> <a style="text-decoration:underline" href="<?=u('upgrade','index')?>">检查版本</a>
			    <div style=" margin:5px 10px; clear:both; height:80px; line-height:20px; vertical-align:middle">
			      <iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="80" width="100%" src="http://soft.duoduo123.com/soft_info/update_v8.1.html" ></iframe>
	          </div></td>
            </tr>
          </table>
	 	</div>
        
        <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" ><div style="float:left">&nbsp;风向标信息</div><div style="float:right"><a href="http://bbs.duoduo123.com/thread-htm-fid-69.html" target="_blank" style="font-family:宋体">更多></a>></div></td>
            </tr>
            <tr>
              <td colspan="2" valign="top">
			    <div style=" margin:5px 10px; clear:both; height:80px; line-height:20px; vertical-align:middle">
			      <iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="80" width="100%" src="http://soft.duoduo123.com/soft_info/fxb_v8.1.html" ></iframe>
	          </div></td>
            </tr>
          </table>
	 	</div>
        
        <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;商业授权查询&nbsp;&nbsp;<span style="font-size:12px; font-weight:normal">查询授权唯一域名:duoduo123.com</span> 
             </td>
            </tr>
            <tr>
              <td colspan="2" valign="top" style="padding:3px 10px;"><div align="left" style="line-height:25px;">
              授权网址： <span style="color:#FF0000"><?=$auth_arr['url']?$auth_arr['url']:'本地测试'?></span>&nbsp;&nbsp;<a href="http://auth.duoduo123.com/ckurl.php?url=<?=iconv('utf-8','gbk',urlencode(get_domain()))?>" target="_blank"><img src="images/biz.gif" width="52" height="23" border="0" align="absmiddle" /></a><br/>
              开始时间：<?=date('Y-m-d',$auth_arr['stime'])?>&nbsp;&nbsp;到期时间：<?=$auth_arr['etime']>=2143123200?'终生授权':date('Y-m-d',$auth_arr['etime'])?> <a href="<?=u(MOD,ACT,array('duoduoauthget'=>'1'))?>"><img src="images/to.gif"  alt="重新获取" border="0" align="absmiddle" /></a><br/>
              <?php if($auth_arr['type']==2){?>
              <span style="line-height:25px;">客服经理：<?=$auth_arr['kefu_name']?></span> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?=$auth_arr['kefu']?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?=$auth_arr['kefu']?>:46" title="<?=$auth_arr['kefu_name']?>"></a>
              <?php }elseif($auth_arr['type']==1){?>
              购买授权，<a href="http://auth.duoduo123.com" target="_blank" style="text-decoration:underline; color:#F00">购买地址</a>
              <?php }elseif((int)$auth_arr['type']==0){?>
              购买授权，<a href="http://auth.duoduo123.com" target="_blank" style="text-decoration:underline; color:#F00">购买地址</a>
              <?php }?>
              </div></td>
            </tr>
          </table>
	 	</div>
        <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;官方公告</td>
            </tr>
            <tr>
              <td colspan="2" valign="top" style="padding:3px 10px;">
	 <iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="166" width="100%" src="http://soft.duoduo123.com/soft_info/gonggao.html" ></iframe>	  
			  </td>
            </tr>
          </table>
		</div>
      <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;站长推荐</td>
            </tr>
            <tr>
              <td colspan="2" valign="top" style="padding:3px 10px;">
<iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="166" width="100%" src="http://soft.duoduo123.com/soft_info/ad.html" ></iframe>			  
			  </td>
            </tr>
          </table>
		</div>
  </div>
</div>  
<style>
#mydiv p{ margin:0}
.admin_dui{ font-size:12px; color:#060}
</style>
<div id="mydiv" style="display:none; ">
<div  style="font-size:14px; color:#666666; font-family:'宋体'; margin-top:15px;">
<p>首先更改后台路径admin、删除install目录及文件。</p>
<p>第一步：网站基本设置：将网站名称，logo，通信密钥等设置完成。 <a href="<?=u('webset','set')?>">设置&gt;&gt;</a></p>
<p>第二步：淘宝设置：将淘宝相关设置及淘点金设置完成。 <a href="<?=u('tradelist','set')?>">设置&gt;&gt;</a></p>
<p>第三步：联盟设置：实现B2C商城返利必要步骤。 <a href="<?=u('mall','set')?>">设置&gt;&gt;</a></p>
<p>第四步：公告、帮助信息、及文章添加。 <a href="<?=u('article','list')?>">添加&gt;&gt;</a></p>
<p>第五步：首页幻灯片设置：将首页幻灯片设置为自己想要的图片和链接。 <a href="<?=u('slides','list')?>">设置&gt;&gt;</a></p>
<p>第六步：站点广告设置：位置和大小可参考模板，如果不需要可全部清空。 <a href="<?=u('ad','list')?>">设置&gt;&gt;</a></p>
<p>第七步：友情链接：增加友情链接。 <a href="<?=u('link','list')?>">设置&gt;&gt;</a></p>
<p>OK，您的网站基本设置完成。其他可按自己需要添加或修改。</p>
</div>
</div> 
<?php include(ADMINTPL.'/footer.tpl.php')?>