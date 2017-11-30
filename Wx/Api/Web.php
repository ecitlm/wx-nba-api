<?php

/**
 * 前端开发日报文章
 * User: ecitlm
 * Date: 2017/11/27
 * Time: 14:42
 */
class Api_Web extends PhalApi_Api
{
    private $domain;
    private $current_day;

    function __construct()
    {
        DI()->functions = "Common_Functions";
        $this->current_day = intval(date("Ymd"));
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
                'page' => array('name' => 'page', 'type' => 'int', 'require' => false, 'max' => '100', 'min' => '0', 'default' => '0', 'desc' => '日不传默认为0、最新的数据/每页返回15条'),
            ),
            'daily' => array(
                'date' => array('name' => 'date', 'type' => 'int', 'require' => false, 'max' => '21000101', 'min' => '20151010', 'default' => $this->current_day, 'desc' => '不传默认为当前日期'),
            ),
        );
    }

    /**
     * 前端日报
     * @url http://192.168.1.2:8080/?service=Web.daily_list
     * @desc 获取前端开发日报
     * @return string title   日报标题
     * @return string des     描述
     * @return string date    时间日期
     */
    public function daily_list()
    {
        $res = $this->domain->daily_list($this->page);
        return $res;
    }


    /**
     * 某一天前端日报列表
     * @url http://192.168.1.2:8080/?service=Web.daily
     * @desc 获取某一天前端日报列表数据
     * @return string p_id   所属某天的日报文章
     * @return string date   发布日期
     * @return string title  文章标题
     * @return string des    文章描述概况
     * @return string des    文章原文地址url
     * @throws PhalApi_Exception_BadRequest
     */
    public function daily()
    {

        if ($this->date > $this->current_day) {
            throw new PhalApi_Exception_BadRequest("日报日期不能大于当前日期", 6);
        }
        $res = $this->domain->daily($this->date);
        return $res;
    }
}