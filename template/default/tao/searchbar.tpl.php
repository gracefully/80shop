<div id="searchbar">
  <div class="searchmain">
      <table border="0">
        <tr>
          <td width="680px" style="padding-left:10px">热门搜索：<?php foreach($webset['hotword'] as $v){?> <a href="<?=u('tao','list',array('cid'=>'','q'=>$v,'list'=>$list,'page'=>1))?>"><?=$v?></a>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#cdcccc">|</span>&nbsp;&nbsp;&nbsp;&nbsp;<?php }?></td>
          <td width="" align="right"><a href="<?=$showpic_list1?>" class="noline"><img src="<?=TPLURL?>/images/list1<?=$list?>.gif" alt="小图片模式"  /></a>&nbsp;<a href="<?=$showpic_list2?>" class="noline"><img src="<?=TPLURL?>/images/list2<?=$list?>.gif" alt="大图片模式"  /></a></td>
        </tr>
      </table>
  </div>
</div>