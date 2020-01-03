<?php

namespace addons\dl\controller;
use think\addons\Controller;
use addons\dl\model\CacheCart;
use addons\dl\model\DlOrder;
use addons\dl\model\DlOrderpay;
use addons\dl\model\DlUseraddress;

use addons\third\model\Third;
use EasyWeChat\Foundation\Application as WXPAY_APP;
use EasyWeChat\Payment\Order as WXPAY_ORDER;

class Order extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        $this->user_id  = $this->auth->id;
        $this->group_id = $this->auth->group_id;
        $this->model    = new DlOrder();
    }    
	/**
     * 订单
     */
    public function index()
    {
    	return $this->fetch(); 
    }


    /*
     * 创建订单
     */
    public function buy(){

    	// $goods  =   I('good_id');
     //    $nums   =   I('good_num');

        // $addid      =   I('addid');
        // $add_name   =   I('add_name');
        // $add_mobile =   I('add_mobile');
        // $add_address=   I('add_address');
        // $remark     =   I('remark');
        

        //地址和留言信息
        $addid  =   $this->request->request('addid');
        $remark =   $this->request->request('remark');

        $sendtype   =   $this->request->request('sendtype');  //发货方式
        $sinceid    =   $this->request->request('since');     //自提ID
        $disid      =   $this->request->request('expid');     //快递ID

        $goods_id   =   $this->request->request('goods_id/a');
        $goods_num  =   $this->request->request('goods_num/a');

        $rq_data    =   $this->request->request();
        
        $Cart   = new CacheCart($this->user_id);
        // $Order  = new DlOrder();

        $express['add']          = array();
        $express['sendtype']    =   $sendtype;

        if($sendtype==1){
            $Add    = new DlUseraddress();
            $add=$Add->where('id',$addid)->find();
            $express['add']         =   $add;
            $express['addid']       =   $addid;
            $express['disid']       =   $disid;
        }else{
            $express['sinceid']     =   $sinceid;
            $add=0;
            $disid=0;
        }

        //数据有效验证        
        $goodslist=$Cart->checkout($this->group_id,$goods_id, $goods_num,$add,$disid);        
        
        // dump($goodslist);
        // exit;
        
        if($this->model->order_add($this->user_id,$goodslist,$express,$remark)){

            //清空购物车
            // $Cart->clearAll();

            //判断微信绑定？
            $this->init_wx_pay_for_gzh(true);
                        
            //发起支付
            $json=$this->make_wx_pay('wechat');
            
            $this->assign('jsApiParameters',$json);
            return $this->fetch('payment');
        }
        // $this->error($Order->getError() ?: '订单创建失败');
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
                        'notify_url'         =>  \think\Request::instance()->domain().addon_url('dl/notify/callback_for_wxgzh'), 
                    ],

                  ];

        $this->wxapp = new WXPAY_APP($options);
    }

    private function make_wx_pay($platform){

        $third = Third::where(['user_id' => $this->user_id, 'platform' => $platform])->find();

        $payment = $this->wxapp->payment;

        $attributes = [
            'trade_type'       => 'JSAPI',
            'body'             => $this->model['sn'],
            'detail'           => 'OrderID:'.$this->model['id'],
            'out_trade_no'     => $this->model['sn'],
            //'total_fee'        => $this->model['pay_price'] * 100, // 单位：分
            'total_fee'        => 1, // 单位：分
            'openid'           => $third['openid'],
        ];
        $order = new WXPAY_ORDER($attributes);

        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
            $config = $payment->configForJSSDKPayment($prepayId); // 返回数组
            $json = $payment->configForPayment($prepayId); 

            //创建支付记录
            $Orderpay   = new DlOrderpay();
            $Orderpay->orderpay_add($this->user_id,$this->model['id'],$this->model['price'],$prepayId,$this->model['sn'],$third['openid']);


            $this->assign('jsApiParameters',$json);
            return $json;
            // return $this->success('预支付成功',$config);
        }

        return $this->error('微信支付调用失败',$result);
    }

    private function make_pay_record($json,$price,$type){

        $Orderpay   = new DlOrderpay();

        // $npdata['o_id']     =   $or['id'];
        // $npdata['userid']   =   $or['userid'];
        // $npdata['money']    =   $or['price'];
        // $npdata['status']   =   0;
        // $npdata['create_time']  =   $time;
        // $npdata['update_time']  =   $time;
        // $npdata['paytype']  =   1;
        // $npdata['prepay_id']=       $order['prepay_id'];
        // $npdata['wx_sn']    =    $data['wx_sn'];

        // $rep=$OrderPay->data($npdata)->add();

        $config=json_decode($json);

        // $Orderpay->save([
        //     'user_id'       => $this->user_id,
        //     'paytime'       => time(),
        //     'paytype'       =>  $type,
        //     'createtime'    => time(),
        //     'order_id'      => $order_id,
        //     'money'         => $price,
        //     'paypay_id'     => $config['prepay_id'],
        //     'wx_sn'         => ,
        //     'wx_openid'     => ,
        // ]);
    }


        /**
     * 订单支付
     */
    function order_pay(){
        $id = $this->request->post("id");
        $order = $this->model->getDetail($id, $this->user_id);
        //检测商品状态
        
        $this->model=$order;
        
        //判断微信绑定？
        $this->init_wx_pay_for_gzh(true);
                    
        //发起支付
        $json=$this->make_wx_pay('wechat');

        //创建支付记录
        // $this->make_pay_record($json);
        
        $this->assign('jsApiParameters',$json);
        return $this->fetch('payment');
    }
}
