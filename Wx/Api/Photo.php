<?php

/**
 * 图片集合
 * User: ecitlm
 * Date: 2017/11/27
 * Time: 14:42
 */
class Api_Photo extends PhalApi_Api
{

    function __construct()
    {
        DI()->functions = "Common_Functions";
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
        );
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


}