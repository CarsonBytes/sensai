<?php
// No direct access
defined('_JEXEC') or die;

$query = "SELECT b.id, a.j2store_product_id, b.title, e.thumb_image /*, b.note, d.title, b.title as tag_title, b.catid, b.introtext, b.fulltext,*/ FROM `h1232_j2store_products` a 
INNER JOIN `h1232_content` b ON a.product_source_id = b.id
LEFT JOIN `h1232_contentitem_tag_map` c ON a.product_source_id = c.content_item_id
LEFT JOIN `h1232_tags` d ON c.tag_id = d.id
LEFT JOIN `h1232_j2store_productimages` e ON a.j2store_product_id = e.product_id
WHERE (b.note = 'deco' OR b.note = 'image' OR b.note = 'painting') AND b.state = 1
group by b.id
ORDER BY RAND()";

$database = JFactory::getDbo();
$database->setQuery($query);

$result = $database->loadAssocList();

$lang = JFactory::getLanguage();
?>
<div class="whole_content row">

    <?php include JPATH_SITE . '/php_html_templates/category.php'; ?>

    <div class="right_listings_wrapper col-sm-12">
        <h1><?php echo ($lang->getTag() == 'ja-JP') ? 'カタログ' : 'Catelog' ?></h1>
        <div class="right_listings">
            <?php foreach ($result as $item) { ?>
                <div class="list_item_wrapper" data-id="<?php echo $item['j2store_product_id']; ?>" data-source="<?php echo $item['id']; ?>">
                    <div class="list_border">
                        <div class="list_item">
                            <a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $item['j2store_product_id']); ?>">
                                <div class="img_wrapper">
                                    <img class="lazyload" data-src="/<?php echo $item['thumb_image'] ?>" />
                                </div>
                            </a>
                            <div class="title_wrapper">
                                <a class="title" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $item['j2store_product_id']); ?>"><?php echo $item['title'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>