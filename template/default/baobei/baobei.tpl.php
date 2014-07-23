
<div id="goods_list_img_u">
    <?php for($j=0;$j<4;$j++){?>
    <div id="zhanxian_<?=$j+1?>" class="zhanxian">
        <?php $k=$j+1; for($i=$k;$i<=$cur_baobei_num;$i=$i+4){$m=$i-1;?>
        <div class='zhanxian_list' id="zhanxian_list_<?=$m?>">
          <div>
          <a class="img" target="_blank" href="<?=u('baobei','view',array('id'=>$baobei[$m]['id']))?>"><?=html_img($baobei[$m]['img'],2,$baobei[$m]['title'],'goods_list_img_i',200,'')?></a>        
          <div class="pinglun">
             <div class="pinglun_s pinglun_s1" onclick="like(<?=$baobei[$m]['id']?>,'x_<?=$baobei[$m]['id']?>')" style="cursor:pointer;" title="送红心"></div>
             <div class="pinglun_s pinglun_s2"></div>
             <div class="pinglun_s pinglun_s3" id="x_<?=$baobei[$m]['id']?>"><?=$baobei[$m]['hart']?></div>
             <div class="pinglun_s pinglun_s4"></div>
             <div class="pinglun_s pinglun_s5">
             <a class="pl" style="" target="_blank" href="<?=u('baobei','view',array('id'=>$baobei[$m]['id']))?>#p">评论</a></div>
          </div>
          <div class="pinglun_r"></div>
          
          <div class="name" style=" padding-bottom:5px">
          <div style="width:26px; height:26px; padding-top:8px; float:left; padding-right:5px; overflow:hidden;">
          <a href="<?=u('baobei','user',array('uid'=>$baobei[$m]['uid']))?>">
          <img width="24" alt="<?=$baobei[$m]['ddusername']?>" height="24" style="border:#ffaf9a 1px solid;" src="<?=a($baobei[$m]['uid'],'small')?>" />
          </a>
          </div>
          <div style=" width:150px; height:32px; padding-top:5px; line-height:16px; float:left; overflow:hidden;">
          <span style="font-size:12px; color:#e8876d;">由</span>
          <a style="color:#fe5dad;" href="<?=u('baobei','user',array('uid'=>$baobei[$m]['uid']))?>"><?=$baobei[$m]['ddusername']?></a>
          <span style="font-size:12px; color:#e8876d;">分享</span><br />
          <span style=" color:#d5bba1; font-size:12px;"><?=date('m月d日 H:i',$baobei[$m]['addtime'])?></span>
          </div>
          <div class="comment"><?=$baobei[$m]['content']?>&nbsp;</div>
          </div>
        </div>
        </div>
        <?php }?>
    </div>
    <?php }?>

    </div>
<script>
/*$(function(){
	h=new Array();
	l=new Array();
	h[0]=0;
	for(i=1;i<=4;i++){
		h[i]=$('#zhanxian_'+i).height();
		l[i]=h[i];
		if(h[i]<h[i-1]){
		    temp=h[i-1];
		    h[i-1]=h[i];
		    h[i]=temp;
		}
	}
	for(k=1;k<=4;k++){
	    if(l[k]<h[4]){
		    $('#zhanxian_'+k).append('<div class="zhanxian_list" style=" background:url(<?=TPLURL?>/images/0227.png);height:'+(h[4]-l[k]-10)+'px">&nbsp;</div>');
		}
	}
})*/
</script>
<div class="megas512" style="text-align:center; margin-top:30px;"><?php echo pageft($total,$pagesize,$page_url,WJT);?></div>