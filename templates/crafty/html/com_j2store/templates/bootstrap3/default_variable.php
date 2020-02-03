<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;
?>

<div class="pro-icon">
	<?php echo J2Store::plugin()->eventWithHtml('AfterAddToCartButton', array($this->product, J2Store::utilities()->getContext('default_cart'))); ?>
	<!-- QUICK VIEW OPTION -->
		<?php if($this->params->get('list_enable_quickview',0)):?>
		<div class="quick-view">
				<a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&id='.$this->product->j2store_product_id.'&tmpl=component'); ?>"
				style="display:inline;position:relative;"
				class="modal j2store-product-quickview-modal"
				rel="{handler:'iframe', size: {x: 700, y: 500}}" >
				<i class="fa fa-external-link-square"></i>
				</a>
			</div>
		<?php endif;?>

	<div class="mod_pic">
		<a href="<?php echo $this->product->thumb_image;?>" class="modal" style="display:inline; position:relative;">
			<i class="fa fa-picture-o"></i>
		</a>
	</div>
</div>
<?php echo $this->loadTemplate('images'); ?>

<?php echo $this->loadTemplate('title'); ?>
<?php if(isset($this->product->event->afterDisplayTitle)) : ?>
		<?php echo $this->product->event->afterDisplayTitle; ?>
<?php endif;?>


<?php if(isset($this->product->event->beforeDisplayContent)) : ?>
	<?php echo $this->product->event->beforeDisplayContent; ?>
<?php endif;?>

<?php echo $this->loadTemplate('description'); ?>

<?php echo $this->loadTemplate('price'); ?>

<?php if($this->params->get('list_show_product_sku', 1)) : ?>
	<?php echo $this->loadTemplate('sku'); ?>
<?php endif; ?>

<?php if($this->params->get('list_show_product_stock', 1)) : ?>
	<?php echo $this->loadTemplate('stock'); ?>
<?php endif; ?>

<?php if($this->params->get('catalog_mode', 0) == 0): ?>

<form action="<?php echo $this->product->cart_form_action; ?>"
		method="post" class="j2store-addtocart-form"
		id="j2store-addtocart-form-<?php echo $this->product->j2store_product_id; ?>"
		name="j2store-addtocart-form-<?php echo $this->product->j2store_product_id; ?>"
		data-product_id="<?php echo $this->product->j2store_product_id; ?>"
		data-product_type="<?php echo $this->product->product_type; ?>"
		<?php if(isset($this->product->variant_json)): ?>
		data-product_variants="<?php echo $this->escape($this->product->variant_json);?>"
		<?php endif; ?>
		enctype="multipart/form-data">

<?php $cart_type = $this->params->get('list_show_cart', 1); ?>

<?php if($cart_type == 1) : ?>
	<?php echo $this->loadTemplate('variableoptions'); ?>
	<?php echo $this->loadTemplate('cart'); ?>

<?php else:?>
<!-- we have options so we just redirect -->
	<a href="<?php echo $this->product->product_link; ?>" class="<?php echo $this->params->get('choosebtn_class', 'btn btn-success'); ?>"><i class="fa fa-list-alt" title="View Option"></i> <?php echo JText::_('J2STORE_VIEW_PRODUCT_DETAILS'); ?></a>
<?php endif; ?>
<input type="hidden" name="variant_id" value="<?php echo $this->product->variant->j2store_variant_id; ?>" />
</form>
<?php endif; ?>
<?php if(isset($this->product->event->afterDisplayContent)) : ?>
	<?php echo $this->product->event->afterDisplayContent; ?>
<?php endif;?>
