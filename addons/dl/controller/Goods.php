<?php
namespace addons\dl\controller;
use think\addons\Controller;

// use addons\dl\model;
use addons\dl\model\DlGoods;

class Goods extends Controller
{

    public function index()
    {        
        
        $Goods       =    model('addons\dl\model\DlGoods');
        $goodslist=$Goods->where('status',1)->order('weight desc')->relation(['type'])->select();     
        $this->assign('goodslist',$goodslist);

        $Type   =   model('addons\dl\model\DlGoodstype');
        $types  =   $Type->where('status',1)->order('weight desc')->select();
        $this->assign('types',$types);
         
    	return $this->fetch(); 
    }

    /**
     * 商品信息
     */
    function detail(){
        
        $gid=$this->request->param('gid');
        //存在id 显示商品 
        if($gid){
            $Goods       =    model('addons\dl\model\DlGoods');
            $goods=$Goods->where('id',$gid)->relation(['type'])->find();

            if($goods['discountlist']){                
                //用户组
                $UserGroup  =    model('app\admin\model\UserGroup');
                $usergroup  =   $UserGroup->field('id,name,status')->order('id asc')->select();
                $this->view->assign("usergroup", json_encode($usergroup));

                $discount =json_decode($goods['discountjson'],true);
                $usergroup=collection($usergroup)->toArray();
                $tem=array_merge($usergroup,$discount);
                $goods['discountjson']    =   (array_column($tem,null,'id'));    

            }

            $this->assign('goods',$goods);
            return $this->fetch();

        }else{
            $this->error('商品信息不存在！');
        }
    
    }

    
    
}