<?php

/**
 * Created by IntelliJ IDEA.
 * User: Chenrongguang
 * Date: 2016-8-24
 * Time: 14:26
 * 线程测试类
 */


namespace app\home\controller;

use Think\Controller;

class Thread
{
    public function index()
    {
        $this->display();
    }

    //测试多线程是否好用
    public function test_ok()
    {
        $thread = new \Home\Service\ThreadTestOk("World");
        //AsyncOperation("World");
        if($thread->start())
            $thread->join();

    }

   //用多线程爬虫百度
    public function  testspy_baidu(){

       // $thread = new \Home\Service\ThreadTestSpyBaidu("World");
        //AsyncOperation("World");
        //if($thread->start())
        //    $thread->join();

        for ($i = 0; $i < 500; $i++) {
            $urls[] = 'http://www.baidu.com/s?wd='. rand(10000, 20000);
        }

        /* 单线程速度测试 */
        $t = microtime(true);
        foreach ($urls as $key=>$url) {
            //dump(model_http_curl_get($url));
            model_http_curl_get($url);
        }
        $e = microtime(true);
        echo "For循环耗时：".($e-$t)."秒<br>";


        /* 多线程速度测试 */
        $t = microtime(true);
        foreach ($urls as $key=>$url) {
            $workers[$key] = new \Home\Service\ThreadTestSpyBaidu($url);
            $workers[$key]->start();
        }
        foreach ($workers as $key=>$worker) {
            while($workers[$key]->isRunning()) {
                usleep(100);
            }
            if ($workers[$key]->join()) {
                //dump($workers[$key]->result);
            }
        }
        $e = microtime(true);
        echo "多线程耗时：".($e-$t)."秒<br>";


    }

}
