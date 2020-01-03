<?php

namespace addons\dl\model;

use think\Model;
// use addons\dl\model\Goods;

/**
 * 支付单
 */
class DlOrderpay extends Model
{

    protected $name = 'dl_orderpay';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    	
    ];  


    function orderpay_add($user_id,$order_id,$price,$prepayId,$sn,$openid){

        $this->save([
            'user_id'       => $user_id,
            'createtime'    => time(),
            'order_id'      => $order_id,
            'money'         => $price,
            'prepay_id'     => $prepayId,
            'wx_sn'         => $sn,
            'wx_openid'     => $openid,
            'status'        =>  0
        ]);

    }

}