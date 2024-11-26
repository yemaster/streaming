<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
    <div class="article-list ax-main__left">
        <div class="ax-card">
            <div class="ax-card-body">
        		<?php if($this->is('index')): ?>
        		<?php else: ?>
        			<h2 class="ax-post-header-title">
            			<a href="<?php $this->options->siteUrl(); ?>">主页</a> &raquo;
            			<?php $this->archiveTitle(array(
            		        'category'  =>  _t('分类 : %s'),
            		        'search'    =>  _t('搜索 : %s'),
            		        'tag'       =>  _t('标签 : %s'),
            		        'author'    =>  _t('作者 : %s'),
            		        'date'      =>  _t('日期 : %s')
            		    ), '', ''); ?>
        		    </h2>
        		<?php endif; ?>
            </div>
            <?php if($this->have()):?>
	    	<?php while($this->next()): ?>
                <div class="ax-card-body">
                    <h2 class="ax-card-title"><a href="<?php $this->permalink(); ?>"><?php $this->sticky(); $this->title(); ?></a></h2>
                    <div class="ax-card-detail">
                        <?php $this->excerpt(140, '...'); ?>
                    </div>
                    <div class="ax-card-meta">
                        <div><i class="icon">&#xe74a;</i><?php $this->date('Y-m-d'); ?></div>
                        <div><i class="icon">&#xe636;</i><?php get_post_view($this); ?></div>
                        <div><i class="icon">&#xe600;</i><?php $this->category(','); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
    	    <?php else: ?>
    	    <div class="ax-card-body">
    	    	<h1 class="ax-card-title">暂无文章</h1>
    	    </div>
    	    <?php endif; ?>
    	    <div class="ax-card-body">
                <?php $this->pageNav('<', '>', 3, '', array('wrapTag' => 'div', 'wrapClass' => 'ax-pagination', 'itemTag' => 'div', 'itemClass' => 'ax-pagination-item', 'textTag' => '', 'currentClass' => 'active', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
    	    </div>
        </div>
    </div>
    <div class="ax-main__right">
        <?php $this->need('sidebar.php'); ?>
    </div>
<?php $this->need('footer.php'); ?>
