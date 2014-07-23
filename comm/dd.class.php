<?php
class duoduo {

	public $link;
	public $webset;
	
	public $dbserver;
	public $dbuser;
	public $dbpass;
	public $dbname;
	public $BIAOTOU;
	public $sql_log=0;
	public $lastsql;
	public $trade_id_uid_arr=array();  //存储trade_id和uid的关系，以便后续订单直接比对
	public $trade_temp=array();        //存储没有uid的临时订单，回滚数据用
	public $user_temp=array();         //会员临时数据，定位会员是求得的会员信息放在这里，以便后续代码直接使用
	
	function connect(){
		$this->link = mysql_connect($this->dbserver, $this->dbuser, $this->dbpass);
	    if($this->link==''){
			echo '数据库连接失败！';exit;
		}
		$query=$this->select_db($this->dbname);
		if($query!=1){
			$sql = "CREATE DATABASE IF NOT EXISTS `".$this->dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			$query=$this->query($sql);
			if($query==''){
				dd_exit('没有创建数据库的权限');
			}
			$this->select_db($this->dbname);
		}
		$this->query("set names utf8");
		return $this->link;
	}
	
	function select_db($dbname){
	    return mysql_select_db($dbname,$this->link);
	}
	
	function ping(){
	    if(mysql_ping()==''){
		    $this->close();
			$this->connect();
		}
	}
	
	function close(){
	    mysql_close($this->link);
	}

	function query($sql,$alert=0) {
		$this->lastsql = $sql;
		if($alert==1){
			echo $sql;
		}
		if($this->webset['sql_log']==1 || $this->sql_log==1){
			$str=$sql.'-----'.get_client_ip().'-----'.date('H:i:s')."\r\n";
			$filename=DDROOT.'/data/temp/sql/'.date('Ym').'/'.date('d').'_'.md5(DDKEY).'.log';
			create_file($filename,$str,1,1);
		}
		if(defined('ADMIN')){
			$str=get_client_ip().'-----'.$sql.'-----'.date('H:i:s')."\r\n";
			$filename=DDROOT.'/data/temp/admin_sql/'.date('Ym').'/'.date('d').'_'.md5(DDKEY).'.log';
			create_file($filename,$str,1,1);
		}
		$query=mysql_query($sql,$this->link);
		if($query==''){
			if($this->webset['sql_debug']==1){
				$filename=DDROOT.'/data/temp/error_sql/'.date('Ym').'/'.date('d').'_'.md5(DDKEY).'.log';
				create_file($filename,$this->error().'---'.$sql."\r\n",1,1);
				//echo $this->error().'<br/>'.$sql;exit;
			}
		}
		else{
			return $query;
		}
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	
	function num_rows($query){
	    return mysql_num_rows($query);
	}
	
	function insert_id(){
	    return mysql_insert_id($this->link);
	}
	
	function free_result(&$query){
		$re=mysql_free_result($query);
		/*if($re!=1){
		    print_r(debug_backtrace());
			exit;
		}*/
	}
	
	function real_escape_string($var){
		return $var=mysql_real_escape_string($var);
	}

	function error() {
		return mysql_error();
	}
	
	function get_version($isformat = true) {
	    $rs = $this->query("SELECT VERSION();");
	    $row = $this->fetch_array($rs,MYSQL_NUM);
	    $mysql_version = $row[0];
	    $this->free_result($rs);
	    if ($isformat) {
		    $mysql_versions = explode(".", trim($mysql_version));
		    $mysql_version = number_format($mysql_versions[0] . "." . $mysql_versions[1], 2);
	    }
	    return $mysql_version;
    }
	
	function show_index($table){
		$query = $this->query("SHOW INDEX FROM ".BIAOTOU.$table);
		if($query!=''){
			while ($arr = $this->fetch_array($query)) {
				if($arr['Key_name']=='PRIMARY'){
					$index_info[] = $arr['Column_name'];
				}
				else{
					$index_info[] = $arr['Key_name'];
				}
			}
		}
		return $index_info;
	}
	
	public function con($a) {
		if(!is_array($a)) return $a;
		$where = '';
		$temp=array();
		$i = 0;
		if(!is_array($a[0])){
		    foreach($a as $k=>$v){
    	        $temp[]=$k."='".$v."'";
            }
			$where='where '.implode(' and ',$temp);
		}
		else{
		    foreach ($a as $row) {
			    if ($i == 0) {
				    $where .= ' where ';
			    } else {
				    if ($row['c'] == '') {
					    $where .= ' and ';
				    } else {
					    $where .= ' ' . $row['c'] . ' ';
				    }

			    }
			    if ($row['e'] == '') {
				    $row['e'] = '=';
			    }
			    $where .= $row['f'] . ' ' . $row['e'] . ' "' . $row['v'] . '"';
			    $i++;
		    }
		}
		return $where;
	}
	
	function get_query_conditions($query_item){
        foreach($query_item as $row){
			if($row['f']!=''){
			    if($row['v']!=='' && $row['v']!=='%%'){
					if(isset($row['equal']) && $row['equal']=='in'){
					    $str1[] = $row['f']." ".$row['e']." ".$row['v'];
					}
					else{
					    $str1[] = $row['f']." ".$row['e']." '".$row['v']."'";
					}
			    }
			}
			else{
			    foreach($row as $arr){
				    if($arr['v']!=='' && $arr['v']!=='%%'){
						if($arr['e']=='in'){
						    $str2[] = $arr['f']." ".$arr['e']." ".$arr['v'];
						}
						else{
						    $str2[] = $arr['f']." ".$arr['e']." '".$arr['v']."'";
						}
			        }
				}
				if($str2[1]!=''){
					$str3='('.implode(' or ',$str2).')';
				}
				elseif($str2[1]=='' && $str2[0]!=''){
				    $str3=$str2[0];
				}
				else{
				    $str3='';
				}
			}
			
        }
		
		if(isset($str3) && $str3!='') $str1[]=$str3;
		if($str1[1]!=''){
			return implode(' and ',$str1);
		}
		elseif($str1[1]=='' && $str1[0]!=''){
			return $str1[0];
		}
		else{
			 return '1=1';
		}
    }
	
	function sql_to_array($sql){
		$arr=array();
		$query=$this->query($sql);
		while ($row = $this->fetch_array($query)) {
			$arr[]=$row;
		}
		//if(!isset($arr[1])){$arr=$arr[0];}
		$this->free_result($query);
		return $arr;
	}
	
	function select2arr($sql,$x=0) {
		$query = $this->query($sql);
		while ($row = $this->fetch_array($query)) {
			$arr[] = $row;
		}
		if($x==0){
		    $re = $arr;
		}
		else{
		    $re = $arr[0];
		}
		$this->free_result($query);
		if(!is_array($re)){$re=array();}
		return $re;
	}

	function select($table, $sel_field, $where='1', $alert = 0) {
		$arr='';

		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from " . $this->BIAOTOU . $table . " where $where limit 1";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				if(strpos($sel_field, ",")!==false or strpos($sel_field, "*")!==false) {
					$arr = $row;
				} 
				else{
					$arr = array_pop($row);
				}
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_limit($table, $sel_field, $where='1',$limit='1', $alert = 0) {
		$arr='';

		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from " . $this->BIAOTOU . $table . " where $where limit ".$limit;
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				if(strpos($sel_field, ",")!==false or strpos($sel_field, "*")!==false) {
					$arr = $row;
				} 
				else{
					$arr = array_pop($row);
				}
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_all($table, $sel_field, $where='1=1', $alert = 0) {
		$arr = array ();
		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_all_key($table, $sel_field, $where='1=1', $key='id', $alert = 0) {
		$arr = array ();
		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[$row[$key]] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_1_field($table, $sel_field='title', $where='1=1', $alert = 0) { //1个字段，输出一维数组
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query,MYSQL_NUM)) {
				$arr[] = $row[0];
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_2_field($table, $sel_field='id,title', $where='1=1', $alert = 0) { //2个字段，输出一维数组，第一个字段是键名，第二个字段是键值
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query,MYSQL_NUM)) {
				$arr[$row[0]] = $row[1];
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_3_field($table, $sel_field='id,title,content', $where='1=1', $alert = 0) { //3个字段，输出二维数组，第一个字段是键名，第二，三组成数字作为子数组
		$field_arr=explode(',',$sel_field);
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[$row[$field_arr[0]]] = array($field_arr[1]=>$row[$field_arr[1]],$field_arr[2]=>$row[$field_arr[2]]);
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
    function update($table, $set_con_arr, $where,$limit=1,$alert = 0) {
		$set = '';
	    if (!array_key_exists(0,$set_con_arr)) {
		    $set_arr[0] = $set_con_arr;
	    } else {
		    $set_arr = $set_con_arr;


	    }

	    if(!array_key_exists('f',$set_arr[0])){
            foreach ($set_arr[0] as $k => $v) {

            	$set = "`$k`='$v'," . $set;
            }
			$set = substr($set, 0, strlen($set) - 1);
	    }
        else{
        	foreach ($set_arr as $k => $v) {
		        if (!isset($v['e']) || $v['e'] == '' || $v['e']=='=') {
			        $temp[] = "`" . $v['f'] . "`='" . $v['v'] . "'";
		        } else {
			        $temp[] = "`" . $v['f'] . "`=`" . $v['f'] . "`" . $v['e'] . "'" . $v['v'] . "'";
		        }
	        }
	        $set = implode(',', $temp);
        }
	    if($limit==0){
			$limit='';
		}
		elseif($limit>0){
			$limit=' limit '.$limit;
		}
	    $sql = "update " . $this->BIAOTOU . $table . " set " . $set . " where " . $where . $limit;
		if ($alert == 0) {
			$this->query($sql);
			return $set_arr;
		}
		elseif ($alert == 1) {
			$this->query($sql);
			echo $sql;
		}
	}
	
	function update_serialize($field,$key,$value,$alert=0){
	    $str=$this->select('webset','val','var="'.$field.'"');
		$row=unserialize($str);
		$row[$key]=$value;
		$data=array('val'=>serialize($row));
		$this->update('webset',$data,'var="'.$field.'"');
	}
	
	function insert($table, $field_arr, $alert = 0) {
		$s='';
		foreach ($field_arr as $k => $v) {
			$s.="`" . $k . "`="."'" . $v . "',";
		}
		$s=preg_replace('/,$/','',$s);
		$sql = 'insert into '.$this->BIAOTOU.$table.' set '.$s;
		$query = $this->query($sql);
		if ($query!=''){
			$re = $this->insert_id();
		}
	    else{
			$re = $this->error();
		}
		if ($alert == 1) {
			echo $sql . "<br/>";
		}
		return $re;
	}
	
	function get_table_struct($tablename){
		$table_struct=array();
		$query = $this->query('show fields from `' . $this->BIAOTOU . $tablename.'`');
		if($query==''){return 0;}
		while ($arr = $this->fetch_array($query)) {
			$info = $arr['Type'];
			if ($arr['Null'] == 'NO') {
				$info .= ' NOT NULL';
			}
			$type = strtolower(preg_replace('/\((.*)\)/', '', $arr['Type']));
			if ($type == 'int' or $type == 'tinyint' or $type == 'bigint' or $type == 'double') { //数字类型<br>
				if ($arr['Default'] != '') {
					$info .= ' default "' . $arr['Default'] . '"';
				}
			} else {
				if ($arr['Null'] == 'YES') {
					if ($arr['Default'] != '') {
						$info .= ' default "' . $arr['Default'] . '"';
					} else {
						$info .= ' default NULL';
					}
				}
			}

			if ($arr['Extra'] != '') {
				$info .= ' ' . $arr['Extra'];
			}

			$table_struct[$arr['Field']] = $info;

			if ($arr['Key'] != '') {
				if ($arr['Key'] == 'PRI') {
					$duoduo_table_index = 'PRIMARY KEY  (`' . $arr['Field'] . '`)';
				}
				elseif ($arr['Key'] == 'UNI') {
					$duoduo_table_index .= ',UNIQUE KEY `' . $arr['Field'] . '` (`' . $arr['Field'] . '`)';
				}
				elseif($arr['Key'] == 'MUL'){
					$duoduo_table_index .= ',KEY `' . $arr['Field'] . '` (`' . $arr['Field'] . '`)';
				}
			}
		}
		$table_struct['duoduo_table_index'] = $duoduo_table_index;
		return $table_struct;
	}
	
	function admin_log($do){
		$data=array('mod'=>MOD,'admin_name'=>$_SESSION['ddadmin']['name'],'addtime'=>TIME,'ip'=>get_client_ip(),'do'=>$do);
		$this->insert('adminlog',$data);
		if(rand(1,10)==1){  //十分之一的概率删除60天前的日志
			$this->delete('adminlog','addtime<"'.(TIME-3600*24*60).'"');
			
			if(date('d')>=28){
				$a=dd_glob(DDROOT.'/data/temp/admin_sql/');
				foreach($a as $v){
					if($v!=date("Ym")){
						deldir($v);
					}
				}
			}
		}
	}
	
	function mingxi_insert($field_arr, $alert = 0) {
		$user=$this->select('user','money,jifenbao,jifen','id="'.$field_arr['uid'].'"');
		$field_arr['leave_money']=$user['money'];
		$field_arr['leave_jifenbao']=$user['jifenbao'];
		$field_arr['leave_jifen']=$user['jifen'];
		if(!array_key_exists('addtime',$field_arr)){
			$field_arr['addtime']=date('Y-m-d H:i:s');
	    }
		return $this->insert('mingxi',$field_arr,$alert);
	}
	
	function msg_insert($data, $msgset_id=0, $msgset = ''){ //带有站内信id，启用站内信模板，否则需要data带有title和content
		$user=$this->select('user','*','id="'.$data['uid'].'"');
		foreach($user as $k=>$v){
			if(!isset($data[$k])){
				$data[$k]=$v;
			}
		}
		
		/*if(!isset($data['email']) || $data['email']==''){
			$data['email']=$user['email'];
		}
		if(!isset($data['mobile']) || $data['mobile']=='' || $data['mobile']==0){
			$data['mobile']=$user['mobile'];
		}*/
		
		$send_web=0;
		$send_email=0;
		$send_sms=0;
        if($msgset_id>0 || !empty($msgset)){
			if($msgset_id>0){
				$m=dd_get_cache('msgset');
				$msgset=$m[$msgset_id];
			}
		    
			$title= $msgset['title'];
			$web_content=$msgset['web'];
			$web_open=$msgset['web_open'];
			$sms_content=$msgset['sms'];
			$sms_open=$msgset['sms_open'];
			
			$email_content=$msgset['email'];
			$email_open=$msgset['email_open'];

			if($web_content!='' && $data['uid']>0 && $web_open==1){
				preg_match_all('/\{(.*?)\}/',$web_content,$arr);
        		foreach($arr[0] as $k=>$v){
	        		$web_content=str_replace($v,$data[$arr[1][$k]],$web_content);
        		}
				$send_web=1;
			}
			
			if($sms_content!='' && $data['mobile']!='' && $sms_open==1 && $this->webset['sms']['open']==1){
				if($msgset_id==2 || $msgset_id==3){ //提现
					$sms_money=(float)$data['money'];
					$sms_content=array('money'=>$sms_money);
				}
				elseif($msgset_id==999 || $msgset_id==998 || $msgset_id==11){ //验证码
					$sms_content=array('yzm'=>$data['yzm']);
				}
				elseif($msgset_id==4){  //兑换成功（如果是优惠券兑换，有兑换码）
					if($data['code']!=''){
						$data['code']=str_replace('认领代码：','',$data['code']);
					}
					$sms_content=array('code'=>$data['code']);
				}
				elseif($msgset_id==5){ //兑换失败
					$sms_content=array();
				}
				elseif($msgset_id==7){ //退款
					$sms_content=array('trade_id'=>$data['trade_id']);
				}
				elseif($msgset_id==9 || $msgset_id==10){ //站长奖励 站长扣除
					$sms_content=array('money'=>$data['money']);
				}
				if(is_array($sms_content)){
					$send_sms=1;
				}
			}
			
			if($email_open==1 && $data['email']!='' && $email_content!=''){
				preg_match_all('/\{(.*?)\}/',$email_content,$arr);
        		foreach($arr[0] as $k=>$v){
	        		$email_content=str_replace($v,$data[$arr[1][$k]],$email_content);
        		}
				$send_email=1;
			}
		}
		else{
		    $title=$data['title'];
			if($data['content']!=''){
				$web_content=$data['content'];
				$send_web=1;
			}
			if($user['mobile']!=''){
				$sms_content=$data['content'];
				$send_sms=0;
			}
			if($data['email']!=''){
				$email_content=$data['content'];
				$send_email=1;
			}
		}
		
		$re_status=array(0,0,0);
		
		if($send_web==1){
			$field_arr['addtime']=date('Y-m-d H:i:s');
			$field_arr['see']=0;
			$field_arr['senduser']=0;
			$field_arr['uid']=$data['uid'];
			$field_arr['title']=$title;
			$field_arr['content']=$web_content;
			$id=$this->insert('msg',$field_arr);
			if($id>0){
				$re_status[0]=1;
			}
		}

		if($send_sms==1){
			$ddopen=fs('ddopen');
			$ddopen->sms_ini($this->webset['sms']['pwd']);
			$ddopen->sms_send($data['mobile'],$sms_content,$msgset_id);
			$re_status[1]=1;
		}
		
		if($send_email==1){
			if($this->webset['smtp']['xingshi']==0){
				$a=array('email'=>$data['email'],'title'=>$title,'content'=>$email_content,'type'=>1);
				$this->cron($a,'insert');
			}
			else{
				mail_send($data['email'], $title, $email_content);
			}
			$re_status[2]=1;
			/*$re=mail_send($data['email'], $title, $email_content);
			if($re>0){
				$re_status[2]=1;
			}*/
		}
		
		return $web_content;
	}
	
	function replace($table, $field_arr, $alert = 0) {
		$field = "";
		$values = "";
		foreach ($field_arr as $k => $v) {
			$field = "`" . $k . "`," . $field;
			$values = "'" . $v . "'," . $values;
		}
		$field = substr($field, 0, strlen($field) - 1);
		$values = substr($values, 0, strlen($values) - 1);
		$sql = "replace into $this->BIAOTOU$table($field) values ($values);";
		$query = $this->query($sql);
		if ($alert == 0) {
			if ($query)
				return mysql_insert_id();
			else
				return $this->error();
		}
		elseif ($alert == 1) {
			echo $sql . "<br/>";
		}
		elseif ($alert == 2) {
			echo $sql;

			if ($query)
				return mysql_insert_id();
			else
				return $this->error();
		}
	}
	
	function left_join($table, $join, $sel_field, $where='1=1', $alert = 0) {
		$arr = array ();
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." LEFT JOIN ".$this->BIAOTOU.$join." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function sel_one_arr_sql($table, $sel_field, $where, $alert = 0) {
		$arr = array ();
		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row[$sel_field];
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function sel_page_sql($table, $sel_field, $where, $frmnum ,$pagesize) {
		$arr = array ();
		if($frmnum>=1000){ //自己估算的临界点
		    $sql="select $sel_field From ".$this->BIAOTOU.$table." Where id >=(Select id From ".$this->BIAOTOU.$table." Order By id limit $frmnum,1) and ".$where." limit $pagesize";
		}
		else{
		    $sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where limit $frmnum ,$pagesize";
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}

	function count($table,$where='',$alert=0){
		if($where!=''){$where ='where '.$where;}
		if(strpos($table,',')!==false){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
	    $sql='select count(1) as num from '.$this->BIAOTOU.$table." ".$where;
		if($alert==1){
		    echo $sql;
		}
	    $query = $this->query($sql);
		if($query){
			$row=$this->fetch_array($query);
			$this->free_result($query);
		}
	    return $row['num']?$row['num']:0;
    }
	
	function count_orther($table,$where='',$alert=0){
		if($where!=''){$where ='where '.$where;}
		if(strpos($table,',')!==false){
		    $table=str_replace(',',',',$table);
		}
	    $sql='select count(1) as num from '.$table." ".$where;
		if($alert==1){
		    echo $sql;
		}
	    $query = $this->query($sql);
	    $row=$this->fetch_array($query);
		$this->free_result($query);
	    return $row['num']?$row['num']:0;
    }
	
	function sum($table,$count_field,$where='1=1',$alert=0){
		if($where!=''){$where ='where '.$where;}
		if(strpos($table,',')!==false){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$select_field='';
		if(strpos($count_field,',')!==false){
			$field_arr=explode(',',$count_field);
			foreach($field_arr as $k=>$v){
				$select_field.='sum(`'.$v.'`) as `'.$v.'`,';
			}
			$select_field=preg_replace('/,$/','',$select_field);
		}
		else{
			$select_field='sum('.$count_field.') as sum';
		}
	    $sql="select ".$select_field." from ".$this->BIAOTOU.$table." ".$where;
		if($alert==1){echo $sql.'<br/>';}
	    $query = $this->query($sql);
		if($query){
			$row=$this->fetch_array($query);
			$this->free_result($query);
			if(count($row)==1){
				return $row['sum']?round($row['sum'],2):0;
			}
			else{
				foreach($row as $k=>$v){
					$row[$k]=(float)$v;
				}
				return $row;
			}
		}
		return 0;
    }
	
	function delete($table,$where,$alert=0){
	    $sql="delete from ".$this->BIAOTOU.$table." where $where";
		$query = $this->query($sql);
		if($alert==1){
		    echo $sql;
		}
		if($query!=''){return 1;}
		else{return mysql_error();}
	}
	
	function delete_id_in($ids,$table=MOD,$alert=0){
	    $where="id IN(".$ids.")";
		$re=$this->delete($table,$where,$alert=0);
		return $re;
	}
	
	function creat_table($name, $field) {
		if (!array_key_exists('duoduo_table_index', $field)) { //如果没有标明索引key，默认一个空
			$field['duoduo_table_index'] = '';
		}

		//$sql = 'DROP TABLE IF EXISTS `' . $this->BIAOTOU . $name . '`;';
		//$this->query($sql);
		$sql = 'CREATE TABLE IF NOT EXISTS `' . $this->BIAOTOU . $name . '` (';
		foreach ($field as $k => $v) {
			if ($k != 'duoduo_table_index') {
				$sql .= '`' . $k . '` ' . $v . ',';
			} else {
				if($v!=''){
				    $sql .= $v;
				}
			}
		}
		$sql .= ') ENGINE=MyISAM DEFAULT CHARSET=utf8;';
		$query=$this->query($sql);
		return $query;
	}
	
	function delete_table($table){
		$query=$this->query("show tables like '".$this->BIAOTOU.$table."'"); 
		$row=$this->fetch_array($query);
		if(!empty($row)){
		    $sql="DROP TABLE `".$this->BIAOTOU.$table."` ";
		    $query=$this->query($sql);
		}
		else{
		    return $this->error();
		}
	}
	
	function show_fields($table,$field=''){
		$query=$this->query('show fields from `'.$this->BIAOTOU.$table.'`;');
		$field_arr=array();
        while($arr=$this->fetch_array($query)){
		    $field_arr[]=$arr['Field'];
		}
		$this->free_result($query);
		if($field==''){
			return $field_arr;
		}
		else{
			if(in_array($field,$field_arr)){
				return 1;
			}
			else{
				return 0;
			}
		}
	}
	
	function show_states($table){
		$sql="SHOW TABLE STATUS LIKE '".$this->BIAOTOU.$table."'";
		$query=$this->query($sql);
		$arr=$this->fetch_array($query);
		return $arr;
	}

	function reapaire_field($table, $field_name, $field_info) {
		$sql = "ALTER TABLE `" . $this->BIAOTOU . $table . "` add `" . $field_name . '` ' . $field_info . ";";
		$this->query($sql);
	}
	
	function update_sort($id,$sort,$table){
		$sort=(int)$sort;
		if($sort<=0){
			$sort=DEFAULT_SORT;
		}
		else{
			$data=array('sort'=>DEFAULT_SORT);
			$this->update($table,$data,'sort="'.$sort.'"',0);
		}
		$data=array('sort'=>$sort);
		$this->update($table,$data,'id="'.$id.'"');
	}
	
function set_constants($table) {
	$data = array ();
	$sql = "show fields from " . $this->BIAOTOU . $table; //得到全表信息
	$query = $this->query($sql);
	while ($row = $this->fetch_array($query)) {
		$data[] = str_replace('_', '', strtoupper($row['Field']));
	}

	$data = array_diff($data, array ('ID'));

	$sql = "select * from " . $this->BIAOTOU .$table." where id=1";
	$query = $this->query($sql);
	$i = 1;
	$set = $this->fetch_array($query, MYSQL_NUM);

	for ($i = 1; $i < count($set); $i++) {
		define($data[$i], $set[$i]);
	}
	define('SITEURL', 'http://'.URL);
}

	//////////////////////////////////////////////////////////////////////////////////////////
	
	public function do_report($row){ //淘宝获取订单处理办法
	    if($row['outer_code']=='null'){$row['outer_code']='';}
		$row['trade_id']=number_format($row['trade_id'],0,'',''); //处理json将数字变成科学计数法的错误
		$id=$this->select('tradelist', 'id', 'trade_id="'.$row['trade_id'].'"');
		if($id>0){ return false;} //订单存在，处理结束
		$i=0; //插入订单
		$j=0; //返利订单

		$row['uid']=$row['outer_code']?$row['outer_code']:0;
		if(strpos($row['uid'],'a')!==false){
			$a=explode('a',$row['uid']);
			$row['uid']=(int)$a[0];
			$row['platform']=(int)$a[1];
		}
		$row['uid']=(float)$row['uid'];
		if($row['uid']>0){
		    $user=$this->select('user','*','id="'.$row['uid'].'"');
			
			if(!$user['id']){
				$user['level']=0;
			}
			
			$row['fxje']=fenduan($row['commission'],$this->webset['fxbl'],$user['level']);
			$row['jifen']=(int)($row['fxje']*$this->webset['jifenbl']);
			
			if($user['id']>0){   //会员存在，添加确认时间
			    $row['qrsj']=TIME;
				$row['checked']=2;
		    }
			if($user['tjr']>0){
			    $tjr_user=$this->select('user','id,ddusername','id="'.$user['tjr'].'"');
		        if($tjr_user['id']>0){
			        $user['tjr_name']=$tjr_user['ddusername'];
				    $row['tgyj']=round($row['fxje']*$this->webset['tgbl'],2);;
		        }
		    }
		} 
		else{
			$row['fxje']=fenduan($row['commission'],$this->webset['fxbl'],0);
			$row['jifen']=(int)($row['fxje']*$this->webset['jifenbl']);
		}
		
		$row['jifenbao']=jfb_data_type($row['fxje']*TBMONEYBL);
		
		if($row['jifenbao']==0){
			return false;
		}
		
		$row['item_title']=mysql_real_escape_string($row['item_title']);
		$row['shop_title']=mysql_real_escape_string($row['shop_title']);
		$row['outer_code']=$row['outer_code']?$row['outer_code']:'';
		$row['app_key']=(int)$row['app_key'];
		$row['mini_trade_id'] = substr($row['trade_id'],0,8).substr($row['trade_id'],-4,4);
		$row['relate_id']=$this->insert('tradelist',$row);
		if($user['id']>0 && $row['relate_id']>0){
		    $this->rebate($user,$row,2);
	    }
	}
	
	public function do_paipai_report($row){ //拍拍获取订单处理办法
		$id=$this->select('paipai_order', 'id', 'dealId="'.$row['dealId'].'"');
		if($id>0){ return false;} //订单存在，处理结束
		$i=0; //插入订单
		$j=0; //返利订单
		
		$trade['dealId']=$row['dealId'];
		$trade['discount']=round($row['discount']/10000,2); //佣金比率
		$trade['careAmount']=round($row['careAmount']/100,2); //实际付款
		$trade['commission']=round($row['brokeragePrice']/100,2); //佣金
		$trade['commName']=addslashes($row['commName']);
		$trade['shopName']=addslashes($row['shopName']);
		$trade['outInfo']=$row['outInfo']?$row['outInfo']:'';
		$trade['realCost']=$row['realCost'];
		$trade['bargainState']=$row['bargainState'];
		$trade['chargeTime']=$row['chargeTime'];
		$trade['commNum']=$row['commNum'];
		$trade['commId']=$row['commId'];
		$trade['classId']=$row['classId'];
		$trade['className']=$row['className'];
		$trade['shopId']=$row['shopId'];
		$trade['uid']=$row['outInfo']?$row['outInfo']:0;
		
		if($trade['uid']>0){
		    $user=$this->select('user','*','id="'.$trade['uid'].'"');
			if(!$user['id']){
				$user['level']=0;
			}
			$trade['fxje']=fenduan($trade['commission'],$this->webset['paipaifxbl'],$user['level']);
			$trade['jifen']=(int)($trade['fxje']*$this->webset['jifenbl']);
			
			if($user['id']>0){   //会员存在，添加确认时间
			    $trade['addtime']=TIME;
				$trade['checked']=2;
		    }
			if($user['tjr']>0){
			    $tjr_user=$this->select('user','id,ddusername','id="'.$user['tjr'].'"');
		        if($tjr_user['id']>0){
			        $user['tjr_name']=$tjr_user['ddusername'];
				    $trade['tgyj']=round($trade['fxje']*$this->webset['tgbl'],2);
		        }
		    }
		} 
		else{
			$trade['fxje']=fenduan($trade['commission'],$this->webset['paipaifxbl'],0);
			$trade['jifen']=(int)($trade['fxje']*$this->webset['jifenbl']);
		}

		$trade['relate_id']=$this->insert('paipai_order',$trade);
		if($user['id']>0 && $trade['relate_id']>0){
		    $this->rebate($user,$trade,17);
	    }
	}
	
	public function rebate($user,$trade,$shijian=0){ //user数组包含会员名，会员id，会员等级，推荐人  trade数组包含订单全部信息，带有id号说明是找回订单
	    if($shijian==0){
		    exit('缺少指定事件');
		}
		
		//判断订单来源
		if(isset($trade['trade_id'])){
		    $dingdan='taobao';
			$fxbl=$this->webset['fxbl'];
			$trade_id=TAOTYPE==1?$trade['trade_id_former']:$trade['trade_id'];
			
			if($trade['commission']==0){
				return false;
			}
			if(!isset($trade['fxje']) || $trade['fxje']==0){
				$trade['fxje']=fenduan($trade['commission'], $this->webset['fxbl'], $user['level']);
				$trade['jifenbao']=jfb_data_type($trade['fxje'] * TBMONEYBL);
				$trade['jifen']=(int)($trade['fxje'] * $this->webset['jifenbl']);
			}
		}
		elseif(isset($trade['order_code'])){
		    $dingdan='mall';
			$fxbl=$this->webset['mallfxbl'];
			$trade_id=$trade['mall_name'].'返利，订单号'.$trade['order_code'];
		}
		elseif(isset($trade['dealId'])){
		    $dingdan='paipai';
			$fxbl=$this->webset['paipaifxbl'];
			$trade_id=$trade['dealId'];
		}
		
		$tgyj=0;
		$user['name']=$user['ddusername']?$user['ddusername']:$user['name'];
		if($user['tjr']>0){
			$tjr_user=$this->select('user','id,ddusername','id="'.$user['tjr'].'"');
		    if($tjr_user['id']>0 && $trade['fxje']>0){
			    $user['tjr_name']=$tjr_user['ddusername'];
				$have_tgyj=1;
		    }
		}

		if($trade['id']>0){  //如果是找回订单（前台和后台），带有订单id，从新计算返利值
			$trade['relate_id']=$trade['id'];
		    
			if(isset($trade['order_code'])){
				$fxje=$trade['fxje'];
				$jifen=$trade['jifen'];
			}
			else{
				$fxje=fenduan($trade['commission'],$fxbl,$user['level']);
				$jifen=round($fxje*$this->webset['jifenbl']);
			}

			if($trade['fxje']==0){
				$fxje=0;
			}
			
			if($have_tgyj==1){
				$tgyj=round($fxje*$this->webset['tgbl'],2);
			}

			//判断是淘宝订单还是商城订单
		    if($dingdan=='taobao'){
				$jifenbao=jfb_data_type($fxje*TBMONEYBL);  //集分宝格式化
		        $data=array('fxje'=>$fxje,'jifenbao'=>$jifenbao,'jifen'=>$jifen,'tgyj'=>$tgyj,'qrsj'=>TIME,'outer_code'=>$user['id'],'uid'=>$user['id'],'checked'=>2,'status'=>5);
				if(array_key_exists('ddjt',$trade)){
				    $data['ddjt']=$trade['ddjt'];
				}
			    $table_name='tradelist';
		    }
			elseif($dingdan=='paipai'){
		        $data=array('fxje'=>$fxje,'jifen'=>$jifen,'tgyj'=>$tgyj,'addtime'=>TIME,'outInfo'=>$user['id'],'uid'=>$user['id'],'checked'=>2);
			    $table_name='paipai_order';
		    }
		    elseif($dingdan=='mall'){
				$mall_fan_type=$this->select('mall','type','id="'.$trade['mall_id'].'"');
				if($mall_fan_type==2){
					$fxje=0;
				}
		        $data=array('fxje'=>$fxje,'jifen'=>$jifen,'tgyj'=>$tgyj,'qrsj'=>TIME,'uid'=>$user['id'],'status'=>1);
			    $table_name='mall_order';
		    }
			
			$this->update($table_name,$data,'id="'.$trade['id'].'"');
		}
		else{
		    $fxje=$trade['fxje'];
		    $jifen=$trade['jifen'];
			$jifenbao=$trade['jifenbao'];	
			if($have_tgyj==1){
				$tgyj=round($fxje*$this->webset['tgbl'],2);
			}
		}
		$trade['relate_id']=(int)$trade['relate_id'];
	
		//给会员加返利，等级，积分
		$set_con_arr=array(array('f'=>'money','v'=>$fxje,'e'=>'+'),array('f'=>'level','v'=>1,'e'=>'+'),array('f'=>'jifen','v'=>$jifen,'e'=>'+'));
		
		if($dingdan=='taobao'){  //淘宝订单返的是集分宝
			$set_con_arr[0]['f']='jifenbao';
			$set_con_arr[0]['v']=$jifenbao;
		}
		
		if($trade['commission']>=$this->webset['taoapi']['freeze_limit'] && $this->webset['taoapi']['freeze']==1 && $dingdan=='taobao'){ //淘宝订单有冻结返利
			//$freeze=1;
		}
		else{
			$freeze=0;
		}

		$this->update_user_mingxi($set_con_arr, $user['id'],$shijian,$trade_id,0,$freeze,$trade['pay_time'],$trade['relate_id']); //冻结佣金，带有下单时间
		//推广佣金
		$this->tgfz($tgyj,$user['tjr'],$user['id'],$user['name'],$trade['relate_id'],$trade['pay_time'],$freeze);

		if($table_name=='mall_order'){
			$this->ddtuiguang($user['id'],$trade['relate_id'],$fxje,$table_name);
		}
		else{
			if($table_name=='tradelist'){
				$goods_id=$trade['num_iid'];
			}
			else{
				$goods_id=$trade['commId'];
			}
			$this->ddtuiguang($user['id'],$trade['relate_id'],$fxje,$table_name,$goods_id);
		}
	}
	
	function ddtuiguang($uid,$order_id,$fxje,$mall,$goods_id='',$date=''){
		//exit($uid.'--'.$order_id.'--'.$fxje.'--'.$mall.'--'.$goods_id.'--'.$date);
		if($mall=='mall_order'){
			$mall=1;
		}
		elseif($mall=='tradelist'){
			$mall=2;
		}
		elseif($type=='paipai_order'){
			$mall=3;
		}
		
		if($mall==1){
			$ddtuiguang=$this->select('ddtuiguang','*','status=0 and mall="'.$mall.'" and uid="'.$uid.'" and order_id="'.$order_id.'"');
		}
		elseif($mall==2 || $mall==3){
			$ddtuiguang=$this->select('ddtuiguang','*','status=0 and mall="'.$mall.'" and uid="'.$uid.'" and goods_id="'.$goods_id.'"');
		}
		
		if(empty($ddtuiguang)) return -1;
		$fuid=(int)$ddtuiguang['fuid'];
		$shuju_id=(int)$ddtuiguang['shuju_id'];
		$code=$ddtuiguang['code'];
		if($fuid==0) return -2;
		$fuid=(int)$this->select('user','id','id="'.$fuid.'"');
		if($fuid==0) return -3;
		if($fuid==$uid) return -4;
			
		if($code=='zdm'){ //值得买商品商城类型
			$bili=(float)$this->webset['zhidemai']['jiangli_bili'];
			if($bili==0) return -5;
			$jiangli=round($fxje*$bili,2);
			$title=$this->select('ddzhidemai','title','id="'.$shuju_id.'"');
			$shijian_id=25;
			$ddtuiguang_update_data[]=array('f'=>'order_id','v'=>(int)$order_id,'e'=>'=');
		}
		elseif($code=='share'){
			$bili=(float)$this->webset['baobei']['jiangli_bili'];
			if($bili==0) return -6;
			$jiangli=round($fxje*$bili,2);
			if($mall==2){
				$title=$this->select('tradelist','item_title','id="'.$order_id.'"');
			}
			elseif($mall==3){
				$title=$this->select('paipai_order','commName','id="'.$order_id.'"');
			}
			$shijian_id=26;
			$ddtuiguang_update_data[]=array('f'=>'order_id','v'=>$order_id,'e'=>'=');
		}
		
		$update_user_data[]=array('f'=>'money','v'=>$jiangli,'e'=>'+');
		$this->update_user_mingxi($update_user_data,$fuid,$shijian_id,$title,0,0,'',$order_id);
		$ddtuiguang_update_data[]=array('f'=>'status','v'=>1,'e'=>'=');
		$ddtuiguang_update_data[]=array('f'=>'pay_time','v'=>SJ,'e'=>'=');
		$ddtuiguang_update_data[]=array('f'=>'money','v'=>$jiangli,'e'=>'=');
		$this->update('ddtuiguang',$ddtuiguang_update_data,'id="'.$ddtuiguang['id'].'"');
		
		return 1;
	}
	
	function ddtuiguang_refund($mall,$order_id,$item_title){
		$ddtuiguang=$this->select('ddtuiguang','*','mall="'.$mall.'" && order_id="'.$order_id.'"');
		if(!empty($ddtuiguang)){
			$data=array('f'=>'money','v'=>-$ddtuiguang['money'],'e'=>'+');
			if($ddtuiguang['code']=='zdm'){
				$shijian_id=27;
			}
			elseif($ddtuiguang['code']=='share'){
				$shijian_id=28;
			}
			$this->update_user_mingxi($data,$ddtuiguang['fuid'],$shijian_id,$item_title,0,'','',$trade['id']);
		}
		return 1;
	}
	
	function ddtuiguang_insert($data){
		$fuid=(int)$data['fuid'];
		if($fuid==0) return 0;
		$uid=$data['uid'];
		if($uid==0) return 0;
		if($fuid==$uid) return 0;
		$order_id=$data['order_id'];
		$mall=$data['mall'];
		$status=$data['status'];
		$code=$data['code'];
		$goods_id=$data['goods_id'];
		$shuju_id=$data['shuju_id'];
		
		if($mall==1){
			$bili=(float)$this->webset['zhidemai']['jiangli_bili'];
			if($bili==0) return -1;
			$data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$order_id,'mall'=>$mall,'code'=>$code,'shuju_id'=>$shuju_id,'date'=>date('Ymd'));
		}
		elseif($mall==2 || $mall==3){
			$bili=(float)$this->webset['baobei']['jiangli_bili'];
			if($bili==0) return -1;
			$data=array('fuid'=>$fuid,'uid'=>$this->dduser['id'],'order_id'=>0,'goods_id'=>$goods_id,'mall'=>$mall,'code'=>$code,'shuju_id'=>$shuju_id,'date'=>date('Ymd'));
		}
		
		$weiyi=substr(md5(http_build_query($data)),8,16);
		$id=(int)$this->select('ddtuiguang','id','weiyi="'.$weiyi.'"');
		if($id==0){
			$data['weiyi']=$weiyi;
			$this->insert('ddtuiguang',$data);
		}
		return 1;
	}
	
	function tgfz($tgyj,$tjrid,$uid,$username,$relate_id,$pay_time='',$freeze=0){
		if($tgyj>0){
			$tjr_tgyj=$this->select('tgyj','id,money','tjrid="'.$tjrid.'" and uid="'.$uid.'"');
			$tjr_tgyj['money']=(float)$tjr_tgyj['money'];

			if($tjr_tgyj['money']+$tgyj>$this->webset['tgfz']){
				$tgyj=$this->webset['tgfz']-$tjr_tgyj['money'];
			}

			if($tgyj>0){
				if(!$tjr_tgyj['id']){
					$data=array('tjrid'=>$tjrid,'uid'=>$uid,'money'=>$tgyj);
					$this->insert('tgyj',$data);
				}
				else{
					$data=array('f'=>'money','e'=>'+','v'=>$tgyj);
					$this->update('tgyj',$data,'id='.$tjr_tgyj['id']);
				}

				if($tjr_tgyj['money']+$tgyj>=$this->webset['tgfz']){
					unset($data);
					$data=array(array('f'=>'tjr','e'=>'=','v'=>0),array('f'=>'tjr_over','e'=>'=','v'=>$tjrid));
					$this->update('user',$data,'id='.$uid);
				}

				$set_con_arr=array('f'=>'money','v'=>$tgyj,'e'=>'+');
		    	$this->update_user_mingxi($set_con_arr, $tjrid,6,$username,0,$freeze,$pay_time,$relate_id);
			}
		}
	}
	
	function refund($id,$do=1){
	    $trade=$this->select('tradelist','id,num_iid,item_title,outer_code,checked,fxje,jifenbao,jifen,tgyj,trade_id,commission,uid,pay_time,checked','id="'.$id.'"');
		$trade_id=preg_replace('/_\d+/','',$trade['trade_id']);
		
		if($trade['id']>0 && $trade['uid']>0 && $trade['checked']==2){
		    $user=$this->select('user','ddusername,tjr,txstatus,tbtxstatus,money,jifenbao,dhstate,email,mobile,mobile_test','id="'.$trade['uid'].'"');
			if($user['ddusername']!=''){ //会员存在，剪掉金额，积分，等级
				if($trade['jifenbao']>0){
					$data=array(array('f'=>'jifenbao','e'=>'+','v'=>-$trade['jifenbao']));
				}
				elseif($trade['fxje']>0){
					$data=array(array('f'=>'money','e'=>'+','v'=>-$trade['fxje']));
				}
				$data[]=array('f'=>'jifen','e'=>'+','v'=>-$trade['jifen']);
				$data[]=array('f'=>'level','e'=>'-','v'=>1);
				if($user['tbtxstatus']==1 && $user['jifenbao']-$trade['jifenbao']<0){ //如果会员处在提现中并且现有金额小于退款金额，取消提现状态
					$why='您的淘宝订单'.$trade_id.'发生退款，所以取消本次提现';
					$tixian=$this->select('tixian','id,money','uid="'.$trade['uid'].' and type=1" order by id desc');
					$user_data[]=array('f'=>'jifenbao','e'=>'+','v'=>$tixian['money']);
					$user_data[]=array('f'=>'tbtxstatus','e'=>'=','v'=>0);
					$msg_data=array('uid'=>$trade['uid'],'money'=>$tixian['money'],'why'=>$why,'email'=>$user['email']);
					if($user['mobile_test']==1){
						$msg_data['mobile']=$user['mobile'];
					}
		            $msg=$this->msg_insert($msg_data,3); //提现失败3号站内信
		            $tixian_data=array('f'=>'status','e'=>'=','v'=>'2');
					$this->update('tixian',$tixian_data,'id="'.$tixian['id'].'"');
					$this->update('user',$user_data,'id="'.$trade['uid'].'"');
				}
				if($user['dhstate']==1){ //如果会员处在兑换中
					$why='您的淘宝订单'.$trade_id.'发生退款，所以取消本次兑换';
					$msg_data=array('uid'=>$trade['uid'],$why,'goods_title'=>$duihuan['goods_title'],'email'=>$user['email']);
					if($user['mobile_test']==1){
						$msg_data['mobile']=$user['mobile'];
					}
					
					$duihuan=$this->select('duihuan as a,huan_goods as b','a.id,a.spend,a.mode,a.title as goods_title','a.uid="'.$trade['uid'].'" and a.huan_goods_id=b.id order by a.id desc');
					if($mode==1 && $user['jifenbao']-$duihuan['spend']){  //金额兑换，现有金额小于退款金额，取消本次兑换
                        $user_data[]=array('f'=>'jifenbao','e'=>'+','v'=>$duihuan['spend']);
						$user_data[]=array('f'=>'dhstate','e'=>'=','v'=>0);
		                $this->msg_insert($msg_data,5); //兑换失败5号站内信
		                $duihuan_data=array('f'=>'status','e'=>'=','v'=>'2');
						$this->update('duihuan',$duihuan_data,'id="'.$duihuan['id'].'"');
						$this->update('user',$user_data,'id="'.$trade['uid'].'"');
					}
					elseif($mode==2 && $user['jifen']-$duihuan['spend']){  //积分兑换，现有积分小于退款积分，取消本次兑换
					    $user_data[]=array('f'=>'jifen','e'=>'+','v'=>$duihuan['spend']);
						$user_data[]=array('f'=>'dhstate','e'=>'=','v'=>0);
		                $this->msg_insert($msg_data,5); //兑换失败5号站内信
		                $duihuan_data=array('f'=>'status','e'=>'=','v'=>'2');
						$this->update('duihuan',$duihuan_data,'id="'.$duihuan['id'].'"');
						$this->update('user',$user_data,'id="'.$trade['uid'].'"');
					}
				}
				$mingxi_id=12+$do; //明细id，do为1是退款，明细id是13，do为2是删除，明细id是14
				if($this->webset['taoapi']['freeze']==1){ //冻结类型1，减去冻结佣金
					/*$d=date('Ym',strtotime($trade['pay_time']));
					$income_id=$this->select('income','id','uid="'.$trade['uid'].'" and date="'.$d.'"');
					if($income_id>0){
						$data=array(array('f'=>'money','e'=>'-','v'=>$trade['fxje']),array('f'=>'jifen','e'=>'-','v'=>$trade['jifen']));
						$this->update('income',$data,'id="'.$income_id.'"');
						$mingxi_data=array('uid'=>$trade['uid'],'money'=>-$trade['fxje'],'jifen'=>-$trade['jifen'],'shijian'=>$mingxi_id,'source'=>$trade_id);
						$this->mingxi_insert($data);
					}
					else{
						$this->update_user_mingxi($data,$trade['uid'],$mingxi_id,$trade_id);
					}*/
				}
				else{
					$this->update_user_mingxi($data,$trade['uid'],$mingxi_id,$trade_id);
				}
			}
			else{
			    return '没有确认用户！';
			}
			if($trade['tgyj']>0 && $user['tjr']>0){
				if($this->webset['taoapi']['freeze']==1){ //冻结类型1，减去冻结佣金
					/*$income_id=$this->select('income','id','uid="'.$user['tjr'].'" and date="'.$d.'"');
					if($income_id>0){
						$data=array(array('f'=>'money','e'=>'-','v'=>$trade['tgyj']));
						$this->update('income',$data,'id="'.$income_id.'"');
						$mingxi_data=array('uid'=>$user['tjr'],'money'=>-$trade['tgyj'],'shijian'=>15,'source'=>$user['ddusername']);
						$this->mingxi_insert($data);
					}*/
				}
				else{
					$data=array(array('f'=>'money','e'=>'+','v'=>-$trade['tgyj']));
					$this->update_user_mingxi($data,$user['tjr'],15,$user['ddusername']);
					$this->update('tgyj',$data,'uid="'.$trade['uid'].'"');
				}
			}
			
			$this->ddtuiguang_refund(2,$trade['id'],$trade['item_title']);
			
		}
		if($do==1){  //退款订单
			$data=array('checked'=>-1,'status'=>4);
			$this->update('tradelist',$data,'id="'.$trade['id'].'"');
			$word='完成退款';
		}
		elseif($do==2){  //删除订单
			$this->delete('tradelist','id="'.$trade['id'].'"');
			$word='完成删除';
		}
		$msg_data=array('uid'=>$trade['uid'],'trade_id'=>$trade_id,'email'=>$user['mobile']);
		if($user['mobile_test']==1){
			$msg_data['mobile']=$user['mobile'];
		}
		$msg=$this->msg_insert($msg_data,7); //退款7号站内信
		return $word;
	}
	
	function update_user_mingxi($set_con_arr, $uid, $shijian, $source = '', $alert = 0, $freeze = 0,$date='',$relate_id=0) { //在update会员数据中，如果金额和积分发生了变化，自动插入一条明细，带有时间编号和数据来源，$freeze表示此金额是否为冻结返利
		$money=0;
		$jifenbao=0;
		$jifen=0;
		if ($freeze == 1) { //冻结返利
		    $date=date('Ym',strtotime($date));  //下单的月份
		    $set = array ();
			if (!array_key_exists(0, $set_con_arr)) {
				$set_arr[0] = $set_con_arr;
			} else {
				$set_arr = $set_con_arr;
			}

			if (!array_key_exists('f', $set_arr[0])) {
				foreach ($set_arr[0] as $k => $v) {
					$arr['f'] = $k;
					$arr['e'] = '+';
					$arr['v'] = $v;
					$set[] = $arr;
				}
			} else {
				foreach ($set_arr as $k => $v) {
					if ($v['e'] == '' || $v['e'] == '=') {
						$arr['e'] = '=';
					} else {
						$arr['e'] = $v['e'];
					}
					$arr['f'] = $v['f'];
					$arr['e'] = '+';
					$arr['v'] = $v['v'];
					$set[] = $arr;
				}
			}
			
			foreach($set as $k=>$v){
			    if($v['f']=='money' && $v['v']>0){
				    $money=$v['v'];
					unset($set[$k]);
				}
				if($v['f']=='jifen' && $v['v']>0){
				    $jifen=$v['v'];
					unset($set[$k]);
				}
			}

			$income_id=$this->select('income','id','uid="'.$uid.'" and date="'.$date.'"');
			if(!$income_id){
				$data=array('money'=>$money,'jifen'=>$jifen,'uid'=>$uid,'date'=>$date);
			    $this->insert('income',$data);
			}
			else{
			    $data=array(array('f'=>'money','e'=>'+','v'=>$money),array('f'=>'jifen','e'=>'+','v'=>$jifen));
				$this->update('income',$data,'id="'.$income_id.'"');
			}

			if(!empty($set)){
				foreach($set as $k=>$v){ //重置数组，使数组第一个元素的键名为0
			        $set1[]=$v;
			    }
			   $this->update('user', $set1, 'id="' . $uid . '"',1, $alert);
			}
		}
		else{
		    $set_arr = $this->update('user', $set_con_arr, 'id="' . $uid . '"',1, $alert);
		    foreach ($set_arr as $row) {
			    if (($row['f'] == 'money' && abs($row['v']) > 0)) {
				    $money = $row['v'];
			    }
				if (($row['f'] == 'jifenbao' && abs($row['v']) > 0)) {
				    $jifenbao = $row['v'];
			    }
			    if (($row['f'] == 'jifen' && abs($row['v']) > 0)) {
				    $jifen = $row['v'];
			    }
		    }
		}

		$data = array (
			'money' => $money,
			'jifenbao' => $jifenbao,
			'jifen' => $jifen,
			'uid' => $uid,
			'shijian' => $shijian,
			'source' => $source,
			'relate_id' => $relate_id
		);
		return $this->mingxi_insert($data, $alert);
	}
	
	function check_user($username,$type=''){
		if($this->webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
            include_once DDROOT.'/uc_client/client.php';
			$uc_name=iconv("utf-8","utf-8",$username);
			$ucresult = uc_user_checkname($uc_name);
			if($type==''){
				if($ucresult!=1) return 'false';
		    	else return 'true';
			}
		    else{
				if($ucresult!=1) return 'true';
		    	else return 'false';
			}
		}
		else{
		    $id=$this->select('user','id',"ddusername='$username'");
			if($type==''){
				if($id>0) return 'false';
		    	else return 'true';
			}
		    else{
				if($id>0) return 'true';
		    	else return 'false';
			}
		}
	}
	
	function check_oldpass($oldpass,$uid){
		if($this->webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
            include_once DDROOT.'/uc_client/client.php';
			$username=$this->select('user','ddusername','id="'.$uid.'"');
			$uc_name=iconv("utf-8","utf-8",$username);
			list ($ucid, $uc_name, $pwd, $email) = uc_user_login($uc_name, $oldpass);
			if($ucid<=0){
			    return 'false';
			}
			else{
			    return 'true';
			}
		}
		else{
			$id=$this->select('user','id',"id='$uid' and ddpassword='".md5($oldpass)."'");
			if($id>0) return 'true';
			else return 'false';
		}
	}
	
	function check_email($email){
		if($this->webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
            include_once DDROOT.'/uc_client/client.php';
			$ucresult = uc_user_checkemail($email);
			if($ucresult!=1){
			    return 'false';
			}
			else{
			    return 'true';
			}
		}
		else{
		    $id=$this->select('user','id',"email='$email'");
		    if($id>0) return 'false';
		    else return 'true';
		}
	}
	
	function check_alipay($alipay){
	    $id=$this->select('user','id',"alipay='$alipay'");
		if($id>0) return 'false';
		else return 'true';
	}
	
	function check_my_email($email,$dduserid){
	    $id=$this->select('user','id',"id<>'$dduserid' and email='".$email."'");
		if($id>0){
		    return $id;
		}
		else{
		    return 0;
		}
	}

	function check_my_field($f,$v,$dduserid){
	    $id=$this->select('user','id',"id<>'$dduserid' and ".$f."='".$v."'");
		if($id>0){
		    return $id;
		}
		else{
		    return 0;
		}
	}
	
	function webset($l=0) {
		$arr = $this->select_all('webset', '*', 'type=1 or type=0');
		if(empty($arr)){
			return false;
		}
		$webset = array ();
		foreach ($arr as $row) {
			if ($row['type'] == 1) {
				$row['val'] = unserialize($row['val']);
			} else {
				$row['val'] = $row['val'];
			}
			$webset[$row['var']] = $row['val'];
		}

		$arr = $this->select_all('webset', '*', 'type=2');
		if(empty($arr)){
			return false;
		}

		foreach ($arr as $row) {
			if($row['id']<88){
				$name = str_replace('_', '', strtoupper($row['var']));
			}
			else{
				$name = strtoupper($row['var']);
			}
			
			$constant[$name]=$row['val'];
			if($l==101){
				define($name,$row['val']);
			}
		}

		dd_float($constant);
		dd_set_cache('constant',$constant);
		
		$webset['taoapi']['jssdk_key']=$webset['taoapi']['appkey'];
		$webset['taoapi']['jssdk_secret']=$webset['taoapi']['secret'];
		
		$webset['duomai']['wzbh']=sprintf("%03s", $webset['duomai']['wzbh']);

		if($l==101){
			return $webset;
		}
		dd_set_cache('webset',$webset);

		if($l==1){return;} //只更新webset就结束
	}
	
	function phpwind($user,$forward){ //$user包含uid,username,password(原始密码),email,money,credit,time,cktime
	    if($this->webset['phpwind']['open']==0){
		    return $forward;
		}
		//$forward=htmlspecialchars($forward);
		$passport_key = $this->webset['phpwind']['key'];
        $userdb = array();
		$jumpurl = $this->webset['phpwind']['url'];
		
		$userdb['uid']		= $user['id'];
        $userdb['username']	= $user['name'];
        $userdb['password']	= $user['password'];
        $userdb['email']	= $user['email'];
        $userdb['money']	= 0;
        $userdb['credit']	= 0;
        $userdb['time']		= TIME;
        $userdb['cktime']	= $user['cookietime'] > 0 ? (TIME + $user['cookietime']) : 1200;
		
		$userdb_encode = '';
        foreach($userdb as $key=>$val){
	        $userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
        }
		
        $userdb_encode = str_replace('=', '', StrCode($userdb_encode,$passport_key));

        if(substr($jumpurl, -1, 1) != '/') $jumpurl .= '/';
		
		if(MOD=='user' && (ACT=='login' || ACT=='register' || ACT=='info')){
			$action='login';
		}
		elseif(MOD=='user' && ACT=='exit'){
			$action='quit';
		}

		$verify = md5($action.$userdb_encode.$forward.$passport_key);
	    $url = $jumpurl."passport_client.php?action=".$action."&userdb=".rawurlencode($userdb_encode)."&forward=".rawurlencode($forward)."&verify=".rawurlencode($verify);
		return $url;
	}
	
	function duihuan($row,$admin=1){
		$goods_id=$row['goods_id'];
		$uid=$row['uid'];
		$email=$row['email'];
		$mobile=$row['mobile'];
		$jifenbao=$row['jifenbao'];
		$jifen=$row['jifen'];
		$title=$row['title'];
		$array=$row['array'];
		$auto=$row['auto'];
		$mode=$row['mode'];
		$num=$row['num'];
		$dh_id=$row['dh_id'];
		$re=1;
		if($admin==0){ //前台申请兑换，数量就减$num
			$huan_goods_arr[]=array('f'=>'num','e'=>'-','v'=>$num);
		}
	    if($array!='' && $auto+$admin>=1){
			$code_arr=unserialize($array);	
			if(!empty($code_arr)&&count($code_arr)>=$num){
				foreach($code_arr as $k=>$v){
					if(count($codes)<$num){
						$codes[]=$v;
						unset($code_arr[$k]);
						$array=serialize($code_arr);
					}else{
						break;
					}
				}
				$codestr=implode("、",$codes);
				$code='认领代码：'.$codestr;
				$huan_goods_arr[]=array('f'=>'array','e'=>'=','v'=>$array);
			}else{
			    $code='认领代码库存不足，请与管理员联系！';
			}
			$re=2;
		}
		else{
		    $code='';
			$array='';
		}
		
		if($auto+$admin>=1){ //如果是自动兑换或者后台审核
			$data=array('uid'=>$uid,'shijian'=>10,'source'=>$title);
			if($mode==1){
				$data['jifenbao']=-$jifenbao;
			}
			elseif($mode==2){
				$data['jifen']=-$jifen;
			}
			else{
				exit('数据错误');
			}
		    $this->mingxi_insert($data);
			$msg_data=array('uid'=>$uid,'goods_title'=>$title,'code'=>$code,'code'=>$code);
			
			if($mobile!=''){
				$msg_data['mobile']=$mobile;
			}
			if($email!=''){
				$msg_data['email']=$email;
			}
			
		    $this->msg_insert($msg_data,4); //兑换成功4号站内信

			$this->update('duihuan',array("code"=>$code), 'id='.$dh_id);
			if(!empty($huan_goods_arr)){
				$this->update('huan_goods',$huan_goods_arr,'id="'.$goods_id.'"');
			}
		}
		if($admin==0 && $auto==0){ //前台兑换，不是自动发货，商品数量减1
			$this->update('huan_goods',$huan_goods_arr,'id="'.$goods_id.'"');
		}
		
		return $re;
	}
	
	function no_pay_trade($pay_time,$jifenbao,$fxje=0){
		$pay_time=strtotime($pay_time);
		$freeze=$this->webset['taoapi']['freeze'];
		$freeze_limit=$this->webset['taoapi']['freeze_limit'];
		$money_freeze_limit=round($this->webset['taoapi']['freeze_limit']/TBMONEYBL,2);
		$auto_jiesuan=$this->webset['taoapi']['auto_jiesuan'];
		$freeze_sday=strtotime($this->webset['taoapi']['freeze_sday']);

		if($freeze==2 && $pay_time>$freeze_sday && TIME-$pay_time<3600*24*TAO_FREEZE_DAY && ($jifenbao>0 && $jifenbao>=$freeze_limit)){
			return 1;
		}
		if($freeze==1 && $fxje>=$freeze_limit){
			if(date("d")>=$auto_jiesuan){
				if(date('m',$pay_time)==date("m")){
					return 1;
				}
			}
			else{
				if(date('m',$pay_time)==date("m") || date('m',$pay_time)==date("m",strtotime("-1 month"))){
					return 1;
				}
			}
		}
		return 0;
	}
	
	function freeze_user($dduser){ //dduser是一个数组，包含id,money,jifenbao,jifen
		if($this->webset['taoapi']['freeze']==1){
			/*$freeze_money=$this->sum('income','money','uid="'.$dduser['id'].'"');
			$freeze_jifen=$this->sum('income','jifen','uid="'.$dduser['id'].'"');
			
			$dduser['live_money']=$dduser['money'];  //可用金额
			$dduser['freeze_money']=$freeze_money;  //冻结金额
			$dduser['money']+=$freeze_money; //总金额
			$dduser['live_jifen']=$dduser['jifen'];  //可用积分
			$dduser['freeze_jifen']=$freeze_jifen;  //冻结积分
			$dduser['jifen']+=$freeze_jifen; //总积分*/
			
		}
		elseif($this->webset['taoapi']['freeze']==2){
			$datetime=date('Y-m-d H:i:s',strtotime("-".TAO_FREEZE_DAY." day"));
			if($datetime<$this->webset['taoapi']['freeze_sday']){
				$datetime=$this->webset['taoapi']['freeze_sday'];
			}
			$freeze=$this->sum('tradelist','fxje,jifenbao,jifen','uid="'.$dduser['id'].'" and checked=2 and  pay_time>="'.$datetime.'" and jifenbao>"'.$this->webset['taoapi']['freeze_limit'].'"');
			$freeze_jifenbao=$freeze['jifenbao'];
			$freeze_jifen=$freeze['jifen'];
			
			$freeze_limit_money=round($this->webset['taoapi']['freeze_limit']/TBMONEYBL,2);
			$freeze['freeze_money']=$this->sum('tradelist','fxje','uid="'.$dduser['id'].'" and checked=2 and  pay_time>="'.$datetime.'" and fxje>"'.$freeze_limit_money.'" and jifenbao=0');
			
			/*$tg_limit=round($freeze_limit_money*$this->webset['tgbl'],2);
			
			$tg_freeze_money=$this->sum('mingxi','money','uid="'.$dduser['id'].'" and shijian=6 and money>"'.$tg_limit.'" and  addtime>="'.$datetime.'"');
			$freeze['freeze_money']+=$tg_freeze_money;*/
			
			$dduser['live_jifenbao']=data_type(round($dduser['jifenbao']-$freeze_jifenbao,2),TBMONEYTYPE);  //可用金额
			$dduser['freeze_jifenbao']=$freeze_jifenbao;  //冻结金额
			$dduser['live_jifen']=$dduser['jifen']-$freeze_jifen;  //可用积分
			$dduser['freeze_jifen']=$freeze_jifen;  //冻结积分
			$dduser['live_money']=round($dduser['money']-$freeze['freeze_money'],2);
			$dduser['freeze_money']=$freeze['freeze_money'];
		}
		else{
			$dduser['freeze_jifenbao']=0;
			$dduser['freeze_jifen']=0;
			$dduser['live_jifenbao']=jfb_data_type($dduser['jifenbao']);
			$dduser['live_jifen']=$dduser['jifen'];
			$dduser['live_money']=$dduser['money'];
			$dduser['freeze_money']=0;
		}
		
		if(defined('INDEX')){
			if($dduser['live_jifenbao']<0) $dduser['live_jifenbao']=0;
			if($dduser['live_jifen']<0) $dduser['live_jifen']=0;
		}
		
		return $dduser;
	}
	
	function user_money_from_buy($uid){
		$num=(float)$this->sum('mingxi','money','uid="'.$uid.'" and shijian in (2,3,8,12,17,18)');
		return round($num,2);
	}
	
	function tixian($id,$do='yes',$ddback=0,$api_ok='',$api_return=''){
		$data=array();
		$row=$this->select('tixian as a,user as b','a.*,b.txstatus as user_status,b.tbtxstatus as user_tbstatus,b.ddusername,b.email,b.mobile as user_mobile,b.mobile_test','a.id="'.$id.'" and a.uid=b.id');
		$money=(float)$row['money'];
		$money2=(float)$row['money2'];
		$type=$row['type'];
		
		if($row['wait']==1 && $do=='yes' && $ddback==0 && $this->webset['tixian']['ddpay']==1){
			if(strpos($_SERVER['HTTP_REFERER'],'act=addedi')!==false){ //来源是提现处理页，返回错误状态
				return array('s'=>0,'r'=>$row['api_return']);
			}
			else{  //来源是提现列表页，返回正确状态（批量提现）
				return array('s'=>1,'r'=>$row);
			}
		}
		
		if($row['tool']==3){
			$txtool=$row['code'];
		}
		elseif($row['tool']==2){
			$txtool='财付通：'.$row['code'];
		}
		elseif($row['tool']==1){
			$txtool='支付宝：'.$row['code'];
		}

		if($row['status']!=0){
	    	return array('s'=>0,'r'=>'ID：'.$row['id'].'此订单状态不是待审核'); //数据错误
		}
		
		if($type==1){
			$alipay=$row['code'];
			$yitixian_f='tbyitixian';  //集分宝提现，已提现字段名
			$money_f='jifenbao';
			$txstatus_f='tbtxstatus';
			if($row['user_tbstatus']!=1) return array('s'=>0,'r'=>'ID：'.$row['id'].'会员集分宝提现不是提现中'); //数据错误
		}
		elseif($type==2){
			$yitixian_f='yitixian';  //金额提现，已提现字段名
			$money_f='money';
			$txstatus_f='txstatus';
			if($row['user_status']!=1) return array('s'=>0,'r'=>'ID：'.$row['id'].'会员金额提现不是提现中'); //数据错误
		}
	
		$user_data=array(array('f'=>$txstatus_f,'e'=>'=','v'=>0));  //不管提现处理的结果，会员的提现状态都是0
	
		$msg_data=array('uid'=>$row['uid'],'username'=>$row['ddusername'],'money'=>$money.($type==1?TBMONEY:'元'),'txtool'=>$txtool,'email'=>$row['email']);
	
		if($do=='yes'){
			if($ddback==1){
				if($api_ok=='' || $api_return==''){
					return array('s'=>0,'r'=>'参数错误'); //数据错误
				}
			}
			else{
				if($type==1 && $this->webset['tixian']['ddpay']==1){
					$ddopen=fs('ddopen');
					$ddopen->ini();
					$api=$ddopen->pay_jifenbao($alipay,$money2,$id,$row['realname'],$row['mobile']);
					$api_return=$api['r']?$api['r']:'未知错误';
					if($api['s']==1){
						$api_ok=1;
					}
					else{
						$api_ok=0;
					}
				}
				else{
					$api_ok=1;
					$api_return='';
				}
			}

			if($api_ok==1){
				unset($data);
				$data=array('uid'=>$row['uid'],$money_f=>-$money,'shijian'=>9,'source'=>$txtool,'relate_id'=>$row['id']);
				$this->mingxi_insert($data);
				$txstatus=0;
				$msg=$this->msg_insert($msg_data,2); //提现成功2号站内信
				unset($data);
				$data=array(array('f'=>'status','e'=>'=','v'=>'1'),array('f'=>'wait','e'=>'=','v'=>'0'),array('f'=>'api_return','e'=>'=','v'=>$api_return));
				$user_data[]=array('f'=>$yitixian_f,'e'=>'+','v'=>$row['money']);
				$user_data[]=array('f'=>'lasttixian','e'=>'=','v'=>TIME);
		
				if($this->webset['tixian']['hytxjl']>0){
		    		$user=$this->select('user','ddusername,tjr,tjr_over,hytx','id="'.$row['uid'].'"');
					if($user['tjr_over']>0) $user['tjr']=$user['tjr_over'];
		    		if($user['tjr']>0 && $user['hytx']==0){
		        		$tjr_data=array('f'=>'money','e'=>'+','v'=>$this->webset['tixian']['hytxjl']);
						$this->update_user_mingxi($tjr_data, (int)$user['tjr'],11,$user['ddusername']); //好友提现奖励，11号明细
						$this->update('user',array('hytx'=>1),'id="'.$row['uid'].'"');
		    		}
				}
			}
			else{  //如果多多集分宝发放接口反馈错误码，会员和提现数据的状态不变
				unset($data);
				$data[]=array('f'=>'api_return','e'=>'=','v'=>$api_return);
				if($api['s']==2){ //等待发送中
					$data[]=array('f'=>'wait','e'=>'=','v'=>1); 
				}
				$this->update('tixian',$data,'id="'.$id.'"');
				
				if(strpos($_SERVER['HTTP_REFERER'],'act=addedi')!==false){ //来源是提现处理页，返回错误状态
					return array('s'=>0,'r'=>$api_return);
				}
				else{  //来源是提现列表页，返回正确状态（批量提现）
					return array('s'=>1,'r'=>$row);
				}
			}
		}
		elseif($do=='no'){
			if($row['wait']==1){
				$ddopen=fs('ddopen');
				$ddopen->ini();
				$api=$ddopen->cancel_jifenbao($id);
			}
			$user_data[]=array('f'=>$money_f,'e'=>'+','v'=>$money);
			$msg_data['why']=$_POST['why'];
			$msg=$this->msg_insert($msg_data,3); //提现失败3号站内信
			$data[]=array('f'=>'status','e'=>'=','v'=>'2');
		}
		$data[]=array('f'=>'dotime','e'=>'=','v'=>TIME);
		$this->update('tixian',$data,'id="'.$id.'"');
		$this->update('user',$user_data,'id="'.$row['uid'].'"');
		$a=array('s'=>1,'r'=>$row);
		return $a;
	}
	
	function set_webset($var,$val,$jiance=1){
		if(preg_match('/[A-Z]{1,50}/',$var)){ //大写字母，是常量定义
			$type=2;
			$var=strtolower($var);
		}
		else{
			if(is_array($val)){
				$val=serialize($val);
				$type=1;
			}
			else{
				$type=0;
			}
		}
		
		if($jiance==1){
			$webset_field=$this->select_2_field('webset','id,var','1=1');
			$id=(int)array_search($var,$webset_field);
			if($id==0){
				$id=(int)array_search(strtoupper($var),$webset_field);
			}
		}
		else{
			$id=1;
		}
		if($id>0){
			$data=array('val'=>$val,'type'=>$type);
			$this->update('webset',$data,'var="'.$var.'"');
		}
		else{
			$data=array('val'=>$val,'var'=>$var,'type'=>$type);
			$this->insert('webset',$data);
		}
	}
	function webset_part($k,$r){
		$webset_field=$this->select('webset','val','var="'.$k.'"');
		$webset_field=unserialize($webset_field);
		$post_arr[$k] = $webset_field;
		foreach($webset_field as $a=>$b){
			foreach($r as $c=>$d){
				if($a==$c){
					$post_arr[$k][$a] = $d; 
				}else{
					$post_arr[$k][$c] = $d;
				}
			}
		}
		if(empty($webset_field)){
			$post_arr[$k] = $r;
		}
		return $post_arr;
	}
	
	function cron($p=0,$action='select'){
		if($action=='insert'){
			$type=$p['type'];
			unset($p['type']);
			$p=dd_xuliehua($p);
			$data=array('val'=>$p,'type'=>$type);
			$this->insert('cron',$data);
			return true;
		}
		
		if(isset($p['type'])){
			$type=$p['type'];
		}
		else{
			$type=0;
		}
		if(isset($p['limit'])){
			$limit=$p['limit'];
		}
		else{
			$limit=5;
		}
		if(isset($p['ids'])){
			$limit=count($p['ids']);
			$ids=implode(',',$p['ids']);
		}
		
		if($type==0){
			$where='1';
		}
		else{
			$where='type='.$type;
		}
		if(isset($ids)){
			$where.=' and id in('.$ids.')';
		}
		$crons=$this->select_all('cron','id,val,type',$where.' limit '.$limit);
		foreach($crons as $row){
			switch($row['type']){
				case 1:  //邮件计划任务
					$data=dd_unxuliehua($row['val']);
					mail_send($data['email'], $data['title'], $data['content'],$data['from'],$data['pwd'],$data['smtp']);
					$this->delete('cron','id='.$row['id']);
				break;
			}
		}
	}
	
	/**
     *$arr 数据传入
     *$result 统计传入
     *$result['update_num'] 返回更新数目
     *$result['insert_num'] 返回插入数目
	 *$result['chongfu'] 重复数据
     */
    function trade_import($shuju,$result) {
		$data_arr=array();
        $status_arr = include (DDROOT . '/data/status_arr.php'); //订单状态
		foreach($status_arr as $k=>$v){
			$status_arr[$k]=strip_tags($v);
		}
        if (count($shuju[1]) < 20) {
            jump("-1", "你导入的文件不符合，请重新导出淘宝客推广明细表");
        }
		//每个参数的坐标，下次只需要改这里
		$create_time_key=1;//创建日期
		$item_title_key=2;//商品信息
		$item_num_key=3;//商品数
		$pay_price_key=4;//商品单价
		$status_key=5;//订单状态
		$pay_time_key=6;//结算时间
		$real_pay_fee_key=7;//实际成交额
		$commission_rate_key=8;//商品佣金比例
		$num_iid_key=11;//商品ID
		$seller_nick_key=12;//掌柜旺旺
		$shop_title_key=13;//所属店铺
		$commission_key=14;//商品佣金收益
		$commission_rate_butie_key=15;//补贴比率
		$commission_butie_key=16;//补贴金额
		$trade_id_former_key=21;//订单编号
        foreach ((array)$shuju as $row) {
			
			if((float)$row[$num_iid_key]==0){
				$row[$num_iid_key]=dd_crc32($row[$item_title_key].$row[$pay_price_key]);
			}
            if (!preg_match('/\d+/',$row[$trade_id_former_key]) || strlen($row[$trade_id_former_key])<7) { //订单号不存在的都删掉
                continue;
            }
            unset($arr);
			$arr['status'] = array_search($row[$status_key], $status_arr);

            $arr['create_time'] = $row[$create_time_key];
            if ($row[$pay_time_key]) {
                $arr['pay_time'] = date("Y-m-d", strtotime($row[$pay_time_key]));
            }
            $arr['item_title'] = mysql_real_escape_string($row[$item_title_key]);
            $arr['shop_title'] = mysql_real_escape_string($row[$shop_title_key]);
            $arr['seller_nick'] = mysql_real_escape_string($row[$seller_nick_key]);
            $arr['num_iid'] = $row[$num_iid_key];
            $arr['item_num'] = $row[$item_num_key];
            $arr['pay_price'] = $row[$pay_price_key];
            $arr['real_pay_fee'] = $row[$real_pay_fee_key];
            if ($row[$commission_rate_key] != '0.00%') {
                $commission_rate = $row[$commission_rate_key];
            } elseif ($row[$commission_rate_butie_key] != '0.00%') {
                $commission_rate = $row[$commission_rate_butie_key];
            }
            $arr['commission_rate'] = sprintf("%01.3f", str_replace('%', '', $commission_rate) / 100);
			if($row[$commission_key]>0){
				$arr['commission'] =(float)$row[$commission_key];
			}elseif($row[$commission_butie_key]){
				$arr['commission'] =(float)$row[$commission_butie_key];
			}
            $arr['trade_id_former'] = $row[$trade_id_former_key];
			$arr['mini_trade_id'] = substr($row[$trade_id_former_key],0,8).substr($row[$trade_id_former_key],-4,4);
			$arr['trade_id']=$row[$trade_id_former_key]."_".$arr['num_iid'];
            $arr['qrsj'] = 0;
            $arr['tgyj'] = 0;
            $arr['platform'] = 0;
			$arr['outer_code'] = '';
			$arr['uid'] = 0;
			
			$arr['fxje'] = fenduan($arr['commission'], $this->webset['fxbl'], 0);
            $arr['jifenbao'] = jfb_data_type($arr['fxje'] * TBMONEYBL);
            $arr['jifen'] = (int)($arr['fxje'] * $this->webset['jifenbl']);

			foreach($data_arr as $k=>$shuzu){
				if($arr['num_iid']==$shuzu['num_iid'] && $arr['trade_id']==$shuzu['trade_id']){
					$data_arr[$k]['item_num']+=$arr['item_num'];
					$data_arr[$k]['real_pay_fee']+=$arr['real_pay_fee'];
					$data_arr[$k]['commission']+=$arr['commission'];
					
					$data_arr[$k]['fxje']+=$arr['fxje'];
					$data_arr[$k]['jifenbao']+=$arr['jifenbao'];
					$data_arr[$k]['jifen']+=$arr['jifen'];
					
					$chongfu[] = $data_arr[$k];
					$chongfu_arr=1;
					break;
				}
				else{
					$chongfu_arr=0;
				}
			}

			if($chongfu_arr==0){
				$data_arr[] = $arr;
			}
        }
        foreach ((array)$data_arr as $vo) {
			$result['insert_num']=0;
			$result['update_num']=0;
			$result['delete_num']=0;
            $result =$this->trade_ruku($vo,$result);
			$r['insert_num']+=$result['insert_num'];
			$r['update_num']+=$result['update_num'];
			$r['delete_num']+=$result['delete_num'];
        }
        
        $r['chongfu'] = $chongfu;
		$r['total']=count($data_arr);
		unset($shuju);
		unset($data_arr);
		
        return $r;
    }
	
    function trade_ruku($arr, $result) {
		$tradedata = $this->select('tradelist', '*', 'trade_id="' . $arr['trade_id'] . '" order by id asc');
		if($tradedata['id']>0){ //存在订单
			$arr['id']=$tradedata['id'];
			if($tradedata['addtime']==0){ //是api获取的
				return false;
			}
			else{  //是导入的				
				if ($arr['status'] != $tradedata['status']){ //状态发生变化
					
					if($tradedata['status']==4 || $tradedata['status']==5){
						//订单是失效或者结算状态，不计算
					}
					else{
						if($tradedata['uid']){
							$arr['uid']=$tradedata['uid'];
						}
						$arr=$this->complete_trade_arr($arr);
					
						if($arr['status']==5){ //结算订单
							$this->update('tradelist', $arr, 'id="' . $tradedata['id'] . '"');
							$result['update_num']++;
							if($arr['uid']>0){
								$user = $this->user_temp;
								if($arr['uid']>0&&$user['id']>0){
									unset($arr['status']);
									$this->update('tradelist', $arr, 'id="' . $tradedata['id'] . '"');
									$this->rebate($user, $arr, 8); //8号明细，确认淘宝订单
								}
							}
						}
						elseif($arr['status']==4){// 失效的订单直接删了
							$this->delete('tradelist','id="'.$tradedata['id'].'"');
							$result['delete_num']++;
						}
						else{
							$this->update('tradelist', $arr, 'id="' . $tradedata['id'] . '"');
							$result['update_num']++;
						}
					
					}
				}
			}
		}
		else{
			if($arr['status']==4){  //失效订单不入库
				return false;
			}
			$arr['addtime'] = TIME;
			
			if($tradedata['uid']){
				$arr['uid']=$tradedata['uid'];
			}
			
			$arr=$this->complete_trade_arr($arr);
            $insert_id = $this->insert('tradelist', $arr);
			if($insert_id>0){
				$this->trade_temp[$insert_id]=$arr;
				$arr['id']=$insert_id;				
				if($arr['status']==5 && $arr['uid']>0){
					if(empty($this->user_temp) || $arr['uid']!=$this->user_temp['id']){ //理论上这种情况不会发生，为了防止万一
						$user=$this->select('user','*','id="'.$arr['uid'].'"');
					}
					else{
						$user=$this->user_temp;
					}
                	$this->rebate($user, $arr, 8); //8号明细，确认淘宝订单
				}
			}
            $result['insert_num']++;
		}

        return $result;
    }
	
	function complete_trade_arr($arr){
		$trade_id=$arr['trade_id_former'];
		$mini_trade_id=$arr['mini_trade_id'];
		$num_iid=$arr['num_iid'];
		$create_time=$arr['create_time'];
		$user_id=0;
		if($arr['uid']){
			$user_id=$arr['uid'];
		}else{
			if($this->webset['taoapi']['auto_fanli']==0){
				return $arr;
			}
			
			if(isset($this->trade_id_uid_arr[$trade_id])){
				if($this->trade_id_uid_arr[$trade_id]>0){
					$user_id=$this->trade_id_uid_arr[$trade_id];
				}
			}
			else{
				$a=$this->reg_trade_uid($trade_id,$num_iid,$create_time);
				
				if($a['uid']>0){
					
					foreach($this->trade_temp as $k=>$row){
						if(preg_replace('/_\d+$/','',$row['trade_id'])==$trade_id){
							$user = $this->select("user", '*', "id=" . $a['uid']);
							if($user['id']>0){
								$row['fxje']=fenduan($row['commission'], $this->webset['fxbl'], $user['level']);
								$row['jifenbao']=jfb_data_type($row['fxje'] * TBMONEYBL);
								$row['jifen']=(int)($row['fxje'] * $this->webset['jifenbl']);
							}
						
							$this->update('tradelist',array('outer_code'=>$a['uid'],'uid'=>$a['uid'],'checked'=>3,'fxje'=>$row['fxje'],'jifenbao'=>$row['jifenbao'],'jifen'=>$row['jifen']),'id="'.$k.'"');
							if($row['status']==5){
								$row['id']=$k;
								$this->rebate($user, $row, 8); //8号明细，确认淘宝订单
							}
							unset($this->trade_temp[$k]);
						}
					}
					
					$this->trade_id_uid_arr[$trade_id]=$a['uid'];
					$user_id=$a['uid'];
				}
			}
		}
		
		if($user_id>0){
			$arr['outer_code']=$arr['uid']=$user_id;
			if($arr['status']==5){
				$arr['checked']=2;
			}
			else{
				$arr['checked']=3;
			}
			
			$user=$this->select('user','*','id="'.$user_id.'"');
			
			$arr['fxje']=fenduan($arr['commission'],$this->webset['fxbl'],$user['level']);
			$arr['jifenbao']=jfb_data_type($arr['fxje'] * TBMONEYBL);
			$arr['jifen']=(int)($arr['fxje']*$this->webset['jifenbl']);
			
			$this->user_temp=$user;
		}
		else{
			$this->user_temp=array();
		}
		return $arr;
	}
	
	function reg_trade_uid($trade_id,$num_iid,$create_time){
		$create_time=date('Ymd',strtotime($create_time));
		$last_create_time=date('Ymd',strtotime($create_time." -1 day"));
		$trade_uid=substr($trade_id,-4,4);
		$uid=$this->select('trade_uid','uid','trade_uid="'.$trade_uid.'"');
		if($uid!=''){
			if(strpos($uid,',')===false){ //订单uid记录的是1个会员
				$id=$this->select('buy_log','id','weiyi="'.$num_iid.'|'.$uid.'|'.$create_time.'" or weiyi="'.$num_iid.'|'.$uid.'|'.$last_create_time.'"');
				if($id>0){
					return array('uid'=>$uid,'trade_id'=>$trade_id);
				}
			}
			else{  //订单uid记录的是多个会员
				$uid_arr=explode(',',$uid);
				foreach($uid_arr as $v){
					$id=$this->select('buy_log','id','weiyi="'.$num_iid.'|'.$v.'|'.$create_time.'" or weiyi="'.$num_iid.'|'.$v.'|'.$last_create_time.'"');
					if($id>0){
						$buy_log_id[]=$v;
					}
				}
				if(count($buy_log_id)==1){
					return array('uid'=>$buy_log_id[0],'trade_id'=>$trade_id);
				}
			}
		}
		return array('uid'=>0,'trade_id'=>0);
	}
	//注意查看下
	function trade_uid($uid,$trade_id,$type='add'){
		$trade_id=preg_replace('/_\d+$/','',$trade_id);
		$trade_uid=substr($trade_id,-4,4);
		if($type=='add'){
			if($trade_uid>0 && $uid>0){
				$user=$this->select('user','id,trade_uid','id="'.$uid.'"');
				if($user['trade_uid']==0) $user['trade_uid']='';
				if($user['trade_uid']!=''){
					$trade_uid_arr=explode(',',$user['trade_uid']);
				}
				else{
					$trade_uid_arr=array();
				}
				if(!in_array($trade_uid,$trade_uid_arr)){
					$trade_uid_arr[]=$trade_uid;
					$data=array('trade_uid'=>implode(',',$trade_uid_arr));
					$this->update('user',$data,'id="'.$uid.'"');
				}
				
				$b=$this->select('trade_uid','*','trade_uid="'.$trade_uid.'"');
				if($b['id']>0){
					$uid_arr=explode(',',$b['uid']);
					if(!in_array($uid,$uid_arr)){
						$data=array('uid'=>$b['uid'].','.$uid);
						$this->update('trade_uid',$data,'id="'.$b['id'].'"');
					}
				}
				else{
					$data=array('trade_uid'=>$trade_uid,'uid'=>$uid);
					$this->insert('trade_uid',$data);
				}
			}
		}
		elseif($type=='del'){
			$uids=$this->select('trade_uid','uid','trade_uid="'.$trade_uid.'"');
			if($uids==$uid){
				$this->delete('trade_uid','trade_uid="'.$trade_uid.'"');
				$trade_uid=0;
				
			}
			else{
				$uid_arr=explode(',',$uids);
				$k=array_search($uid,$uid_arr);
				unset($uid_arr[$k]);
				$data=array('uid'=>implode(',',$uid_arr));
				$this->update('trade_uid',$data,'trade_uid="'.$trade_uid.'"');
				
				$user=$this->select('user','id,trade_uid','id="'.$uid.'"');
				$trade_uid_arr=explode(',',$user['trade_uid']);
				$k=array_search($uid,$uid_arr);
				unset($trade_uid_arr[$k]);
				$trade_uid=implode(',',$trade_uid_arr);
			}
			$this->update('user',array('trade_uid'=>$trade_uid),'id="'.$uid.'"');
		}
	}
	
	function dd_refund($arr,$shijian=0,$t=0){//arr数组包含以下信息：uid会员id money金额 jifen积分 jifenbao集分宝 source原因来源  relate_id 订单id  plugin表示数据来源 / $shijian 事件id  /  $t默认0 扣钱  1 加钱
		
		if($t==0){
			$e='-';	
		}elseif($t==1){
			$e='+';	
		}else{
			exit('dd_refund error!');
		}
		$uid=$arr['uid'];
		if($uid>0 && $shijian!='0'){
			//插入明细
			unset($mingxi_arr);
			$mingxi_arr=array('uid'=>$uid,'shijian'=>$shijian,'source'=>$arr['source']);
			//会员数据更新
			unset($user_arr);
			if($arr['money']>0){
				$user_arr[]=array('f'=>'money','e'=>$e,'v'=>$arr['money']);
				$mingxi_arr['money']=$e.$arr['money'];
				$tjr_money1=round($arr['money']*$this->webset['tgbl'],2);
			}
			if($arr['jifen']>0){
				$user_arr[]=array('f'=>'jifen','e'=>$e,'v'=>$arr['jifen']);
				$mingxi_arr['jifen']=$e.$arr['jifen'];
			}
			if($arr['jifenbao']>0){
				$user_arr[]=array('f'=>'jifenbao','e'=>$e,'v'=>$arr['jifenbao']);
				$mingxi_arr['jifenbao']=$e.$arr['jifenbao'];
				$tjr_money2=round(($arr['jifenbao']*$this->webset['tgbl']/TBMONEYBL),2);
			}
			$this->update('user',$user_arr,'id="'.$uid.'"');
			$this->mingxi_insert($mingxi_arr);
			if($t==1){//推荐人奖励
				$tgyj=$tjr_money1+$tjr_money2;
				$user=$this->select('user','id,tjr,ddusername','id="'.$arr['uid'].'"');
				if($user['tjr']>0){
					$this->tgfz($tgyj,$user['tjr'],$user['id'],$user['ddusername'],$arr['relate_id']);
				}
			}
		}
	}
}
?>