<?php //多多
class ddgoods{
	public $duoduo;
	public $table_name='ddgoods';
	public $cat;
	public $auditor_word='——';
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
	}
	
	function show($pagesize,$page=1,$field='*',$where="1=1",$order_by='sort asc,id desc'){
		if($order_by==''){$order_by='sort asc,id desc';}
		$frmnum=($page-1)*$pagesize;
		if($where==''){
			$where="1=1";
		}
		if(strpos($where,'`del`')===false){
			$where.=' and `del`=0';
		}
		if(strpos($where,'`xiajia`')===false){
			$where.=' and `xiajia`=0';
		}
		$a=$this->duoduo->select_all($this->table_name,$field,$where.' order by '.$order_by.' limit '.$frmnum.','.$pagesize);
		foreach($a as $k=>$row){
			$a[$k]=$this->do_item($row);
		}
		return $a;
	}
	
	function total($where){
		if($where=='1=1' || $where=='' || $where=='1'){
			$where='`del`=0';
		}
		elseif(strpos($where,'`del`')!==false){
			$where=$where;
		}
		else{
			$where=$where.' and `del`=0';
		}
		return (float)$this->duoduo->count($this->table_name,$where);
	}
	
	function do_item($item){
		$ddgoodslanmu=$this->duoduo->webset['ddgoodslanmu'];
		if(isset($item['cid']) && $item['code']!='zhuanxiang'){
			$item['catname']=$this->catname($item['code'],$item['cid']);
		}
		if(isset($item['sort']) && $item['sort']==DEFAULT_SORT){
			$item['sort']='——';
		}
		if(isset($item['starttime']) && $item['starttime']>0){
			$item['starttime']=date('Y-m-d H:i:s',$item['starttime']);
		}
		if(isset($item['endtime']) && $item['endtime']>0){
			$item['endtime']=date('Y-m-d H:i:s',$item['endtime']);
		}
		if(isset($item['addtime']) && $item['addtime']>0){
			$item['addtime']=date('Y-m-d H:i:s',$item['addtime']);
		}
		$item['lanmuname']=$ddgoodslanmu[$item['code']];
		$item['lanmuurl']=u($item['code'],'index');
		if(ADMIN==1 && $item['auditor']==''){$item['auditor']=$this->auditor_word;}
		if($item['discount_price']==0){$item['discount_price']=$item['price'];}
		$item['jump']=u('tao','jump',array('id'=>$item['id']));
		$item['view']=u('tao','view',array('id'=>$item['id']));
		return $item;
	}

	function admin_list($pagesize=20,$where='',$order_by='id desc'){
		$a=$this->duoduo->get_table_struct($this->table_name);
		foreach($a as $k=>$v){
			if($k!='duoduo_table_index'){
				$b[]=$k;
			}
		}
		$page=(int)$_GET['page'];
		if($page==0) $page=1;
		
		if($where=='1=1' || $where==''){
			$total_where='`del`=0';
		}
		elseif(strpos($where,'`del`')!==false){
			$total_where=$where;
		}
		else{
			$total_where=$where.' and `del`=0';
		}
		$re['total']=$this->total($total_where);
		$re['data']=$this->show($pagesize,$page,implode(',',$b),$where,$order_by);
		return $re;
	}
	
	function index_list($pagesize=20,$page=1,$where='',$total=0,$order_by=''){
		if($where==''){$where='1=1';}
		$where.=' and starttime<="'.TIME.'" and (endtime=0 or endtime>"'.TIME.'") and xiajia=0';
		if($total==1){
			$re['total']=$this->total($where);
			$re['data']=$this->show($pagesize,$page,'*',$where,$order_by);
		}
		else{
			$re=$this->show($pagesize,$page,'*',$where,$order_by);
		}
		
		return $re;
	}
	
	function catname($lanmu,$cid=''){
		if($cid>0){
			if($this->cat==''){
				$this->cat=include(DDROOT.'/data/ddgoods.php');
			}
			$re=$this->cat['cat'][$lanmu][$cid];
		}
		else{
			$this->cat=include(DDROOT.'/data/ddgoods.php');
			$re=$this->cat['cat'][$lanmu];
			if(!empty($re)){$re=array(''=>'全部')+$re;}
		}
		return $re;
	}
	
	function update_sort($id,$sort){
		$this->duoduo->update_sort($id,$sort,$this->table_name);
	}
	
	function get_ddusername($uid){
		return $this->duoduo->select('user','ddusername','id="'.$uid.'"');
	}
	
	function status($status=''){
		if(is_numeric($status)){
			if($this->cat==''){
				$this->cat=include(DDROOT.'/data/ddgoods.php');
			}
			$re=$this->cat['status'][$status];
		}
		else{
			$this->cat=include(DDROOT.'/data/ddgoods.php');
			$re=$this->cat['status'];
			foreach($re as $k=>$v){
				$re[$k]=strip_tags($v);
			}
		}
		return $re;
	}
}