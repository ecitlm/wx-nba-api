<?php

/**
 * NBA赛事API
 * Date: 2017/11/02
 * @Time: 21:55
 * @author  ecitlm, http://code.it919.cn/
 * @copyright 2017 ecitlm
 */
class Api_Nba extends PhalApi_Api {

    function __construct() {
        DI()->functions = "Common_Functions";
    }

    /**
     * 定义路由规则
     * @return array
     */
    public function getRules() {
        return array(
            'schedule' => array(
                'date' => array('name' => 'date', 'type' => 'string', 'min' => '', 'default' => '', 'require' => false, 'desc' => '直播时间、默认为当前日期'),
            ),
            'live_detail' => array(
                'schid' => array('name' => 'schid', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => '直播schid'),
                'liveid' => array('name' => 'liveid', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => '直播liveid'),
            ),
            'live_content' => array(
                'schid' => array('name' => 'schid', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => 'schid'),
            ),
            'technical_statistics' => array(
                'schid' => array('name' => 'schid', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => 'schid'),
            ),
            'player_detail' => array(
                'playerid' => array('name' => 'playerid', 'type' => 'int', 'min' => '', 'default' => '', 'require' => true, 'desc' => '球员id'),
            ),
            'team_info' => array(
                'teamId' => array('name' => 'teamId', 'type' => 'int', 'min' => '', 'default' => '', 'require' => true, 'desc' => '球队Id'),
            ),
            'team_schedule' => array(
                'teamId' => array('name' => 'teamId', 'type' => 'int', 'min' => '', 'default' => '', 'require' => true, 'desc' => '球队Id'),
                'mouth' => array('name' => 'mouth', 'type' => 'int', 'min' => '', 'default' => '', 'require' => true, 'desc' => '每月的赛程月份'),
            ),
            'Lineup' => array(
                'teamId' => array('name' => 'teamId', 'type' => 'int', 'min' => '', 'default' => '', 'require' => true, 'desc' => '球队Id'),
            ),
            'new_list' => array(
                'page' => array('name' => 'page', 'type' => 'int', 'min' => '0', 'default' => '0', 'require' => true, 'desc' => 'page第几页页数、每页返回15条'),
            ),
            'news_info' => array(
                'docid' => array('name' => 'docid', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => '文章详情id'),
            ),
            'playerGame'=>array(
                'playerId' => array('name' => 'playerId', 'type' => 'int', 'min' => '', 'default' => '', 'require' => true, 'desc' => '球员id'),
                'seasonId' => array('name' => 'seasonId', 'type' => 'int', 'min' => '', 'default' => '', 'require' => true, 'desc' => '赛季id'),
            ),
            //
            'statDetail'=>array(
                'mid' => array('name' => 'mid', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => '直播ID')
            ),
            'news_comments' => array(
                'docid' => array('name' => 'docid', 'type' => 'string', 'min' => '', 'default' => '', 'require' => true, 'desc' => '文章详情id'),
            ),
        );
    }

    /**
     * @param $url
     * 获取爬虫url数据
     */
    private function HttpGet($url) {
        return DI()->functions->HttpGet($url);
    }

    /**
     * 获取赛事直播列表
     * @method GET请求
     * @desc 获取赛事直播列表
     * @url http://192.168.1.2:8080/?service=Nba.schedule
     * @return string cur_date   当前日期
     * @return string pre_date   上一天日期
     * @return string pre_next   下一日
     * @return array list   直播赛事列表
     */
    public function schedule() {
        $date = $this->date;
		$timestamp = time();
        $res = $this->HttpGet("https://nb.3g.qq.com/nba/api/schedule@getList?md={$date}&timestamp={$timestamp}&sid=");
        $arr = json_decode($res, true)['schedule@getList'];
        return json_decode($res, true)['schedule@getList'];
    }

    /**
     * 比赛直播详情信息
     * @method GET请求
     * @desc 获取赛事直播列表
     * @url http://192.168.1.2:8080/?service=Nba.live_detail&schid=1470215&liveid=2009587
     * @return string t1_name 客队名称
     * @return string t2_name 客队名称
     * @return array sec_scores 每节比分
     * @return  int t1_point  客队总分
     * @return  int t2_point  主队总分
     * @return  int t1_icon  客队logo
     * @return  int t2_icon  主队logo
     */
    public function live_detail() {
        $schid = $this->schid;
        $liveid = $this->liveid;
        $res = $this->HttpGet("https://nb.3g.qq.com/nba/api/live@getInfo?i_schid={$schid}&i_liveid={$liveid}");
        return json_decode($res, true)['live@getInfo']['data'];
    }

    /**
     * 比赛直播实时数据
     * @method GET请求
     * @desc 比赛直播实时数据
     * @url http://192.168.1.2:8080/?service=Nba.live_content&schid=1470215
     */
    public function live_content() {
        $schid = $this->schid;
        $res = $this->HttpGet("https://live.3g.qq.com/g/s?aid=action_api&module=nba&action=broadcast_content%2Cbroadcast_info&sch_id={$schid}");
        return json_decode($res, true)['broadcast_content']['contentAry'];
    }

    /**
     * 球员技术统计
     * @method GET请求
     * @desc 球员技术统计信息
     * @url http://192.168.1.2:8080/?service=Nba.technical_statistics&schid=1470215
     * @return array topplayer  最佳球员信息(主队和客队)
     * @return  array playStat   主队和客队球员信息
     */
    public function technical_statistics() {
        $schid = $this->schid;
        $res = $this->HttpGet("https://live.3g.qq.com/g/s?aid=action_api&module=nba&action=live_stat_4_nba%2Cbroadcast_info&sch_id={$schid}&bid=2009605");
        return json_decode($res, true)['live_stat_4_nba'];
    }

    /**
     * 球员详情
     * @method GET请求
     * @desc 球员基本信息详情
     * @url http://192.168.1.2:8080/?service=Nba.player_detail&playerid=4130
     */
    public function player_detail() {
        $playerid = $this->playerid;
        $res = $this->HttpGet("https://live.3g.qq.com/g/s?aid=action_api&module=nba&action=player_detail&playerId={$playerid}&sid=");
        return json_decode($res, true)['player_detail'];
    }

    /**
     * 联盟排名
     * @method GET请求
     * @desc 30只球队联盟排名
     * @url http://192.168.1.2:8080/?service=Nba.team_rank
     */
    public function team_rank() {
        $res = $this->HttpGet("https://matchweb.sports.qq.com/rank/team?columnId=100000&from=NBA");
        return json_decode($res, true)[1];
    }

    /**
     * 球队信息
     * @method GET请求
     * @desc 球队基本信息数据
     * @url http://192.168.1.2:8080/?service=Nba.team_info&teamId=15
     */
    public function team_info() {
        $id = $this->teamId;
        $res = $this->HttpGet("https://live.3g.qq.com/g/s?aid=action_api&module=nba&action=team_detail&teamId={$id}&sid=");
        return json_decode($res, true)['team_detail'];
    }

    /**
     * 球队赛程
     * @method GET请求
     * @desc 球队每月赛程
     * @url http://192.168.1.2:8080/?service=Nba.team_schedule&teamId=15&mouth=11
     */
    public function team_schedule() {
        $id = $this->teamId;
        $mouth = $this->mouth;
        $res = $this->HttpGet("https://nb.3g.qq.com/nba/api/schedule@getMonthListByTeam?teamid={$id}&mouth={$mouth}&sid=");
        return json_decode($res, true)['schedule@getMonthListByTeam']['data'];
    }

    /**
     * 球队阵容
     * @method GET请求
     * @desc 球队阵容球员列表
     * @url http://192.168.1.2:8080/?service=Nba.Lineup&teamId=15
     */
    public function Lineup() {

        $id = $this->teamId;
        $res = $this->HttpGet("https://live.3g.qq.com/g/s?aid=action_api&module=nba&action=team_player&teamId={$id}&sid=");
        return json_decode($res, true)['team_player']['players'];
    }

    /**
     * NBA联盟数据排名
     * @method 得分篮板助攻抢断三分等等排名
     * @desc 球队阵容球员列表
     * @url http://192.168.1.2:8080/?service=Nba.player_top
     */
    public function player_top() {
        $res = $this->HttpGet("https://live.3g.qq.com/g/s?aid=action_api&module=nba&action=player_top2");
        return json_decode($res, true)['player_top2'];
    }

    /**
     * NBA新闻列表
     * @method GET请求
     * @desc NBA新闻篮球快讯
     * @url http://192.168.1.2:8080/?service=Nba.new_list&page=1
     */
    public function new_list() {
        $page = $this->page * 15;
        $res = $this->HttpGet("https://3g.163.com/touch/reconstruct/article/list/BD2AQH4Qwangning/{$page}-15.html");
        $arr = json_decode(substr($res, 9, -1), true)['BD2AQH4Qwangning'];
        //数据里面有一些直播的新闻数据、需要删除那些数据
        $newArr = array();
        foreach ($arr as $k => $v) {
            if (!empty($arr[$k]['liveInfo'])) {
                unset($arr[$k]);
            } else {
                array_push($newArr, $arr[$k]);
            }
        }
        return $newArr;
    }

    /**
     *  NBA篮球快讯新闻详情
     * @method GET请求
     * @desc NBA新闻内容详情
     * @url http://192.168.1.2:8080/?service=Nba.news_info&docid=D22DCS5S0005877U
     * @return string  body   文章内容
     * @return string bodyBottomAd.title 文章标题
     */
    public function news_info() {
        $id = $this->docid;
        $res = $this->HttpGet("http://3g.163.com/touch/article/{$id}/full.html");
        $arr = json_decode(substr($res, 12, -1), true);
        unset($arr[$id]['relate']);
        return $arr[$id];
    }

    /**
     *  NBA篮球快讯新闻详情评论
     * @method GET请求
     * @desc NBA新闻内容详情评论
     * @url http://192.168.1.2:8080/?service=Nba.news_comments&docid=D22DCS5S0005877U
     * @return string  body   文章内容
     * @return string bodyBottomAd.title 文章标题
     */
    public function news_comments() {
        $id = $this->docid;
        $res = $this->HttpGet("https://comment.news.163.com/api/v1/products/a2869674571f77b5a0867c3d71db5856/threads/{$id}/comments/newList?offset=0&limit=20&headLimit=1&tailLimit=2&ibc=newswap&showLevelThresho");
        $arr = json_decode($res, true)['comments'];
        $newArr = array();
        foreach ($arr as $k => $v) {
            array_push($newArr, $arr[$k]);
        }
        return $newArr;

    }
    /**
     *  球员最近五场比赛数据
     * @method GET请求
     * @desc 球员最近五场比赛数据
     * @url http://192.168.1.2:8080/?service=Nba.playerGame&playerId=4840&seasonId=2018
     */
    public function playerGame () {
        $playerId = $this->playerId;
        $seasonId = $this->seasonId;
        $res = $this->HttpGet("https://matchweb.sports.qq.com/player/stats?playerId={$playerId}&seasonId={$seasonId}&seasonType=1&from=h5");
        return json_decode($res, true)['data'];
    }


    /**
     *  直播页面详情
     * @method GET请求
     * @desc 直播页面详情
     * @url http://192.168.1.2:8080/?service=Nba.statDetail&mid=xxxx
     */
    public function statDetail () {
        $mid = $this->mid;
        $res = $this->HttpGet("https://app.sports.qq.com/match/statDetail?mid={$mid}");
        return json_decode($res, true)['data'];
    }
    /**
     *  关于作者
     * @method GET请求
     * @desc 关于作者
     * @url http://192.168.1.2:8080/?service=Nba.website
     * @return object  JSON   文章内容
     */
    public function website() {
        $info=[
            'name' => "没有故事的明同学",
            'job' => "Web开发工程师",
            'icon' => "https://wapapi.it919.cn/static/images/zixia.jpg",
            'address' => "深圳市南山区高新园",
            'latitude' => "22.539728",
            'longitude' => "113.
            961553",
            'github' => "https://github.com/ecitlm",
            'blog' => "https://blog.it919.cn",
            'mail' => "ecitlm@163.com",
            'Motto' => '我们这一生，要走很远的路，有如水坦途，有荆棘挡道；有簇拥同行，有孤独漫步；有幸福如影，有苦痛袭扰；有迅跑，有疾走，有徘徊，还有回首……正因为走了许多路，经历的无数繁华与苍凉，才在时光的流逝中体会岁月的变迁，让曾经稚嫩的心慢慢地趋于成熟。',
            'music' => [
                'src' => "https://wapapi.it919.cn/bzyy.mp3",
                'author' => "Beyond",
                'name' => "不再犹豫-Music",
                'poster' => "https://wapapi.it919.cn/bzyy.png"
            ]
        ];
        return $info;
    }
}
