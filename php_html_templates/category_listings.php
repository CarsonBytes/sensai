<?php
// No direct access
defined('_JEXEC') or die;

JHtml::_('jquery.framework');
require_once JPATH_SITE . '/php_html_templates/functions.php';

$query = "SELECT c.id, a.j2store_product_id, c.title, e.thumb_image 
/*, b.note, d.title, b.title as tag_title, b.catid, b.introtext, b.fulltext,*/ 
FROM `#__j2store_products` a 
INNER JOIN `#__content` c ON a.product_source_id = c.id
LEFT JOIN `#__j2store_productimages` e ON a.j2store_product_id = e.product_id
LEFT JOIN `#__j2store_variants` v ON a.j2store_product_id = v.product_id
RIGHT JOIN `bundle_params` bi ON bi.bundle_id = c.id
/*LEFT JOIN `#__contentitem_tag_map` c ON a.product_source_id = c.content_item_id
 LEFT JOIN `#__tags` d ON c.tag_id = d.id
 */
 WHERE c.state = 1
/* WHERE (b.note = 'deco' OR b.note = 'image' OR b.note = 'painting') AND b.state = 1 */
group by c.id
ORDER BY RAND()";

$database = JFactory::getDbo();
$database->setQuery($query);

$result = $database->loadAssocList();
?>
<div class="whole_content row">

    <?php include JPATH_SITE . '/php_html_templates/category.php'; ?>

    <div class="right_listings_wrapper col-sm-12">
        <h1><?php echo JText::sprintf('MENU_CATEGORIES'); ?></h1>
        <p style="margin-top: 10px;">The following is a random display of our products.</p>
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