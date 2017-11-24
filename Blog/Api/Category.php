<?php
/**
 * 获取博客栏目
 * Date: 2017/11/20
 * @Time: 21:55
 * @author  ecitlm, http://code.it919.cn/
 * @copyright 2017 ecitlm
 */
class Api_Category extends PhalApi_Api
{

    /**
     * 博客栏目
     * @method GET请求
     * @desc 获取博客栏目; code=200 为请求成功
     * @url http://192.168.1.2:8080/blog?service=Category.index
     * @return string name       栏目名称
     * @return string description       栏目描述简介
     * @return string pid       栏目所属级别 0位顶级栏目、parentId
     * @return string id        栏目id
     * @return string image     栏目缩略图
     */
    public function index()
    {
        $category_domain = new Domain_Category();
        $data = $category_domain->index();
        return $data;
    }
}
