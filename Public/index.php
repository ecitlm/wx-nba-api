<?php
/**
 * $APP_NAME 统一入口
 */

require_once dirname(__FILE__) . '/init.php';

//装载你的接口
DI()->loader->addDirs('Wx');



/** ---------------- 通用方法加载 ---------------- **/
//加载项目通用文件
DI()->loader->addDirs('General');
//通用函数基础类
DI()->base = new Common_Base();

/** ---------------- 响应接口请求 ---------------- **/


DI()->phpquery = new QUERY_Lite();

$api = new PhalApi();
$rs = $api->response();
$rs->output();

