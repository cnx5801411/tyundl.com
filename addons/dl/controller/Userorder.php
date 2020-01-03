<?php 

namespace addons\dl\controller;
use think\addons\Controller;

use addons\dl\model\DlOrder;
use addons\dl\model\DlGoods;

/**
 * 用户订单管理
 */
class Userorder extends Controller{

    protected $noNeedRight = '*';


    public function _initialize()
    {
        parent::_initialize();
        $this->user_id  =   $this->auth->id;
        $this->user 	= 	$this->auth->getUser()->toArray();
        $this->model    =   new DlOrder;
    }
	/**
	 * 可以根据状态查看
	 */
	public function index(){

        $data 		=	$this->request->param();
		$status 	=	$this->request->request('status');
        $tpage 		=	$this->request->request('page')?$tpage=$data['page']:'1';

		switch ($status) {

			case 'all':
				$where['status']=array('egt',0);
				break;
			case 'wait':
				$where['status']=0;
				break;
			case 'pay':
				$where['status']=1;
				break;
			case 'transport':
				$where['status']=2;
				break;
			case 'finish':
				$where['status']=3;
				break;
			default:
				$status='all';
				break;
		}

		$where['user_id'] = $this->user_id;

        $spage=array();
        $spage['page']=$tpage;

        $list = $this->model->alias('o')->where($where)->order('createtime desc')->with('goods')->paginate(10,true,['query' => $spage]);

        $Goods    =   new DlGoods;

        foreach ($list as $row) {
        	$num=0;
        	foreach ($row['goods'] as $k => $val) {
        		$val['gds']	=	$Goods->where('id',$val['goods_id'])->find();
        		$num+=$val['num'];
        	}
        	$row['num']	=	$num;
        }

        $page = $list->render();

        // dump($status);
        // exit();
        $this->assign('status',$status);
        $this->assign('orders', $list);
        $this->assign('page', $page);

        return $this->view->fetch();
	}

	/**
	 * 查看订单
	 */
	function detail(){
 		$id = $this->request->request('id');
		$order=$this->model->getDetail($id, $this->user_id);
		// dump($order->toArray());
		// exit;
		$this->assign('vo',$order);
        return $this->view->fetch();
	}



	/**
	 * 删除订单（只能删除未支付的）
	 */
	function del(){
  		$id = $this->request->request("id");
        $order = $this->model->getDetail($id, $this->user_id);

        if ($order->cancel($this->user_id,$id)) {
            return $this->success('取消成功！');
        }
        return $this->error($order->getError());
	}

	/**
	 * 查看快递
	 */
	function express(){

	}

	/**
	 * 确认收货
	 */
	function confirm(){
  		$id = $this->request->request("id");
        $order = $this->model->getDetail($id, $this->user_id);

        if ($order->confirm($this->user_id,$id)) {
            return $this->success('确认成功！');
        }
        return $this->error($order->getError());
	}
	
}
?>