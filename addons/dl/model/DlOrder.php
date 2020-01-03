<?php

namespace addons\dl\model;

use think\Model;
use think\Db;

// use addons\dl\model\Goods;

/**
 * 订单
 */
class DlOrder extends Model
{

    protected $name = 'dl_order';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    	
    ];  


     /**
     * 创建订单
     */
    public function order_add($user_id,$order,$express,$remark){

        Db::startTrans();
        
        $sn=$this->orderNo();

        if($express['sendtype']==1){
            // 记录订单信息
            $this->save([
                'user_id'       => $user_id,
                'sn'            => $sn,
                'price'         => $order['order_pay_price'],
                'sprice'        => $order['order_standard_price'],
                'goodprice'     => $order['order_total_price'],
                'freight'       => $order['express_price'],
                'address_id'    => $express['addid'],
                'dispatch_id'   => $express['disid'],
                'sendtype'      => $express['sendtype'],
                'remark'        => $remark,
                'addressinfo'   => json_encode($express['add'],JSON_UNESCAPED_UNICODE),
                'sprice'        => $order['order_standard_price'],
                'agent'         => $order['agent'],
                'bonus'         => $order['ordeer_total_bonus'],
                'group_id'      => $order['group_id']

            ]);
        }else{
            $this->save([
                'user_id'       => $user_id,
                'sn'            => $sn,
                'price'         => $order['order_pay_price'],
                'sprice'        => $order['order_standard_price'],
                'goodprice'     => $order['order_total_price'],
                'freight'       => $order['express_price'],
                'since_id'      => $express['sinceid'],
                'sendtype'      => $express['sendtype'],
                'remark'        => $remark,
                'sprice'        => $order['order_standard_price'],
                'agent'         => $order['agent'],
                'bonus'         => $order['ordeer_total_bonus'],
                'group_id'      => $order['group_id'],
            ]);
        }

        // 订单商品列表
        $goodsList = [];

        // 更新商品库存 (下单减库存)
        $deductStockData = [];
        foreach ($order['goods_list'] as $goods) {
            /* @var Goods $goods */
            $goodsList[] = [
                'user_id' => $user_id,
                'sn'      => $sn,
                'goods_id'=> $goods['id'],
                'price'   => $goods['total_price'],
                'num'     => $goods['total_num'],
                'uprice'  => $goods['price'],
                'sprice'  => $goods['sprice'],
                'title'   => $goods['title']
            ];

            // 下单减库存
            // $goods['deduct_stock_type'] === '10' && $deductStockData[] = [
            //     'goods_spec_id' => $goods['goods_sku']['goods_spec_id'],
            //     'stock_num' => ['dec', $goods['total_num']]
            // ];
            
        }

        // 保存订单商品信息
        $this->goods()->saveAll($goodsList);

        Db::commit();
        return true;
    }


     /**
     * 商品列表
     */
    public function getList($user_id)
    {
        //商品列表
        $goodsList = [];
        $goodsIds = array_unique(array_column($this->cart, 'goods_id'));

        foreach ((new DlGoods)->getListByIds($goodsIds) as $goods) {
            $goodsList[$goods['id']] = $goods;
        }
        
        // 购物车商品列表
        $cartList = [];
        foreach ($this->cart as $key => $cart) {
            // 判断商品不存在则自动删除
            if (!isset($goodsList[$cart['goods_id']])) {
                $this->delete($cart['goods_id']);
                continue;
            }

            /* @var Goods $goods */
            $goods = $goodsList[$cart['goods_id']]; 

            $goods['show_error'] = 0;

            // 商品单价
            $goods['price'] = $goods['price'];

            // 商品总价
            $goods['total_num']     = $cart['goods_num'];
            $goods['total_price']   = bcmul($goods['price'], $cart['goods_num'], 2);
            $cartList[] = $goods->toArray();
        }

        // 商品总金额
        $orderTotalPrice = array_sum(array_column($cartList, 'total_price'));
        
        return [
            'goods_list' => $cartList,                              // 商品列表
            'order_total_num' => $this->getTotalNum(),              // 商品总数量
            'order_total_price' => round($orderTotalPrice, 2),                 // 商品总金额 (不含运费)
            // 'order_pay_price' => bcadd($orderTotalPrice, $expressPrice, 2),    // 实际支付金额
            // 'address' => $defaultcity,  // 默认地址
            // 'exist_address' => $exist_address,      // 是否存在收货地址
            // 'express_price' => $expressPrice,       // 配送费用
            // 'intra_region' => $intraRegion,         // 当前用户收货城市是否存在配送规则中
            'has_error' => $this->hasError(),
            'error_msg' => $this->getError(),
        ];        
    }


    protected function orderNo()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    public function getCreattimeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['createtime']) ? $data['createtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;;
    }

    public function goods()
    {
        return $this->hasMany('DlOrdergoods','order_id', 'id');
    }

    public function since()
    {
        return $this->hasOne('DlSince','id', 'since_id');
    }

    public function payDetail($order_no){
        return self::get(['sn' => $order_no, 'status' => 0], ['goods']);
    }

    public function updatePayStatus($transaction_id)
    {
        Db::startTrans();
        // 更新商品库存、销量
        // $GoodsModel = new Wxlitestoregoods;
        // $GoodsModel->updateStockSales($this['goods']);
        // 更新订单状态
        
        $this->save([
            'status' => '1',
            'paytime' => time(),
            'transaction_id' => $transaction_id,
            'paytype'   =>   1,
        ]);

        //支付单记录       
        // $OrderPay   =  new DlOrderPay();
        // $OrderPay->data([
        //     'paytype'       =>  1,
        //     'updatetime'    =>  time(),
        //     'status'        =>  1,
        //     'transaction_id'=>  $transaction_id,
        //     'wx_openid'     =>  
        // ]);

        Db::commit();
        return true;
    }

    public function getDetail($id, $user_id){
        if (!$order = self::get([
            'id' => $id,
            'user_id' => $user_id,
            'status' => ['<>', '-1'] 
        ], ['goods'=>['goods'],'since'])) {
            // echo self::getLastSql();
            throw new BaseException(['msg' => '订单不存在']);
        }

        if($order['addressinfo']){
            $order['addressinfo']=json_decode($order['addressinfo'],true);
        }
        return $order;
    }


    //删除订单
    public function cancel($user_id,$order_id){

        if ($this['status'] > '0') {
            $this->error = '已付款订单不可取消';
            return false;
        }

        $order = self::get([
            'id' => $order_id,
            'user_id' => $user_id,
            'status' => ['<>', '-1']
        ]);

        return $order->save([
            'status' => '-1'
        ]);
    }

    //确认收货
    public function confirm($user_id,$order_id){

        if ($this['status'] <> '2') {
            $this->error = '该订单无法确认收货';
            return false;
        }

        $order = self::get([
            'id' => $order_id,
            'user_id' => $user_id,
            'status' => ['=', '2']
        ]);

        return $order->save([
            'status' => '3'
        ]);
    }
    
}