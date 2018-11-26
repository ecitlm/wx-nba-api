<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/5
 * Time: 13:20
 */

class Domain_Book extends PhalApi_Api
{
    function __construct()
    {
        DI()->functions = "Common_Functions";
    }

    public function bookList($id, $page)
    {
        $start=($page-1)*10;
        $end=($page)*10;
        $data = DI()->notorm->book_list->select('title','thumb','description','author')->where('pid', $id)->limit($start,$end)->fetchAll();
        return $data;
    }
}