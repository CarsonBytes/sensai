<?php

/**
 * @package 		J2Store
 * @copyright 	Copyright (c)2016-19 Sasi varna kumar / J2Store.org
 * @license 		GNU GPL v3 or later
 */
defined('_JEXEC') or die;
$total_cols = $params->get('number_of_coloums', 3);
$total_count = count($list);
$counter = 0;

include JPATH_SITE . '/php_html_templates/functions.php';
?>
<div itemscope itemtype="http://schema.org/ItemList" class="j2store-product-module j2store-product-module-list row-fluid">
	<?php error_reporting(0);
	if ($module->showtitle != 0) : ?>
		<div class="section-title">
			<h2><span><?php echo $module->title; ?></span></h2>

		</div>
	<?php endif; ?>
	<?php if (count($list) > 0) : ?>
		<div class="thumbnail_list">
			<?php
			foreach ($list as $product_id => $product) :
				$image_root_path = JUri::root();
				$image_path = '';
				if (isEdupack($product->source->note)) {
					$edupack_info = getEdupackInfo($product->source->note);
					$image_path = $edupack_info['edupack_img_path'];
				} else {
					if ($product->image_type == 'thumbimage' && isset($product->thumb_image)) {
						$image_path = $product->thumb_image;
					} else if ($product->image_type == 'mainimage' && isset($product->main_image)) {
						$image_path = $product->main_image;
					}
				} ?>
				<div class="list_item_wrapper" data-id="<?php echo $product->j2store_product_id; ?>">
					<div class="list_border">
						<div class="list_item">
							<a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $product->j2store_product_id); ?>">
								<div class="img_wrapper">
									<img alt="<?php echo $product->product_name; ?>" class="lazyload j2store-img-responsive j2store-product-image-<?php echo $product->j2store_product_id; ?>" data-src="<?php echo $image_root_path . $image_path; ?>" width="<?php echo $product->image_size_width; ?>" height="<?php echo $product->image_size_height; ?>" /> </div>
							</a>
							<div class="title_wrapper">
								<a class="title" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $product->j2store_product_id); ?>"><?php echo $product->product_name; ?></a>
							</div>
						</div>
					</div>
				</div>
			<?php
			endforeach;  ?>
		</div>
	<?php endif; ?>
</div>