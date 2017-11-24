<?php

class Model_Category extends PhalApi_Model_NotORM {



    /**
    protected function getTableName($id) {
    return 'user';
    }
     */

    public function index()
    {
        $category = DI()->notorm->category;
        $list = $category->select("*")->limit(10)->fetchRows();
        return $list;
    }
}
