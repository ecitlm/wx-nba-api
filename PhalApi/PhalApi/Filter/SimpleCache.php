<?php
/**
 * Created by PhpStorm.
 * User: kuye
 * Date: 2017/3/14
 * Time: 16:53
 */
class PhalApi_Filter_SimpleCache implements PhalApi_Filter {

    public function check() {
        $token = DI()->request->get('token');
        $service = DI()->request->get('service');
        $app=DI()->config->get('app');
        $app = json_decode(json_encode($app),true);
        $apiFilterRules = $app['apiFilterRules'];
        if (in_array($service,$apiFilterRules)) {
            $user_id = DI()->cache->get($token);
            if (empty($user_id) or $user_id <= 0){
                throw new PhalApi_Exception_BadRequest(T('wrong sign'), 5);
            }
        }
    }

}