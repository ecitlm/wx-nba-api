<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 20:31
 */
class Domain_Category
{
   public  function index(){
       $category_modle = new Model_Category();
       $data = $category_modle->index();
       return $data;
   }

}