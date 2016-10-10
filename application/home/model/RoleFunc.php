<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-27
 * Time: 14:26
 * 角色权限-模型类
 */
namespace app\home\model;

use think\Model;

class RoleFunc extends Model
{

    public function _initialize()
    {

    }

    /**
     * @param $pid 父节点
     * @param $type 类型：菜单还是按钮
     * @return mixed
     */
    public function getUserSysPower($pid,$type,$result_ur)
    {
        $handle_arr_obj= new  \tools\util\HandleArr();
        $nokey_arr=$handle_arr_obj->make_nokey_arr($result_ur,'role_id');
        $arr_string = join(',', $nokey_arr);

        $sql = "select * from t_role_func A left join t_func B  on A.func_id=B.func_id where B.type='$type' and pid='$pid' and A. role_id in(";
        $sql =$sql  .$arr_string;
        $sql =$sql  . ") order by B.sort ASC;";
        $result=\think\Db::query($sql);

        return $result;

    }

    /**
     * @param $module
     * @param $controller
     * @param $action
     * 根据当前的模块，控制器 和方法 获取其下的按钮
     **/
    public  function getUserPageBtnPower($module, $controller,$action){

        $url='/'.$module.'/'.$controller.'/'.$action;

        $resunt_sysfunc=model('Func')->where(array('url'=>$url))->field('func_id')->find();
        $func_id=$resunt_sysfunc['func_id']; //菜单id


        //获取该人的角色
        $result_ur = \think\Session::get('user.user_role');
        $handle_arr_obj= new  \tools\util\HandleArr();
        $nokey_arr=$handle_arr_obj->make_nokey_arr($result_ur,'role_id');
        $arr_string = join(',', $nokey_arr);

        //获取其按钮权限
        $sql = "select B.btn from t_role_func A inner join t_func B  on A.func_id=B.func_id where B.type=1 and B.pid='$func_id' and A. role_id in(";
        $sql =$sql  .$arr_string;
        $sql =$sql  . ") order by B.sort ASC;";
        $result=\think\Db::query($sql);

        if($result!=null && $result!=false){
            //转化为字符串的个人返回，供前台使用
            $nokey_arr=$handle_arr_obj->make_nokey_arr($result,'btn');
            return join(',', $nokey_arr);
        }
        else{
            return "";
        }

    }

}