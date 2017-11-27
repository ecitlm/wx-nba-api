<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27
 * Time: 19:55
 */

class Domain_Photo
{

    function __construct()
    {
        DI()->functions = "Common_Functions";
    }


    /**
     * 图片爬虫列表
     * @param $page
     * @return array
     */
    public function meizi_list($page)
    {

        $url = "http://www.meizitu.com/a/more_{$page}.html";
        $res = DI()->functions->HttpGet($url);
        \phpQuery::newDocumentHTML($res);
        $arr = array();
        $list = pq('.wp-list li');
        foreach ($list as $li) {
            $title = pq($li)->find('.tit')->text();
            $img = pq($li)->find('img')->attr('src');
            $url = pq($li)->find('a')->attr('href');
            $id = intval(preg_replace('/\D/s', '', $url));
            $tmp = array(
                'title' => $title,
                'img' => $img,
                'id' => $id,
                'url'=>"http://localhost:8080/?service=Photo.meizi_detail&id={$id}"
            );
            array_push($arr, $tmp);
        }
        return $arr;
    }

    /**
     * 爬虫获取妹子图片详情列表
     * @param $id
     * @return array
     */
    public function meizi_detail($id)
    {

        $url = "http://www.meizitu.com/a/{$id}.html";
        $res = DI()->functions->HttpGet($url);
        //$res = file_get_contents($url);
        \phpQuery::newDocumentHTML($res);
        $arr = array();
        $list = pq('#pagecontent p img');
        foreach ($list as $li) {
//            $tmp = array(
//                'src' =>pq($li)->attr('src')
//            );
            array_push($arr, pq($li)->attr('src'));

        }
        return $arr;
    }
}
