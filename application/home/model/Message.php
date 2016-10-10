<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-27
 * Time: 14:26
 * 报表消息-模型类
 */

namespace app\home\model;
use think\Model;

class Message extends Model{

    public function _initialize()
    {

    }

    public  function getlist($paras){

        $sql = "select A.*,B.name as fund_name from t_message A left join t_fund B on A.fund_id=B.fund_id  where A.use_yn='";
        $sql =$sql  .$paras['where']['use_yn'] ."' ";
        $sql =$sql  ." and A.fund_id IN (";
        $sql =$sql  .$paras['fund_id'];
        $sql =$sql  . ") ";
        $sql =$sql  . " order by id desc ";
        $sql =$sql  . " limit ".$paras['firstRow'].",".$paras['listRows'];
        $result=\think\Db::query($sql);

        return $result;
    }


}