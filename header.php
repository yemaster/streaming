<?php if(!defined( '__TYPECHO_ROOT_DIR__'))exit;?>
<!DOCTYPE HTML>
<html class="no-js" lang="zh-Hans">
	<head>
		<meta charset="<?php $this->options->charset(); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-Control" content="no-transform" />  
        <meta http-equiv="Cache-Control" content="no-siteapp" />  
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title><?php $this->archiveTitle(array('category'=>_t(' %s '),'search'=>_t(' %s '),'tag'=>_t(' %s '),'author'=>_t(' %s ')),'',' - ');?> <?php $this->options->title();?></title>
		<meta name="keywords" content="<?php $this->keywords() ?>" />
		<?php $this->header('keywords=&generator=&template=&pingback=&xmlrpc=&wlw=&commentReply=&rss1=&rss2=&atom='); ?>
		<link rel="shortcut icon" href="/favicon.png">
		<link rel='stylesheet' id='streaming-main-css' href='<?php $this->options->themeUrl('css/streaming.min.css?ver=1.0.0'); ?>' type='text/css' media='all' />
	</head>
	<?php flush(); ?>
	<body data-spy="scroll" data-target=".scrollspy">
	    <header class="ax-header-menu">
	        <div class="ax-navbar">
				<div class="ax-navbar__left">
				    <div class="ax-navbar-item logo">
				        <a class="ax-navbar-item__link" href="<?php $this->options ->siteUrl(); ?>"><?php $this->options->title() ?></a>
				    </div>
				    <div class="ax-navbar-item">
				        <a class="<?php if($this->is('index')): ?>ax-navbar-item__link-active <?php endif; ?>ax-navbar-item__link" href="<?php $this->options ->siteUrl(); ?>">首页</a>
				    </div>
    				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
    				<?php while($pages->next()): ?>
    				    <div class="ax-navbar-item">
    				        <a class="<?php if($this->is('page', $pages->slug)): ?>ax-navbar-item__link-active <?php endif; ?>ax-navbar-item__link" href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
    				    </div>
    				<?php endwhile; ?>
				</div>
				<div class="ax-navbar__right">
                    <div class="ax-navbar-item ax-menu-bar">
                        <a class="ax-navbar-item__link" href="javascript:;">
                            <i class="icon">&#xe601;</i>
                        </a>
                        <div class="ax-navbar-dropdown-container">
                            <a class="ax-navbar-dropdown__item" href="<?php $this->options ->siteUrl(); ?>">
                                首页
                            </a>
            				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            				<?php while($pages->next()): ?>
            				    <a class="ax-navbar-dropdown__item" href="<?php $pages->permalink(); ?>">
            				        <?php $pages->title(); ?>
            				    </a>
            				<?php endwhile; ?>
                        </div>
                    </div>
				</div>
	        </div>
	    </header>
	    <section class="ax-banner" style="background-image: url(<?php $this->options->bannerImg(); ?>)">
	        <div class="ax-banner__text"><?php $this->options->title() ?></div>
	    </section>
	    <section class="ax-main">