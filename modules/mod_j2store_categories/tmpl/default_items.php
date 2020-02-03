<?php
/*------------------------------------------------------------------------
# mod_j2store_categories
# ------------------------------------------------------------------------
# author    Gokila priya - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php foreach ($list as $item) : ?>
	<li <?php if ($_SERVER['PHP_SELF'] == JRoute::_(ContentHelperRoute::getCategoryRoute($item->id))) echo ' class="active"';?>> <?php $levelup = $item->level - $startLevel - 1; ?>
		<?php $image = $item->getParams()->get('image');
			$itemid = isset($item->menu_id) ? $item->menu_id: 0; 
			if ($params->get('show_image', 0) && $image !='') :?>
			<a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&j2storesource=category&task=browse&filter_catid='.$item->id .'&Itemid='.$itemid);?>">
				<img src="<?php echo JUri::root().$image; ?>" width="40" height="40" border="0"/>
			</a>
		<?php endif;?>

		<h<?php echo $params->get('item_heading') + $levelup; ?>>

		<!--  <a href="<?php // echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>"> -->
		<a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&j2storesource=category&task=browse&filter_catid='.$item->id .'&Itemid='.$itemid);?>">
		<?php echo $item->title;?>
			<?php if ($params->get('numitems')) : ?>
				(<?php echo $item->numitems; ?>)
			<?php endif; ?>
		</a>
   		</h<?php echo $params->get('item_heading') + $levelup; ?>>

		<?php if ($params->get('show_description', 0)) : ?>
			<?php echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_j2store_categories.products'); ?>
		<?php endif; ?>

		<?php if ($params->get('browse_link', 1)) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&j2storesource=category&task=browse&filter_catid='.$item->id .'&Itemid='.$itemid);?>">
			<?php echo JText::_('J2STORE_BROWSE_PRODUCTS'); ?>
		</a>
		<?php endif; ?>



		<?php if ($params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0)
			|| ($params->get('maxlevel') >= ($item->level - $startLevel)))
			&& count($item->getChildren())) : ?>
			<?php echo '<ul>'; ?>
			<?php $temp = $list; ?>
			<?php $list = $item->getChildren(); ?>
			<?php require JModuleHelper::getLayoutPath('mod_j2store_categories', $params->get('layout', 'default') . '_items'); ?>
			<?php $list = $temp; ?>
			<?php echo '</ul>'; ?>
		<?php endif; ?>
</li>
<?php endforeach;?>
