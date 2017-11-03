<?php

/**
 * Index API
 * Date: 2017/11/02
 * @Time: 21:55
 * @author  ecitlm, http://code.it919.cn/
 * @copyright 2017 ecitlm
 */
class Api_Index extends PhalApi_Api
{

    function __construct()
    {
        DI()->functions = "Common_Functions";
    }

    public function index(){
        $res =DI()->functions->HttpGet("https://wxapp.it919.cn/wx/listAllApis.php");
        echo $res;
        die();
    }
}