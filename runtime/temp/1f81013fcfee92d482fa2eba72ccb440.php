<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"D:\www\www.sm.cn\addons\dl\view\user\index.html";i:1568260729;s:50:"D:\www\www.sm.cn\addons\dl\view\common\layout.html";i:1565920816;}*/ ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
<meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
<title></title>
<meta name="description" content="">

<link rel="stylesheet" type="text/css" href="/assets/addons/dl/css/aui/css/aui.2.0.css" />
<link rel="stylesheet" type="text/css" href="/assets/addons/dl/css/iconfont/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/assets/addons/dl/css/weui.min.css" />
<link rel="stylesheet" type="text/css" href="/assets/addons/dl/css/style.css" />

<script src="/assets/addons/dl/js/jquery-1.10.2.min.js"></script>
<script src="/assets/addons/dl/js/yxMobileSlider.js"></script>
<script src="/assets/addons/dl/css/iconfont/iconfont.js"></script>
<style type="text/css">
.icon {
    /* 通过设置 font-size 来改变图标大小 */
    width: 1em; height: 1em;
    /* 图标和文字相邻时，垂直对齐 */
    vertical-align: -0.15em;
    /* 通过设置 color 来改变 SVG 的颜色/fill */
    fill: currentColor;
    /* path 和 stroke 溢出 viewBox 部分在 IE 下会显示
        normalize.css 中也包含这行 */
    overflow: hidden;
}
</style>
</head>

<body>

    

<div class="uc_top">
    <a href="<?php echo addon_url('dl/agent/qrcode'); ?>"><img src=""></a>
    <div class="uc_top_name"><?php echo $user['nickname']; ?></div>
</div>

<div class="uc_table">
    <a href="<?php echo addon_url('dl/userorder/index'); ?>">
        <i class="icon iconfont">&#xe611;</i>
        我的订单
    </a>
    <a href="">
        <i class="icon iconfont">&#xe689;</i>
        下级代理
    </a>
    <a href="<?php echo addon_url('dl/agent/register'); ?>">
        <i class="icon iconfont">&#xe691;</i>
        添加代理
    </a>
    <a href="">
        <i class="icon iconfont">&#xe608;</i>
        修改密码
    </a>
    <a href="">
        <i class="icon iconfont">&#xe604;</i>
        历史奖金
    </a>
    <a href="<?php echo url('/addons/dl/useraddress/index'); ?>">
        <i class="icon iconfont">&#xe6dc;</i>
        收货地址管理
    </a>
</div>

<div class="uc_list aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in">
        <li class="aui-list-header"></li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner aui-list-item-arrow">
                <a href=""><i class="icon iconfont">&#xe61d;</i>下级代理审核</a>
            </div>
        </li>

        <li class="aui-list-item">
            <div class="aui-list-item-inner aui-list-item-arrow">
                <a href="<?php echo url('/addons/dl/user/info'); ?>"><i class="icon iconfont">&#xe60b;</i>修改个人信息</a>
            </div>
        </li>

        <li class="aui-list-item">
            <div class="aui-list-item-inner aui-list-item-arrow">
                <a href=""><i class="icon iconfont">&#xe606;</i>收货地址管理</a>
            </div>
        </li>

        <li class="aui-list-item">
            <div class="aui-list-item-inner aui-list-item-arrow">
                <a href=""><i class="icon iconfont">&#xe645;</i>退出</a>
            </div>
        </li>
    </ul>
</div>

    <div class="footer">
        <a class="on"  href="<?php echo url('dl/index'); ?>">
            <i class="icon iconfont">&#xe605;</i>
            <p>首页</p>
        </a>
        <a  href="<?php echo addon_url('dl/goods/index'); ?>">
            <i class="icon iconfont">&#xe690;</i>
            <p>下单</p>
        </a>
        <a  href="<?php echo addon_url('dl/cart/index'); ?>">
            <i class="icon iconfont">&#xe690;</i>
            <p>购物车</p>
        </a>
        <a href="<?php echo addon_url('dl/agent/index'); ?>">
            <i class="icon iconfont">&#xe602;</i>
            <p>代理</p>
        </a>
        <a href="<?php echo addon_url('dl/user/index'); ?>">
            <i class="icon iconfont">&#xe613;</i>
            <p>我的</p>
        </a>
    </div>

</body>
<script>
    $(".slider").yxMobileSlider({width:640,height:320,during:3000}) 
</script>
</html>

