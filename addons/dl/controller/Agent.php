<?php

namespace addons\dl\controller;

use think\addons\Controller;
use addons\dl\model\DlUseragent;
use EasyWeChat\Foundation\Application;

use think\Config;

class Agent extends Controller
{

    protected $noNeedLogin = '';
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
        $this->user     = $this->auth->getUser()->toArray();
        $this->model    = new DlUseragent();
    }

    public function index()
    {
    	return $this->fetch(); 
    }

    /*
     * 代理注册,申请代理
     */
    public function register(){
    	return $this->fetch();
    }

    /*
     * 审核下级代理
     */
    public function audit(){
    	return $this->fetch();
    }
    
    /**
     * 代理个人信息
     */
    function my(){

    }

    /**
     * 个人奖金
     */
    function bonus(){

    }


    /**
     * 代理二维码
     */
    public function qrcode(){
        //查询用户是否有二维码
        $agent=$this->model->get(['user_id' => $this->user['id']]);

        if(!$agent['qrcode']){  //不存在，申请

            $options= get_addon_config('dl');

            vendor("phpqrcode.phpqrcode");

            $QRcode = new \QRcode();

            $data = $options['site_url'].url('/index/user/login',array('mycode' => $user['mycode']));

            // 纠错级别：L、M、Q、H
            $level = 'L';

            // 点的大小：1到10,用于手机端4就可以了
            $size = 4;

            $name = 'code_'.$this->user['id'];
            // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
            $path = "/uploads/code/";
            // 生成的文件名
            $fileName = $path.$size.$name.'.png';
            
            $QRcode::png($data, './'.$fileName, $level, $size);

            //保存
            $this->model->where('user_id', $this->user['id'])->update(['qrcode' => $fileName]);

        }else { //存在直接返回
            
            $fileName=$agent['qrcode'];

        }

        $this->assign('qrcode',$fileName);
        return $this->fetch();
    }


    /**
     * 代理二维码
     */
    public function qrcode1(){

        //查询用户是否有二维码
        $agent=$this->model->get(['user_id' => $this->user['id']]);

        if(!$agent['qrcode']){  //不存在，申请

            $options= get_addon_config('dl');

            $app = new Application([
                'debug'   => true,
                'app_id'  => $options['app_id'],         
                'secret'  => $options['secret'],     
                'token'   => $options['token'],         
                'aes_key' => $options['aes_key'],                    
            ]);

            $qrcode = $app->qrcode;
            $result = $qrcode->forever($this->user['id']);        // 或者 $qrcode->forever("foo");
            $ticket = $result->ticket;                      // 或者 $result['ticket']

            $url = $qrcode->url($ticket);

            $content = file_get_contents($url); // 得到二进制图片内容

            file_put_contents(ROOT_PATH . '/public/code/code_'.$this->user['id'].'.jpg', $content); // 写入文件
            
            $filename='/code/code_'.$this->user['id'].'.jpg';

            //保存
            $this->model->where('user_id', $this->user['id'])->update(['qrcode' => $filename]);

        }else { //存在直接返回
            
            $filename=$agent['qrcode'];

        }

        $this->assign('qrcode',$filename);
        return $this->fetch();
    }
}
