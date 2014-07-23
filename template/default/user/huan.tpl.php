<?php
$parameter=act_user_huan();
extract($parameter);
$css[]=TPLURL."/css/usercss.css";
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
                <div class="admin_xfl">
                    <ul>
                    <li class="admin_xfl_xz"><a>我的兑换商品</a> </li>
                    <li style="float:right; background:none; color:#333; font-weight:bold"><a style="text-decoration:underline" target="_blank" href="<?=u('huan','list')?>">兑换认领</a></li>
                    </ul>
              	</div>
                <div class="admin_table">
                <?php foreach($huan as $r){?>
                   <table width="770" border="0" cellspacing="0" cellpadding="0" class="admin_table_fx">
                      <tr>
                        <td width="105" height="90" align="center"><a target="_blank" href="<?=u('huan','view',array('id'=>$r['huan_goods_id']))?>"><img src="<?=$r['img']?>" alt="<?=$r['title']?>" /></a></td>
                        <td width="665">
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="27" colspan="4"><strong>商品名：</strong><a target="_blank" href="<?=u('huan','view',array('id'=>$r['huan_goods_id']))?>"><?=$r["title"]?></a></td>
                            <td width="18%" height="27"><?=date('Y-m-d H:i:s',$r['addtime'])?></td>
                          </tr>
                          <tr>
                            <td width="16%" height="34"><?php if($r['mode']==1){echo TBMONEY.'：'.jfb_data_type($r["spend"]);}else{echo '积分'.'：'.$r["spend"];}?> </td>
                            <td width="16%">QQ：<?=$r['qq']?></td>
                            <td width="20%">手机：<?=$r['mobile']?></td>
                            <td colspan="2">状态：<?=$huan_status['status'][$r["status"]]?></td>
                          </tr>
                        </table></td>
                      </tr>
                </table>
                <?php }?>
                <?php if($total==0){?>
                    <div style="margin-top:25px; text-align:center">暂无数据</div>
                    <?php }?>
                <div class="megas512" style="clear:both"><?=pageft($total,$pagesize,u(MOD,ACT));?></div>
                </div>
            </div>
    	</div>
  </div>
</div>

<?php
include(TPLPATH."/footer.tpl.php");
?>