<?php

namespace addons\dl\controller;
use think\addons\Controller;


class User extends Controller
{
	/**
     * 用户中心
     */
    public function index()
    {
    	return $this->fetch(); 
    }



}
