<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if (!defined('INDEX')) {
	exit ('Access Denied');
}
/**
* @name 店铺列表
* @copyright duoduo123.com
* @example 示例shop_list();
* @param $field 字段
*/
function act_shop_list($pagesize = 27,$field = 'nick,type,level,shop_click_url,title,pic_path,fanxianlv,auction_count,sid,uid') {
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$tao_level = include (DDROOT . '/data/tao_level.php');
	$tao_area = include (DDROOT . '/data/tao_area.php');
	$tao_shop = include (DDROOT . '/data/tao_shop_cid.php');
	//店铺类型
	$type_all = dd_get_cache('type');
	$page = isset ($_GET['page']) ? (int) $_GET['page'] : 1;
	$frmnum = ($page -1) * $pagesize;
	$default_sreach_word = '查询掌柜昵称';

	if (isset ($_GET['cid'])) {
		$cid = $_GET['cid'];
		if (!is_numeric($cid)) {
			$_GET['nick'] = $cid;
			$cid = 0;
		} else {
			$cid = (int) $cid;
		}
	} else {
		$cid = 0;
	}

	$start_level = empty ($_GET['start_level']) ? '0' : intval($_GET['start_level']);
	$end_level = empty ($_GET['end_level']) ? '21' : intval($_GET['end_level']);
	$type = empty ($_GET['type']) ? '0' : intval($_GET['type']);
	$px = empty ($_GET['px']) ? '0' : intval($_GET['px']);
	switch ($px) {
		case '0' :
			$sort = 'sort desc';
			break;
		case '1' :
			$sort = 'level desc';
			break;
		case '2' :
			$sort = 'level asc';
			break;
	}

	$nick = gbk2utf8(trim($_GET['nick']));
	if ($nick == $default_sreach_word) {
		$nick = '';
	}

	$query_item = array (
		array (
			'f' => 'nick',
			'e' => 'like',
			'v' => '%' . $nick . '%'
		),
		array (
			'f' => 'level',
			'e' => '>=',
			'v' => $start_level
		),
		array (
			'f' => 'level',
			'e' => '<=',
			'v' => $end_level
		),
		array (
			'f' => 'shop_click_url',
			'e' => '<>',
			'v' => ''
		),
	);

	if ($type == 1) {
		$query_item[] = array (
			'f' => 'type',
			'e' => '=',
			'v' => 'B'
		);
	}

	if ($cid != 0) {
		$query_item[] = array (
			'f' => 'cid',
			'e' => '=',
			'v' => $cid
		);
	}

	$conditions = $duoduo->get_query_conditions($query_item);
	$total = $duoduo->count('shop', $conditions);
	
	/*$crc32_conditions = dd_crc32($conditions);
	
	$webset['shop_count']=array_jieyasuo($webset['shop_count']);

	if (isset ($webset['shop_count'][$crc32_conditions])) {
		if (TIME - $webset['shop_count'][$crc32_conditions]['time'] > 600) { //店铺个数，缓存10分钟
			$total = $duoduo->count('shop', $conditions);
			$webset['shop_count'][$crc32_conditions] = array (
				'count' => $total,
				'time' => TIME
			);
			$data = array ('val' => array_yasuo($webset['shop_count']));
			$duoduo->update('webset', $data, 'var="shop_count"');
		} else {
			$total = $webset['shop_count'][$crc32_conditions]['count'];
		}
	} else {
		$total = $duoduo->count('shop', $conditions);
		$webset['shop_count'][$crc32_conditions] = array (
			'count' => $total,
			'time' => TIME
		);
		$data = array ('val' => array_yasuo($webset['shop_count']));
		$duoduo->update('webset', $data, 'var="shop_count"');
	}*/

	$shops = $duoduo->sel_page_sql('shop', $field, $conditions . ' and del=0 order by ' . $sort, $frmnum, $pagesize);
	if (empty ($shops)) {
		$c = 0;
	} else {
		$c = count($shops);
	}

	$dd_tao_class=include_mod('tao',$duoduo);

	if ($c == 0 && $cid == 0 && $nick != '') {
		include (DDROOT . '/mod/tao/shopinfo.act.php'); //获取店铺信息
		if ($shop != 104 && $shop['user_id'] > 0) {
			$shops[0] = $shop;
		} else {
			$shops = array ();
			$no_shops = 1;
		}
	}

	$shops=$dd_tao_class->dd_tao_shops($shops);

	$page_num = ceil($total / $pagesize);
	$page_url = u(MOD, ACT, array (
		'cid' => $cid,
		'start_level' => $start_level,
		'end_level' => $end_level,
		'type' => $type,
		'nick' => $nick,
		'px' => $px
	));

	$next_page = $page +1 > $page_num ? 1 : $page +1;
	$next_page_url = u(MOD, ACT, array (
		'cid' => $cid,
		'start_level' => $start_level,
		'end_level' => $end_level,
		'type' => $type,
		'nick' => $nick,
		'px' => $px,
		'page' => $next_page
	));

	$last_page = $page -1 < 1 ? 1 : $page -1;
	$last_page_url = u(MOD, ACT, array (
		'cid' => $cid,
		'start_level' => $start_level,
		'end_level' => $end_level,
		'type' => $type,
		'nick' => $nick,
		'px' => $px,
		'page' => $last_page
	));
	
	$parameter['jssdk_shops_convert'] = $jssdk_shops_convert;
	$parameter['tao_shop'] = $tao_shop;
	$parameter['cid'] = $cid;
	$parameter['default_sreach_word'] = $default_sreach_word;
	$parameter['q'] = $q;
	$parameter['tao_level'] = $tao_level;
	$parameter['start_level'] = $start_level;
	$parameter['end_level'] = $end_level;
	$parameter['px'] = $px;
	$parameter['pagesize'] = $pagesize;
	$parameter['page'] = $page;
	$parameter['total'] = $total;
	$parameter['nick'] = $nick;
	$parameter['type'] = $type;
	$parameter['shops'] = $shops;
	$parameter['page_num'] = $page_num;
	$parameter['page_url'] = $page_url;
	$parameter['next_page'] = $next_page;
	$parameter['next_page_url'] = $next_page_url;
	$parameter['last_page'] = $last_page;
	$parameter['last_page_url'] = $last_page_url;
	$parameter['no_shops'] = $no_shops;
	unset ($duoduo);
	return $parameter;
}
?>