<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 * 
 * Bootstrap 2 layout of product detail
 */
// No direct access
defined('_JEXEC') or die;
?>

<?php if($this->params->get('item_show_title', 1)): ?>
	<h<?php echo $this->params->get('item_title_headertag', '2'); ?> itemprop="name" class="product-title">
		<?php echo $this->product->product_name; ?> <span class="chart_toggle_in_title"> (with exclusive chart posters)</span>
	</h<?php echo $this->params->get('item_title_headertag', '2'); ?>>
<?php endif; ?>

