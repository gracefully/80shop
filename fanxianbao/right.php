<?php
include('header.php');
$css[]="fanxianbao/css/fanxianbao.css";
include(TPLPATH."/header.tpl.php");
?>
<div style="width:1000px; background:#FFF; border:#D0210C 1px solid; margin:auto; margin-top:10px; padding-bottom:10px">
<div style="height:5px; clear:both"></div>
<div class="select_fan">
<ul>
<li><a class="cur" href="fanxianbao/index.php"><h2>右键版</h2><span>(适用：IE内核，360安全浏览器，世界之窗等)</span><b>下载安装，无需登录，一键返利！</b></a></li>
<li><a class="normal" href="fanxianbao/favorites.php"><h2>收藏版</h2><span>适用：所有浏览器，360急速浏览器，Firefox，Chrome，Opera等</span><b>只需收藏，安全方便，一键返利！</b></a></li>
</ul>
</div>
<form id="form" name="form" method="get" action="fanxianbao/download.php" target="_blank">
<div id="main" style="width:946px;margin: 0 auto;"><div style="margin-top:8px;width:947px;">
      <div class="banner">
            <div class="attribute">
                      <ul>
                          <li>软件版本：V2.0正式版</Li>
                      <li>软件大小：0.2 KB</li>
                          <li>更新日期：2011-07-07</li>
                      </ul>
            </div>
             <div class="user_input">
                 <input name="username" type="text" class="input_text" id="username" <?php if($dduser["name"]==''){echo "value=\"输入您的用户名\"";}else{echo "value=".$dduser["name"]."";}?> onfocus="if (this.value=='输入您的用户名') this.value='';" onblur="if (this.value=='') this.value='输入您的用户名'" />
            </div>
            <div class="user_smt">
            <input type="submit" class="input_smt" value=" " />
            </div>
         <input type="hidden" name="checkok" value="0" />
      </div>
  	  <div class="help">
         <div class="top"></div>
         <div class="bg">
                <table width="885" height="18" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><div class="question">
                                  <ul>
                                    <li>A1  <a href="#step1">什么是返现宝？</a></li>
                                      <li>A2  <a href="#step2">如何安装返现宝？</a></li>
                                      <li>A3  <a href="#step3">如何使用返现宝？</a></li>
                             </ul><div class="clear"></div>
                           </div></td>
                  </tr>
                  <tr>
                    <td><div class="title"><span><a name="step1"></a><a href="#">返回页顶</a><em>↑</em></span>A1  <strong>什么是返现宝？</strong></div></td>
                  </tr>
                  <tr>
                    <td><p>返现宝是专门为淘宝买家设计的一款返现小软件，只要下载安装后，以后所有在淘宝的购物就可以直接通过IE右键方便的查询淘宝网商品的返现信息，傻瓜安装，不占用桌面空间，方便灵活，是买家的必备工具。</p></td>
                  </tr>
                  <tr>
                    <td><div class="title"> <span><a name="step2" id="step2"></a><a href="#">返回页顶</a><em>↑</em></span>A2 <strong>如何安装返现宝？</strong> </div></td>
                  </tr>
                  <tr>
                    <td align="left">1、输入本站账号，点击<span>“立刻下载”</span>按钮绑定并下载即可！<br />
                      <br />
                                    <img src="fanxianbao/img/1.jpg" border="0" /> <br /><br />
                                    
                                    2、解压对应账号的压缩包如：51fanmi.rar 并双击fanxianbao.reg 。
                                <br />
                            <img src="fanxianbao/img/2.jpg" /> &nbsp;&nbsp;&nbsp;<img src="fanxianbao/img/3.jpg" /><br />
                            <br />3、出现以下画面，并选择&quot;是&quot;（注：添加的信息将不会影响注册表内容！）<br />
                            <img src="fanxianbao/img/4.jpg" /><br /><br /><img src="fanxianbao/img/5.jpg" />
                                <br /><br />
                                 4、<strong>安装完成，必须重新打开浏览器</strong>，在页面上点击右键就能够看到 “ <span>返现宝（淘宝返现）</span>” 的选项了。<br /><br /></td>
                  </tr>
                  <tr>
                    <td><div class="title"><span><a name="step3"></a><a href="#">返回页顶</a><em>↑</em></span>A3  <strong>如何使用返现宝？</strong> </div></td>
                  </tr>
                  <tr>
                    <td>1、打开淘宝网找到您要购买的宝贝，选择部分或完整的宝贝名称，点击右键选择 “ 返现宝（淘宝返现）” 如下图所示<br />
                              （注:有链接的宝贝名称直接点击右键选择，没有链接的宝贝名称先选中宝贝名称再点击右键选择！）<br /><br />
                <img src="fanxianbao/img/7.jpg" width="780" height="420" /><br /><br />
                                      2、点击 “ 返现宝（淘宝返现）”后，页面中出现一个浮动窗口，窗口中显示的就是购买此产品可以返现的淘宝商家，选择您喜欢的商家点击“<span>购买拿返现</span>”去购物，就可以拿到返现。<br />
                              <br />
                <img src="fanxianbao/img/6.jpg" width="724" height="471" /></li><br /><br />
                                      3、点击<span>“购买拿返现”</span>后就会新打开一个宝贝的详细页，然后照着淘宝网原来的流程操作购买就可以了。
                <br /><br />
                            4、购买以后，本站会自动跟踪订单，当您确定付款后30分钟内本站会自动返现金给您！您可以登陆本站看下返现情况并进行提现！</td>
                  </tr>
                  <tr>
                    <td><div class="title">
                           <span><a name="step4"></a><a href="#">返回页顶</a><em>↑</em></span>A4  <strong>返现宝如何卸载？</strong></div></td>
                  </tr>
                  <tr>
                    <td>1、点击此处<a href="uninstall.rar" target="_blank" style="color:#FF0000">下载“返现宝”卸载软件</a>，(右键&quot;目标另存为&quot;即可)！
                               <br />
                               <br />2、双击下载好的卸载软件<br /><br />
                                    <img src="fanxianbao/img/9.jpg" width="136" height="94" />
                              <br />
                              <br />3、出现以下画面，并选择是（注：此过程是移出！）<br /><br />
                <img src="fanxianbao/img/8.jpg" width="504" height="135" />
                              <br />
                            <br />4、重启浏览器就可以看到已经移除！</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
         </div>
     </div>
</div>
</div>
</form>
</div>
<?php
include(TPLPATH."/footer.tpl.php");
$duoduo->close();
?>