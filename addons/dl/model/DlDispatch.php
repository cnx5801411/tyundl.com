<?php

namespace addons\dl\model;

use think\Model;
// use addons\dl\model\Goods;

/**
 * 运费设置
 */
class DlDispatch extends Model
{

    protected $name = 'dl_dispatch';

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
    public function calFreight($weight=0,$add=0,$val){

        //判断所在区域
        $dis=$this->judge($add['city'],$val);

        //计算运费
        if($weight<=$dis['first_fee']){
            return $dis['first'];
        }else{

            $cw=$weight-$dis['first_fee'];
            if($dis['additional_fee']>0){
                $cn=ceil($cw/$dis['additional_fee']);
            }else{
                $cn=0;
            }
            $sprice=$cn*$dis['additional'];
            return round($sprice+$dis['first'],2);
        }
    }

    /*
     * 判断用户地址区域
     */
    public function judge($city,$area){

        $areaarr=json_decode($area['area'],true);
        $cityarr=explode("/", $city);

        foreach ($areaarr as $k => $val) {

            if($val['regioncontent']=='全国'){
                 $info=$val;
                 return $info;
            }

            $temarea=array();
            $temarea=json_decode($val['regioncontent'],true);
            $info = array( );

            foreach ($temarea as $k1 => $val1) {
                if($k1==$cityarr[0]){
                    if(count($val1)==0){
                        $info=$val;
                        return $info;
                        // break 2;
                    }else{
                        if(array_search($cityarr[1], $val1)){
                            $info=$val;
                            return $info;
                        }
                    }
                }
            }
        }

        $info['first']           =   $area['firstweight'];
        $info['first_fee']       =   $area['firstprice'];
        $info['additional']      =   $area['secondweight'];
        $info['additional_fee']  =   $area['secondprice'];

        return $info;
    }
}