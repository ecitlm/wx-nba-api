<?php 
/**
 * 以下配置为系统级的配置，通常放置不同环境下的不同配置
 */

return array(
	/**
	 * 默认环境配置
	 */
	'debug' => false,

	/**
	 * MC缓存服务器参考配置
	 */
	 'mc' => array(
        'host' => '127.0.0.1',
        'port' => 11211,
	 ),

    /**
     * 加密
     */
    'crypt' => array(
        'mcrypt_iv' => '12345678', // 8位
    ),
    /**
     * 签名appkey
     */
    'appkey' => '6fc18957ce391f84a7ce34ce13cd99c4',
    'need_sign' => false,
);
