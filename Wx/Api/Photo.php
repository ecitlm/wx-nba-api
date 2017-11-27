<?php

/**
 * 图片集合
 * User: ecitlm
 * Date: 2017/11/27
 * Time: 14:42
 */
class Api_Photo extends PhalApi_Api
{
    private $domain;

    function __construct()
    {
        DI()->functions = "Common_Functions";
        $this->domain = new Domain_Photo();
    }

    /**
     * 定义路由规则
     * @return array
     */
    public function getRules()
    {
        return array(
            'hua_ban' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名'),
                'timestamp' => array('name' => 'timestamp', 'type' => 'string', 'require' => false, 'desc' => '时间戳参数')
            ),
            'meizi_list' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名'),
                'timestamp' => array('name' => 'timestamp', 'type' => 'string', 'require' => false, 'desc' => '时间戳参数'),
                'page' => array('name' => 'page', 'type' => 'int', 'require' => true, 'max' => '72', 'min' => '1', 'default' => '', 'desc' => '页码'),
            ),
            'meizi_detail' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名'),
                'timestamp' => array('name' => 'timestamp', 'type' => 'string', 'require' => false, 'desc' => '时间戳参数'),
                'id' => array('name' => 'id', 'type' => 'int', 'require' => true, 'max' => '9999', 'min' => '1', 'default' => '', 'desc' => '详情id'),
            ),

        );
    }

    /**
     * 花瓣图片接口
     * @desc 获取花瓣美图数据列表
     * @url http://192.168.1.2:8080/?service=Photo.hb
     * @return string url   图片地址
     * @return string title   图片名字
     * @return string desc   描述
     * @return array like   点赞数
     */
    public function hb()
    {
        $url = "http://huaban.com/favorite/beauty?j3ej14y9&max=11" . $this->get_random(8) . "&limit=30&wfl=1";
        $res = DI()->functions->HttpGet($url, true);
        $query = json_decode($res, true);
        $arr = array();
        foreach ($query['pins'] as &$k) {
            $tmp = array(
                'url' => "http://img.hb.aicdn.com/" . $k['file']['key'],
                'title' => $k['board']['title'],
                'desc' => $k['board']['description'],
                'like' => $k['like_count']
            );
            array_push($arr, $tmp);
        }
        return $arr;
    }

    /**
     * 生成随机数
     * @param $len
     * @return string
     *
     */
    protected function get_random($len)
    {
        $chars_array = array(
            "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        );
        $charsLen = count($chars_array) - 1;

        $outputstr = "";
        for ($i = 0; $i < $len; $i++) {
            $outputstr .= $chars_array[mt_rand(0, $charsLen)];
        }
        return $outputstr;
    }

    /**
     * 妹子图接口
     * @desc 获取妹子图接口列表
     * @url http://192.168.1.2:8080/?service=Photo.meizi_list
     * @return string img    图片地址
     * @return string title  标题
     * @return int    id     详情id
     */
    public function meizi_list()
    {
        $page = $this->page;
        $res = $this->domain->meizi_list($page);
        return $res;
    }

    /**
     * 靓妹图接口
     * @desc 获取妹子图接口列表
     * @url http://192.168.1.2:8080/?service=Photo.meizi_detail&id=5585
     * @return string title  标题
     * @return string tag    标签
     * @return 数组    list   图片集合
     */
    public function meizi_detail()
    {
        $id=$this->id;
        $res = $this->domain->meizi_detail($id);

        return $res;
    }

}