<?php //多多
return array (
  'admin_nav' => 
  array (
    'index' => 
    array (
      'title' => '基本设置',
    ),
    'jinzhe' => 
    array (
      'title' => '一键获取今日商品',
    ),
    'jinzhe_list' => 
    array (
      'title' => '商品列表',
    ),
    'jinzhe_class' => 
    array (
      'title' => '分类设置',
    ),
  ),
  'admin_auto' => 
  array (
    'index' => 1,
    'list' => 1,
    'addedi' => 1,
    'del' => 1,
  ),
  'table' => 
  array (
    'jinzhe' => 
    array (
      'id' => 'int(11) NOT NULL auto_increment',
      'cid' => 'int(11) NOT NULL default "1"',
      'iid' => 'bigint(11) NOT NULL',
      'pic_url' => 'varchar(200) NOT NULL',
      'price' => 'double(10,2) NOT NULL default "0.00"',
      'price_original' => 'double(10,2) NOT NULL default "0.00"',
      'title' => 'varchar(100) NOT NULL',
      'commission_rate' => 'double(10,2) NOT NULL default "0.00"',
      'volume' => 'int(11) NOT NULL default "0"',
      'baoyou' => 'tinyint(1) NOT NULL default "0"',
      'shop_type' => 'tinyint(1) NOT NULL default "0"',
      'sort' => 'smallint(6) NOT NULL',
      'starttime' => 'int(10) NOT NULL default "0"',
      'endtime' => 'int(10) NOT NULL default "0"',
      'addtime' => 'int(10) NOT NULL default "0"',
      'status' => 'tinyint(1) NOT NULL default "0"',
      'duoduo_table_index' => 'PRIMARY KEY  (`id`),KEY `cid` (`cid`),UNIQUE KEY `iid` (`iid`),KEY `title` (`title`),KEY `status` (`status`)',
    ),
    'jinzhe_class' => 
    array (
      'id' => 'int(11) NOT NULL auto_increment',
      'title' => 'varchar(32) NOT NULL',
      'bind_id' => 'int(10) NOT NULL default "0"',
      'sort' => 'smallint(6) NOT NULL',
      'duoduo_table_index' => 'PRIMARY KEY  (`id`)',
    ),
  ),
  'act_arr' => 
  array (
    0 => 
    array (
      'act' => 'index',
      'title' => '聚优惠',
      'tag' => 'jinzhe',
      'nav' => 1,
    ),
    1 => 
    array (
      'act' => 'view',
      'title' => '聚优惠',
      'tag' => 'jinzhe',
    ),
  ),
  'search' => 
  array (
  ),
  'install_sql' => 'INSERT INTO `{%BIAOTOU%}plugin_jinzhe_class`(`id`,`title`,`sort`,`bind_id`) VALUES ("1", "时尚男装", "1","1"),("2", "数码家电", "21","2"),("3", "箱包鞋靴", "31","3"),("4", "食品酒水", "41","4"),("5", "配饰百货", "51","5"),("6", "化妆护理", "61","6"),("7", "文娱体育", "71","7"),("8", "母婴玩具", "81","8"),("9", "生活周边", "91","9"),("10", "时尚女装", "11","10");',
  'uninstall_sql' => '',
  'need_include' => 1,
  'rewrite' => 1,
  'debug' => 0,
);
?>