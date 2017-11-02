<?php
class PhalApi_Filter_SimpleToken implements PhalApi_Filter
{

    public function check()
    {
        $service = DI()->request->get('service');
        $app = DI()->config->get('app');
        $app = json_decode(json_encode($app), true);
        $apiTokenRules = $app['apiTokenRules'];
        if (in_array($service, $apiTokenRules)) {
            $allParams = DI()->request->getAll();
            $token = isset($allParams['token']) ? $allParams['token'] : '';
            $user_id = $allParams['user_id'];
            if (empty($user_id)) {
                throw new PhalApi_Exception_BadRequest('缺少必要参数user_id');
            }
            $service_token = DI()->cache->get($user_id . 'token');
            if (empty($service_token)) {
                throw new PhalApi_Exception_BadRequest('请重新登录', 99);
            } else {
                if (strcmp($token, $service_token) !== 0) {
                    DI()->logger->debug('Wrong Token', array('needToken' => $service_token));
                    throw new PhalApi_Exception_BadRequest('Token错误，请重新登录', 99);
                } else {
                    DI()->cache->set($user_id . 'token', $service_token, 24 * 60 * 60);
                }
            }
        }
    }

}