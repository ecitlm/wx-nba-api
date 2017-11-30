<?php

/**
 * Created by PhpStorm.
 * User: ecitlm
 * Date: 2017/11/29
 * Time: 20:13
 */
class Domain_Web extends PhalApi_Api
{

    function __construct()
    {
        DI()->functions = "Common_Functions";
    }

    /**
     * 查询前端日报列表
     * @param $page
     * @return mixed
     */
    public function daily_list($page)
    {
        $rows = DI()->notorm->daily_list->select('id,date,title,des')->where('p_id', 0)->order('date DESC')->limit($page * 15, 15)->fetchAll();
        return $rows;
    }

    /**
     * 获取某一天下面的文章列表
     * @param $date
     * @return array
     */
    public function daily($date)
    {

        //先从数据库里面查询数据、如果没有查询到就去 目标网站抓取数据
        $rows = DI()->notorm->daily_list->select('*')->where('p_id', $date)->fetchAll();
        if (empty($rows)) {
            $url = "http://caibaojian.com/fe-daily-{$date}.html";
            $res = DI()->functions->HttpGet($url);
            \phpQuery::newDocumentHTML($res);
            //获取该日期信息
            $content = array(
                'title' => $date . "前端开发日报",
                'date' => $date,
                'des' => pq(".fe-desc")->text(),
                'p_id' => 0,
                'url' => ''
            );
            if ($content['des']) {
                $rss = DI()->notorm->daily_list->insert($content);
                //获取该日期下的文章列表数据
                $arr = array();
                $list = pq('.fed-li');
                foreach ($list as $li) {
                    $title = pq($li)->find('.fed-title a')->text();
                    $desc = pq($li)->find('.fed-con')->text();
                    $url = pq($li)->find('.tlink')->attr('href');
                    $tmp = array(
                        'title' => $title,
                        'date' => $date,
                        'url' => explode("?url=", $url)[1],
                        'des' => $desc,
                        'p_id' => $date
                    );
                    array_push($arr, $tmp);
                    $rs = DI()->notorm->daily_list->insert($tmp);
                }
                return $arr;
            }
        } else {
            return $rows;
        }
    }
}