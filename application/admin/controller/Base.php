<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-28
 * Time: 16:26
 * 基类
 */

namespace app\admin\controller;
use Think\Controller;

class Base extends \think\Controller {

    public function _initialize()
    {
        $this->login_check();

    }

    //登录判断
    public function login_check(){

        if (empty( \think\Session::get('admin'))) {
            $redirect_obj= new \tools\route\Redirect();
            $redirect_obj->redirect('/admin/login/login');
        }

    }


}