<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <div class="ax-main__left article">
        <div class="ax-card">
            <h2 class="ax-card-title"><?php $this->title(); ?></h2>
            <div class="ax-divider"></div>
            <div class="article-main" id="article-main">
                <?php parseContent($this); ?>
            </div>
    	</div>
    </div>
    <div class="ax-main__right">
        <?php $this->need('sidebar.php'); ?>
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
<?php $this->need('footer.php'); ?>
