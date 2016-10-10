<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-28
 * Time: 16:26
 * 角色-控制器
 */
namespace app\admin\controller;

use Think\Controller;

class Role extends Base
{

    public function _initialize()
    {
        parent::_initialize();
    }



    public function rolelist()
    {
        $model = new \app\admin\model\Role();
        $list = $model->select();

        $view = new \think\View();

        return $view->fetch('',array('list'=> $list));

    }

}