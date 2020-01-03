<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:48:"D:\www\www.sm.cn\addons\dl\view\agent\index.html";i:1555576206;s:50:"D:\www\www.sm.cn\addons\dl\view\common\layout.html";i:1565920816;}*/ ?>
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

    

<body class="index">
<div class="index_table">
    <table>
        <tbody>
            <tr>
                <td>
                    <i class="icon iconfont">&#xe661;</i>
                    <p>当日销量</p>
                    <p>元</p>
                </td>
                <td>
                    <i class="icon iconfont">&#xe62a;</i>
                    <p>当月销量</p>
                    <p>元</p>
                </td>
                <td>
                    <i class="icon iconfont">&#xe88e;</i>
                    <p>个人累计销量</p>
                    <p>元</p>
                </td>
            </tr>
            <tr>
                <td>
                    <i class="icon iconfont">&#xe67c;</i>
                    <p>团队日销</p>
                    <p>元</p>
                </td>
                <td>
                    <i class="icon iconfont">&#xe61c;</i>
                    <p>团队月销</p>
                    <p>元</p>
                </td>
                <td>
                    <i class="icon iconfont">&#xe603;</i>
                    <p>团队累计销量</p>
                    <p>元</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="index_btn">

    <div class="index_btn_inner">
        <a href="" style="background-color:#fef5e3">
            <i class="icon iconfont">&#xe632;</i>
            <div class="index_btn_info">
                <p>元</p>
                <p>当月团队奖金</p>
            </div>
        </a>
    </div>

    <div class="index_btn_inner">
        <a href="" style="background-color:#fee1e6">
            <i class="icon iconfont">&#xe74f;</i>
            <div class="index_btn_info">
                <p>元</p>
                <p>当月个人奖金</p>
            </div>
        </a>
    </div>

    <div class="index_btn_inner">
        <a href="" style="background-color:#fddcbe">
            <i class="icon iconfont">&#xe671;</i>
            <div class="index_btn_info">
                <p>元</p>
                <p>当日个人利润</p>
            </div>
        </a>
    </div>

    <div class="index_btn_inner">
        <a href="" style="background-color:#fce7d3">
            <i class="icon iconfont">&#xe64e;</i>
            <div class="index_btn_info">
                <p>元</p>
                <p>当月个人利润</p>
            </div>
        </a>
    </div>

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

