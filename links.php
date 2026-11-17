<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<?php $friendLinks = get_friend_links(); ?>

    <div class="ax-main__left article">
        <div class="ax-card">
            <h2 class="ax-card-title">友情链接</h2>
            <div class="ax-divider"></div>
            <?php if (!empty($friendLinks)): ?>
            <div class="ax-friend-list">
                <?php foreach ($friendLinks as $item): ?>
                <?php
                    $name = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
                    $desc = htmlspecialchars($item['desc'], ENT_QUOTES, 'UTF-8');
                    $avatar = htmlspecialchars($item['avatar'], ENT_QUOTES, 'UTF-8');
                    $bgRaw = str_replace(array("'", '"', '(', ')', '\\', "\r", "\n"), array('%27', '%22', '%28', '%29', '%5C', '', ''), $item['bg']);
                    $bg = htmlspecialchars($bgRaw, ENT_QUOTES, 'UTF-8');
                    $url = htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8');
                    $tag = $url !== '' ? 'a' : 'div';
                ?>
                <<?php echo $tag; ?> class="ax-friend-card"<?php if ($url !== ''): ?> href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                    <?php if ($bg !== ''): ?>
                    <div class="ax-friend-card__bg" style="background-image: url('<?php echo $bg; ?>');"></div>
                    <div class="ax-friend-card__mask"></div>
                    <?php endif; ?>
                    <div class="ax-friend-card__avatar-wrap">
                        <?php if ($avatar !== ''): ?>
                        <img class="ax-friend-card__avatar" src="<?php echo $avatar; ?>" alt="<?php echo $name; ?>" loading="lazy" onerror="this.style.display='none'">
                        <?php endif; ?>
                    </div>
                    <div class="ax-friend-card__info">
                        <div class="ax-friend-card__name"><?php echo $name; ?></div>
                        <?php if ($desc !== ''): ?>
                        <div class="ax-friend-card__desc" title="<?php echo $desc; ?>"><?php echo $desc; ?></div>
                        <?php endif; ?>
                    </div>
                </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="ax-card-detail">暂无友情链接</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="ax-main__right">
        <?php $this->need('sidebar.php'); ?>
    </div>

<?php $this->need('footer.php'); ?>
