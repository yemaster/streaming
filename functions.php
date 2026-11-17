<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/* 后台设置 */
function themeConfig($form) {
	//header部分
    $authorImg = new Typecho_Widget_Helper_Form_Element_Text('authorImg', NULL, 'https://assets.yemaster.cn/imgs/imglogo.jpg', _t('作者简介头像'), _t('留空了就加载不出来啦'));
	$form->addInput($authorImg);
	
	//header部分
    $bannerImg = new Typecho_Widget_Helper_Form_Element_Text('bannerImg', NULL, NULL, _t('Banner图片'), _t('不写不加载'));
	$form->addInput($bannerImg);
	
	//底部部分
    $icpCode = new Typecho_Widget_Helper_Form_Element_Text('icpCode', NULL, NULL, _t('ICP备案号'), _t('示例：浙ICP备xxxxxx号-x'));
	$form->addInput($icpCode);
	
    $gonganCode = new Typecho_Widget_Helper_Form_Element_Text('gonganCode', NULL, NULL, _t('公安备案号'), _t('示例：浙公网安备xxxxxxxx'));
	$form->addInput($gonganCode);

    $hitokotoDescription = new Typecho_Widget_Helper_Form_Element_Radio('hitokotoDescription', array(
        'enable' => '启用',
        'disable' => '不启用'
    ), 'disable', _t('博客作者介绍启用一言 Hitokoto'));
    $form->addInput($hitokotoDescription);
	
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock',
        array(
            'ShowAuthor' => _t('显示作者信息'),
            'ShowSearch' => _t('显示搜索'),
            'ShowCategory' => _t('显示分类'),
        ),
        array(
            'ShowAuthor',
            'ShowSearch',
            'ShowCategory',
        ), _t('侧边栏显示')
    );  
    $form->addInput($sidebarBlock->multiMode());

    $enableLinks = new Typecho_Widget_Helper_Form_Element_Radio('enableLinks', array(
        'enable' => '启用',
        'disable' => '不启用'
    ), 'disable', _t('启用友情链接'));
    $form->addInput($enableLinks);

    $friendLinksHtml = <<<'HTML'
<style>
.streaming-links-editor {
    margin-top: 6px;
}
.streaming-links-item {
    background: #fff;
    border: 1px solid #d9d9d6;
    border-radius: 3px;
    padding: 10px 12px;
    margin-bottom: 10px;
}
.streaming-links-item__head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    padding-bottom: 6px;
    border-bottom: 1px solid #f0f0ec;
}
.streaming-links-item__index {
    font-size: 12px;
    font-weight: 600;
    color: #444;
}
.streaming-links-item__actions {
    display: flex;
    gap: 4px;
}
.streaming-links-item__actions button {
    padding: 2px 8px;
    font-size: 12px;
    line-height: 1.4;
    cursor: pointer;
    border: 1px solid #d9d9d6;
    background: #f6f6f3;
    color: #444;
    border-radius: 2px;
}
.streaming-links-item__actions button:hover {
    background: #ecece7;
}
.streaming-links-item__actions button.danger {
    color: #b94a48;
}
.streaming-links-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 12px;
}
.streaming-links-field.full {
    grid-column: 1 / -1;
}
.streaming-links-field label {
    display: block;
    font-size: 12px;
    color: #666;
    margin-bottom: 3px;
    font-weight: normal;
}
.streaming-links-field input {
    width: 100%;
    box-sizing: border-box;
    padding: 5px 8px;
    font-size: 13px;
    border: 1px solid #d9d9d6;
    border-radius: 2px;
    background: #fff;
}
.streaming-links-add {
    cursor: pointer;
}
@media (max-width: 640px) {
    .streaming-links-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<script>
(function() {
    var script = document.currentScript;
    if (!script) return;
    var li = script.parentNode;
    while (li && li.tagName !== 'LI') {
        li = li.parentNode;
    }
    if (!li) return;
    var textarea = li.querySelector('textarea[name="friendLinks"]');
    if (!textarea) return;

    var raw = textarea.value.trim();
    var items = [];
    if (raw !== '') {
        try {
            var parsed = JSON.parse(raw);
            if (!Array.isArray(parsed)) return;
            items = parsed;
        } catch (e) {
            return;
        }
    }

    var desc = script.parentNode;
    if (desc && desc.tagName === 'P') {
        desc.style.display = 'none';
    }
    textarea.style.display = 'none';

    var editor = document.createElement('div');
    editor.className = 'streaming-links-editor';
    textarea.parentNode.insertBefore(editor, textarea.nextSibling);

    var listEl = document.createElement('div');
    editor.appendChild(listEl);

    var addBtn = document.createElement('button');
    addBtn.type = 'button';
    addBtn.className = 'btn btn-s primary streaming-links-add';
    addBtn.textContent = '添加项目';
    editor.appendChild(addBtn);

    function sync() {
        textarea.value = JSON.stringify(items);
    }

    function createField(labelText, placeholder, value, full, onInput) {
        var wrap = document.createElement('div');
        wrap.className = 'streaming-links-field' + (full ? ' full' : '');
        var label = document.createElement('label');
        label.textContent = labelText;
        var input = document.createElement('input');
        input.type = 'text';
        input.placeholder = placeholder;
        input.value = value || '';
        input.addEventListener('input', function() {
            onInput(input.value);
            sync();
        });
        wrap.appendChild(label);
        wrap.appendChild(input);
        return { wrap: wrap, input: input };
    }

    function render(focusLast) {
        listEl.innerHTML = '';
        var lastInput = null;
        items.forEach(function(item, idx) {
            if (!item || typeof item !== 'object') {
                item = {};
                items[idx] = item;
            }
            var card = document.createElement('div');
            card.className = 'streaming-links-item';

            var head = document.createElement('div');
            head.className = 'streaming-links-item__head';

            var indexLabel = document.createElement('span');
            indexLabel.className = 'streaming-links-item__index';
            indexLabel.textContent = '#' + (idx + 1);

            var actions = document.createElement('div');
            actions.className = 'streaming-links-item__actions';

            if (idx > 0) {
                var upBtn = document.createElement('button');
                upBtn.type = 'button';
                upBtn.textContent = '上移';
                upBtn.addEventListener('click', function() {
                    var tmp = items[idx - 1];
                    items[idx - 1] = items[idx];
                    items[idx] = tmp;
                    sync();
                    render(false);
                });
                actions.appendChild(upBtn);
            }

            if (idx < items.length - 1) {
                var downBtn = document.createElement('button');
                downBtn.type = 'button';
                downBtn.textContent = '下移';
                downBtn.addEventListener('click', function() {
                    var tmp = items[idx + 1];
                    items[idx + 1] = items[idx];
                    items[idx] = tmp;
                    sync();
                    render(false);
                });
                actions.appendChild(downBtn);
            }

            var delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.className = 'danger';
            delBtn.textContent = '删除';
            delBtn.addEventListener('click', function() {
                items.splice(idx, 1);
                sync();
                render(false);
            });
            actions.appendChild(delBtn);

            head.appendChild(indexLabel);
            head.appendChild(actions);
            card.appendChild(head);

            var grid = document.createElement('div');
            grid.className = 'streaming-links-grid';

            var nameField = createField('昵称', '昵称', item.name, false, function(v) { item.name = v; });
            var urlField = createField('链接URL', 'https://', item.url, false, function(v) { item.url = v; });
            var descField = createField('介绍', '介绍', item.desc, true, function(v) { item.desc = v; });
            var avatarField = createField('头像URL', 'https://', item.avatar, false, function(v) { item.avatar = v; });
            var bgField = createField('背景URL', 'https://', item.bg, false, function(v) { item.bg = v; });

            grid.appendChild(nameField.wrap);
            grid.appendChild(urlField.wrap);
            grid.appendChild(descField.wrap);
            grid.appendChild(avatarField.wrap);
            grid.appendChild(bgField.wrap);
            card.appendChild(grid);

            listEl.appendChild(card);
            lastInput = nameField.input;
        });

        if (focusLast && lastInput) {
            lastInput.focus();
        }
    }

    addBtn.addEventListener('click', function() {
        items.push({ name: '', url: '', desc: '', avatar: '', bg: '' });
        sync();
        render(true);
    });

    var form = textarea.form;
    if (form) {
        form.addEventListener('submit', sync);
    }

    render(false);
})();
</script>
HTML;

    $friendLinks = new Typecho_Widget_Helper_Form_Element_Textarea('friendLinks', NULL, NULL, _t('友情链接'), $friendLinksHtml);
    $form->addInput($friendLinks);
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

function streaming_safe_url($url) {
    $url = trim((string)$url);
    if ($url === '') {
        return '';
    }
    if (preg_match('/^\s*(?:javascript|vbscript):/i', $url)) {
        return '';
    }
    if (preg_match('/^\s*data:/i', $url) && !preg_match('/^\s*data:image\/(?:png|jpeg|jpg|gif|webp);base64,/i', $url)) {
        return '';
    }
    return $url;
}

function is_links_page($archive = null) {
    $options = Typecho_Widget::widget('Widget_Options');
    if ($options->enableLinks !== 'enable' || !isset($_GET['links'])) {
        return false;
    }
    if ($archive === null) {
        return true;
    }
    if ($archive->is('index')) {
        return true;
    }
    return $archive->is('page') && isset($archive->parameter) && isset($archive->parameter->type) && $archive->parameter->type === 'index';
}

function get_links_url() {
    $options = Typecho_Widget::widget('Widget_Options');
    $index = (string)$options->index;
    return $index . (strpos($index, '?') === false ? '?' : '&') . 'links';
}

function get_friend_links() {
    $options = Typecho_Widget::widget('Widget_Options');
    $raw = $options->friendLinks;
    if (empty($raw) || !is_string($raw)) {
        return array();
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return array();
    }
    $links = array();
    foreach ($data as $item) {
        if (!is_array($item)) {
            continue;
        }
        $name = isset($item['name']) ? trim((string)$item['name']) : '';
        $desc = isset($item['desc']) ? trim((string)$item['desc']) : '';
        $avatar = isset($item['avatar']) ? streaming_safe_url($item['avatar']) : '';
        $bg = isset($item['bg']) ? streaming_safe_url($item['bg']) : '';
        $url = isset($item['url']) ? streaming_safe_url($item['url']) : '';
        if ($name === '' && $desc === '' && $avatar === '' && $bg === '' && $url === '') {
            continue;
        }
        $links[] = array(
            'name' => $name,
            'desc' => $desc,
            'avatar' => $avatar,
            'bg' => $bg,
            'url' => $url,
        );
    }
    return $links;
}

?>
