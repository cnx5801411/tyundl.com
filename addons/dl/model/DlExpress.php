<?php

namespace addons\dl\model;

use think\Model;
// use addons\dl\model\Goods;

/**
 * 快递信息
 */
class DlExpress extends Model
{

    protected $name = 'dl_express';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    	
    ];  




    /*
     *计算快递费用
     */
    public function calFreight($weight=0,$add=0,$expid=0){

        //判断是否有区域设置
        // $Dispatch       =    model('addons\dl\model\Dispatch');
        // $map['status']  =   1;
        // $map['expid']   =   $expid;
        // $order='sort asc';
        // $dis=$Dispatch->where($map)->order($order)->select();

        

        return 1;
    }
}