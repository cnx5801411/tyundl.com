<?php

namespace addons\dl\model;

use think\Model;
// use addons\dl\model\Goods;

/**
 * 商品信息
 */
class DlGoods extends Model
{

    protected $name = 'dl_goods';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    	
    ];  


    public function type()
    {
        return $this->belongsTo('DlGoodstype', 'type_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public static function detail($goods_id)
    {
        $dataout = self::get($goods_id, ['category', 'spec', 'specRel', 'freight']);
        // $dataout['image'] = cdnurl(explode(",",$dataout['images'])[0], true);
        return $dataout;
    }

    public function getListByIds($goodsIds) {
        $dataout = $this->relation(['type'])
        ->where('id', 'in', $goodsIds)->select();
        return $dataout;
    }

}