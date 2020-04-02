<?php
// No direct access
defined('_JEXEC') or die;

$query = "SELECT b.id, a.j2store_product_id, b.catid, b.title, d.title as tag_title, e.thumb_image FROM `h1232_j2store_products` a 
INNER JOIN `h1232_content` b ON a.product_source_id = b.id
LEFT JOIN `h1232_contentitem_tag_map` c ON a.product_source_id = c.content_item_id
LEFT JOIN `h1232_tags` d ON c.tag_id = d.id
LEFT JOIN `h1232_j2store_productimages` e ON a.j2store_product_id = e.product_id
WHERE (a.main_tag = 'image' or a.main_tag = 'deco') AND d.title = 'animal'
ORDER BY a.`j2store_product_id` DESC";

$database->setQuery($query);

$result = $database->loadAssocList();

/* echo '<pre>';

var_dump($result);

echo '</pre>';  */
/* 
$id=16;
//echo  \Joomla\CMS\Router\Route::_('index.php?option=com_j2store&view=products&id='.$id).'<br />';
echo JRoute::link('site', 'index.php?option=com_j2store&task=view&view=products&Itemid=227&id='.$id). '<br />'; */

 /* 

 
$articleId= 21;
echo JRoute::_(ContentHelperRoute::getArticleRoute($articleId, $articleLink[$articleId])) . '<br />';
 
 

$catid = 18;
echo rtrim(JUri::base(), '/') . JRoute::_(ContentHelperRoute::getArticleRoute( $articleId, $catid )) . '<br />';
 
echo JRoute::_(JUri::root() . 'index.php?option=com_content&view=article&id=' . $articleId); */


?>
<div class="whole_content row">

    <?php include JPATH_SITE . '/php_html_templates/category.php'; ?>

    <div class="right_listings_wrapper col-sm-12">
        <h1>炊飯器・精米器</h1>
        <div class="right_listings">
            <?php for ($i = 0; $i <= 10; $i++) { ?>
                <div class="list_item_wrapper">
                    <div class="list_border">
                        <div class="list_item">
                            <a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . rand(36, 56)); ?>">
                                <div class="img_wrapper">
                                    <img src="/images/sensaihonya/poster<?php echo rand(1, 4); ?>.jpg" />
                                </div>
                            </a>
                            <div class="title_wrapper">
                                <a class="title" href="#">RAIN QUEEN 絵画風 壁紙ポスター 風景 景色 おしゃれ ウォールステッカー 多用途なシール DIYシール 偽窓ステッカー 絵画風 壁紙ポスター</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>