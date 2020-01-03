<?php
namespace addons\dl\model;

use think\Cache;
use addons\dl\model\DlGoods;

/**
 * 购物车管理
 * Class Cart
 */
class CacheCart
{
    /* @var string $error 错误信息 */
    public $error = '';

    /* @var int $user_id 用户id */
    private $user_id;

    /* @var array $cart 购物车列表 */
    private $cart = [];

    /* @var bool $clear 是否清空购物车 */
    private $clear = false;

    /**
     * 构造方法
     * Cart constructor.
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->cart = Cache::get('cart_' . $this->user_id) ?: [];
        // Cache::set('name',$value,3600);
    }

    /**
     * 购物车列表
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
        $orderTotalPrice    = array_sum(array_column($cartList, 'total_price'));
        
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


    /**
     * 结算
     * 还需要计算库存等
     */
    public function checkout($group_id, $goods_id, $goods_num, $add=null,$disid=null)
    {
        //商品列表
        $goodsList = [];
        $goodsIds = $goods_id;

        $tgoods = array();
        foreach ($goods_id as $key => $val) {
            $tgoods[$key]['goods_id']=$goods_id[$key];
            $tgoods[$key]['goods_num']=$goods_num[$key];
        }

        foreach ((new DlGoods)->getListByIds($goodsIds) as $goods) {
            $goodsList[$goods['id']] = $goods;
        }    

        // 购物车商品列表
        $cartList = [];
        $agent    = 0;
        $group_id = $group_id;
        foreach ($tgoods as $key => $cart) {
            /* @var Goods $goods */
            $goods = $goodsList[$cart['goods_id']]; 
            $goods['show_error'] = 0;

            //标准价
            $goods['sprice']    =   $goods['price'];

            // 商品单价
            if($goods['discountlist']==
                '1'){
                $goods['discount']=json_decode($goods['discountjson'],true);
                foreach ($goods['discount'] as $k => $val) {
                    if($val['id']==$group_id){
                        $goods['price']     =   $val['price'];
                        $agent  =   1;
                        break;
                    }
                }
            }else{
                $goods['price'] = $goods['price'];
            }

            // 商品总价
            $goods['total_num']     = $cart['goods_num'];
            $goods['total_price']   = bcmul($goods['price'], $cart['goods_num'], 2);
            $goods['stotal_price']  = bcmul($goods['sprice'], $cart['goods_num'], 2);

            //商品总重量
            $goods['total_weight']  = bcmul($goods['weight'],$cart['goods_num'],2);

            $cartList[] = $goods->toArray();
        }
        
        // 商品总金额
        $orderTotalPrice    = array_sum(array_column($cartList, 'total_price'));

        // 商品总标准价          
        $orderSTotalPrice    = array_sum(array_column($cartList, 'stotal_price'));

        // 总重量
        $orderTotalWeight   = array_sum(array_column($cartList, 'total_weight'));

        //配送费用，这里还要计算,判断是否有地址ID传入
        if($add==null){
            $expressPrice   =   0;
        }else{
            $Dispatch       =   model('addons\dl\model\DlDispatch');
            $dis=$Dispatch->get($disid);
            $expressPrice   =   $Dispatch->calFreight($orderTotalWeight,$add,$dis);  //运费
        }
        
        return [
            'goods_list' => $cartList,                              // 商品列表
            'order_total_num'   => $this->getTotalNum(),            // 商品总数量
            'order_total_price'     => round($orderTotalPrice, 2),      // 商品总金额 (不含运费)
            'order_pay_price'       => round($orderTotalPrice+$expressPrice,2),      // 实际支付金额
            'order_standard_price'   => round($orderSTotalPrice,2),      // 总标准价
            'order_total_weight' => round($orderTotalWeight, 2),                 // 商品总重量
            'ordeer_total_bonus'    => round($orderSTotalPrice-$orderTotalPrice,2),    //代理奖金
            'group_id'          =>  $group_id,
            'agent'             =>  $agent,
            // 'address' => $defaultcity,  // 默认地址
            // 'exist_address' => $exist_address,      // 是否存在收货地址
            'express_price'     => $expressPrice,       // 配送费用
            // 'intra_region' => $intraRegion,         // 当前用户收货城市是否存在配送规则中
            'has_error'         => $this->hasError(),
            'error_msg'         => $this->getError(),
        ];        
    }


    /**
     * 添加购物车
     * @param $goods_id
     * @param $goods_num
     * @return bool
     * @throws \think\exception\DbException
     */
    public function add($goods_id,$goods_num)
    {

        // 购物车商品索引
        $index = 'goodsid_'.$goods_id;

        //获得商品信息
        $Goods      =    model('addons\dl\model\DlGoods');
        $goods      =   $Goods->where('id',$goods_id)->relation(['type'])->find();   //查询商品信息

        //判断商品状态
        if ($goods['status'] !== '1') {
            $this->setError('很抱歉，该商品已下架');
            return false;
        }

        // 判断商品库存
        $cartGoodsNum = $goods_num + (isset($this->cart[$index]) ? $this->cart[$index]['goods_num'] : 0);
        if ($cartGoodsNum > $goods['total']) {
            $this->setError('很抱歉，商品库存不足');
            return false;
        }

        $create_time = time();
        $data = compact('goods_id', 'goods_num', 'create_time');
        if (empty($this->cart)) {
            $this->cart[$index] = $data;
            return true;
        }

        isset($this->cart[$index]) ? $this->cart[$index]['goods_num'] = $cartGoodsNum : $this->cart[$index] = $data;
        
        return true;
    }


    /**
     * 减少购物车中某商品数量
     * @param $goods_id
     */
    public function reduce($goods_id)
    {
        $index = 'goodsid_'.$goods_id;
        $this->cart[$index]['goods_num'] > 1 && $this->cart[$index]['goods_num']--;
    }

    /**
     * 删除购物车中指定商品
     * @param $goods_id
     * @param $goods_sku_id
     */
    public function delete($goods_id)
    {
        $index = 'goodsid_'.$goods_id;
        unset($this->cart[$index]);
    }

    /**
     * 获取当前用户购物车商品总数量
     * @return int
     */
    public function getTotalNum()
    {
        return array_sum(array_column($this->cart, 'goods_num'));
    }

    /**
     * 析构方法
     * 将cart数据保存到缓存文件
     */
    public function __destruct()
    {
        // echo "sadfasdfadf";exit;
        $this->clear !== true && Cache::set('cart_' . $this->user_id, $this->cart, 86400 * 15);
    }

    /**
     * 清空当前用户购物车
     */
    public function clearAll()
    {
        $this->clear = true;
        Cache::rm('cart_' . $this->user_id);
    }

    /**
     * 设置错误信息
     * @param $error
     */
    private function setError($error)
    {
        empty($this->error) && $this->error = $error;
    }

    /**
     * 是否存在错误
     * @return bool
     */
    private function hasError()
    {
        return !empty($this->error);
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

}
