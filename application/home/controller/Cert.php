<?php
/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-9-29
 * Time: 14:26
 * 证书测试控制器
 */

namespace app\home\controller;

use Think\Controller;

class Cert extends \think\Controller
{
//例子：
//http://local.userauth.com/home/cert/make_cert

    public function _initialize()
    {

    }

//生成证书密钥
    public function make_cert()
    {

       //这个是购买ssl的时候填的资料了，必须准确，才能生成的了，
        $dn = array(
            "countryName" => 'XX', //所在国家名称
            "stateOrProvinceName" => 'State', //所在省份名称
            "localityName" => 'SomewhereCity', //所在城市名称
            "organizationName" => 'MySelf',   //注册人姓名
            "organizationalUnitName" => 'Whatever', //组织名称
            "commonName" => 'mySelf', //公共名称
            "emailAddress" => 'user@domain.com' //邮箱
        );

        $privkeypass = '111111'; //私钥密码
        $numberofdays = 365;     //有效时长
        $cerpath = "./test.cer"; //生成证书路径
        $pfxpath = "./test.pfx"; //密钥文件路径


//生成证书
        $privkey = openssl_pkey_new();
        $csr = openssl_csr_new($dn, $privkey);
        $sscert = openssl_csr_sign($csr, null, $privkey, $numberofdays);
        openssl_x509_export($sscert, $csrkey); //导出证书$csrkey
        openssl_pkcs12_export($sscert, $privatekey, $privkey, $privkeypass); //导出密钥$privatekey
//生成证书文件
        $fp = fopen($cerpath, "w");
        fwrite($fp, $csrkey);
        fclose($fp);
//生成密钥文件
        $fp = fopen($pfxpath, "w");
        fwrite($fp, $privatekey);
        fclose($fp);

    }

    //加密解密数据 ：利用上面生成的证书，来对数据进行验证
    public function sign_content()
    {
        $privkeypass = '111111'; //私钥密码
        $pfxpath = "./test.pfx"; //密钥文件路径
        $priv_key = file_get_contents($pfxpath); //获取密钥文件内容
        $data = "test"; //加密数据测试test

//私钥加密
        openssl_pkcs12_read($priv_key, $certs, $privkeypass); //读取公钥、私钥
        $prikeyid = $certs['pkey']; //私钥
        openssl_sign($data, $signMsg, $prikeyid, OPENSSL_ALGO_SHA1); //注册生成加密信息
        $signMsg = base64_encode($signMsg); //base64转码加密信息


//公钥解密
        $unsignMsg = base64_decode($signMsg);//base64解码加密信息
        openssl_pkcs12_read($priv_key, $certs, $privkeypass); //读取公钥、私钥
        $pubkeyid = $certs['cert']; //公钥
        $res = openssl_verify($data, $unsignMsg, $pubkeyid); //验证
        echo $res; //输出验证结果，1：验证成功，0：验证失败

    }


}
