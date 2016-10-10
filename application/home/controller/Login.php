<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-8-24
 * Time: 14:26
 * 登录登出
 */

namespace app\home\controller;

use Think\Controller;


class Login
{
    public function index()
    {
        $view = new \think\View();
        // 渲染模板输出 并赋值模板变量
        return $view->fetch();
        //$this->display('login');
    }

    public function login()
    {
        $view = new \think\View();
        // 渲染模板输出 并赋值模板变量
        return $view->fetch();
        //$this->display('login');
    }

    //登录操作
    public function loginDo()
    {
        $model = model('User');

        $request = \think\Request::instance();
        $req = $request->param();

        $pwd = md5($req["password"]);
        $username = $req["username"];

        $map['name'] = $username;
        $map['pwd'] = $pwd;
        $map['use_yn'] = 'Y';

        $result = $model->where($map)->find();
        $rep_obj = new \tools\route\Resp();
        //登录成功，设置session
        if ($result != false && $result != null) {
            \think\Session::set('user.user_id', $result['user_id']);
            \think\Session::set('user.name', $result['name']);

            //$_SESSION['user']['id']=$result['id'];
            $this->getBaseInfo();//获取该登录人的必要信息，放入session

            //$return_data['url']= U('/home/index/');
            $return_data['url'] = \think\Url::build('index/index');

            $rep_data = $rep_obj->get_response('SUCCESS', '0', '处理成功', $return_data);
        } //登录不成功
        else {
            $rep_data = $rep_obj->get_response('FAIL', '0001', '用户名和密码不匹配，请重试!');
        }

        $ajx_obj = new \tools\route\AjaxReturn();
        $ajx_obj->ajx_return($rep_data);
    }

    //登出操作
    public function logoutDo()
    {
        \think\Session::delete('user');
        $redirect_obj = new \tools\route\Redirect();
        $redirect_obj->redirect('/home/login/login');
    }


    //获取其他必要信息 ，例如角色等
    private function getBaseInfo()
    {
        $user_id = \think\Session::get('user.user_id');
        //获取该人的角色
        $model_ur = model('UserRole');
        $result_ur = $model_ur->where(array('user_id' => $user_id))->field('role_id')->select();
        \think\Session::set('user.user_role', $result_ur);

        //获取该人的数据组信息
        $model_ug = model('UserGroup');
        $result_ug = $model_ug->where(array('user_id' => $user_id))->field('group_id')->select();
        \think\Session::set('user.user_group', $result_ug);

        $this->setFuncPower($result_ur);//设置该登录人的功能权限，放入session

    }

    //设置登录人的功能权限 放到session中
    private function setFuncPower($result_ur)
    {

        if ($result_ur == null) {
            return;
        }

        $model_rf = model('RoleFunc');
        //先获取第一级目录
        $result_rf = $model_rf->getUserSysPower(0, 0, $result_ur);
        $menu = $this->makeMenu($result_rf, $result_ur); //生成菜单
        \think\Session::set('user.menu', $menu);

    }

    /**
     * @param $result_rf
     * @param $result_ur
     * 生成菜单
     */
    private function makeMenu($result_rf, $result_ur)
    {
        //先生成个例子看看吧
        //每个人的固定节点
        $menu = " <li><a href='/home/index/index'><span class='am-icon-home'></span> 首页</a></li>";

        foreach ($result_rf as $k => $value) {
            //看看是否有子节点
            if (!empty($value['url'])) {
                $menu = $menu . "<li><a href='" . $value['url'] . "'><span class='am-icon-sign-out'></span> " . $value['name'] . "</a></li>";
            } else {
                $menu = $menu . " <li class='admin-parent'><a class='am-cf' data-am-collapse='{target: '#collapse-nav'}'><span class='am-icon-file'></span> " . $value['name'] . " <span class='am-icon-angle-right am-fr am-margin-right'></span></a>";
                $menu = $menu . $this->getchild($value['func_id'], $result_ur);
                $menu = $menu . "</li>";
            }

        }

        //每个人的固定节点
        $menu .= "<li><a href='/home/login/logoutDo'><span class='am-icon-sign-out'></span> 注销</a></li>";
        return $menu;

    }

    /**
     * @param $func_id
     * @param $result_ur
     * 获取该节点下面的子节点
     */
    private function getchild($func_id, $result_ur)
    {
        $submenu = '';
        $model_rf = model('RoleFunc');
        $result_rf = $model_rf->getUserSysPower($func_id, 0, $result_ur);

        if ($result_rf == null || $result_rf == false) {
            return $submenu;
        }

        $submenu .= "<ul class='am-list am-collapse admin-sidebar-sub am-in' id='collapse-nav'>";

        foreach ($result_rf as $k => $value) {
            $submenu .= "<li><a href='" . $value['url'] . "'><span class='am-icon-puzzle-piece'></span> " . $value['name'] . "</a></li>";
        }
        $submenu .= "</ul>";

        return $submenu;
    }

}