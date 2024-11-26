<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/* 后台设置 */
function themeConfig($form) {
	//header部分
    $authorImg = new Typecho_Widget_Helper_Form_Element_Text('authorImg', NULL, 'https://cdn.jsdelivr.net/gh/yemaster/streaming@1.0.0/imgs/imglogo.jpg', _t('作者简介头像'), _t('留空了就加载不出来啦'));
	$form->addInput($authorImg);
	
	//header部分
    $bannerImg = new Typecho_Widget_Helper_Form_Element_Text('bannerImg', NULL, NULL, _t('Banner图片'), _t('不写不加载'));
	$form->addInput($bannerImg);
	
	//底部部分
    $icpCode = new Typecho_Widget_Helper_Form_Element_Text('icpCode', NULL, NULL, _t('ICP备案号'), _t('示例：浙ICP备xxxxxx号-x'));
	$form->addInput($icpCode);
	
    $gonganCode = new Typecho_Widget_Helper_Form_Element_Text('gonganCode', NULL, NULL, _t('公安备案号'), _t('示例：浙公网安备xxxxxxxx'));
	$form->addInput($gonganCode);
	
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock',
        array(
            'ShowAuthor' => _t('显示作者信息'),
            'ShowSearch' => _t('显示搜索'),
            'ShowCategory' => _t('显示分类'),
            'ShowAd' => _t('显示自定义链接'),
        ),
        array(
            'ShowAuthor',
            'ShowSearch',
            'ShowCategory',
            'ShowAd'
        ), _t('侧边栏显示')
    );  
    $form->addInput($sidebarBlock->multiMode());
	
	$adSidebar = new Typecho_Widget_Helper_Form_Element_Textarea('adSidebar', NULL, NULL, _t('侧边栏自定义链接'), _t('自定义链接代码，支持html'));
    $form->addInput($adSidebar);
}



/**
 * 解析内容以实现附件加速
 * @access public
 * @param string $content 文章正文
 * @param Widget_Abstract_Contents $obj
 */
function parseContent($obj) {
    $options = Typecho_Widget::widget('Widget_Options');
    if (!empty($options->src_add) && !empty($options->cdn_add)) {
        $obj->content = str_ireplace($options->src_add, $options->cdn_add, $obj->content);
    }
    echo trim($obj->content);
}


/*文章阅读次数统计*/
function get_post_view($archive) {
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
            
        }
    }
    echo $row['views'];
}


/*Typecho 24小时发布文章数量*/
function get_recent_posts_number($days = 1,$display = true)
{
$db = Typecho_Db::get();
$today = time() + 3600 * 8;
$daysago = $today - ($days * 24 * 60 * 60);
$total_posts = $db->fetchObject($db->select(array('COUNT(cid)' => 'num'))
->from('table.contents')
->orWhere('created < ? AND created > ?', $today,$daysago)
->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish'))->num;
if($display) {
echo $total_posts;
} else {
return $total_posts;
}
}

//随机文章
function theme_random_posts(){
$defaults = array(
'number' => 6,
'before' => '',
'after' => '',
'xformat' => '<a class="list-group-item visible-lg" title="{title}" href="{permalink}" rel="bookmark"><i class="fa  fa-book"></i> {title}</a> 
	<a class="list-group-item visible-md" title="{title}" href="{permalink}" rel="bookmark"><i class="fa  fa-book"></i> {title}</a>'
);
$db = Typecho_Db::get();
 
$sql = $db->select()->from('table.contents')
->where('status = ?','publish')
->where('type = ?', 'post')
->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
->limit($defaults['number'])
->order('RAND()');
 
$result = $db->fetchAll($sql);
echo $defaults['before'];
foreach($result as $val){
$val = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($val);
echo str_replace(array('{permalink}', '{title}'),array($val['permalink'], $val['title']), $defaults['xformat']);
}
echo $defaults['after'];
}

?>
