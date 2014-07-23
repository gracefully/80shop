<?php
if(TAODATATPL==2){
	$pagesize=30;
}
else{
	$pagesize=27;
}
$parameter=act_shop_list($pagesize);
extract($parameter);
$css[]=TPLURL."/css/shoplist.css";
$js[]="js/md5.js";
$js[]="js/jssdk.js";
include(TPLPATH."/header.tpl.php");
?>
<script>
$(function(){
	var $searchA=$('#searchbox .s-nav a');
	$searchA.attr('class','n');
	$searchA.each(function(i){
		var mod,act,name,value,curMod,curAct;
    	mod = $(this).attr('mod');
		act = $(this).attr('act');
		name = $(this).attr('name');
		value = $(this).attr('value');
	
		if(mod=='tao' && act=='shop'){
			$(this).attr('class','y');
			$('#searchbox .mod').val(mod);
			$('#searchbox .act').val(act);
			$('#searchbox #s-txt').val(value);
			$('#searchbox #s-txt').attr('name',name);
			return false;
		}
	});
});
</script>
<div class="mainbody">
	<div class="mainbody1000">
    	<div class="dpmain biaozhun5">
        	<div class="dpleft">
            	<h2>店铺分类</h2>	
                <?php foreach($tao_shop as $k=>$v){?>
                <ul class="dpfenlei">
               <li<?php if($k==$cid){?> class="current"<?php }?>><a href="<?=u('shop','list',array('cid'=>$k))?>"><?=$v?></a></li>
                </ul>
                <?php }?>
                
            </div>

            <div class="dpright">
            	<div class="dpsearch">
                <form name="form" action="index.php" id="form" onsubmit="if($('#q').val()=='<?=$default_sreach_word?>') $('#q').val('')">
                <div class="dpasearch_1">
                <div class="dpsearch_txt">关键字：<input name="nick" type="text" value="<?php if($q==""){echo $default_sreach_word;}else{echo $q;}?>" onfocus="if(this.value=='<?=$default_sreach_word?>')this.value='';" /> 
                </div>
                
                <input type="hidden" name="mod" value="<?=MOD?>" />
                <input type="hidden" name="act" value="<?=ACT?>" />
                <div class="dpsearch_select">
                    
                      <?=select($tao_level, $start_level,'start_level')?>
                      
                    <p style="font:'Times New Roman', Times, serif; line-height:12px">--</p>
                      <?=select($tao_level, $end_level,'end_level')?>
                   <select name="px" id="px">
				  <option value='0' <?php if ($px == 0) echo "selected"; ?>>信誉排序</option>
				  <option value='1' <?php if ($px == 1) echo "selected"; ?>>从高到低</option>
				  <option value='2' <?php if ($px == 2) echo "selected"; ?>>从低到高</option>
				  </select>
                    
                </div>
                    <div class="dpsearch_input">
                        <input name="type" type="checkbox" value="1" <?php if($type=='1') echo 'checked';?> /><span>商城卖家</span>
                    </div>
                    <div class="dpsearch_tijiao">
                    	<input name="cid" type="hidden" value="<?=$cid?>" /><input name="submit" type="submit" value="" />
                    </div>
                  
                </div>
                </form>
                </div>
            	
                <div class="dppage">
                	<p><b><?=$page?>/<?=ceil($total/$pagesize)?></b> <span><a href="<?=$last_page_url?>">上一页</a></span> <span><a href="<?=$next_page_url?>">下一页</a></span> </p>
                </div>
                <div class="dpshow">
                	<ul>
                    <?php if(TAODATATPL==2){?>
                    <?php foreach($shops as $row){?>
                    <li style=" width:140px; height:200px">
                    <a data-type="1" biz-sellerid="<?=$row['uid']?>" data-tmpl="140x190" data-tmplid="3" data-rd="1" data-style="2" target="_blank" data-border="1" href="#"><?=$row['nick']?></a>
                    </li>
                    <? }?>
                    <?php }else{?>
                    <?php foreach($shops as $row){?>
                       <li>
                    	<div class="dpshowleft">
                            <a target="_blank" class="pointer" <?=tdj_click($row['jump'],$row['uid'],'shop')?>><?=html_img($row["logo"],0,$row["title"],'','','',$row['onerror'])?></a>
                            <div class="dpbutton"><a class="pointer" target="_blank" <?=tdj_click($row['jump'],$row['uid'],'shop')?>>&nbsp;</a></div>
                        </div>
                        <div class="dpshowright">
                            <div class="dpshowbt"><a class="pointer" target="_blank" <?=tdj_click($row['jump'],$row['uid'],'shop')?>><s><?=$row['title']?></s></a></div>
                            
                            <?php if($row['auction_count']>0){?>
                            <div class="dpshowhp">宝贝数量：<?=$row['auction_count']?></div>
                            <?php }else{?>
                            <div class="dpshowhp"></div>
                            <?php }?>
                            <?php if($row['level']>0){?>
                            <div class="dpshowxy"><DIV class=title>信用：</DIV>  <img alt="信用" src="images/level_<?=$row['level']?>.gif" /></div>
                            <?php }elseif($row['created']!=''){?>
                            <div class="dpshowxy"><DIV class=title>创店时间：</DIV>  <?=date('Y-m-d',strtotime($row['created']))?></div>
                            <?php }?>
                            <div class="dpshowdz">最高返：<?=$webset['taoapi']['max_fan']?></div>
                        </div>
                    </li>
                    <?php }?>
                    <?php }?>
                    </ul>
                </div>
                <div style="padding-top:10px;_padding-top:0px"><div class="megas512"><?=pageft($total,$pagesize,$page_url,WJT)?></div></div>
            </div>
            <div style="clear:both"></div>
    	</div>
    </div>
</div>
<?php 
include TPLPATH."/footer.tpl.php";
?>