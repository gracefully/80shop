<?php //多多
include(TPLPATH.'/header.tpl.php');
?>
<style>
*{padding:0; margin:0; list-style-type:none}
a{text-decoration:none; color:#666}
a img{border:0}
a:hover{color:#e52142}
em{font-style:normal;}
body{font-family:"Microsoft YaHei"; font-size:12px; line-height:1.5; color:#666; background:#f6f6f6}
.clear{clear:both}
*html,*html body{background-image:url(about:blank);background-attachment:fixed}
 .ju-more{margin: 10px auto;width: 950px;height: auto;overflow: hidden;}
.tf8_sp{padding-top:10px; overflow:hidden;_margin-top:-3px;}
.tf8_sp ul{list-style-type: none;width: 958px;overflow: hidden;list-style-position: outside;margin: 0px;padding: 0px;}
.tf8_sp ul li{float: left;width: 305px;display: inline;border: #f0f0f0 solid 3px;margin-bottom: 10px;margin-right: 8px;}
.tf8_li_div{width:302px; padding:6px 0; border:#e0e0e0 solid 1px; margin:0 auto;background:#fff;}
.tf8_opacity_div{width:290px; height:290px; font-size:0; position:relative; text-align:center;}
.tf8_opacity_div a{text-align:center; width:290px; height:290px;}
.tf8_opacity_div a img{vertical-align:middle;}
.tf8_opacity{height:25px; line-height:28px; position:absolute; bottom:0px; left:0px;}
.tf8_span{display:block;height:25px; width:290px; overflow:hidden; position:absolute; bottom:0px;_bottom:-1px; left:0px;filter:alpha(opacity=90); -moz-opacity:0.9; opacity: 0.9; background-color:#fff;text-align:left;}
.tf8_shop{height: 43px;width: 280px;padding: 0 5px;margin: 0 auto;background-color: #E42141;}
.tf8_spname{height:25px;line-height:27px; font-size:14px; color:#505050; width:280px; overflow:hidden; padding:0 5px;}
.tf8_spname:hover{color:#505050; text-decoration:underline;}
.tf8-zt-a,.tf8-zt-b{width:135px; height:51px; font-family:'微软雅黑'; position:absolute; right:-7px; bottom:40px; text-align:center; line-height:45px; color:#fff; font-size:24px;}
.tf8-zt-a{background:url() no-repeat;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=); _background:none;}
.tf8-zt-a span{font-size:24px; margin-right:10px;}
.tf8-zt-b{background:url() no-repeat;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=); _background:none;}
.tf8-zt-b span{font-size:24px; margin-right:10px;}
.tf8-index-d1{float:right; margin-left:5px;}
.tf8-index-d1 div{width: 38px;height: 14px;margin: 7px 0 3px 0;color: #ed477d;text-align: center;line-height: 14px;font-family: Arial;background-image: url(/plugin/jinzhe/template/images/zhekou.png);background-repeat: no-repeat;}
.tf8-index-d2{float:right; height:43px; line-height:43px;}
.tf8-d2-span1{font-family:微软雅黑; font-size:20px; margin-right:-3px;}
.tf8-d2-span2{font-size:35px;font-family:Arial;}
.tf8-d2-span3{font-family:Arial; font-size:24px;}
.tf8-index-spname{overflow:hidden; width:290px;}
.tf8_shop_div{height:43px;font-size:19px; font-family:'微软雅黑';color:#fff; float:left;font-family:Arial;}
.tf8_shop div dl{font-size:12px; margin-top:5px; line-height:17px; color:#fff;}
.tf8-index{width:63%;height:43px; float:right; font-family:'微软雅黑'; color:#fff; text-align:center;}
.tf8-index-see{width:113px; height:43px; float:right;}
.tf8-index-dd{font-size:16px; color:#fff; font-weight:bold;}
.go_guangyh{width:950px; text-align:center; height:40px; font-family:"宋体"; color:#000; background:url() no-repeat; font-size:12px; line-height:45px; margin:10px 0;}
.go_guangyh a{font-family:"宋体"; text-decoration:underline;text-decoration:underline; font-size:14px; color:#b9075f; font-weight:bold;}
.tab-link{width: 950px;height: 40px;line-height: 39px;font-family: '微软雅黑';background: #f1f1f1;overflow: hidden;_zoom: 1;border-bottom-width: 3px;border-bottom-style: solid;border-bottom-color: #E42141;}
.tab-link a{font-size: 12px;color: #E42141;float: right;margin: 7px 0 0 20px;}
.tab-link a:hover{color: #E42141;}
.tf8-size22{font-size:22px; float:left; font-weight:normal;color:#000;}
.tf8-size12{font-size:12px; float:left; color:#868686; margin:5px 0 0 5px;}
.b2cmall{width: 966px;margin-top: 15px;margin-bottom: 25px;margin-right: auto;margin-left: auto;}
.tf8_index_midA,.tf8_shangc_midA{width: 120px;float: left;text-align: center;color: #9e9e9e;font-family: "微软雅黑";background-color: #FFFFFF;margin-right: 0px;margin-bottom: 0px;margin-left: 9px;}
.tf8_shangc_midA{height: 120px;}
.tf8_index_midA{display: inline;border: 1px solid #e8e8e8;margin-right: 11px;margin-left: 0px;padding-right: 2px;padding-bottom: 2px;padding-left: 2px;}
.tf8_index_midA.bode{border-right-width: 3px;border-bottom-width: 3px;border-left-width: 3px;border-right-style: solid;border-bottom-style: solid;border-left-style: solid;border-right-color: #f36956;border-bottom-color: #f36956;border-left-color: #f36956;padding: 0px;}
.tf8_index_midA a,.tf8_shangc_midA a{height: 45px;width: 90px;display: inline;margin-right: 15px;margin-bottom: 0;margin-top: 10px;margin-left: 3px;}
.tf8_index_midA .b2{margin-left: 15px;}
.tf8_shangc_midA span,.tf8_index_midA span{color:#f4614d;font-family:arial}
.tf8_index_midA p,.tf8_shangc_midA p{color: rgb(158, 158, 158);height: 18px;line-height: 18px;overflow: hidden;text-align: center;padding: 5px;margin-top: 5px;}
.daohang_news {float:right}
.tab-link {line-height:auto;}
.tab-link a {margin:0 20px 0 0;color:#666;float:left;font-size:16px;}
.tab-link a.on {background:#E42141;font-weight:800;padding:0 8px;color:#fff}
.daohang_news a{font-size:14px;float:left}
.daohang_news a:hover {color:#e4393c;}
.tab-link{background:none}
.tab-link {}/*indexWWW*/
.tf8_fenl{width:950px;height:40px;background:#ffffff;z-index:9999;filter: alpha(opacity=90);-moz-opacity: 0.9;opacity: 0.9;}
.tf8_fenl ul{list-style-type:none; padding:7px 0 0 25px;}
.tf8_fenl ul li{float:left; font-size:14px; font-family:"宋体"; padding:5px; margin-right:16px; cursor:pointer;line-height:normal;}
.tf8_sp ul li:hover{border-top-color: #E42141;border-right-color: #E42141;border-bottom-color: #E42141;border-left-color: #E42141;}
.tf8_sp ul .bor{border-top-color: #E42141;border-right-color: #E42141;border-bottom-color: #E42141;border-left-color: #E42141;}
.tf8_fenl_red{background:#777;color:#fff;}
.tf8_fenl_ccc{color:#686868;background:none;}
#nav_left_layout .tf8_fenl_red a{font-size:14px;color:#fff;margin:0; float:left;}
#nav_left_layout .tf8_fenl_ccc a{color:#686868;font-size:14px;margin:0; float:left;}
.tf8_maijia{font-size:12px; color:#e00e7f;float:right; margin:10px 0 0 20px;}
.tf8_maijia:hover{color:#e00e7f;}
.tf8_spkong_div{position:absolute; top:30px; left:290px;}
.tf8_spkong{position:absolute; font-family:'微软雅黑'; left: 442px; top: 65px; line-height:25px;}
.tf8_spkong_d1{color:#dd0068; font-size:16px; font-weight:bold;}
.tf8_spkong_d2{font-size:14px; color:#000; margin-top:10px;}
.tf8_spkong_d3{font-size:14px; color:#dd0068; text-decoration:underline;}
/*indexWWW分页码*/
.tf8_pagediv{clear: both;height: 32px;line-height: 32px;text-align: center; margin-top:5px;}
.tf8_pagediv .tf8page,.tf8_pagediv .tf8page-cur{margin-right:5px;font-size: 13px;border: 1px solid #f0f0f0;display: inline-block;width: 32px;height: 32px;overflow: hidden;color: #909090;font-family: Arial;background-color: #dcdcdc;line-height: 32px;}
.tf8_pagediv .tf8page-cur,.tf8page:hover,.tf8page a:visited{text-decoration: none;border: 1px solid #E42141;outline: none;}
.tf8page{outline:none;}
 
DIV.megas512 {PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; MARGIN: 3px; PADDING-TOP: 3px; TEXT-ALIGN: center; font-family:"瀹嬩綋";clear:both; margin-top:10px; margin-bottom:10px}
DIV.megas512 A {BORDER: #dedfde 1px solid;   BACKGROUND-POSITION: 50% bottom;  COLOR: #0063dc; MARGIN-RIGHT: 3px; padding:5px 10px; background:#FFFFFF; TEXT-DECORATION: none;}
DIV.megas512 A:hover {BORDER: #ff5500 1px solid; BACKGROUND-IMAGE: none; COLOR: #fd6a21; BACKGROUND-COLOR: #ffede1}
DIV.megas512 A:active {BORDER-RIGHT: #fd6d01 1px solid; BORDER-TOP: #fd6d01 1px solid; BACKGROUND-IMAGE: none; BORDER-LEFT: #fd6d01 1px solid; COLOR: #fd6d01; BORDER-BOTTOM: #fd6d01 1px solid; BACKGROUND-COLOR: #ffede1}
DIV.megas512 SPAN.current {BORDER: #ff5500 1px solid; PADDING-RIGHT: 10px; PADDING-LEFT: 10px; FONT-WEIGHT: bold; PADDING-BOTTOM: 5px; COLOR: #ff7400; MARGIN-RIGHT: 3px; PADDING-TOP: 5px;}
DIV.megas512 SPAN.disabled {PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 2px; COLOR:#666; MARGIN-RIGHT: 3px; PADDING-TOP: 2px;position:relative; }
 
 </style>
  <div class="ju-more">
		<div style="border:none;height:75px;" class="tab-link">
	    	<div style="width:950px;height:33px;border-bottom:3px solid #E42141;">
	    		<style>
				.daohang_news {float:right}
				.tab-link {line-height:auto;}
				.tab-link a {margin:0 20px 0 0;color:#666;float:left;font-size:16px;}
				.tab-link a.on {background:#E42141;font-weight:800;padding:0 8px;color:#fff}
				.daohang_news a{font-size:14px;float:left}
				.daohang_news a:hover {color:#e4393c;}
				.tab-link{background:none}
				.tab-link {}
				</style>
				<p class="daohang_news r"><span>聚优惠每日为您优选数百款高返利的商品</span></p>

				<p class="l" style="font-size:12px">
					<a <? if($type=='all'){ echo 'class="on"';}?> href="<?=p(MOD,'index',array('type'=>'all'));?>">聚优惠</a>
					<a <? if($type=='baoyou'){ echo 'class="on"';}?> href="<?=p(MOD,'index',array('type'=>'baoyou'));?>">9块9包邮</a>
					<a <? if($type=='fengding'){ echo 'class="on"';}?> href="<?=p(MOD,'index',array('type'=>'fengding'));?>">20元封顶</a>
					<a <? if($type=='tejia'){ echo 'class="on"';}?> href="<?=p(MOD,'index',array('type'=>'tejia'));?>">天天特价</a>
				</p>
			</div>
	        <div id="nav_left_layout" class="tf8_fenl" style="position: static; top: 482px;">
	        	<ul>
	            	<li <? if($cid==0){ echo 'class="tf8_fenl_red"';}else{  echo 'class="tf8_fenl_ccc"';}?>><a href="<?=p(MOD,'index');?>" name="catHref">全部分类</a></li>
					<?
					foreach($plugin_data_class_list as $val){
					?>
	                <li <? if($cid==$val['id']){ echo 'class="tf8_fenl_red"';}else{  echo 'class="tf8_fenl_ccc"';}?>><a href="<?=p(MOD,'index',array('type'=>$type,'cid'=>$val['id']));?>" name="catHref"><?=$val['title']?></a></li>
					<?
					}
					?>
	            </ul>
	        </div>
	    </div>
	    <div class="tf8_sp">
	      	<ul>
				<? 
				foreach($plugin_data_list as $pdval){
					$gourl=u('tao','view',array('iid'=>$pdval['iid']));
				?>
	            <li title="<?=$pdval['title']?>" class="vipgoods">
	        		<div class="tf8_li_div">
	                	<div style="width:290px; margin:0 auto;">
	                        <div class="tf8_opacity_div">
	                            <a target="_blank" href="<?=$gourl?>" rel="nofollow" style="cursor: pointer;">
	                            	<img width="290" height="290" src="<?=$pdval['pic_url']?>" alt="<?=$pdval['title']?>">
	                            </a>
	                            <div class="tf8_span">
	                            	<a target="_blank" href="<?=$gourl?>" style="cursor: pointer;" class="tf8_spname"><?=$pdval['title']?></a>
	                            </div>
							</div>
	                        <div class="tf8_shop">
	                            <div class="tf8_shop_div">
	                            	<dl style="line-height:30px;">
	                                    <dd style="color:#fff;">返利<span style="color:#fedd00; font-weight:bold;font-size:20px;padding:0 5px;"><?=intval($pdval['price']*$pdval['commission_rate']*0.5);?></span>集分宝</dd>
 	                                </dl>
	                            </div>
	                            <div class="tf8-index">
	                            	<div class="tf8-index-d1">
	                                	<div><?=round( $pdval['price'] / $pdval['price_original'] * 10, 1)?><span>折</span></div><del><?=$pdval['price_original']?></del>
	                                </div>
	                            	<div class="tf8-index-d2">
	                                    <span class="tf8-d2-span1">￥</span><span class="tf8-d2-span2"><?php echo floor($pdval['price'])?></span><span class="tf8-d2-span3">.<?php echo floor(($pdval['price']-floor($pdval['price']))*100)?></span>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </li>
				<? }?>
	            	       	</ul>
			<!--分页-->
			<div style="height:40px;">
	        	<div>
	        		<div class="tf8_pagediv">
	                	<div class="megas512" style=" margin-top:5px;"><?=$pageft;?></div>
	                </div>
	            </div>
	        </div>
		</div>
	</div>




<?php
include(TPLPATH.'/footer.tpl.php');
?>