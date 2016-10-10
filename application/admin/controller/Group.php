<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-28
 * Time: 16:26
 * 数据权限组-控制器
 */


namespace app\admin\controller;

use Think\Controller;

class Group extends Base
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function grouplist()
    {
        $model = new \app\admin\model\Group();
        $list = $model->select();

        $view = new \think\View();
        return $view->fetch('',array('list'=> $list));

    }

    //设置改组的业务数据权限
    public function setgroupbus(){

       //需要先输入已经设置过的内容，进行界面的回显

        $model = new \app\home\model\Fund();
        $fund_list = $model->select();

        $model = new \app\home\model\Money();
        $money_list = $model->select();


        $view = new \think\View();

        return $view->fetch('',array('list'=> $fund_list,'list_money'=> $money_list));

    }

    //提交设置的保存
    public  function setgroupbusDo(){


    }

}