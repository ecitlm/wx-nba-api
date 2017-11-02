<?php
class PhalApi_Filter_SimpleCheck implements PhalApi_Filter {

    protected $signName;

    public function __construct($signName = 'sign') {
        $this->signName = $signName;
    }

    public function check() {

        $service = DI()->request->get('service');
        $app=DI()->config->get('app');
        //签名校验
        $apiFilterRules = $app['apiFilterRules'];
        if (!in_array($service,$apiFilterRules)) {
            $allParams = DI()->request->getAll();

            $sign = isset($allParams[$this->signName]) ? $allParams[$this->signName] : '';
            unset($allParams[$this->signName]);
            unset($allParams['service']);

            //加上appkey
            $sys = DI()->config->get('sys');
            $allParams['appkey'] = $sys['appkey'];
            $expectSign = $this->encryptAppKey($allParams);

            if ($expectSign != $sign) {
                DI()->logger->debug('Wrong Sign', array('needSign' => $expectSign));
                throw new PhalApi_Exception_BadRequest(T('wrong sign'), 6);
            }
        }

        //Token校验
        $apiTokenRules = $app['apiTokenRules'];
        if (in_array($service,$apiTokenRules)) {
            $allParams = DI()->request->getAll();
            if ($allParams['service'] == 'Users.CheckPhone' && $allParams['type'] == 1){

            }else{
                $token = isset($allParams['token']) ? $allParams['token'] : '';
                $user_id = $allParams['user_id'];
                if (empty($user_id)){
                    throw new PhalApi_Exception_BadRequest('缺少必要参数user_id');
                }
                $service_token = DI()->cache->get($user_id.'token');
                if (empty($service_token)){
                    throw new PhalApi_Exception_BadRequest('请重新登录',99);
                }else{
                    if (strcmp($token,$service_token) !== 0){
                        DI()->logger->debug('Wrong Token', array('needToken' => $service_token));
                        throw new PhalApi_Exception_BadRequest('Token错误，请重新登录',99);
                    }else{
                        DI()->cache->set($user_id.'token',$service_token,24*60*60);
                    }
                }
            }
//            DI()->cache->set($user_id.'token',md5($user_id.time()),24*60*60);
        }
    }

    protected function encryptAppKey($params) {
        ksort($params);

        $paramsStrExceptSign = '';
        foreach ($params as $val) {
            $paramsStrExceptSign .= $val;
        }

        return MD5($paramsStrExceptSign);

    }
}
