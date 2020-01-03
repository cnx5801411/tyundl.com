<?php

namespace addons\dl\controller;

use think\addons\Controller;
use app\common\library\Auth;
use addons\dl\model\CacheCart;

class Cart extends Controller
{
	/**
     * 购物车
     */    
    public function _initialize()
    {
        parent::_initialize();
        // Auth::instance()->setAllowFields($this->allowFields);
        $this->user_id = $this->auth->id;
        $this->group_id = $this->auth->group_id;
        $this->model = new CacheCart($this->user_id);

    }

    public function index()
    {
        $goodslist=$this->model->getList($this->user_id);
        $this->assign('goodslist',$goodslist);
    	return $this->fetch(); 
    }

    /**
     * 添加商品
     */
    function add(){
        $rq_data   = $this->request->request();
        $goods_id  = $rq_data['goods_id'];
        $goods_num = 1;

        if (!$this->model->add($goods_id,$goods_num)) {
            return $this->error($this->model->getError() ?: '加入购物车失败');        
        }

        $total_num = $this->model->getTotalNum();
        return $this->success('加入购物车成功','',['cart_total_num' => $total_num]);
    }

    /**
     * 删除商品 
     */
    function del(){
        $rq_data = $this->request->request();
        $goods_id = $rq_data['goods_id'];
        $this->model->delete($goods_id);
        return $this->success();
    }

    /**
     * 获得购物车商品数量
     */
    function getNum(){
        $total_num = $this->model->getTotalNum();
        return $this->success('',['cart_total_num' => $total_num]);
    }

    //获得购物车商品数量
    public function getTotalNum(){
        $total_num = $this->model->getTotalNum();
        return $this->success('',['cart_total_num' => $total_num]);
    }

    /**
     * 减少数量
     */    
    function reduce(){
        $rq_data = $this->request->request();
        $goods_id = $rq_data['goods_id'];
        $this->model->reduce($goods_id);
        return $this->success();
    }
    
    /**
     * 结算
     */    
    function checkout(){

        $goods_id   = $this->request->param('goods_id/a');
        $goods_num  = $this->request->param('goods_num/a');
        $rq_data    = $this->request->request();

        if($goods_id){
            session('goods_id', $goods_id);
            session('goods_num', $goods_num);
        }else{
            $goods_id   =   session('goods_id');
            $goods_num  =   session('goods_num');
        }

        //自提点
        $Since      =    model('addons\dl\model\DlSince');
        $sinces     =   $Since->where('status',1)->order('weigh desc')->select();
        $this->assign('sinces',$sinces);

        //判断是否有默认收货地址
        $Address       =    model('addons\dl\model\DlUseraddress');
        $add  =  $Address->where('defaultswitch',1)->where('user_id',$this->user_id)->order('id desc')->find(); 
        $this->assign('add',$add);

        $goodslist=$this->model->checkout($this->group_id,$goods_id, $goods_num);
        $this->assign('goodslist',$goodslist);

        //查询快递公司模版        
        $Dispatch   =   model('addons\dl\model\DlDispatch');
        $exps       =   $Dispatch->where('status',1)->order('weigh desc')->select();
        if($exps){
            foreach ($exps as $k => &$val) {
                $val['weightprice']=$Dispatch->calFreight($goodslist['order_total_weight'],$add,$val);  //运费
            }   
        }

        $this->assign('exps',$exps); 
        return $this->fetch(); 
    }

}
