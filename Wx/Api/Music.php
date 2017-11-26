<?php

/**
 * 酷狗音乐web端接口
 * User: ecitlm
 * Date: 2017/11/25
 * Time: 16:55
 */
class Api_Music extends PhalApi_Api
{
    private $music_api;

    function __construct()
    {
        DI()->functions = "Common_Functions";
        $this->music_api = DI()->config->get('app')['music_api'];
    }

    /**
     * @param $url
     * 获取爬虫url数据
     */
    private function mobile_curl($url)
    {
        return DI()->functions->mobile_curl($url);
    }

    /**
     * 定义路由规则
     * @return array
     */
    public function getRules()
    {
        return array(
            'plist_list' => array(
                'specialid' => array('name' => 'specialid', 'type' => 'int', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '歌单id'),
            ),
            'singer_list' => array(
                'classid' => array('name' => 'classid', 'type' => 'int', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '分类classid'),
            ),
            'singer_info' => array(
                'singerid' => array('name' => 'singerid', 'type' => 'int', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '歌手id'),
            ),
            'song_info' => array(
                'hash' => array('name' => 'hash', 'type' => 'string', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '音乐的hash'),
            ),
            'song_info1' => array(
                'hash' => array('name' => 'hash', 'type' => 'string', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '音乐的hash'),
            ),
            'lrc' => array(
                'hash' => array('name' => 'hash', 'type' => 'string', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '音乐的hash'),
            ),
            'mv' => array(
                'mvhash' => array('name' => 'mvhash', 'type' => 'string', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '音乐mv的id'),
            ),
            'relate_mv' => array(
                'mvhash' => array('name' => 'mvhash', 'type' => 'string', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '音乐mv的id'),
            ),
            'search' => array(
                'keyword' => array('name' => 'keyword', 'type' => 'string', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '关键字'),
            ),


        );
    }


    /**
     * 音乐新歌榜
     * @desc 获取云音新歌榜
     * @url http://192.168.1.2:8080/?service=music.new_songs
     */
    public function new_songs()
    {

        $res = $this->mobile_curl($this->music_api . "&json=true");
        return json_decode($res, true)['data'];

    }


    /**
     * 音乐排行榜接口
     * @desc 获取音乐排行榜
     * @url http://192.168.1.2:8080/?service=music.rank_list
     */
    public function rank_list()
    {
        $res = $this->mobile_curl($this->music_api . "/rank/list&json=true");
        return json_decode($res, true)['rank']['list'];

    }


    /**
     * 音乐歌单列表
     * @desc 获取音乐歌单
     * @url http://192.168.1.2:8080/?service=music.plist
     */
    public function plist()
    {
        $res = $this->mobile_curl($this->music_api . "/plist/index&json=true");
        return json_decode($res, true)['plist']['list']['info'];
    }


    /**
     * 歌单下的音乐列表
     * @desc   歌单下的某个歌单下的音乐列表
     * @url    http://192.168.1.2:8080/?service=music.plist_list&specialid=126317
     */
    public function plist_list()
    {

        $specialid = $this->specialid;
        $url = $this->music_api . "/rank/list/{$specialid}&json=true";
        $res = $this->mobile_curl($url);
        return json_decode($res, true)['rank']['list'];
    }


    /**
     * 歌手分类接口
     * @desc   获取歌手分类
     * @url    http://192.168.1.2:8080/?service=music.singer_class
     * @return int     classid    id
     * @return string  classname  名称
     * @return string  imgurl     分类头像
     */
    public function singer_class()
    {
        $res = $this->mobile_curl($this->music_api . "/singer/class&json=true");
        return json_decode($res, true)['list'];
    }

    /**
     * 歌手列表接口
     * @desc 歌手分类下面的歌手列表
     * @url    http://192.168.1.2:8080/?service=music.singer_list
     * @return int     singerid   歌手的id
     * @return string  singername 歌手名称
     * @return string  imgurl     歌手头像
     */
    public function singer_list()
    {
        $classid = $this->classid;
        $res = $this->mobile_curl($this->music_api . "/singer/info/{$classid}&json=true");
        return json_decode($res, true);

    }

    /**
     * 歌手信息
     * @desc 获取某位歌手的基本信息
     * @url    http://192.168.1.2:8080/?service=music.singer_info
     * @return string intro   歌手简介
     * @return array  list    歌手的热门歌单
     */
    public function singer_info()
    {
        $singerid = $this->singerid;
        $res = $this->mobile_curl($this->music_api . "/singer/info/{$singerid}&json=true");
        return json_decode($res, true);
    }

    /**
     * 音乐详情接口
     * @desc 获取音乐详情接口播放数据
     * @url   http://192.168.1.2:8080/?service=music.song_info
     * @return string url        音乐地址
     * @return string songName   音乐名称
     * @return string singerName 演唱歌手
     * @return string album_img  封面
     * @return string mvhash     Mv id
     */
    public function song_info()
    {
        $hash = $this->hash;
        $res = $this->mobile_curl($this->music_api . "app/i/getSongInfo.php?cmd=playInfo&hash={$hash}");
        return json_decode($res, true);
    }

    /**
     * 带歌词歌曲信息
     * @desc 获取音乐详情接口播放数据
     * @url   http://192.168.1.2:8080/?service=music.song_info
     * @return string play_url   音乐地址
     * @return string songName   音乐名称
     * @return string singerName 演唱歌手
     * @return string lyrics     歌词
     * @return string mvhash     Mv id
     */
    public function song_info1()
    {
        $hash = $this->hash;
        $res = $this->mobile_curl("http://www.kugou.com/yy/index.php?r=play/getdata&hash={$hash}");
        return json_decode($res, true);
    }

    /**
     * 歌曲MV接口
     * @desc 获取音乐mv
     * @url   http://192.168.1.2:8080/?service=music.mv
     * @return 对象 mvdata   mv视频列表(sq/rq/le)
     */
    public function mv()
    {
        $mvhash = $this->mvhash;
        $res = $this->mobile_curl($this->music_api ."app/i/mv.php?cmd=100&hash={$mvhash}&ismp3=1&ext=mp4");
        return json_decode($res, true);
    }


    /**
     * 相关MV视频接口
     * @desc 获取音乐mv相关的MV数据
     * @url   http://192.168.1.2:8080/?service=music.mv
     * @return 对象 info   mv数据列表
     */
    public function relate_mv()
    {

        $mvhash = $this->mvhash;
        $res = $this->mobile_curl("http://service.mobile.kugou.com/v1/mv/relate?mv_hash={$mvhash}");
        return json_decode($res, true)['data'];
    }

    /**
     * 歌曲歌词接口
     * @desc 获取音乐歌曲的歌词
     * @url   http://192.168.1.2:8080/?service=music.lrc
     * @return string data   歌词字符串
     */
    public function lrc()
    {
        $hash = $this->hash;
        $res = $this->mobile_curl($this->music_api ."app/i/krc.php?cmd=100&hash={$hash}&timelength=3012000");
        return $res;
    }

    /**
     * 音乐搜索接口
     * @desc 获取搜索结果数据
     * @url   http://192.168.1.2:8080/?service=music.search
     */
    public function search()
    {
        $keyword = $this->keyword;
        $res = $this->mobile_curl("http://mobilecdn.kugou.com/api/v3/search/song?format=json&keyword={$keyword}&page=1&pagesize=20&showtype=1");
        return json_decode($res, true)['data']['info'];
    }
}