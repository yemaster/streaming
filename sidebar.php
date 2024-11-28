<?php
if (is_array($this->options->sidebarBlock) && in_array('ShowAuthor', $this->options->sidebarBlock)):
?>
<div class="ax-card t-center">
    <div style="max-width: 80%; margin: 0 auto;">
        <img src="<?php $this->options->authorImg(); ?>" width="96" height="96" style="border-radius: 50%" alt="作者头像">
        <h2 class="ax-card-title"><?php $this->options->title() ?></h2>
        <div class="ax-card-detail" id="blog-description"><?php $this->options->description() ?></div>
    </div>
</div>
<?php 
if ($this->options->hitokotoDescription == 'enable'):
?>
<script>
fetch('https://v1.hitokoto.cn')
    .then(response => response.json())
    .then(data => {
      const hitokoto = document.querySelector('#blog-description')
      hitokoto.innerText = data.hitokoto
    })
    .catch(console.error)
</script>
<?php endif; ?>
<?php
endif;
?>

<div class="sticky-top">
    <?php
    if (is_array($this->options->sidebarBlock) && in_array('ShowSearch', $this->options->sidebarBlock)):
    ?>
    <div class="ax-card">
        <h2 class="ax-card-title-small">搜索</h2>
        <form role="search" method="get" action="<?php $this->options ->siteUrl(); ?>"><input type="text" name="s" id="s" placeholder="输入关键字，回车搜索" class="ax-search-box" x-webkit-speech=""></form>
    </div>
    <?php
    endif;
    ?>
    
    <?php
    if (is_array($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)):
    ?>
    <div class="ax-card" style="margin-top: 2rem">
        <h2 class="ax-card-title-small">分类目录</h2>
        <div class="ax-tag-list"><?php $this->widget('Widget_Metas_Category_List')->to($cats);?><?php while ($cats->next()): ?>
    	   <a class="ax-tag-item" href="<?php $cats->permalink()?>"><?php $cats->name()?> <?php $cats->count()?></a><?php endwhile; ?>
    	</div>
    </div>
    <?php
    endif;
    ?>
    
    <?php
    if (is_array($this->options->sidebarBlock) && in_array('ShowAd', $this->options->sidebarBlock)):
    ?>
    <div class="ax-card" style="margin-top: 2rem">
        <h2 class="ax-card-title-small">Links</h2>
        <div class="ax-link-list ax-link-list-bordered">
            <?php $this->options->adSidebar(); ?>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>