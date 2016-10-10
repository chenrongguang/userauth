<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-29
 * Time: 14:26
 * 远程握手调用控制器
 */

namespace app\home\controller;

use Think\Controller;

class Rpc extends \think\Controller
{
    //例子：
    //http://local.userauth.com/home/rpc/example_sign?appkey=123&signature=jsdfsdfsf&timestamp=243423423&nonce=ssdfdsfdfdsfd

    public function _initialize()
    {

    }

    private $ret_info = array(
        1=>'缺少必要参数',
        2=>'时间戳验证失败',
        3=>'APPKEY验证失败',
        4=>'签名验证失败'
    );


    /**
     * @param $timestamp
     * @param $nonce
     * @param $signature
     * @param $secrect
     * @return bool
     * 签名规则，双方约定，可以有很多种：
     * 例如这里：将get的所有的参数，除签名字段
     * 再加上获取到的 $secrect 进行升序排序，然后进行md5进行加密
     * 如果这样生成的签名和对方传入的签名一直，那么表示验证成功，如果比对失败，则验证失败
     * 这样的方式，需要双方保护好自己的密钥secrete ,千万不要泄露了
     * 这是目前淘宝，微信等平台的普遍做法
     */
    private function _checkRequest($appkey,$timestamp, $nonce, $signature,$secrect)
    {
        $token =$secrect;
        $tmpArr = array($appkey,$token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = md5($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $appkey
     */
    private function getSecrect($appkey){
        return "a94d4a04-8544-11e6-a91b-2c56dc977b60";
    }


    /**
     * @param $timestamp
     * 验证时间戳，可以是10分钟的过期
     */
    private function checktimespan($timestamp){
        return true;
    }

    //采用签名验证的例子
    function example_sign()
    {
        $request = \think\Request::instance();
        $req= $request->param();

        $appkey = $req['appkey']; //分配的appkey
        $signature =$req['signature']; //对方生成的签名
        $timestamp = $req['timestamp'];//时间戳
        $nonce = $req['nonce'];//随机数
        if (empty($appkey) || empty($timestamp) || empty($nonce) || empty($signature)) {
            exit($this->ret_info[1]);
        } else {
            //比较时间，如果时间已经过期，则返回
            if(!$this->checktimespan($timestamp)){
                exit($this->ret_info[2]);
            }

            //根据appkey,获取分配的appsecrect
            $secrect= $this->getSecrect($appkey);
            if(empty($secrect)){
                exit($this->ret_info[3]);
            }


            if (!$this->_checkRequest($appkey,$timestamp, $nonce, $signature,$secrect)) {
                exit($this->ret_info[4]);
            }

            exit('验证成功');
        }
    }
}
