<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
function threadedComments($comments, $options) {
    $commentClass = 'commentlist';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';

    if ($comments->url) {
        $author = '<a href="' . $comments->url . '" target="_blank"' . ' rel="external nofollow">' . $comments->author . '</a>';
    } else {
        $author = $comments->author;
    }
?>

<div id="<?php $comments->theId(); ?>" class="ax-comment depth-<?php echo $comments->levels+1; ?><?php
if ($comments->levels > 0) {
    echo '';
    $comments->levelsAlt(' thread-odd', ' thread-even');
} else {
    echo ' parent';
} 
$comments->alt(' odd', ' even');
?>">
	<?php
        /*$host = 'https://secure.gravatar.com';
        $url = '/avatar/';
        $size = '50';
        $rating = Helper::options()->commentsAvatarRating;
        $hash = md5(strtolower($comments->mail));
        $avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=';*/
        $avatar = "https://cdn.jsdelivr.net/gh/yemaster/streaming@1.0.0/imgs/imglogo.jpg";
    ?>
	<div class="ax-comment-header">
	    <img class="ax-comment-avatar" src="<?php echo $avatar ?>">
	    <div class="ax-comment-info">
    	    <div class="ax-comment-author"><?php echo $comments->author; ?></div>
    	    <div class="ax-comment-meta">发布于 <?php $comments->date('Y-m-d'); ?> | <a class="comment-reply-link" href="<?php echo substr($comments->permalink, 0, - strlen($comments->theId) - 1) . '?replyTo=' . $comments->coid .'#' . $comments->parameter->respondId . '" rel="nofollow" onclick="return TypechoComment.reply(\'' .$comments->theId . '\', ' . $comments->coid . ');'?>">回复</a> </div>
	    </div>
	</div>
	<div id="<?php $comments->theId(); ?>" class="ax-comment-body">
		<?php $comments->content(); ?>
	</div>
	<?php if ($comments->children) { ?>
		<div class="ax-comment-children">
			<?php $comments->threadedComments($options); ?>
		</div>
	<?php } ?>
</div><!-- #comment -->
<?php } ?>


<?php $this->comments()->to($comments); ?>
<div class="ax-card">
    <div class="ax-card-title-small">Comments</div>
    <div class="ax-divider"></div>
    <div id="comments" class="comments-area">
    <?php if ($comments->have()) : ?>
    	<?php $comments->listComments(array('before' =>  '','after'  =>  '')); ?>
    	<div id="ax-comments-pagination" style="margin-top: .5rem">
    		<?php $comments->pageNav('<', '>', 3, '', array('wrapTag' => 'div', 'wrapClass' => 'ax-pagination', 'itemTag' => 'div', 'itemClass' => 'ax-pagination-item', 'textTag' => '', 'currentClass' => 'active', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
    	</div>
    <?php endif; ?>
</div>
<div id="<?php $this->respondId(); ?>" class="comment-respond">
<?php if($this->allow('comment')): ?>
	<h4 id="reply-title" class="ax-comment-reply-title">发表评论 <small><?php $comments->cancelReply('取消回复'); ?></small></h4>
	<form action="<?php $this->commentUrl() ?>" method="post" id="commentform" class="comment-form">
		<p class="ax-comment-notes">
		    <?php if($this->user->hasLogin()): ?>
		    欢迎回来，<?php $this->user->screenName(); ?>。
		    <?php else: ?>
		    电子邮件地址不会被公开。必填项已用 * 标注
		    <?php endif; ?>
		</p>
		<div class="comment form-group has-feedback">
		    <div class="ax-comment-input-group">
		        <textarea class="ax-comment-input" id="comment" placeholder=" " name="text" rows="5" aria-required="true" required="" onkeydown="if(event.ctrlKey){if(event.keyCode==13){document.getElementById('submit').click();return false}};"></textarea>
		    </div>
		</div>
		<?php if(!$this->user->hasLogin()): ?>
		<div class="comment-form-author form-group has-feedback">
		    <div class="ax-comment-input-group">
		        <label for="author">昵称 (*)</label>
		        <input class="ax-comment-input" placeholder="昵称" id="author" name="author" type="text" value="" size="30">
		    </div>
		</div>
		<div class="comment-form-email form-group has-feedback">
		    <div class="ax-comment-input-group">
		        <label for="mail">邮箱 (*)</label>
		        <input class="ax-comment-input" placeholder="邮箱" id="mail" name="mail" type="text" value="" size="30">
		    </div>
		</div>
		<div class="comment-form-url form-group has-feedback">
		    <div class="ax-comment-input-group">
		        <label for="url">网站 (*)</label>
		        <input class="ax-comment-input" placeholder="网站" id="url" name="url" type="text" value="" size="30">
		    </div>
		</div>
		<?php endif; ?>
		<p class="form-submit">
		    <input name="submit" type="submit" id="submit" class="ax-comment-send-button" value="发表评论"><?php $security = $this->widget('Widget_Security'); ?>
		    <input type="hidden" name="_" value="<?php echo $security->getToken($this->request->getReferer())?>">
		</p>
	</form>
<?php endif; ?>
</div>
</div>
