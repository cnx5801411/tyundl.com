<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:49:"D:\www\www.sm.cn\addons\dl\view\agent\qrcode.html";i:1574064135;s:50:"D:\www\www.sm.cn\addons\dl\view\common\layout.html";i:1565920816;}*/ ?>
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

    

<body class="shareBG">

<div id='wx_logo' style='margin:0 auto;display:none;'>
    <!--分享图标-->
    <img src='/Public/Home/Images/shareIcon.jpg' />
</div>

<header class="aui-bar aui-bar-nav header_common">

    <a class="aui-pull-left aui-btn" href="javascript:history.go(-1);">

        <span class="aui-iconfont aui-icon-left"></span>

    </a>

    <div class="aui-title">二维码</div>

</header>


<div class="qrcode">
    <img class="qrcodehead" src="<?php echo (isset($user['avatar']) && ($user['avatar'] !== '')?$user['avatar']:'/assets/addons/dl/images/userImgDefault.jpg'); ?>">
    <p style="font-size:1rem; font-weight:bold; margin-bottom:0.5rem; color:#fff;"></p>
    <img src="<?php echo $qrcode; ?>">
    <p style="color:#fff">手指长按识别二维码</p>
</div>



<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

</body>

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

