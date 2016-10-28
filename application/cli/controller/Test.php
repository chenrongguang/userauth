<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/10/28
 * Time: 11:15
 */

namespace app\cli\controller;


class Test
{
    /**
     * 任务测试
     */
    public  function task(){

        $request = \think\Request::instance();
        $id= $request->param("id");

        \think\Log::write("Test:".$id."-start:" .time());
        for($i=0;$i<100;$i++) {
            \think\Log::write("Test:".$id."-:" .$i);
        }
        \think\Log::write("Test:".$id."-end:" .time());
    }
}