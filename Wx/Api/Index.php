<?php

class Api_Index extends PhalApi_Api
{



    /**
     * 获取分类下的列表
     * @url http://192.168.1.2:8080/?service=Book.list
     */
    public function  Index()
    {
		// $app = DI()->config->get('apiUrl');
       return 'welcome to IT-developer';
    }
}