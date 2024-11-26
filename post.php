<?php

 if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <div class="ax-main__left article">
        <div class="ax-card">
            <h2 class="ax-card-title"><?php $this->title(); ?></h2>
            <div class="ax-card-meta">
                <div><i class="icon">&#xe74a;</i><?php $this->date('Y-m-d'); ?></div>
                <div><i class="icon">&#xe636;</i><?php get_post_view($this); ?></div>
            </div>
            <div class="ax-divider"></div>
            <div class="article-main" id="article-main">
                <?php parseContent($this); ?>
            </div>
			<div class="ax-divider"></div>
            <div class="ax-tags">
                <span>分类标签：</span><?php $this->tags(' ', true, 'none'); ?>
            </div>
    	</div>
    	<div class="ax-card">
    	    <div class="ax-prev-next-container">
    			<div class="ax-prev-next-container__left">
                    <h3>上一篇</h3>
                    <?php $this->thePrev('%s', '没有了'); ?>
                </div>
                <div class="ax-prev-next-container__right">
                    <h3>下一篇</h3>
                    <?php $this->theNext('%s', '没有了'); ?>
                </div>
    	    </div>
    	</div>
    	<?php $this->need("comments.php"); ?>
    </div>
    <div class="ax-main__right">
        <div class="ax-card ax-toc-card sticky-top mobile-hidden">
            <h2 class="ax-card-title">目录</h2>
            <div id="ax-toc"></div>
        </div>
    </div>
    
	<!-- highlightjs -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/atom-one-light.min.css">
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
	<!-- katex -->
	<script src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/contrib/auto-render.min.js"></script>
	<script>
        document.addEventListener("DOMContentLoaded", function() {
            renderMathInElement(document.getElementById("article-main"), {
              // customised options
              // • auto-render specific keys, e.g.:
              delimiters: [
                  {left: '$$', right: '$$', display: true},
                  {left: '$', right: '$', display: false}
              ],
              // • rendering keys, e.g.:
              throwOnError : false
            });
        });
    </script>
    <script type='text/javascript' src='<?php $this->options->themeUrl('js/toc.min.js?ver=2.5.6'); ?>'></script>
<?php $this->need('footer.php'); ?>