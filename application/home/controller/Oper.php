<?php

/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-29
 * Time: 14:26
 * 运营订单控制器
 */
namespace app\home\controller;

use Think\Controller;

class Oper extends Base
{
    public function confirm()
    {
        $view = new \think\View();
        return $view->fetch('');

    }

    public function unconfirm()
    {
        $view = new \think\View();
        return $view->fetch('');

    }
}