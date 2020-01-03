<?php

namespace addons\dl\controller;
use think\addons\Controller;
use addons\dl\model\CacheCart;
use addons\dl\model\DlOrder;
use addons\dl\model\DlUseraddress;
use addons\dl\model\DlOrderpay;

use addons\third\model\Third;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Foundation\Application as WXPAY_APP;
use EasyWeChat\Payment\Order as WXPAY_ORDER;
use EasyWeChat\Message\Text;
use think\Log;


//fJys1kXHDNzUTa0DhvIkACMOnKej9RMtxC0S4zcvZxv EncodingAESKey
//fbgFtdzxIYSnebvVq6fSHWUph3g94ci3 Token

class Wechat extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        // $this->user_id  = $this->auth->id;
        // $this->group_id = $this->auth->group_id;
        // $this->model    = new DlOrder();
    }    
	
    public function callback(){

        $options=$this->options();


        $app = new Application($options);
        $notice = $app->notice; //模版消息


        // 从项目实例中得到服务端应用实例。
        $server = $app->server;

        $server->setMessageHandler(function ($message) {
            // return "您好！欢迎关注我!";
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            // subscribe 关注事件 $message->Event qrscene_id
            // SCAN 已关注事件
            // unsubscribe 取消订阅
             
             switch ($message->MsgType) {
                case 'event':

                    // $notice = $app->notice; //模版消息

                    // $userId = 'of_rnwMFvbVdowa9GsoSGysFCBxQ';
                    // $templateId = 'Evc38qXfEc3SfgC-cDpamq8WcuSLbki4m3nHQA0s7n8';
                    // $url = 'http://zd.juren360.com';
                    // $data = array(
                    //          "first"  => "新会员加入1！",
                    //          "keyword1"   => "会员编号",
                    //          "keyword2"  => "加入时间",
                    //          "remark" => "备注！"
                    //         );

                    // $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

                    return $message->EventKey.' - '.$message->Event;
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });

        // $message = $server->getMessage();

        // if ($message['MsgType']=='event') {
        //     $notice = $app->notice; //模版消息

        //     $userId = 'of_rnwMFvbVdowa9GsoSGysFCBxQ';
        //     $templateId = 'Evc38qXfEc3SfgC-cDpamq8WcuSLbki4m3nHQA0s7n8';
        //     $url = 'http://zd.juren360.com';
        //     $data = array(
        //              "first"  => "新会员加入1！",
        //              "keyword1"   => "会员编号",
        //              "keyword2"  => "加入时间",
        //              "remark" => "备注！"
        //             );

        //     // $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        // }


        $response = $server->serve();
        $response->send(); //Laravel 里请使用：return $response;

    }
    
    public function options(){

        return [
            /**
             * Debug 模式，bool 值：true/false
             *
             * 当值为 false 时，所有的日志都不会记录
             */
            'debug'  => true,

            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id'  => 'wxa6a600b909200bcb',         // AppID
            'secret'  => '8de129475b1c4c51927d53126b60b058',     // AppSecret
            'token'   => 'fbgFtdzxIYSnebvVq6fSHWUph3g94ci3',          // Token
            'aes_key' => 'fJys1kXHDNzUTa0DhvIkACMOnKej9RMtxC0S4zcvZxv',                    // EncodingAESKey，安全模式与兼容模式下请一定要填写！！！
        ];



    }
}
