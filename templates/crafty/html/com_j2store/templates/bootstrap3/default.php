<?php

/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 *
 * Bootstrap 2 layout of products
 */
// No direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addScript('/js/category_listings.js');

//$j2store_product_id=16;
//echo rtrim(JUri::base(), '/') . JRoute::_('index.php?option=com_j2store&view=products&task=view&&id='.$j2store_product_id).'<br />';


$db = JFactory::getDbo();
/* echo '<pre>';
var_dump($this->active_menu);
echo '</pre>';
die(); */
$query = "SELECT b.id, a.j2store_product_id, b.title, e.thumb_image /*, b.note, d.title, b.title as tag_title, b.catid, b.introtext, b.fulltext,*/ FROM `h1232_j2store_products` a 
INNER JOIN `h1232_content` b ON a.product_source_id = b.id
LEFT JOIN `h1232_j2store_productimages` e ON a.j2store_product_id = e.product_id
LEFT JOIN `bundles_categories` bc ON bc.bundle_id = b.id
LEFT JOIN `h1232_categories` c ON  c.id = bc.category_id
WHERE c.alias = {$db->quote($this->active_menu->alias)} AND b.state = 1
ORDER BY a.`j2store_product_id` DESC";

$db->setQuery($query);

$result = $db->loadAssocList();/* 

echo '<pre>';

var_dump($this->active_menu->title);

echo '</pre>'; */

$active_menu_route = $this->active_menu->route;
?>
<div class="whole_content row">

	<?php include JPATH_SITE . '/php_html_templates/category.php'; ?>

	<div class="right_listings_wrapper col-sm-12">
		<h1><?php $img_path = "/images/page/common/list/category/" . $this->active_menu->alias . "_50.jpg";
			if (file_exists(JPATH_SITE . $img_path)) { ?>
				<img src="<?= $img_path ?>" />
			<?php } ?>
			<?php echo $this->active_menu->title ?>
		</h1>
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