<?php

namespace addons\dl\model;

use think\Model;
// use addons\dl\model\Goods;

/**
 * 用户收货地址
 */
class DlUseraddress extends Model
{

    protected $name = 'dl_useraddress';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    	
    ];  

    public function getList($user_id)
    {
        return self::all(compact('user_id'));
    }

    public function user()
    {
        return $this->belongsTo('app\common\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

}