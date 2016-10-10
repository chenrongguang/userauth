<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-28
 * Time: 16:26
 * 共同区
 */

namespace app\admin\controller;

use Think\Controller;

class Syspub extends Base
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function  index()
    {
        $view = new \think\View();
        return $view->fetch('');
    }

    public function  footer()
    {
        $view = new \think\View();
        return $view->fetch('');
    }

    public function  header()
    {
        $view = new \think\View();
        return $view->fetch('');
    }

    public function left()
    {
        $view = new \think\View();
        return $view->fetch('');
    }

    public function top()
    {
        $view = new \think\View();
        return $view->fetch('');
    }


    public function main()
    {
        $view = new \think\View();
        return $view->fetch('');
    }

}