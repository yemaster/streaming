<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
    </section>
		<footer class="ax-footer">
		    <div class="ax-footer-bottom">
		        <div class="ax-footer-bottom__left">
    		        &copy; <?= date("Y"); ?> <a href="<?php $this->options ->siteUrl(); ?>"><?php $this->options->title() ?></a>. All Rights Reserved.<br>
    		        <?php
        			if ($this->options->icpCode || $this->options->gonganCode):
        			?>
    		        <div<?php if ($this->options->icpCode && $this->options->gonganCode) { ?> style="display: flex; justify-content: center;"<?php } ?>>
        				<?php
        				if ($this->options->icpCode):
        				?>
        				<div>
        					<a target="_blank" href="https://beian.miit.gov.cn"><?php $this->options->icpCode(); ?></a>
        				</div>
        				<?php
        				endif;
        				?>
        				<?php
        				if ($this->options->icpCode && $this->options->gonganCode):
        				?>
        				<span style="margin: 0 4px">|</span>
        				<?php
        				endif;
        				?>
        				<?php
        				if ($this->options->gonganCode):
        				?>
        				<div style="display: inline-flex; justify-content: center;">
        					<img src="https://cdn.jsdelivr.net/gh/yemaster/streaming@1.0.0/imgs/beiantubiao.png" width="20" height="20" style="margin-right:5px"> 
        					<a href="https://beian.mps.gov.cn/#/query/webSearch?code=<?php echo filter_var($this->options ->gonganCode, FILTER_SANITIZE_NUMBER_INT); ?>" rel="noreferrer" target="_blank"><?php $this->options ->gonganCode(); ?></a>
        				</div>
        				<?php
        				endif;
        				?>
        			</div>
        			<?php
        			endif;
        			?>
		        </div>
		        <div class="ax-footer-bottom__right">
    		        Powered by <a href="https://typecho.org/" target="_blank">Typecho</a><br>Theme <a href="https://github.com/yemaster/streaming" target="_blank">streaming</a> by <a href="https://github.com/yemaster" target="_blank">yemaster</a>.
		        </div>
		    </div>
		</footer>
    <script type='text/javascript' src='<?php $this->options->themeUrl('js/streaming.min.js?ver=1.0.0'); ?>'></script>
</body>
</html>
