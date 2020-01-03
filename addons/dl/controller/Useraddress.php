<?php

namespace addons\dl\controller;
use think\addons\Controller;
use think\Validate;

use addons\dl\model\DlUseraddress;


/**
 * 用户地址管理
 */
class Useraddress extends Controller{

	protected $noNeedLogin = '';
	protected $token = '';

	public function _initialize()
    {
        parent::_initialize();
        $this->user_id  =   $this->auth->id;
        $this->model    =   new DlUseraddress;
        $this->url      =   session('url');
    }

	public function index(){
        session('url', $this->request->url());
        $list = $this->model->getList($this->user_id);
        $this->assign('list',$list);
    	return $this->fetch();
	}

	/**
	 * 添加地址
	 */
	function add(){

		if ($this->request->isPost()) { //保存提交            

			$data=$this->request->post();
            $data['user_id']    =   $this->user_id;
                
            $rule=[
                'name'   => 'require|max:30|token',
                'mobile' => 'require|max:30|number',
                'info'  => 'require',
            ];

            $msg = [
                'name.require'  => '姓名必须',
                'name.max'      => '姓名最多不能超过30个字符',
                'mobile.require'=> '电话必须',
                'mobile.max'    => '电话最多不能超过30个字符',
                'mobile.number' => '电话格式不正确',
                'info.require' =>  '详细地址必须',
                '__token__.token'   =>'请勿重复提交'
            ];  
            
            $validate   = Validate::make($rule,$msg);

            if (!$validate->check($data)) {
                $this->error($validate->getError(), null, $data = '', $wait = 1);
            }   

            $re=$this->model->allowField(true)->save($data);
            if($re){              
                $this->success('保存成功',$this->url,['user_id' => $this->user_id],1);
            }else{
                $this->error('保存失败');
            }

		}else{

		}

    	return $this->fetch();
	}

	/**
	 * 修改地址
	 */
	function edit(){
        $id = $this->request->request('id');
        if (!$this->request->isPost()) {
            $add= $this->model->get($id);        
            $this->assign('add',$add);
        }else{
            $data=$this->request->post();
            
            $rule=[
                'name'   => 'require|max:30|token',
                'mobile' => 'require|max:30|number',
                'info'  => 'require',
            ];

            $msg = [
                'name.require'  => '姓名必须',
                'name.max'      => '姓名最多不能超过30个字符',
                'mobile.require'=> '电话必须',
                'mobile.max'    => '电话最多不能超过30个字符',
                'mobile.number' => '电话格式不正确',
                'info.require' =>  '详细地址必须',
                '__token__.token'   =>'请勿重复提交'
            ];  
            
            $validate   = Validate::make($rule,$msg);

            if (!$validate->check($data)) {
                $this->error($validate->getError(), null, $data = '', $wait = 1);
            }  

            $re=$this->model->allowField(true)->save($data,['user_id' => $this->user_id,'id'=>$id]);

            if($re){              
                $this->success('保存成功',addon_url('dl/useraddress/index'),['user_id' => $this->user_id],1);
            }else{
                $this->error('保存失败');
            }
        }

        return $this->fetch();
	}

	/**
	 * 删除地址
	 */
	function del(){
        if ($this->model->where(['id'=>$this->request->request('id'),'user_id'=>$this->user_id])->delete()) {
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
	}

    /**
     * 选择地址
     */
    function choose(){
        session('url', $this->request->url());
        $list = $this->model->getList($this->user_id);
        $this->assign('list',$list);  
        
        return $this->fetch();
    } 

    /**
     * 设置地址
     */
    function setdefault(){      
        $this->model->where(['user_id' => $this->user_id])->update(['defaultswitch' => '0']);
        if($this->model->where(['user_id' => $this->user_id,'id'=>$this->request->request('id')])->update(['defaultswitch' => '1'])){
            // return $this->success('设置成功',addon_url('dl/cart/checkout'),'',1);
            return $this->redirect(addon_url('dl/cart/checkout'));
        }
        return $this->error('设置失败');
    }

}