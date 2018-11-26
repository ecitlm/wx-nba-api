<?php

class Api_Book extends PhalApi_Api
{

    private $domain;

    function __construct()
    {
        $this->domain = new Domain_Book();
    }

    /**
     * 定义路由规则
     * @return array
     */
    public function getRules()
    {
        return array(

            'bookList' => array(
                // nickName
                'id' => array('name' => 'id', 'type' => 'int', 'require' => true, 'desc' => '分类id'),
                'page' => array('name' => 'page', 'type' => 'int', 'default' => '1', 'require' => true, 'desc' => '页码')
            ),
        );
    }


    /**
     * 获取分类下的列表
     * @url http://192.168.1.2:8080/?service=Book.list
     */
    public function  bookList()
    {
        $page = $this->page;
        $id = $this->id;
        $res = $this->domain->bookList($id, $page);
        return $res;
    }
}