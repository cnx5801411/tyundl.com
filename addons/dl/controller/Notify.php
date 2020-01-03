<?php

namespace addons\dl\controller;
use think\addons\Controller;
use addons\dl\model\CacheCart;
use addons\dl\model\DlOrder;
use addons\dl\model\DlUseraddress;
use addons\dl\model\DlOrderpay;

use addons\third\model\Third;
use EasyWeChat\Foundation\Application as WXPAY_APP;
use EasyWeChat\Payment\Order as WXPAY_ORDER;
use think\Log;

class Notify extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        $this->user_id  = $this->auth->id;
        $this->group_id = $this->auth->group_id;
        $this->model    = new DlOrder();
    }    
	
    public function callback_for_wxgzh(){

        $this->init_wx_pay_for_gzh(false);
        $response = $this->wxapp->payment->handleNotify(function($notify, $successful){

            $order = $this->model->payDetail($notify->out_trade_no);

            // Log::record('测试日志信息:'.$notify->out_trade_no);
            // Log::record('测试日志信息 ' . var_export($notify, true), 'info');
            // Log::record('测试日志信息:'.$notify->transaction_id);

            if (empty($order)) { // 如果订单不存在
                return true;
                //return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            if ($successful) {                
                $order->updatePayStatus($notify->transaction_id);

                //修改支付记录
                $DlOrderpay    = new DlOrderpay();
                $DlOrderpay->where('order_id', $order['id'])->update(['transaction_id' => $notify->transaction_id,
                'updatetime'=>time(),
                'paytype'=>1,
                'status' =>1
                ]);
            }

            return true; // 返回处理完成
        });

        $response->send();
    }


     private function init_wx_pay_for_gzh($Ischeck=false){
        //这里首先判断 此用户是否绑定了微信公众号
        if($Ischeck){
            $third = Third::where(['user_id' => $this->user_id, 'platform' => 'wechat'])->find();
            if(!$third){
                //从这里自动绑定微信公众号的账户
                $this->error('您未绑定微信号',null,1008);
            }
        }

        $config = get_addon_config('dl');
        
        $third_config = get_addon_config('third');
        $third_options = array_intersect_key($third_config, array_flip(['wechat']));
        $third_options = $third_options['wechat'];

        $options = [
                    'debug'  => true,
                     'log' => [
                        'level' => 'debug',
                        'file'  => '/tmp/easywechat.log',
                    ],
                    'app_id'   => $third_options['app_id'],
                    'secret'   => $third_options['app_secret'],
                    'payment' => [
                        'merchant_id'        =>  $config['MCHIDGZH'],
                        'key'                =>  $config['APIKEYGZH'],
                        'notify_url'         =>  \think\Request::instance()->domain().addon_url('dl/Notify/callback_for_wxgzh'), 
                    ],

                  ];

        $this->wxapp = new WXPAY_APP($options);
    }
    
}
