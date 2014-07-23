<?php
$parameter=act_user_confirm();
extract($parameter);
$css[]=TPLURL.'/css/usercss.css';
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="contain" style="padding-left:10px">
    <div class="order">
    <div class="content" style="font-size:12px; height:300px;">
      <form id="form2" name="form2" method="post" action="" onsubmit="return checkForm($(this))"  enctype="multipart/form-data">
        <table width="780" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td height="38" align="left"><div style="border:1px solid #FFCC7F; background-color:#FFFFE5; padding:8px;">
            <?php if(TAOTYPE==1){?>
            注：未结算的订单不显示具体返利详情，请输入订单号进行确认，只要您输入的订单号与系统内的一致，这笔交易您就确认成功了。
            <?php }elseif(TAOTYPE==2){?>
			注：如果您发现系统没有自动返现给您，可能是您购买商品的时候未登录，请输入订单号进行确认，只要您输入的订单号与系统内的一致，这笔交易您就确认成功了。
			<?php }?>
            </div></td>
          </tr>
        </table>
        <?php if($do=='tao'){?>
        <table width="680" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="121" height="35" align="right">商品名称：</td>
            <td height="35" colspan="2" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['item_title'];?></font><input type="hidden" name="id" value="<?php echo $id;?>" /></td>
          </tr>
		  <tr>
                          <td height="35" align="right">淘宝订单编号：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['trade_id'];?></font></td>
                          <td width="350" rowspan="5" align="left">
                          <?php if($webset['taoapi']['trade_check']==1){?>
                          <div id="newPreview" style=" width:348px; height:79px; background:url(images/ddjt.jpg); border:#CCC 1px solid"></div>
                          <p><em style="font-style:normal;" id="ckup_pic"></em><input id="up_pic" name="up_pic" class="required" word='订单截图必须上传' type="file" style="width:236px" /></p>
                          <?php }?>
                          </td>
                        </tr>
                        <tr>
                          <td height="35" align="right">单&nbsp;&nbsp;价：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['pay_price'];?> ( 成交数量：<?php echo $trade['item_num'];?> )</font></td>
                          </tr>
                          <?php if($trade['jifenbao']>0){?>
                        <tr>
                          <td height="35" align="right">返<?=TBMONEY?>：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?=jfb_data_type($trade['jifenbao'])?></font></td>
                          </tr>
                        <?php }?>
                          <td height="35" align="right" id="ckjyh">淘宝订单编号：</td>
                          <td width="239" height="35" align="left">
                          <input name="trade_id" type="text" id="trade_id" class="ddinput required" num='y' style="width:120px;"/></td>
                          </tr>
                        <tr>
                          <td height="35" align="right" id="ckyzm">验证码：</td>
                          <td height="35" align="left"><input name="captcha" type="text" size="10" maxlength="4" class="ddinput required" style="width:80px;" />
                          &nbsp; <?=yzm()?></td>
                          </tr>
                        <tr>
                          <td height="35" align="right">&nbsp;</td>
                          <td height="35" colspan="2" align="left"><div class="img-button "><p><input type="submit" name="sub" value="找回订单" /></p></div></td>
                        </tr>
          </table>
          <?php }elseif($do=='paipai'){?>
        <table width="680" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="121" height="35" align="right">商品名称：</td>
            <td height="35" colspan="2" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['commName'];?></font><input type="hidden" name="id" value="<?php echo $id;?>" /></td>
          </tr>
		  <tr>
                          <td height="35" align="right">拍拍订单号：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['dealId'];?></font></td>
                        </tr>
                        <tr>
                          <td height="35" align="right">成交价：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['careAmount'];?> ( 成交数量：<?php echo $trade['commNum'];?> )</font></td>
                          </tr>
                        <tr>
                          <td height="35" align="right">返现金额：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['fxje'];?></font></td>
                          </tr>
                        <tr>
                          <td height="35" align="right" id="ckjyh">输入拍拍订单号：</td>
                          <td width="239" height="35" align="left">
                          <input name="dealId" type="text" id="dealId" class="ddinput required" num='y' style="width:120px;"/></td>
                          </tr>
                        <tr>
                          <td height="35" align="right" id="ckyzm">验证码：</td>
                          <td height="35" align="left"><input name="captcha" type="text" size="10" maxlength="4" class="ddinput required" style="width:80px;" />
                          &nbsp; <?=yzm()?></td>
                          </tr>
                        <tr>
                          <td height="35" align="right">&nbsp;</td>
                          <td height="35" colspan="2" align="left"><div class="img-button "><p><input type="submit" name="sub" value="找回订单" /></p></div></td>
                        </tr>
          </table>
          <?php }elseif($do=='mall'){?>
          <table width="300" border="0" cellspacing="0" cellpadding="0" style=" margin-left:150px">
          <tr>
                          <td width="121" height="35" align="right">下单商城：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['mall_name'];?></font></td>
                        </tr>
		  <tr>
                          <td height="35" align="right">订单号：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['order_code'];?></font></td>
                        </tr>
                        <tr>
                          <td height="35" align="right">单&nbsp;&nbsp;价：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['item_price'];?> ( 成交数量：<?php echo $trade['item_count'];?> )</font></td>
                          </tr>
                        <tr>
                          <td height="35" align="right">返现金额：</td>
                          <td height="35" align="left">&nbsp;<font color="#dd0000"><?php echo $trade['fxje'];?></font></td>
                          </tr>
                        <tr>
                          <td height="35" align="right" id="ckjyh">输入订单号：</td>
                          <td width="239" height="35" align="left">
                          <input name="order_code" type="text" id="order_code" class="ddinput required" style="width:120px;"/></td>
                          </tr>
                        <tr>
                          <td height="35" align="right" id="ckyzm">验证码：</td>
                          <td height="35" align="left"><input name="captcha" type="text" size="10" maxlength="4" class="ddinput required" style="width:80px;" />
                          &nbsp; <?=yzm()?></td>
                          </tr>
                        <tr>
                          <td height="35" align="right">&nbsp;</td>
                          <td height="35" colspan="2" align="left"><input type="hidden" name="id" value="<?php echo $id;?>" /><div class="img-button"><p><input type="submit" name="sub" value="找回订单" /></p></div></td>
                        </tr>
          </table>
          <?php }?>
        </form>
	  </div>
	</div>
</div>
            </div>
    	</div>
  </div>
</div>
<?php
include(TPLPATH."/footer.tpl.php");
?>