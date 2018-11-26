<?php
/**
 * 请在下面放置任何您需要的应用配置
 */

return array(

	/**
	 * 应用接口层的统一参数
	 */
	'apiCommonRules' => array(
		'sign' => array('name' => 'sign', 'require' => true, 'desc' => '接口签名'),
		'timestamp' => array('name' => 'timestamp', 'type' => 'string', 'require' => false, 'desc' => '时间戳'),
	),

	/**
	 * 接口服务白名单，格式：接口服务类名.接口服务方法名
	 *
	 * 示例：
	 * - *.*            通配，全部接口服务，慎用！
	 * - Default.*      Api_Default接口类的全部方法
	 * - *.Index        全部接口类的Index方法
	 * - Default.Index  指定某个接口服务，即Api_Default::Index()
	 */
	'service_whitelist' => array(
		'Index.index',
		'Common.*',
	),

	/**
	 * 不需要带签名的接口
	 */
	'apiFilterRules' => array(
		'Index.index',
        'Web.daily',
		'Common.huaban',
		'Common.website',
	),

	/**
	 * 需要带Token的接口
	 */
	'apiTokenRules' => array(
		'User.index',
		'Index.index',
	),

	'apiUrl' => "https://live.3g.qq.com",
	'music_api' => "http://m.kugou.com/",
);
