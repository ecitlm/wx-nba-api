<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/5
 * Time: 13:20
 */

class Domain_WxLogin extends PhalApi_Api
{
    function __construct()
    {
        DI()->functions = "Common_Functions";
    }

    public function index($openid, $province, $city, $sex, $nickName, $avatarUrl)
    {
        $data = DI()->notorm->wx_user->select('*')->where('openid', $openid)->fetchOne();
        if ($data === false) {
            $content = array('openid' => $openid, 'province' => $province,'sex'=>intval($sex),'time'=>date('Y-m-d h:i:s', time()),'ip'=>DI()->functions->getIp(), 'city' => $city, 'nickName' => $nickName, 'avatarUrl' => $avatarUrl);
            $res = DI()->notorm->wx_user->insert($content);
            if ($res){
                return $res;
            } else{
                throw new PhalApi_Exception_BadRequest('服务器内部错误', 100);
            }
        } else {
            return $data;
        }
    }
}