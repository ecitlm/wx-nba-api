<?php

class Api_WxLogin extends PhalApi_Api
{

    private $domain;

    function __construct()
    {
        $this->domain = new Domain_WxLogin();
    }

    /**
     * 定义路由规则
     * @return array
     */
    public function getRules()
    {
        return array(

            'index' => array(
                // nickName
                'province' => array('name' => 'province', 'type' => 'string', 'default' => '', 'require' => true, 'desc' => '省'),
                'city' => array('name' => 'city', 'type' => 'string', 'default' => '', 'require' => true, 'desc' => '市'),
                'gender' => array('name' => 'gender', 'type' => 'string', 'default' => '', 'require' => true, 'desc' => '性别'),
                'nickName' => array('name' => 'nickName', 'type' => 'string', 'require' => true, 'desc' => '昵称'),
                'avatarUrl' => array('name' => 'avatarUrl', 'type' => 'string', 'require' => true, 'desc' => '头像'),
                'code' => array('name' => 'code', 'type' => 'string','require' => true, 'desc' => 'code')
            ),
        );
    }


    /**
     * 微信小程序授权登录
     * @url http://192.168.1.2:8080/?service=WxLogin.index
     * @desc 获取某一天前端日报列表数据
     * @return string p_id   所属某天的日报文章
     * @return string date   发布日期
     * @return string title  文章标题
     * @return string des    文章描述概况
     * @return string des    文章原文地址url
     * @throws PhalApi_Exception_BadRequest
     */
    public function index()
    {
        $province = $this->province;
        $city = $this->city;
        $sex = $this->gender;
        $nickName = $this->nickName;
        $avatarUrl = $this->avatarUrl;
        $code = $this->code;
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx9c8cc0e03f8be24d&secret=5db099a59f1eb80ad270219f4aaaf27b&js_code=' . $code . '&grant_type=authorization_code';
        $info = file_get_contents($url);
        $json = json_decode($info);
        $arr = get_object_vars($json);
        $openid = $arr['openid'];
        $res = $this->domain->index($openid, $province, $city, $sex, $nickName, $avatarUrl);
        return $res;
    }
}