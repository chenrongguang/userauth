<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-29
 * Time: 14:26
 * 基类
 */

namespace app\home\controller;
use Think\Controller;

class Base extends \think\Controller {

    public function _initialize()
    {
        $this->login_check();
    }

    //登录判断
    public function login_check(){

        if (empty( \think\Session::get('user'))) {
            //$this->display('Login:login');
            $redirect_obj= new \tools\route\Redirect();
            $redirect_obj->redirect('/home/login/login');

            //redirect('/home/login/login');
        }
    }

    /**
     * @param $module
     * @param $controller
     * @param $action
     * 判断该用户是否有该url的访问权限
     */
    public function checkPagePower($module, $controller,$action){

        //todo
        //如果非法，直接跳转到登陆页面
        if(false ==true){
            \think\Session::delete('user');
            $redirect_obj= new \tools\route\Redirect();
            $redirect_obj->redirect('/home/login/login');

        }

        return true;
    }

}