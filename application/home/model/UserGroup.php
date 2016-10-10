<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-27
 * Time: 14:26
 * 用户组-模型类
 */

namespace app\home\model;
use think\Model;

class UserGroup extends Model{

    public function _initialize()
    {

    }


    /**
     * @param $type
     * @param $result_ur
     * @return mixed
     * 获取该用户，关于资产端的权限
     */
    public  function  getUserFundPower($type,$result_ur){

        //$result_ur = \think\Session::get('user.user_group');
        $handle_arr_obj= new  \tools\util\HandleArr();
        $nokey_arr=$handle_arr_obj->make_nokey_arr($result_ur,'group_id');
        $arr_string = join(',', $nokey_arr);

        $sql = "select distinct bus_data as fund_id from t_group_bus  where bus_type='$type' and set_type='equal' and  group_id in(";
        $sql =$sql  .$arr_string;
        $sql =$sql  . ") ;";
        $result=\think\Db::query($sql);

        return $result;

    }

}