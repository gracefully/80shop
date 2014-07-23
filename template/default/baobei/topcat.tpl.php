<table class="cat" border="0" >
    <tr>
      <td <?php if($cid==''){?> class="curcat"<?php }?>><a href="<?=u('baobei','list')?>">最新分享</a></td>
      <?php foreach($cat_arr as $k=>$v){?>
      <td <?php if($k==$cid){?> class="curcat"<?php }?>><a href="<?=u('baobei','list',array('cid'=>$k))?>"><?=$v?></a></td>
      <?php }?>
    </tr>
  </table>