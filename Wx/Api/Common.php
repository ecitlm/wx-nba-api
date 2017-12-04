<?php
/**
 * 通用接口
 * User: Administrator
 * Date: 2017/12/4
 * Time: 21:56
 */

class Api_Common extends PhalApi_Api
{
    /**
     * 定义路由规则
     * @return array
     */
    public function getRules()
    {
        return array(
            'img' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名、该接口可以不要'),
                'imgurl' => array('name' => 'imgurl', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => '图片代理地址'),
                'timestamp' => array('name'=>'timestamp', 'type'=>'string', 'require'=>false, 'desc'=>'时间戳参数、该接口可以不要')
            ),
            'huaban' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名、该接口可以不要'),
                'imgurl' => array('name' => 'imgurl', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => '图片代理地址'),
                'timestamp' => array('name'=>'timestamp', 'type'=>'string', 'require'=>false, 'desc'=>'时间戳参数、该接口可以不要')
            ),
            'website' => array(
                'sign' => array('name' => 'sign', 'type' => 'string', 'require' => false, 'desc' => '接口签名、该接口可以不要'),
                'timestamp' => array('name'=>'timestamp', 'type'=>'string', 'require'=>false, 'desc'=>'时间戳参数、该接口可以不要')
            ),
        );
    }

    /**
     * 关于个人的JSON数据
     * @method GET请求
     * @desc 关于个人的JSON数据
     * @url http://192.168.1.2:8080/?service=Common.website
     */
    public function website()
    {
        return [
            'name' => "没有故事的小明同学",
            'job' => "Web开发工程师",
            'icon' => "https://coding.it919.cn/static/images/zixia.jpg",
            'address' => "深圳市南山区科技园",
            'latitude' => "22.549990",
            'longitude' => "113.950660",
            'github' => "https://github.com/ecitlm",
            'blog' => "https://code.it919.cn",
            'mail' => "ecitlm@163.com",
            'Motto' => '我们这一生，要走很远的路，有如水坦途，有荆棘挡道；有簇拥同行，有孤独漫步；有幸福如影，有苦痛袭扰；有迅跑，有疾走，有徘徊，还有回首……正因为走了许多路，经历的无数繁华与苍凉，才在时光的流逝中体会岁月的变迁，让曾经稚嫩的心慢慢地趋于成熟。',
            'music' => [
                'src' => "https://coding.it919.cn/static/images/lzxs.mp3",
                'author' => "Robbie Williams",
                'name' => "Better Man",
                'poster' => "https://coding.it919.cn/static/images/lzxs.jpg"
            ]
        ];
    }


    /**
     * 转发图片
     * @method GET请求
     * @desc 转发图片代理地址
     * @url http://192.168.1.2:8080/?service=Common.img&imgurl=https://code.it919.cn/img/head.jpg
     */
    public function img()
    {
        $filename = $this->imgurl;
        header('content-type: image/jpeg');
        echo file_get_contents($filename);
        die();
    }


    /**
     * 转发图片
     * @method GET请求
     * @desc 转发图片代理地址
     * @url http://192.168.1.2:8080/?service=Common.huaban&imgurl=c9620979e1efeeed43a12534687fa8d20f03c1436e0a1-FeC2tz
     */
    public function huaban()
    {
        $filename ="http://img.hb.aicdn.com/". $this->imgurl;
        header('content-type: image/png');
        echo file_get_contents($filename);
        die();
    }



}