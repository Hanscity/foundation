<?php
require_once 'autoload_file.php';

use library\config\ReadConf;
use library\rpc\client;


$config  = ReadConf::init(APP_PATH_ROOT . '/conf' . '/config.ini');
$clientCommon = $config->getconfig('client');
$address_array = $config->getconfig('client:member');

$address_array = array_merge($clientCommon, $address_array);
if (isset($address_array['server_address']) && !empty($address_array['server_address'])) {
    foreach ($address_array['server_address'] as &$addr) {
        list($host, $port) = explode(':', $addr);
        $addr = ['host' => $host, 'port' => $port];
    }
    unset($addr);
}

$user_client = client::instance('member/Recommend', $address_array);
/**
* 获取直接推荐人ID
* @return string--username
*/
$data = ['userid'=>24490];
$results = $user_client->getMyIntoId($data);//string(5) "24487"

/**
* 获取顶级推荐人ID（顶级推荐人必须是理财经理）
* @return string--username
*/
// $data = ['userid'=>24490];
// $results = $user_client->getMyTopIntoId($data);//string(1) "1"


/**
* 修改推荐关系
* @return string--username
*/
// $data = [
// 		'where'=>['userid'=>24490],
// 		'data' =>['is_status'=>1,
// 					'remark'=>1
// 				]

// 		];
// $results = $user_client->putUpdate($data);//int(0)||int(1)


//打印结果
var_dump($results);
