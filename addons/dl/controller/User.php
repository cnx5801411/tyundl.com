<?php

namespace addons\dl\controller;
use think\addons\Controller;


class User extends Controller
{

    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    
    public function _initialize()
    {
        parent::_initialize();
        $user = $this->auth->getUser()->toArray();
    }

	/**
     * 用户中心
     */    
    public function index()
    {

    // dump($this->auth->getUser()->toArray());
    // 	exit();

    	return $this->fetch();
    }

    /**
     * 个人信息
     */
    public function info(){

        return $this->fetch();
    }


}
