<?php

namespace app\index\controller;

use app\common\controller\Frontend;

class Index extends Frontend
{

    protected $noNeedLogin = [''];
    protected $noNeedRight = ['*'];
    protected $layout = '';

    public function index()
    {
        //团队总业绩(历史) 只计算已经结算的业绩

 
        //团队当月业绩
        
        //个人当月业绩

        //团队本月奖金
        
        //我的本月奖金
        
        //团队人数

        //待审核人数

        //代理二维码

        //个人应得奖金总奖金-减去下属奖金
        
        
        return $this->view->fetch();
    }

    public function news()
    {
        $newslist = [];
        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.fastadmin.net?ref=news']);
    }

}
