<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-28
 * Time: 16:26
 * 系统功能-控制器
 */

namespace app\admin\controller;

use Think\Controller;

class Sysfunc extends Base
{

    public function _initialize()
    {
        parent::_initialize();
    }


    public function funclist()
    {
        $view = new \think\View();
        return $view->fetch();

    }

}