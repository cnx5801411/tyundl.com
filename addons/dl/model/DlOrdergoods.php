<?php

namespace addons\dl\model;

use think\Model;
use think\Db;

// use addons\dl\model\Goods;

/**
 * 订单
 */
class DlOrdergoods extends Model
{

    protected $name = 'dl_ordergoods';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    	
    ];  



    public function goods()
    {
        return $this->hasMany('DlOrdergoods','order_id', 'id');
    }
}