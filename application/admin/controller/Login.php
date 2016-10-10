<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-28
 * Time: 17:16
 * 登录登出
 */

namespace app\admin\controller;
use Think\Controller;
use Think\Verify;

class Login extends \think\Controller {

    public  function  login(){
        $view = new \think\View();
        return $view->fetch();

    }
    //登录操作
    public  function  loginDo(){


        $model = model('Admin');

        $request = \think\Request::instance();
        $req= $request->param();

        $pwd = md5($req["password"]);
        $username = $req["username"];

        $map['name']=$username;
        $map['pwd']=$pwd;
        $map['use_yn']='Y';

        $result= $model->where($map)->find();
        $rep_obj= new \tools\route\Resp();
        //登录成功，设置session
        if($result!=false && $result !=null){
            \think\Session::set('admin.id',$result['id']);
            \think\Session::set('admin.name',$result['name']);
            $return_data['url']= \think\Url::build('syspub/index');
            $rep_data= $rep_obj->get_response('SUCCESS','0','处理成功',$return_data);
        }
        //登录不成功
        else{
            //  $this->ajaxReturn(\Common\Util\Response::get_response();

            $rep_data= $rep_obj->get_response('FAIL','0001','用户名和密码不匹配，请重试!');

        }

        $ajx_obj= new \tools\route\AjaxReturn();
        $ajx_obj->ajx_return($rep_data);



/*
        $model = M('admin');
        $pwd = md5(I("post.password"));
        $username = I("post.username");

        $map['name']=$username;
        $map['pwd']=$pwd;
        $map['use_yn']='Y';

        $result= $model->where($map)->find();
        //登录成功，设置session
        if($result!=false && $result !=null){
            $_SESSION['admin']['id']=$result['id'];
            $_SESSION['admin']['name']=$result['name'];
            $return_data['url']= '/public/index/';
            //$return_data['url']= U('public/main');
            //$return_data['url']= U('public/index');
            $this->ajaxReturn(\Common\Util\Response::get_response('SUCCESS','0','处理成功',$return_data));
        }
        //登录不成功
        else{
            $this->ajaxReturn(\Common\Util\Response::get_response('FAIL','0001','用户名和密码不匹配'));
        }

*/
    }
    //登出操作
    public  function logoutDo(){
        \think\Session::delete('user');
        $redirect_obj= new \tools\route\Redirect();
        $redirect_obj->redirect('/admin/login/login');

    }


}