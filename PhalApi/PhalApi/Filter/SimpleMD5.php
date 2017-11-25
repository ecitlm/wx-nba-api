<?php
/**
 * PhalApi_Filter_SimpleMD5 简单的MD5拦截器
 *
 * - 签名的方案如下：
 *
 * + 1、排除签名参数（默认是sign）
 * + 2、将剩下的全部参数，按参数名字进行字典排序
 * + 3、将排序好的参数，全部用字符串拼接起来
 * + 4、进行md5运算
 *
 * 注意：无任何参数时，不作验签
 *
 * @package     PhalApi\Filter
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author      dogstar <chanzonghuang@gmail.com> 2015-10-23
 */

class PhalApi_Filter_SimpleMD5 implements PhalApi_Filter
{

    protected $signName;

    public function __construct($signName = 'sign')
    {
        $this->signName = $signName;
    }

    /**
     * 签名验证 去除了sign和方法名参数
     * @throws PhalApi_Exception_BadRequest
     */
    public function check()
    {

        $service = DI()->request->get('service');
        $app = DI()->config->get('app');
        $apiFilterRules = $app['apiFilterRules'];//获取不需要签名的接口配置文件
        if (!in_array($service, $apiFilterRules)) {
            $allParams = DI()->request->getAll();//获取所有的参数
            $sign = isset($allParams[$this->signName]) ? $allParams[$this->signName] : '';
            $timestamp = isset($allParams['timestamp']) ? $allParams['timestamp'] : '';

            //判断接口请求时间问题
            if (empty($timestamp)) {
                throw new PhalApi_Exception_BadRequest("缺少时间戳参数", 6);
            }

            //一个接口请求能使用300秒有效期
            $times = time() * 1000;
            if ($times - floatval($timestamp) > 300000) {
                throw new PhalApi_Exception_BadRequest("接口请求超时", 6);
            }

            if (empty($sign)) {
                throw new PhalApi_Exception_BadRequest("缺少必要sign参数", 6);
            }
            unset($allParams[$this->signName]); //移除sign自身
            unset($allParams['service']);//移除接口类名

            //加上appkey
            $sys = DI()->config->get('sys');
            $allParams['appkey'] = $sys['appkey'];
            $expectSign = $this->encryptAppKey($allParams);//生成签名
            if ($expectSign != $sign) {
                DI()->logger->debug('Wrong Sign', array('needSign' => $expectSign)); //输出日志信息
                throw new PhalApi_Exception_BadRequest(T('wrong sign'), 6);
            }
        }
    }

    protected function encryptAppKey($params)
    {
        ksort($params);

        $paramsStrExceptSign = '';
        foreach ($params as $val) {
            $paramsStrExceptSign .= $val;
        }
        return MD5($paramsStrExceptSign);

    }
}
