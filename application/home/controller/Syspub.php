<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-8-24
 * Time: 14:26
 * 共通区域
 */

namespace app\home\controller;
use Think\Controller;

class Syspub extends Base{

    public function _initialize()
    {
        parent::_initialize();
    }

    public  function  footer(){
        $view = new \think\View();
        return $view->fetch();

    }
    public  function  header(){
        $view = new \think\View();
        return $view->fetch();

    }
    public  function menu(){
        $view = new \think\View();
        return $view->fetch();

    }

}