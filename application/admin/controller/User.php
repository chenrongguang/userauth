<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-28
 * Time: 16:26
 * 用户-控制器
 */

namespace app\admin\controller;

use Think\Controller;

class User extends Base
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function userlist()
    {
        $model = new \app\home\model\User();
        $list = $model->select();

        $view = new \think\View();

        return $view->fetch('',array('list'=> $list));

    }

}