<?php

/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-29
 * Time: 14:26
 * 入口控制器
 */

namespace app\home\controller;

use Think\Controller;

class Index extends Base
{
    public function index()
    {
        //$menu=\think\Session::get('user.menu');
        $view = new \think\View();
        return $view->fetch('');

    }

    //测试DB
    public function testdb()
    {
        $Model = M("test");
        $Data = $Model->select();
        dump($Data);
        echo "<hr>";

    }


    public function  testLog(){

        \Think::Log.write('test');
    }

    public function phpinfo(){
        echo phpinfo();
    }

    //测试发送邮件
    /*
     *最终的测试结果是，在发送给某些邮件的时候会报错，但是有些邮箱又没有问题
     * 还不知道什么原因，估计和接收方有关系
     */
    public  function  testsendmail(){
         Vendor('SendMail.sendmail');
         $mail = new \MySendMail();
         $mail->setServer("smtp.163.com", "ruixuesoft_develop@163.com", "ruixuesoft"); //设置smtp服务器
         $mail->setFrom("ruixuesoft_develop@163.com"); //设置发件人
         $mail->setReceiver("chenrongguang@rongcapital.cn"); //设置收件人，多个收件人，调用多次
         //$mail->setCc(""); //设置抄送，多个抄送，调用多次
         //$mail->setBcc("XXXXX"); //设置秘密抄送，多个秘密抄送，调用多次
         $mail->setMailInfo("test", "<b>test by crg </b>"); //设置邮件主题、内容
         $result= $mail->sendMail(); //发送
        if($result==true){
            echo 'success';
        }
        else{
            echo 'fail';
        }
    }
}