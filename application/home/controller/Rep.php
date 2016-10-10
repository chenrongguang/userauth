<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-29
 * Time: 14:26
 * 报表控制器
 */

namespace app\home\controller;
use Think\Controller;
use think;

class Rep extends Base {

    public function _initialize()
    {
        parent::_initialize();
    }

    public  function  alllist(){
        $view = new \think\View();
        return $view->fetch();
    }

    public  function  add(){
       $this->display();
    }
    public  function  replist(){

        //接收请求参数
        $request = \think\Request::instance();
        $req= $request->param();

        //判断用户确实有该权限，如果不判断的话，用户虽然看不见菜单，
        //但是输入正确的url仍然可以破解进入，所以这里必须判断

        $this->checkPagePower($request->module(),$request->controller(), $request->action());

        $sess_user_group=\think\Session::get('user.user_group');
        $result_fund=null;
        //获取数据组权限
        if(!empty($sess_user_group)){
            $model_fund=model('UserGroup');
            $result_fund=$model_fund->getUserFundPower('fund',\think\Session::get('user.user_group'));

            //获取对应的资产端具体数据，供前端下拉选择
            $handle_arr_obj= new  \tools\util\HandleArr();
            $nokey_arr=$handle_arr_obj->make_nokey_arr($result_fund,'fund_id');
            $arr_string = join(',', $nokey_arr);
            $map['fund_id']= array('IN',$arr_string);
            $result_fund_name= model('fund')->where($map)->order('fund_id asc')->select();
        }

        //获取按钮权限
        $model_btn=model('RoleFunc');
        $str_btn=$model_btn->getUserPageBtnPower($request->module(),$request->controller(), $request->action());

        $conditionData['use_yn'] = 'Y';

        //如果是全部，则取其权限之内的fund,注意不可取全部
        if(empty($req['fund'])){
            $handle_arr_obj= new  \tools\util\HandleArr();
            $nokey_arr=$handle_arr_obj->make_nokey_arr($result_fund,'fund_id');
            $arr_string = join(',', $nokey_arr);
            $select_fund=0;
        }
        else{
            $arr_string=$req['fund'];
            $select_fund=$req['fund'];
        }

        $conditionData['fund_id'] =array('IN', $arr_string);

        //$model = M('message');
        $model = model('Message');
        $total = $model->field('id')->where($conditionData)->count();

        if(empty( $req['page_size'])){
            $page_size=\think\Config::get('default_page_size');
        }
        else{
            $page_size= $req['page_size'];
        }

        $Page = new \tools\page\Pagebar($total,$page_size);

        $paras['firstRow']=$Page->firstRow;
        $paras['listRows']=$Page->listRows;
        $paras['where']=$conditionData;
        $paras['fund_id']=$arr_string;

        $list = model('Message')->getlist($paras); //获取分页数据

        $show = $Page->show();

       // $this->assign('page', $show);
       // $this->assign('list', $list);

        $view = new \think\View();
        // 渲染模板输出 并赋值模板变量
        return $view->fetch('',array('page'=> $show,'list'=> $list,'fund'=>$result_fund,'list_fund'=>$result_fund_name,'select_fund'=>$select_fund,'str_btn'=>$str_btn));
    }

}