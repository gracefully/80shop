<?php
$parameter=act_user_baobei();
extract($parameter);
$css[]=TPLURL."/css/usercss.css";
$css[]='css/qqFace.css';
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright" style="padding-top:10px">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="admin_xfl">
                    <ul>
                    <li id="share"><a href="<?=u('user','baobei',array('do'=>'share'))?>">我分享的宝贝</a> </li>
                    <li id="shai"><a href="<?=u('user','baobei',array('do'=>'shai'))?>">我的晒单宝贝</a> </li>
                    <script>
                    $(function(){
					    $('.admin_xfl li#<?=$do?>').addClass('admin_xfl_xz');
					})
                    </script>
                    </ul>
              	</div>
                <div class="admin_table">
                <?php foreach($baobei as $row){?>
                   <table width="770" border="0" cellspacing="0" cellpadding="0" class="admin_table_fx">
                      <tr>
                        <td width="105" height="90" align="center"><a target="_blank" href="<?=u('baobei','view',array('id'=>$row['id']))?>"><?=html_img($row['img'],3,$row['title'])?></a></td>
                        <td width="665">
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="27" colspan="4"><strong>商品名：</strong><a target="_blank" href="<?=u('baobei','view',array('id'=>$row['id']))?>"><?=$row["title"]?></a></td>
                            <td width="12%" height="27"><span>红心：<?=$row["hart"]?></span></td>
                          </tr>
                          <tr>
                            <td width="16%" height="34">原价：<?=$row["price"]?></td>
                            <td width="12%">点击：<?=$row["hits"]?></td>
                            <td width="15%">类别：<?=$cat_arr[$row["cid"]]?></td>
                            <td colspan="2">标签：<?=$row["keywords"]?></td>
                          </tr>
                        </table></td>
                      </tr>
                </table>
                <?php }?>
                <?php if($total==0){?>
                    <div style="margin-top:25px; text-align:center">暂无数据</div>
                    <?php }?>
                <div class="megas512" style="clear:both"><?=pageft($total,$pagesize,u(MOD,ACT,array('do'=>$do)));?></div>
                </div>
                <div class="admin_botton">
                <div class="admin_botton_back" id="startShare">分享我喜欢的</div>
                <a href="<?=u('user','tradelist')?>"><div class="admin_botton_back">晒买到的宝贝</div></a>
                </div>
            </div>
    	</div>
  </div>
</div>

<?php
include(TPLPATH."/baobei/share.tpl.php");
include(TPLPATH."/footer.tpl.php");
?>