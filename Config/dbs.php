<?php
/**
 * 分库分表的自定义数据库路由配置
 */

return array(
    /**
     * DB数据库服务器集群
     */
    'servers' => array(
        'db_blog' => array(                   //服务器标记
            'host'      => 'localhost',               //数据库域名
            'name'      => 'blog_cms',               //数据库名字
            'user'      => 'root',               //数据库用户名
            'password'  => '',           //数据库密码
            'port'      => '3306',               //数据库端口
            'charset'   => 'UTF8',            //数据库字符集
        ),
    ),

    /**
     * 自定义路由表
     */
    'tables' => array(
        //通用路由
        '__default__' => array(
            'prefix' => '',
            'key' => 'id',
            'map' => array(
                array('db' => 'db_blog'),
            ),
        ),
    ),
);
