<?php

namespace addons\dl\controller;

// use think\addons\Controller;

// class Index extends Base

use think\addons\Controller;

class Index extends Base
{
    protected $noNeedLogin = '';
    protected $noNeedRight = ['*'];

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
    	return $this->fetch(); 
    }

    public function login()
    {
    	return $this->fetch('login');
    }

}
