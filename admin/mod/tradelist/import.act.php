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
if (!defined('ADMIN')) {
    exit('Access Denied');
}
if ($_POST['sub'] != '') {
	//导入处理函数
    ini_set('memory_limit', '128M');
    set_time_limit(0);
    $max_file_size = 5000000; //上传文件大小限制, 单位BYTE
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])) { //是否存在文件
            echo "<font color='red'>文件不存在！</font>";
            exit;
        }
        $file = $_FILES["upfile"];
        if ($max_file_size < $file["size"]) {
            echo "<font color='red'>文件太大！</font>";
            exit;
        }
        function resetname($name) {
            $arr = explode('.', $name);
            return date('His') . rand(10000, 99999) . '.' . $arr[1];
        }
        $saved_upload_name = DDROOT . "/upload/" . resetname($_FILES['upfile']['name']);
        if (!move_uploaded_file($_FILES["upfile"]['tmp_name'], $saved_upload_name)) {
            echo "<font color='red'>服务器的临时目录没有移动文件权限，找空间商！</font>";
        } else {
            chmod($saved_upload_name, 0777);
        }
        $result['update_num'] = 0;
        $result['insert_num'] = 0;
        $file_type = substr(strstr($file['name'], '.') , 1);
        if ($file_type == "csv") {
            $handle = fopen($saved_upload_name, "r");
            $kk = 1;
            while ($row = fgetcsv($handle, 1000, ',')) {
                $row = array_map("gbk2utf8", $row);
                foreach ($row as $key => $vo) {
                    $csv_arr[$kk][($key + 1) ] = $vo;
                }
                $kk++;
            }
            fclose($handle);
			$result=$duoduo->trade_import($csv_arr,$result);
        }
        if ($file_type == "xls") {
            include DDROOT . '/comm/readxls.php';
            $uptypes = array(
                'application/vnd.ms-excel'
            );
            /*if (!in_array($file["type"], $uptypes)){
            echo "<font color='red'>只能上传xls！</font>";
            exit;
            }*/
            $data = new Spreadsheet_Excel_Reader();
            $data->setOutputEncoding('utf-8');
            $data->read($saved_upload_name);
            $result=$duoduo->trade_import($data->sheets[0]['cells'],$result);
        }
    }
	$chongfu=$result['chongfu'];
    unlink($saved_upload_name);
} else {
}

?>