<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$do=$_GET['do'];

include(DDROOT.'/comm/zhidemai.class.php');
$zhidemai_class=new zhidemai($duoduo);

if($do=='vote'){
	$type=(int)$_GET['type'];
	$data_id=(int)$_GET['id'];
	$uid=(int)$dduser['id'];
	$re=$zhidemai_class->vote($data_id,$uid,$type);
	exit(dd_json_encode($re));
}
elseif($do=='comment'){
	$sub=$_GET['sub'];
	$data_id=(int)$_GET['data_id'];
	if($sub==''){
		$comment=$zhidemai_class->comment_list($data_id);
		foreach($comment as $row){?>
        <div class="bd J-comment-list">
      <div class="clearfix item" style="display:block;">
        <div class="item-l l"><img src="<?=a($row['uid'],'small')?>" class="item-face"></div>
        <div class="item-r l">
          <div><span class="name"><?=$row['username']?></span><span class="detail">：</span><span class="detail J-comment-detail"><?=$row['content']?></span></div>
          <div class="clearfix"><span class="l nine time"><i><?=$row['addtime']?></i></span></div>
        </div>
      </div>
    </div>
        <?php }?>
        
        <?php if($dduser['id']>0){?>
        <div class="zdm-expand-pub-comment J-zdm-expand-pub-comment clearfix" style="display:">
      <div class="J-box-comment">
        <textarea class="zdm-input zdm-textarea J-add-comment" name="comment" maxlength="140"></textarea>
        <p class="comment-tips J-comment-tips" style="display:none;">
        </p>
        <div class="clearfix ft-btn">
          <span class="pub-left J-pub-textnum">字数最多为<strong>140</strong>字</span>
          <a href="javascript:void(0);" class="btn-zdm btn-zdm-submit J-btn-comment" data_id="<?=$data_id?>" onclick="comment($(this))">发表</a>
        </div>
        <div class="loading-status" style="display:none;"></div>
        <div class="J-success-status success-status" style="display:none;"><i></i>评论成功</div>
      </div>
    </div>
        <?php }else{?>
        <div class="J-zdm-expand-pub-no-login zdm-expand-pub-no-login" style="display:block"><i></i><span class="bar-login">必须 <a href="<?=u('user','login')?>" class="blue J-comment-login-url">登录</a> 后才可以发表评论哦！</span></div>
        <?php }?>
	<?php }
	else{
		$comment=$_GET['comment'];
		$re=$zhidemai_class->comment_sub($data_id,$dduser['id'],$dduser['name'],$comment);
		if($re['s']==1){
			$html='<div class="bd J-comment-list"><div class="clearfix item" style="display:block;"><div class="item-l l"><img src="'.a($dduser['id'],'small').'" class="item-face"></div><div class="item-r l"><div><span class="name">'.$dduser['name'].'</span><span class="detail">：</span><span class="detail J-comment-detail">'.$comment.'</span></div><div class="clearfix"><span class="l nine time"><i>'.$sj.'</i></span></div></div></div></div>';
			$re=array('s'=>1,'r'=>$html);
		}
		exit(dd_json_encode($re));
	}
}