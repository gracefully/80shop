<?php
$parameter=act_help_index();
extract($parameter);
$css[]=TPLURL."/css/help.css";
include(TPLPATH.'/header.tpl.php');
?>
<script>
function addBorder(id){
	$('.helpright_help_qa_q').css('border','0px').next('div').css('background','none');
 	$('#'+id).next('div').css('border','#30F 1px solid').next('div').css('background','#FFC');
}
$(function(){
	url=document.location.href;
    $('.helpright_wenti ul li a').click(function(){
		var url=$(this).attr('href');
	    addBorder(url)
	});
});

var DOM = (document.getElementById) ? 1 : 0; 
var NS4 = (document.layers) ? 1 : 0; 
var IE4 = 0; 
if (document.all) { 
	IE4 = 1; 
	DOM = 0; 
} 
var win = window; 
var n = 0; 

function findInPage(str) { 
	var txt, i, found; 
	if (str == "") 
	return false; 
	if (DOM){ 
		win.find(str, false, true); 
		return true; 
	} 
	if (NS4) { 
		if (!win.find(str)) 
			while(win.find(str, false, true)) 
			n++; 
		else 
			n++; 
		if (n == 0) 
		alert("未找到指定内容."); 
	} 
	if (IE4) { 
		txt = win.document.body.createTextRange(); 
		for (i = 0; i <= n && (found = txt.findText(str)) != false; i++) { 
			txt.moveStart("character", 1); 
			txt.moveEnd("textedit"); 
		} 
		if (found) { 
			txt.moveStart("character", -1); 
			txt.findText(str); 
			txt.select(); 
			txt.scrollIntoView(); 
			n++; 
		} 
		else { 
			if (n > 0) { 
			n = 0; 
			findInPage(str); 
		} 
		else 
			alert("未找到指定内容."); 
		} 
	} 
	return false; 
} 
</script>
<div class="mainbody">
	<div class="mainbody1000">
    	<div class="helpmain">
        	<div class="helpleft">
                <div class="helpleft1">
                        <div class="helpmenu">
                        <div class="helpmenu_bt">
                            <div class="helpmenu_bt_font"><div class="shutiao"></div>帮助中心</div>
                            
                        </div>
                        <ul>
                            <li><div class="adminmenu_tixian"></div><div class="adminmenu_a"><a href="<?=u('help','index',array('cid'=>3))?>">返利常见问题</a></div></li>
                            <li><div class="adminmenu_dindan"></div><div class="adminmenu_a"><a href="<?=u('help','index',array('cid'=>4))?>">返利订单问题</a></div></li>
                            <li><div class="adminmenu_fanli"></div><div class="adminmenu_a"><a href="<?=u('help','index',array('cid'=>5))?>">返利提现问题</a></div></li>
                            <li><div class="adminmenu_haoyou"></div><div class="adminmenu_a"><a href="<?=u('help','index',array('cid'=>6))?>">用户常见问题</a></div></li>
                        </ul>
                        </div>
                </div> 	
                <div class="helpleft2">
                		<div class="helpmenu">
                        <div class="helpmenu_bt">
                            <div class="helpmenu_bt_font"><div class="shutiao"></div>在线客服</div>
                        </div>
                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?=$webset['qq']?>&site=qq&menu=yes"><div class="help_kf"></div></a>
                        <div class="help_txt">通过在线解答的方式为您提供咨询服务。</div>
                        </div>
                </div>
           </div>

        	<div class="helpright">
              <div class="helpright_search">
                <h3>找帮助</h3><input type="text" id="helpsearchkang" class="helpsearchkang" value="" />  
<input class="helpsearchbt" name="" onclick="javascript:findInPage($('#helpsearchkang').val());" type="button" /> <span>简化搜索词语，便于查询结果</span>                </div>
                <div class="helpright_wenti">
                <h3>
                <?=$help_type[$cid]?>
                </h3>
                <ul>
                <?php foreach($article as $row){?>
                <li><a href="javascript:scroller('a<?=$row['id']?>',500,15);addBorder('a<?=$row['id']?>')"><?=$row['title']?></a></li>
                <?php }?>
                </ul>
                </div>
            
            
        	  <div class="helpright_help">
                	<div class="helpright_help_qa">
                    <?php foreach($article as $row){?>
                    <a name="a<?=$row['id']?>" id="a<?=$row['id']?>"></a>
                        <div class="helpright_help_qa_q"><div class="tubiao_ask"></div><p><?=$row['title']?></p><div class="tree_on"></div></div>
                        <div style="width:778px;"><div class="tubiao_answer"></div><div class="helpright_help_qa_a"><p><?=$row['content']?></p></div><div style="clear:both"></div></div>
                     <?php }?> 
                    </div>
             </div>

            </div>
        
        </div>
  </div>
<?php include(TPLPATH.'/footer.tpl.php');?>