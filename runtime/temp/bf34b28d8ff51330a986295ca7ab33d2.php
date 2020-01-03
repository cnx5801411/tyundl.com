<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:59:"D:\www\www.sm.cn\addons\cms\view\default\show_download.html";i:1574242084;s:59:"D:\www\www.sm.cn\addons\cms\view\default\common\layout.html";i:1574242084;s:60:"D:\www\www.sm.cn\addons\cms\view\default\common\comment.html";i:1574242084;s:60:"D:\www\www.sm.cn\addons\cms\view\default\common\sidebar.html";i:1574242084;}*/ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=""> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title><?php echo \think\Config::get("cms.title"); ?> - <?php echo \think\Config::get("cms.sitename"); ?></title>
    <meta name="keywords" content="<?php echo \think\Config::get("cms.keywords"); ?>"/>
    <meta name="description" content="<?php echo \think\Config::get("cms.description"); ?>"/>

    <link rel="stylesheet" media="screen" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" media="screen" href="/assets/libs/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" media="screen" href="/assets/libs/fastadmin-layer/dist/theme/default/layer.css"/>
    <link rel="stylesheet" media="screen" href="/assets/addons/cms/css/swiper.min.css">
    <link rel="stylesheet" media="screen" href="/assets/addons/cms/css/common.css?v=<?php echo \think\Config::get("site.version"); ?>"/>

    <link rel="stylesheet" href="//at.alicdn.com/t/font_1104524_z1zcv22ej09.css">

    {__STYLE__}

    <!--[if lt IE 9]>
    <script src="/libs/html5shiv.js"></script>
    <script src="/libs/respond.min.js"></script>
    <![endif]-->

</head>
<body class="group-page">

<header class="header">
    <!-- S 导航 -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo \think\Config::get("cms.indexurl"); ?>"><img src="/assets/addons/cms/img/logo.png" width="180" alt=""></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <!--如果你需要自定义NAV,可使用channellist标签来完成,这里只设置了2级,如果显示无限级,请使用cms:nav标签-->
                    <?php $__AFB5cql3hy__ = \addons\cms\model\Channel::getChannelList(["id"=>"nav","type"=>"top","condition"=>"1=isnav"]); if(is_array($__AFB5cql3hy__) || $__AFB5cql3hy__ instanceof \think\Collection || $__AFB5cql3hy__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__AFB5cql3hy__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?>
                    <!--判断是否有子级或高亮当前栏目-->
                    <li class="<?php if($nav['has_child']): ?>dropdown<?php endif; if($nav->is_active): ?> active<?php endif; ?>">
                        <a href="<?php echo $nav['url']; ?>" <?php if($nav['has_child']): ?> data-toggle="dropdown" <?php endif; ?>><?php echo $nav['name']; if($nav['has_child']): ?> <b class="caret"></b><?php endif; ?></a>
                        <ul class="dropdown-menu" role="menu">
                            <?php $__aYnpIwLHJc__ = \addons\cms\model\Channel::getChannelList(["id"=>"sub","type"=>"son","typeid"=>$nav['id'],"condition"=>"1=isnav"]); if(is_array($__aYnpIwLHJc__) || $__aYnpIwLHJc__ instanceof \think\Collection || $__aYnpIwLHJc__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__aYnpIwLHJc__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
                            <li><a href="<?php echo $sub['url']; ?>"><?php echo $sub['name']; ?></a></li>
                            <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__aYnpIwLHJc__; ?>
                        </ul>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__AFB5cql3hy__; ?>
                </ul>
                <ul class="nav navbar-right hidden">
                    <ul class="nav navbar-nav">
                        <li><a href="javascript:;" class="addbookbark"><i class="fa fa-star"></i> 加入收藏</a></li>
                        <li><a href="javascript:;" class=""><i class="fa fa-phone"></i> 联系我们</a></li>
                    </ul>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="form-inline navbar-form" action="<?php echo addon_url('cms/search/index'); ?>" method="get">
                            <div class="form-search hidden-sm hidden-md">
                                <input class="form-control typeahead" name="search" data-typeahead-url="<?php echo addon_url('cms/search/typeahead'); ?>" type="text" id="searchinput" placeholder="搜索">
                            </div>
                        </form>
                    </li>
                    <li class="dropdown">
                        <?php if($user): ?>
                        <a href="<?php echo url('index/user/index', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 10px;height: 50px;">
                            <span class="avatar-img"><img src="<?php echo cdnurl($user['avatar']); ?>" style="width:30px;height:30px;border-radius:50%;" alt=""></span>
                        </a>
                        <?php else: ?>
                        <a href="<?php echo url('index/user/index', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>" class="dropdown-toggle" data-toggle="dropdown">会员<span class="hidden-sm">中心</span> <b class="caret"></b></a>
                        <?php endif; ?>
                        <ul class="dropdown-menu">
                            <?php if($user): ?>
                            <li><a href="<?php echo url('index/user/index', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>"><i class="fa fa-user fa-fw"></i>会员中心</a></li>
                            <li><a href="<?php echo addon_url('cms/user/index', [':id'=>$user['id']]); ?>"><i class="fa fa-user fa-fw"></i>我的个人主页</a></li>
                            <li><a href="<?php echo url('index/cms.archives/my', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>"><i class="fa fa-list fa-fw"></i>我发布的文章</a></li>
                            <li><a href="<?php echo url('index/cms.archives/post', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>"><i class="fa fa-pencil fa-fw"></i>发布文章</a></li>
                            <li><a href="<?php echo url('index/user/logout', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>"><i class="fa fa-sign-out fa-fw"></i>注销</a></li>
                            <?php else: ?>
                            <li><a href="<?php echo url('index/user/login', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>"><i class="fa fa-sign-in fa-fw"></i>登录</a></li>
                            <li><a href="<?php echo url('index/user/register', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>"><i class="fa fa-user-o fa-fw"></i>注册</a></li>
                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- E 导航 -->

</header>


<style>

    .entry-box .media-left {
        padding-right: 20px;
    }

    .entry-box .media-content {
        margin-top: 15px;
        color: #a1a0a0;
        font-size: 14px;

    }

    .entry-box .media-extend {
        margin-top: 15px;
    }

    .entry-box .media-object {
        width: 150px;
        height: 150px;
    }

    .download-num {
        border-bottom: 1px #e5e5e5 solid;
        margin-bottom: 30px;
        padding-bottom: 30px;
        color: #444;
    }

    .download-num .num {
        padding: 10px 0;
        font-size: 36px;
        font-weight: 700;
        text-align: center;
        height: 65px;
    }

    .download-num .text {
        font-size: 18px;
        line-height: 25px;
        text-align: center;
        color: #8e8f94;
    }

    .base-info h2 {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .base-info .row {
        margin-bottom: 15px;
        font-size: 14px;
    }

    .base-info .row .col-xs-8 {
        text-align: right;
    }

    .base-info .link {
        color: #0084ff;
    }

    .screenshots-box {
        margin-top: 30px;
        position: relative;
    }

    .swiper-container .swiper-wrapper .swiper-slide {
        width: auto;
        cursor: pointer;
        height: 400px;
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        margin-right: 20px;
    }

    .swiper-container .swiper-wrapper .swiper-slide img {
        height: 100%;
        border-radius: 5px;
    }

    .screenshots-box > h2, .download-box > h2, .intro-box > h2, .history-box > h2 {
        font-size: 18px;
        color: #444;
    }
</style>

<div class="container" id="content-container">

    <div class="row">

        <main class="col-md-8">
            <div class="panel panel-default article-content">
                <div class="panel-heading">
                    <ol class="breadcrumb">
                        <!-- S 面包屑导航 -->
                        <?php $__IszJfxwLPC__ = \addons\cms\model\Channel::getBreadcrumb(isset($__CHANNEL__)?$__CHANNEL__:[], isset($__ARCHIVES__)?$__ARCHIVES__:[], isset($__TAGS__)?$__TAGS__:[], isset($__PAGE__)?$__PAGE__:[]); if(is_array($__IszJfxwLPC__) || $__IszJfxwLPC__ instanceof \think\Collection || $__IszJfxwLPC__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__IszJfxwLPC__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                        <li><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__IszJfxwLPC__; ?>
                        <!-- E 面包屑导航 -->
                    </ol>
                </div>
                <div class="panel-body">
                    <div class="entry-box mt-4">
                        <div class="media-left">
                            <div style="width:120px;height:120px;">
                                <div class="embed-responsive embed-responsive-square">
                                    <img class="embed-responsive-image" src="<?php echo cdnurl($__ARCHIVES__['image']); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="media-body">
                            <h2 class="media-heading" <?php if($__ARCHIVES__['style']): ?>style="<?php echo $__ARCHIVES__['style_text']; ?>" <?php endif; ?>><?php echo $__ARCHIVES__['title']; ?></h2>

                            <div class="media-content">
                                <?php echo $__ARCHIVES__['description']; ?>
                            </div>

                            <div class="media-extend">
                                <a href="#download" class="btn btn-primary btn-download-now"><i class="fa fa-download"></i> <?php echo $__ARCHIVES__['price']>0?'立即下载':'免费下载'; ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="screenshots-box">
                        <h2>预览截图</h2>
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?php $screenshots=explode(',', $__ARCHIVES__['screenshots']); if(is_array($screenshots) || $screenshots instanceof \think\Collection || $screenshots instanceof \think\Paginator): if( count($screenshots)==0 ) : echo "" ;else: foreach($screenshots as $key=>$item): ?>
                                <div class="swiper-slide">
                                    <img itemprop="screenshot" layer-src="<?php echo cdnurl($item); ?>" src="<?php echo cdnurl($item); ?>"/>
                                </div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>

                    <div class="intro-box">
                        <h2>应用介绍</h2>
                        <!-- S 正文 -->
                        <p>
                            <?php echo $__ARCHIVES__['content']; ?>
                        </p>
                        <!-- E 正文 -->
                    </div>

                    <div class="copyright-box alert alert-warning"><p>©软件著作权归作者所有。本站所有软件均来源于网络，仅供学习使用，请支持正版！</p>
                        <p>
                            转载请注明出处：
                            <a href="<?php echo \think\Config::get("site.indexurl"); ?>"><?php echo \think\Config::get("site.name"); ?></a> »
                            <a href="<?php echo $__ARCHIVES__['fullurl']; ?>"><?php echo $__ARCHIVES__['title']; ?></a>
                        </p>
                    </div>

                    <div class="article-donate">
                        <a href="javascript:" class="btn btn-primary btn-like btn-lg" data-action="vote" data-type="like" data-id="<?php echo $__ARCHIVES__['id']; ?>" data-tag="archives"><i class="fa fa-thumbs-up"></i> 点赞(<span><?php echo $__ARCHIVES__['likes']; ?></span>)</a>
                        <a href="javascript:" class="btn btn-outline-primary btn-donate btn-lg" data-action="donate" data-id="<?php echo $__ARCHIVES__['id']; ?>" data-image="<?php echo cdnurl($config['donateimage']); ?>"><i class="fa fa-cny"></i> 打赏</a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="panel panel-default" id="download">
                <div class="panel-heading">
                    <h3 class="panel-title">立即下载</h3>
                </div>
                <div class="panel-body">
                    <!-- S 下载按钮 -->
                    <div class="">
                        <?php if($__ARCHIVES__['price']<=0 || $__ARCHIVES__['ispaid']): if(is_array($__ARCHIVES__['downloadurl_list']) || $__ARCHIVES__['downloadurl_list'] instanceof \think\Collection || $__ARCHIVES__['downloadurl_list'] instanceof \think\Paginator): if( count($__ARCHIVES__['downloadurl_list'])==0 ) : echo "" ;else: foreach($__ARCHIVES__['downloadurl_list'] as $key=>$item): ?>
                        <a href="<?php echo $item['url']; ?>" class="btn btn-primary btn-download" target="_blank" data-url="<?php echo $item['url']; ?>" data-id="<?php echo $__ARCHIVES__['id']; ?>" data-clipboard-text="<?php echo $item['password']; ?>"><?php echo $item['title']; ?>下载</a>
                        <?php endforeach; endif; else: echo "" ;endif; else: ?>
                        <div class="alert alert-danger">
                            <strong>温馨提示!</strong> 你需要支付 <b>￥<?php echo $__ARCHIVES__['price']; ?></b> 元后才可以下载
                            <div class="mt-3">
                                <a href="<?php echo addon_url('cms/order/submit', ['id'=>$__ARCHIVES__['id']]); ?>" target="_blank" class="btn btn-success btn-paynow"><i class="fa fa-wechat"></i> 立即支付</a>
                                <a href="<?php echo addon_url('cms/order/submit', ['id'=>$__ARCHIVES__['id'],'paytype'=>'alipay']); ?>" target="_blank" class="btn btn-primary btn-paynow"><i class="fa fa-money"></i> 支付宝支付</a>
                                <a href="<?php echo addon_url('cms/order/submit', ['id'=>$__ARCHIVES__['id'],'paytype'=>'balance']); ?>" class="btn btn-warning btn-balance" data-price="<?php echo $__ARCHIVES__['price']; ?>"><i class="fa fa-dollar"></i> 余额支付</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- E 下载按钮 -->
                </div>

            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">相关下载</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled download-list">
                        <?php $__6aoT2HX5If__ = \addons\cms\model\Archives::getArchivesList(["id"=>"item","tags"=>$__ARCHIVES__['tags'],"model"=>$__ARCHIVES__['model_id'],"limit"=>"6"]); if(is_array($__6aoT2HX5If__) || $__6aoT2HX5If__ instanceof \think\Collection || $__6aoT2HX5If__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__6aoT2HX5If__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                        <li>
                            <a href="<?php echo $item['url']; ?>" class="link img-zoom">
                                <img src="<?php echo $item['image']; ?>">
                                <?php echo $item['title']; ?>
                            </a>
                            <em><?php echo $item['channel']['name']; ?></em>
                            <a href="<?php echo $item['url']; ?>" class="btn btn-primary">立即下载</a>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__6aoT2HX5If__; ?>
                    </ul>
                </div>

            </div>

            <div class="panel panel-default" id="comments">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Comment list'); ?>
                        <small>共有 <span><?php echo $__ARCHIVES__['comments']; ?></span> 条评论</small>
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="comment-container">
    <!-- S 评论列表 -->
    <div id="commentlist">
        <?php $aid = $__ARCHIVES__['id']; $__COMMENTLIST__ = \addons\cms\model\Comment::getCommentList(["id"=>"comment","type"=>"archives","aid"=>"$aid","pagesize"=>"10"]); if(is_array($__COMMENTLIST__) || $__COMMENTLIST__ instanceof \think\Collection || $__COMMENTLIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__COMMENTLIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comment): $mod = ($i % 2 );++$i;?>
        <dl id="comment-<?php echo $comment['id']; ?>">
            <dt><a href="<?php echo $comment['user']['url']; ?>" target="_blank"><img src='<?php echo $comment['user']['avatar']; ?>'/></a></dt>
            <dd>
                <div class="parent">
                    <cite><a href='<?php echo $comment['user']['url']; ?>' target="_blank"><?php echo $comment['user']['nickname']; ?></a></cite>
                    <small> <?php echo human_date($comment['createtime']); ?> <a href="javascript:;" data-id="<?php echo $comment['id']; ?>" title="@<?php echo $comment['user']['nickname']; ?> " class="reply">回复TA</a></small>
                    <p><?php echo $comment['content']; ?></p>
                </div>
            </dd>
            <div class="clearfix"></div>
        </dl>
        <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__COMMENTLIST__; if($__COMMENTLIST__->isEmpty()): ?>
        <div class="loadmore loadmore-line loadmore-nodata"><span class="loadmore-tips">暂无评论</span></div>
        <?php endif; ?>
    </div>
    <!-- E 评论列表 -->

    <!-- S 评论分页 -->
    <div id="commentpager" class="text-center">
        <?php echo $__COMMENTLIST__->render(["type"=>"full"]); ?>
    </div>
    <!-- E 评论分页 -->

    <!-- S 发表评论 -->
    <div id="postcomment">
        <h3>发表评论 <a href="javascript:;">
            <small>取消回复</small>
        </a></h3>
        <form action="<?php echo addon_url('cms/comment/post'); ?>" method="post" id="postform">
            <?php echo token(); ?>
            <input type="hidden" name="type" value="archives"/>
            <input type="hidden" name="aid" value="<?php echo $__ARCHIVES__['id']; ?>"/>
            <input type="hidden" name="pid" id="pid" value="0"/>
            <div class="form-group">
                <textarea name="content" class="form-control" <?php if(!$user): ?>disabled placeholder="请登录后再发表评论" <?php endif; ?> id="commentcontent" cols="6" rows="5" tabindex="4"></textarea>
            </div>
            <?php if(!$user): ?>
            <div class="form-group">
                <a href="<?php echo url('index/user/login', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>" class="btn btn-primary">登录</a>
                <a href="<?php echo url('index/user/register', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>" class="btn btn-outline-primary">注册新账号</a>
            </div>
            <?php else: ?>
            <div class="form-group">
                <input name="submit" type="submit" id="submit" tabindex="5" value="提交评论(Ctrl+回车)" class="btn btn-primary"/>
                <span id="actiontips"></span>
            </div>
            <div class="checkbox">
                <label>
                    <input name="subscribe" type="checkbox" class="checkbox" tabindex="7" checked value="1"/> 有人回复时邮件通知我
                </label>
            </div>
            <?php endif; ?>
        </form>
    </div>
    <!-- E 发表评论 -->
</div>
                </div>
            </div>

        </main>

        <aside class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="download-num counter-box">
                        <div class="num counter number-count" data-from="0" data-to="<?php echo $__ARCHIVES__['downloads']; ?>" data-speed="2000" data-refresh-interval="50"><?php echo number_format($__ARCHIVES__['downloads']); ?></div>
                        <div class="text">下载次数</div>
                    </div>

                    <div class="entry-meta">
                        <div class="base-info"><h2>信息</h2>
                            <div class="row">
                                <div class="col-xs-4">类别</div>
                                <div class="col-xs-8">
                                    <a href="<?php echo $__CHANNEL__['url']; ?>" class="link" itemprop="category"><?php echo $__CHANNEL__['name']; ?></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">兼容性</div>
                                <div class="col-xs-8">
                                    <span itemprop="operatingSystem"><?php echo $__ARCHIVES__['os_text']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">最新版本</div>
                                <div class="col-xs-8"><span itemprop="softwareVersion"><?php echo $__ARCHIVES__['version']; ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">文件大小</div>
                                <div class="col-xs-8"><span itemprop="fileSize"><?php echo $__ARCHIVES__['filesize']; ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">更新日期</div>
                                <div class="col-xs-8"><span itemprop="datePublished"><?php echo date('Y-m-d',$__ARCHIVES__['publishtime']); ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">语言</div>
                                <div class="col-xs-8"><span itemprop="operatingSystem"><?php echo $__ARCHIVES__['language_text']; ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">浏览次数</div>
                                <div class="col-xs-8"><span itemprop="views"><?php echo $__ARCHIVES__['views']; ?></span> 次浏览</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">标签</div>
                                <div class="col-xs-8">
                                    <?php if(is_array($__ARCHIVES__['tagslist']) || $__ARCHIVES__['tagslist'] instanceof \think\Collection || $__ARCHIVES__['tagslist'] instanceof \think\Paginator): $i = 0; $__LIST__ = $__ARCHIVES__['tagslist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><a href="<?php echo $tag['url']; ?>" itemprop="keywords" class="tag" rel="tag"><?php echo $tag['name']; ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($config['userpage']): ?>
            <!-- S 关于作者 -->
            <div class="panel panel-default about-author" data-id="<?php echo $__ARCHIVES__['user']['id']; ?>" itemProp="author" itemscope="" itemType="http://schema.org/Person">
                <meta itemProp="name" content="<?php echo $__ARCHIVES__['user']['nickname']; ?>"/>
                <meta itemProp="image" content="<?php echo cdnurl($__ARCHIVES__['user']['avatar']); ?>"/>
                <meta itemProp="url" content="<?php echo $__ARCHIVES__['user']['url']; ?>"/>
                <div class="panel-heading">
                    <h3 class="panel-title">关于作者</h3>
                </div>
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="<?php echo $__ARCHIVES__['user']['url']; ?>">
                                <img class="media-object img-circle img-medium" style="width:64px;height:64px;" src="<?php echo cdnurl($__ARCHIVES__['user']['avatar']); ?>"
                                     data-holder-rendered="true">
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 style="margin-top:10px;" class="media-heading">
                                <a href="<?php echo $__ARCHIVES__['user']['url']; ?>"><?php echo $__ARCHIVES__['user']['nickname']; ?></a>
                            </h3>
                            <?php echo (isset($__ARCHIVES__['user']['bio']) && ($__ARCHIVES__['user']['bio'] !== '')?$__ARCHIVES__['user']['bio']:"这家伙很懒，什么也没写！"); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- E 关于作者 -->
            <?php endif; ?>
            
<div class="panel panel-blockimg">
    <a href="https://www.fastadmin.net/store/ask.html">
    <img src="https://cdn.fastadmin.net/assets/addons/ask/img/sidebar/howto.png" class="img-responsive">
</a>
</div>

<!-- S 热门资讯 -->
<div class="panel panel-default hot-article">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo __('Recommend news'); ?></h3>
    </div>
    <div class="panel-body">
        <?php $__UpXMPxSlKR__ = \addons\cms\model\Archives::getArchivesList(["id"=>"item","model"=>1,"row"=>"10","flag"=>"recommend","orderby"=>"id","orderway"=>"asc"]); if(is_array($__UpXMPxSlKR__) || $__UpXMPxSlKR__ instanceof \think\Collection || $__UpXMPxSlKR__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__UpXMPxSlKR__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <div class="media media-number">
            <div class="media-left">
                <span class="num"><?php echo $i; ?></span>
            </div>
            <div class="media-body">
                <a class="link-dark" href="<?php echo $item['url']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__UpXMPxSlKR__; ?>
    </div>
</div>
<!-- E 热门资讯 -->

<div class="panel panel-blockimg">
    <a href="https://www.fastadmin.net/go/aliyun" rel="nofollow" title="FastAdmin推荐企业服务器" target="_blank">
        <img src="https://cdn.fastadmin.net/uploads/store/aliyun-sidebar.png" class="img-responsive" alt="">
</a>
</div>

<!-- S 热门标签 -->
<div class="panel panel-default hot-tags">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo __('Hot tags'); ?></h3>
    </div>
    <div class="panel-body">
        <div class="tags">
            <?php $__jcHBx6DV8l__ = \addons\cms\model\Tags::getTagsList(["id"=>"tag","orderby"=>"rand","limit"=>"30"]); if(is_array($__jcHBx6DV8l__) || $__jcHBx6DV8l__ instanceof \think\Collection || $__jcHBx6DV8l__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__jcHBx6DV8l__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?>
            <a href="<?php echo $tag['url']; ?>" class="tag"> <span><?php echo $tag['name']; ?></span></a>
            <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__jcHBx6DV8l__; ?>
        </div>
    </div>
</div>
<!-- E 热门标签 -->

<!-- S 推荐下载 -->
<div class="panel panel-default recommend-article">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo __('Recommend download'); ?></h3>
    </div>
    <div class="panel-body">
        <?php $__CATfZDHSM0__ = \addons\cms\model\Archives::getArchivesList(["id"=>"item","model"=>3,"row"=>"10","flag"=>"recommend","orderby"=>"id","orderway"=>"asc","addon"=>"downloads"]); if(is_array($__CATfZDHSM0__) || $__CATfZDHSM0__ instanceof \think\Collection || $__CATfZDHSM0__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__CATfZDHSM0__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <div class="media media-number">
            <div class="media-left">
                <span class="num"><?php echo $i; ?></span>
            </div>
            <div class="media-body">
                <a href="<?php echo $item['url']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__CATfZDHSM0__; ?>
    </div>
</div>
<!-- E 推荐下载 -->

<div class="panel panel-blockimg">
    <a href="http://www.fastadmin.net/go/aliyun"><img src="https://cdn.fastadmin.net/uploads/store/enterprisehost.png" class="img-responsive"/></a>
</div>
        </aside>
    </div>
</div>
<script type="text/html" id="downloadtpl">
    <div class="p-4" style="min-width:300px;">
        <div class="p-2 mb-4 text-center" style="background:#eee;border-radius:5px;">
            <h4>提取码 <span class="text-danger"><%=code%></span> 已复制</h4>
        </div>
        <p><a href="<%=url%>" target="_blank" data-id="<?php echo $__ARCHIVES__['id']; ?>" class="btn btn-block btn-primary btn-download btn-lg">前往下载</a></p>
    </div>
</script>
<script data-render="script" src="/assets/addons/cms/js/clipboard.min.js"></script>
<script data-render="script">
    $(function () {

        //格式化数字
        var number_format = function (text) {
            return text.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        };

        //动画数字
        $('.number-count').each(function () {
            var $this = $(this);
            $({from: 0, to: $this.data("to"), elem: $this}).animate({from: $this.data("to")}, {
                duration: 1000,
                easing: 'swing',
                step: function () {
                    $this.text(number_format(Math.ceil(this.from)));
                },
                complete: function () {
                    if (number_format(this.to) != this.elem.text()) {
                        this.elem.text(number_format(this.to));
                    }
                }
            });
        });

        //立即下载
        $(document).on('click', '.btn-download-now', function () {
            $('html,body').animate({
                scrollTop: $("#download").offset().top - 60
            }, 700);
            return false;
        });

        //点击复制
        var clipboard = new ClipboardJS('.btn-download');
        clipboard.on('success', function (e) {
            layer.open({
                title: '',
                content: template("downloadtpl", {code: e.text, url: $(e.trigger).data("url")}),
                btn: false
            });
            e.clearSelection();
        });

        //下载统计
        $(document).on('click', '.btn-download', function () {
            var id = $(this).data("id");
            if ($(this).data("clipboard-text")) {
                return false;
            }
            if (!CMS.api.storage("download." + id)) {
                CMS.api.ajax({
                    url: "<?php echo addon_url('cms/archives/download'); ?>",
                    data: {id: $(this).data("id")}
                }, function () {
                    CMS.api.storage("download." + id, true);
                    return false;
                }, function () {
                    return false;
                });
            }
        });

        //预览图片
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 'auto', height: 300,
            navigation: {
                nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev',
            }, on: {
                slideNextTransitionEnd: function () {
                    if (swiper.progress == 1) {
                        swiper.activeIndex = swiper.slides.length - 1;
                    }
                }
            }
        });
        layer.photos({
            photos: '.screenshots-box'
            , anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
    });
</script>

<footer>
    <div class="container-fluid" id="footer">
        <div class="container">
            <div class="row footer-inner">
                <div class="col-md-3 col-sm-3">
                            <div class="footer-logo">
                                <a href="#"><i class="fa fa-bookmark"></i></a>
                            </div>
                            <p class="copyright"><small>© 2017. All Rights Reserved. <br>
                                    FastAdmin
                                </small>
                            </p>
                        </div>
                        <div class="col-md-5 col-md-push-1 col-sm-5 col-sm-push-1">
                            <div class="row">
                                <div class="col-xs-4">
                                    <ul class="links">
                                        <li><a href="#">关于我们</a></li>
                                        <li><a href="#">发展历程</a></li>
                                        <li><a href="#">服务项目</a></li>
                                        <li><a href="#">团队成员</a></li>
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <ul class="links">
                                        <li><a href="#">新闻</a></li>
                                        <li><a href="#">资讯</a></li>
                                        <li><a href="#">推荐</a></li>
                                        <li><a href="#">博客</a></li>
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <ul class="links">
                                        <li><a href="#">服务</a></li>
                                        <li><a href="#">圈子</a></li>
                                        <li><a href="#">论坛</a></li>
                                        <li><a href="#">广告</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-md-push-1 col-sm-push-1">
                            <div class="footer-social">
                                <a href="#"><i class="fa fa-weibo"></i></a>
                                <a href="#"><i class="fa fa-qq"></i></a>
                                <a href="#"><i class="fa fa-wechat"></i></a>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</footer>

<div id="floatbtn">
    <!-- S 浮动按钮 -->

    <?php if(isset($config['wxapp'])&&$config['wxapp']): ?>
    <a href="javascript:;">
        <i class="iconfont icon-wxapp"></i>
        <div class="floatbtn-wrapper">
            <div class="qrcode"><img src="<?php echo cdnurl($config['wxapp']); ?>"></div>
            <p>微信小程序</p>
            <p>微信扫一扫体验</p>
        </div>
    </a>
    <?php endif; ?>

    <a class="hover" href="<?php echo url('index/cms.archives/post', '', false, \think\Config::get('url_domain_deploy')?'www':''); ?>" target="_blank">
        <i class="iconfont icon-pencil"></i>
        <em>立即<br>投稿</em>
    </a>

    <?php if($config['qrcode']): ?>
    <a href="javascript:;">
        <i class="iconfont icon-qrcode"></i>
        <div class="floatbtn-wrapper">
            <div class="qrcode"><img src="<?php echo cdnurl($config['qrcode']); ?>"></div>
            <p>微信公众账号</p>
            <p>微信扫一扫加关注</p>
        </div>
    </a>
    <?php endif; if(isset($__ARCHIVES__)): ?>
    <a id="feedback" class="hover" href="#comments">
        <i class="iconfont icon-feedback"></i>
        <em>发表<br>评论</em>
    </a>
    <?php endif; ?>

    <a id="back-to-top" class="hover" href="javascript:;">
        <i class="iconfont icon-backtotop"></i>
        <em>返回<br>顶部</em>
    </a>
    <!-- E 浮动按钮 -->
</div>


<script type="text/javascript" src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/libs/fastadmin-layer/dist/layer.js"></script>
<script type="text/javascript" src="/assets/libs/art-template/dist/template-native.js"></script>
<script type="text/javascript" src="/assets/addons/cms/js/bootstrap-typeahead.min.js"></script>
<script type="text/javascript" src="/assets/addons/cms/js/swiper.min.js"></script>
<script type="text/javascript" src="/assets/addons/cms/js/cms.js?r=<?php echo $site['version']; ?>"></script>
<script type="text/javascript" src="/assets/addons/cms/js/common.js?r=<?php echo $site['version']; ?>"></script>

{__SCRIPT__}

</body>
</html>