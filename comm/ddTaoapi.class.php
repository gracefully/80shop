<?php
class ddTaoapi extends Taoapi{
    public $dduser;
	public $nowords;
	public $virtual_cid;
	public $format='json';
	public $jssdk_time='';
	public $jssdk_sign='';
	public $catch_num=3;
	public $renminbi=0;   //是否显示原始返利
	
	function __construct(){
		parent::__construct();
		if(empty($this->nowords)){
			if(REPLACE<3){
				$noword_tag='';
			}
			else{
				$noword_tag='3';
			}
			$this->nowords=dd_get_cache('no_words'.$noword_tag);
		}
		if(empty($this->virtual_cid)){
			$this->virtual_cid=include (DDROOT.'/data/virtual_cid.php');
		}
	}

	function taobao_tbk_items_get($Tapparams){
		
		if($Tapparams['keyword']=='' && $Tapparams['cid']==''){
		    return 'miss keyword or cid';
		}
	    $this->method = 'taobao.tbk.items.get';
        if(!isset($Tapparams['fields']) || $Tapparams['fields']==''){
		    $Tapparams['fields'] = 'num_iid,seller_id,nick,title,price,volume,pic_url';
		}
        $this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])){
            $this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])){
		    $this->cid = $Tapparams['cid'];
		}
        $this->page_size = $Tapparams['page_size'];
		if(isset($Tapparams['page_no'])){
		    $this->page_no=$Tapparams['page_no'];
		}
		if(isset($Tapparams['sort'])){
		    $this->sort = $Tapparams['sort'];
		}
		else{
		    $this->sort = 'commissionNum_desc';
		}
		if(isset($Tapparams['start_commissionRate'])){
            $this->start_commissionRate=$Tapparams['start_commissionRate'];
		}
		if(isset($Tapparams['end_commissionRate'])){
            $this->end_commissionRate=$Tapparams['end_commissionRate'];
		}
		if(isset($Tapparams['start_credit'])){
            $this->start_credit=$Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])){
            $this->end_credit=$Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_price'])){
            $this->start_price=$Tapparams['start_price'];
		}
		if(isset($Tapparams['end_price'])){
            $this->end_price=$Tapparams['end_price'];
		}
		if(isset($Tapparams['area'])){
            $this->area=$Tapparams['area'];
		}
		if(isset($Tapparams['mall_item'])){
		   $this->mall_item=$Tapparams['mall_item'];
		}
		if(isset($Tapparams['is_mobile'])){
		    $is_mobile=$Tapparams['is_mobile'];
		}

        $TaobaokeData = $this->Send('get',$this->format)->getArrayData();
        $TaobaokeItem1 = $TaobaokeData["tbk_items"]["tbk_item"];
		
		if($is_mobile=='true'){
			return $TaobaokeItem1;
		}
		
		if(isset($tag_goods) && is_array($tag_goods) && !empty($tag_goods)){
			$TaobaokeItem1=array_merge($tag_goods,$TaobaokeItem1);
		}
		
        $TotalResults = $TaobaokeData["total_results"]; 
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		
		if($TotalResults>0){
		    $TaobaokeItem=$this->do_TaobaokeItem($TaobaokeItem,0,$this->is_mobile);
			if(isset($Tapparams['total'])){
		        $TaobaokeItem['total']=$TotalResults?$TotalResults:0;
		    }
			return $TaobaokeItem;
		}
		else{
		    return 102; 
		}
	}
	
	function do_TaobaokeItem($TaobaokeItem,$type='goods'){
		if($type=='goods'){
			foreach($TaobaokeItem as $k=>$row){
				$TaobaokeItem[$k]["title"]=dd_replace($row["title"],$this->nowords);
				$TaobaokeItem[$k]['name']=strip_tags($TaobaokeItem[$k]['title']);
	        	$TaobaokeItem[$k]['name_url']=urlencode($TaobaokeItem[$k]['name']);

				$TaobaokeItem[$k]['item_url']='http://item.taobao.com/item.htm?id='.$TaobaokeItem[$k]['num_iid'];
				$TaobaokeItem[$k]['shop_url']='http://store.taobao.com/shop/view_shop.htm?user_number_id='.$TaobaokeItem[$k]['seller_id'];
				$TaobaokeItem[$k]['jump']=u('jump','goods',array('iid'=>$TaobaokeItem[$k]['num_iid'],'price'=>$TaobaokeItem[$k]["price"],'pic'=>$TaobaokeItem[$k]["pic_url"].'_100x100.jpg'));
	       		$TaobaokeItem[$k]['go_view']=u('tao','view',array('iid'=>$TaobaokeItem[$k]["num_iid"]));
				$TaobaokeItem[$k]['gourl']=u('tao','view',array('iid'=>$TaobaokeItem[$k]["num_iid"]));
			}
		}
		elseif($type='shop'){
			foreach($TaobaokeItem as $k=>$row){
				$TaobaokeItem[$k]['onerror']='images/tbdp.gif';
				$TaobaokeItem[$k]['shop_url']='http://store.taobao.com/shop/view_shop.htm?user_number_id='.$row['user_id'];
				$TaobaokeItem[$k]['jump']=u('jump','shop',array('user_id'=>$row["user_id"],'pic'=>$row["pic_url"]));
			}
		}
		return $TaobaokeItem;
	}
	
	function get_et(){
		$l=time();
		$r=-480*60;
		$p=$l+$r;
		$m=$p + (3600 * 8);
		$q=substr($m,2,8);
		$o=array(6, 3, 7, 1, 5, 2, 0, 4);
		$n=array();
		
		for($k=0;$k<count($o);$k++){
			$n[]=$q[$o[$k]];
		}
		$n[2] = 9 - $n[2];
		$n[4] = 9 - $n[4];
		$n[5] = 9 - $n[5];
		
		return implode("",$n);
	}

	function taobao_tbk_tdj_get($iid,$type=1,$return_type=0){
		$rf=urlencode(u(MOD,ACT,array('iid'=>$iid)));
		if(!preg_match('/^http/',$rf)){
			$rf=urlencode(SITEURL.'/').$rf;
		}
		$pid=$this->ApiConfig->taodianjin_pid;

		$md5_cache_path=md5($iid.$pid);
		$md5_cache_path=substr($md5_cache_path,0,2).'/'.$md5_cache_path.'.json';
		$cache_path=DDROOT.'/data/temp/taoapi/taobao.taobaoke.tdj.get/'.$md5_cache_path;
			
		if(file_exists($cache_path) && $this->ApiConfig->Cache>0){
			$json=file_get_contents($cache_path);
			$is_cache=1;
		}
		else{
			$json=dd_json_encode(array());
			$pgid=md5($iid);
			$et=$this->get_et();
			if($type==1){
				$url='http://g.click.taobao.com/display?cb=jsonp_callback_03655084007659234&pid='.$pid.'&wt=0&ti=7&tl=628x100&rd=1&ct=itemid%3D'.$iid.'&st=2&rf='.$rf.'&et='.$et.'&pgid='.$pgid.'&v=2.0';
				$a = dd_get($url);
				$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
				$json=preg_replace('/\)$/','',$a);
			}
			elseif($type==2){
				$url='http://g.click.taobao.com/display?cb=jsonp_callback_018103029002313714&pid='.$pid.'&wt=1&ti=3&tl=140x190&rd=1&ct=sellerid%3D'.$iid.'&st=1&rf='.$rf.'&et='.$et.'&pgid='.$pgid.'&v=2.0';
				$a = dd_get($url);
				$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
				$json=preg_replace('/\)$/','',$a);
			}
			
			/*$url='http://g.click.taobao.com/load?rf='.$rf.'&pid='.$pid.'&pgid='.$pgid.'&cbh=261&cbw=1436&re=1440x900&cah=870&caw=1440&ccd=32&ctz=8&chl=2&cja=1&cpl=0&cmm=0&cf=10.0&cb=jsonp_callback_004967557514815568';
			$a = dd_get($url);
			preg_match('/jsonp_callback_\d+\(\{"code":"(.*)"\}\)/',$a,$b);
			if($b[1]!=''){
				if($type==1){
					$url='http://g.click.taobao.com/display?cb=jsonp_callback_03655084007659234&pid='.$pid.'&wt=0&ti=7&tl=628x100&rd=1&ct=itemid%3D'.$iid.'&st=2&rf='.$rf.'&et='.$b[1].'&pgid='.$pgid.'&v=2.0';
					$a = dd_get($url);
					$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
					$json=preg_replace('/\)$/','',$a);
				}
				elseif($type==2){
					$url='http://g.click.taobao.com/display?cb=jsonp_callback_018103029002313714&pid='.$pid.'&wt=1&ti=3&tl=140x190&rd=1&ct=sellerid%3D'.$iid.'&st=1&rf='.$rf.'&et='.$b[1].'&pgid='.$pgid.'&v=2.0';
					$a = dd_get($url);
					$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
					$json=preg_replace('/\)$/','',$a);
				}
			}*/
			$is_cache=0;
		}
		
		$a=dd_json_decode($json,1);
		if(($a['code']==400 || $a=='') && $this->catch_num>=0){
			$this->catch_num--;
			if($this->catch_num<0){error_html('淘点金代码错误！');}
			return $this->taobao_tbk_tdj_get($iid,$type);
		}
		
		if(is_array($a)){
			if($return_type==0){
				if($type==1){
					$goods['price']=$a['data']['items'][0]['ds_reserve_price'];
					$goods['promotion_price']=$a['data']['items'][0]['ds_discount_price'];
					if($goods['price']<=$goods['promotion_price']){
						$goods['promotion_price']=0;
					}
					$goods['click_url']=$a['data']['items'][0]['ds_item_click'];
					$goods['shop_click_url']=$a['data']['items'][0]['ds_shop_click'];
				}
				elseif($type==2){
					$goods['nick']=$a['data']['items'][0]['ds_nick'];
					$goods['pic_url']=$a['data']['items'][0]['ds_img']['src'];
					$goods['shop_click_url']=$a['data']['items'][0]['ds_shop_click'];
				}
			}
			else{
				$goods=$a['data']['items'][0];
			}
			
			if($this->ApiConfig->Cache>0 && $is_cache==1 && isset($a['data']['items'][0])){
				create_file($cache_path,$json);
			}
			
			return $goods;
		}
		else{
			return array();
		}
	}
	
	function tdj_zujian($type,$uid=0){ //1为充值框
		$rf=urlencode(SITEURL);
		$pid=$this->ApiConfig->taodianjin_pid;
		$pgid=md5($pid);
		$ak='21114278';
		if($type==1){
			$url='http://g.click.taobao.com/load?rf='.$rf.'&pid='.$pid.'&pgid='.$pgid.'&ak='.$ak.'&cbh=720&cbw=1920&re=1920x1080&cah=1050&caw=1920&ccd=32&ctz=8&chl=2&cja=1&cpl=37&cmm=87&cf=11.9&cb=jsonp_callback_09713946501724422';
			$a = dd_get($url);
			$et=$this->tiqu_callback($url);
			$url='http://g.click.taobao.com/display?cb=jsonp_callback_0561472135130316&ak='.$ak.'&pid='.$pid.'&unid='.$uid.'&wt=5&ti=135&tl=210x200&rd=1&ct=&st=2&rf='.$rf.'&et='.$et.'&pgid='.$pgid.'&v=2.0';
			$json=$this->tiqu_callback($url,2);
			$a=dd_json_decode($json,1);
			return $a['templet'];
		}
	}
	
	function tiqu_callback($url,$type=1){ //1为提取callback中的code，2为提取callback中的内容
		$a = dd_get($url);
		if($type==1){
			preg_match('/jsonp_callback_\d+\(\{"code":"(\d+)"\}\)/',$a,$b);
			return $b[1];
		}
		elseif($type==2){
			$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
			return $json=preg_replace('/\)$/','',$a);
		}
	}
	
	function taobao_tbk_items_detail_get($iid){
		$this->method = 'taobao.tbk.items.detail.get';
        $this->fields = 'num_iid,seller_id,nick,title,price,volume,pic_url';
        $this->num_iids = $iid;
		$TaobaoData = $this->Send('get',$this->format)->getArrayData();
		
		$a=$TaobaoData['tbk_items']['tbk_item'];
		if(empty($a)){
			return 102;
		}
		$a=$this->do_TaobaokeItem($a);
		if(strpos($iid,',')===false){
			$a=$a[0];
			$b=$this->taobao_tbk_tdj_get($iid);
			$a['click_url']=$b['click_url'];
			$a['shop_click_url']=$b['shop_click_url'];
			$a['promotion_price']=$b['promotion_price'];
		}
		
		return $a;
	}
	
	function taobao_tbk_shops_detail_get($str,$type='nick'){
	    $this->method = 'taobao.tbk.shops.detail.get';
		$this->fields = 'user_id,seller_nick,shop_title,pic_url';
		if($type=='nick'){
			$this->seller_nicks=$str;
		}
		else{
			$this->sids = $str;
		}
		$ShopData = $this->Send('get',$this->format)->getArrayData();
		$a=$ShopData['tbk_shops']['tbk_shop'];
		if(empty($a)){
			return 104;
		}
		$a=$this->do_TaobaokeItem($a,'shop');
		
		if(strpos($str,',')===false){
			$a=$a[0];
		}
		return $a;
	}
	
	function taobao_tbk_shops_get($Tapparams){
		$this->method='taobao.tbk.shops.get';
		$this->fields='user_id,seller_nick,shop_title,pic_url';
		$this->keyword=$Tapparams['keyword'];
		$this->cid=$Tapparams['cid'];
		$this->start_credit=$Tapparams['start_credit'];
		$this->end_credit=$Tapparams['end_credit'];
		$this->start_commissionrate=$Tapparams['start_commissionrate'];
		$this->end_commissionrate=$Tapparams['end_commissionrate'];
		$this->start_auctioncount=$Tapparams['start_auctioncount'];  //宝贝数量
		$this->end_auctioncount=$Tapparams['end_auctioncount'];
		$this->start_totalaction=$Tapparams['start_totalaction'];  //店铺累计推广量
		$this->end_totalaction=$Tapparams['end_totalaction'];
		$this->only_mall=$Tapparams['only_mall'];  //true  false
		$this->sort_field=$Tapparams['sort_field'];  //commission_rate，auction_count，total_auction
		$this->sort_type=$Tapparams['sort_type'];  //desc,asc
		$this->page_no=$Tapparams['page_no'];
		$this->page_size=$Tapparams['page_size'];
		$ShopData = $this->Send('get',$this->format)->getArrayData();
		$a=$ShopData['tbk_shops']['tbk_shop'];
		if(empty($a)){
			return 104;
		}
		$a=$this->do_TaobaokeItem($a,'shop');
		return $a;
	}
	
	function taobao_taobaoke_rebate_authorize_get($str,$type='num_iid'){
		$temp=$this->ApiConfig->AppKey;
		unset($this->ApiConfig->AppKey);
		$this->ApiConfig->AppKey[$this->ApiConfig->jssdk_key]=$this->ApiConfig->jssdk_secret;
		
		$this->method='taobao.taobaoke.rebate.authorize.get';
		if($type=='num_iid'){
			$this->num_iid=$str;
		}
		elseif($type=='seller_id'){
			$this->seller_id=$str;
		}
		elseif($type=='nick'){
			$this->nick=$str;
		}
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
			
		if($TaobaokeData['rebate']==1 || $TaobaokeData['rebate']=='true'){
			$a=1;
		}
		else{
			$a=0;
		}
		
		$this->ApiConfig->AppKey=$temp;
		return $a;
	}
	
	function taobao_taobaoke_rebate_auth_get($params,$type=3){  //1-按nick查询，2-按seller_id查询，3-按num_iid查询
		$temp=$this->ApiConfig->AppKey;
		unset($this->ApiConfig->AppKey);
		$this->ApiConfig->AppKey[$this->ApiConfig->jssdk_key]=$this->ApiConfig->jssdk_secret;
		$this->method='taobao.taobaoke.rebate.auth.get';
		$this->params=$params;
		$this->type=$type;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$this->ApiConfig->AppKey=$temp;
		return $TaobaokeData['results']['taobaoke_authorize'];
	}
	
	function taobao_taobaoke_rebate_report_get($start_time){
		
		$temp=$this->ApiConfig->AppKey;
		unset($this->ApiConfig->AppKey);
		$this->ApiConfig->AppKey[$this->ApiConfig->jssdk_key]=$this->ApiConfig->jssdk_secret;
		$goods=array();
		$page_no=1;
		
		for($i=1;$i<=6;$i++){
			$_start_time=date('Y-m-d H:i:s',strtotime($start_time)+($i-1)*600);
			if($_start_time>date('Y-m-d H:i:s')){
				$this->ApiConfig->AppKey=$temp;return $goods;
			}
			
			for($page_no=1;$page_no<10;$page_no++){
				$this->start_time=$_start_time;
				$this->page_no = $page_no;
				$this->method='taobao.taobaoke.rebate.report.get';
				$this->fields = 'app_key,outer_code,trade_id,pay_time,create_time,pay_price,num_iid,item_title,item_num,category_id,category_name,shop_title,commission_rate,commission,iid,seller_nick,real_pay_fee';
				$this->span=600;
				$this->page_size=TAO_REPORT_GET_NUM;
			
				$TaobaokeData = $this->Send('get',$this->format)->getArrayData();

				if(isset($TaobaokeData['code'])){
					echo $_start_time;
					print_r($TaobaokeData);exit;
				}
				else{
					$_goods=$TaobaokeData['taobaoke_payments']['taobaoke_payment'];
					if(!empty($_goods)){
						$goods=array_merge($goods,$_goods);
						if(count($_goods)<TAO_REPORT_GET_NUM){
							$page_no=99999;
						}
					}
					else{
						$page_no=99999;
					}
				}
			}
		}
		$this->ApiConfig->AppKey=$temp;
		return $goods;
	}
	
	function taobao_taobaoke_listurl_get($q,$outer_code){ //S8接口，可以自己拼装url
		if(strpos($this->ApiConfig->taobao_search_pid,'mm')!==false){
			$pid=$this->ApiConfig->taobao_search_pid;
		}
		else{
			$pid='mm_'.$this->ApiConfig->taobao_search_pid;
		}
		$url='http://s8.taobao.com/search?q='.rawurlencode(iconv('utf-8','gbk//IGNORE',$q)).'&pid='.$pid.'&commend=all&unid='.$outer_code.'&taoke_type=1';
	    return $url;
	}
	
	function taobao_tbk_mobile_items_convert($num_iids,$outer_code=''){
		$this->method='taobao.tbk.mobile.items.convert';
		$this->fields='click_url';
		echo $this->num_iids=$num_iids;
		$this->outer_code=$outer_code;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		print_r($TaobaokeData);exit('aaa');
		return $TaobaokeData['tbk_items']['tbk_item'][0]['click_url'];
	}
	
	function taobao_tbk_mobile_shops_convert($str,$outer_code='',$type='nick'){
		$this->method='taobao.tbk.mobile.shops.convert';
		$this->fields='click_url';
		if($type=='nick'){
			$this->seller_nicks=$str;
		}
		else{
			$this->sids=$str;
		}
		$this->outer_code=$outer_code;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['tbk_shops']['tbk_shop'][0]['click_url'];
	}
	
	function taobao_item_get($data){
		return $this->taobao_tbk_items_detail_get($data['iid']);
	}
	
	function items_detail_get($data){
		return $this->taobao_tbk_items_detail_get($data['iid']);
	}
	
	function taobao_shop_get($nick){
		return $this->taobao_tbk_shops_detail_get($nick);
	}
	
	function taobao_taobaoke_items_get($data){
		return $this->taobao_tbk_items_get($data);
	}
	
	function taobao_ju_cities_get(){
		$this->method='taobao.ju.cities.get';
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		print_r($TaobaokeData);exit;
	}
}
?>