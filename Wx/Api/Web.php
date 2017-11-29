<?php

/**
 * 图片集合
 * User: ecitlm
 * Date: 2017/11/27
 * Time: 14:42
 */
class Api_Web extends PhalApi_Api
{
    private $domain;

    function __construct()
    {
        DI()->functions = "Common_Functions";
        $this->domain = new Domain_Web();
    }

    /**
     * 定义路由规则
     * @return array
     */
    public function getRules()
    {
        return array(

            'daily_list' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名、该接口可以不要'),
                'timestamp' => array('name'=>'timestamp', 'type'=>'string', 'require'=>false, 'desc'=>'时间戳参数、该接口可以不要'),
                'page' => array('name' => 'page', 'type' => 'int', 'require' => false, 'max' => '100', 'min' => '1', 'default' => '1', 'desc' => '日不传默认为1、最新的数据'),
            ),
            'daily' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名、该接口可以不要'),
                'timestamp' => array('name'=>'timestamp', 'type'=>'string', 'require'=>false, 'desc'=>'时间戳参数、该接口可以不要'),
                'date' => array('name' => 'date', 'type' => 'int', 'require' => true, 'max' => '21000101', 'min' => '20160901', 'default' => '1', 'desc' => '日不传默认为1、最新的数据'),
            ),
        );
    }

    /**
     * 前端日报
     * @url http://192.168.1.2:8080/?service=Web.daily_list
     * @desc 获取前端开发日报
     * @return string title 商品id
     * @return int daily_id   详情id
     * @return string des  描述
     * @return string date  时间日期
     */
    public function daily_list(){
        $res=$this->domain->daily_list($this->page);
        return $res;
    }

    /**
     * 前端日报
     * @url http://192.168.1.2:8080/?service=Web.daily&date=20171128
     * @desc 获取前端开发日报
     * @return string title 商品id
     * @return int daily_id   详情id
     * @return string des  描述
     * @return string date  时间日期
     */
    public function  daily(){
        $res=$this->domain->daily($this->date);
        return $res;
    }





}