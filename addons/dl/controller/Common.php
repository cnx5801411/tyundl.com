<?php

namespace addons\dl\controller;
use think\addons\Controller;


class Common extends Controller
{
	/**
     * 系统相关
     */
    public function index()
    {
    	return $this->fetch(); 
    }



}
