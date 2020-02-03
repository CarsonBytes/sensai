<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_j2store_categories
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/modules/mod_j2store_categories/helpers/categories.php';
require_once JPATH_SITE . '/components/com_content/helpers/route.php';
/**
 * Helper for mod_j2store_categories
 *
 * @package     Joomla.Site
 * @subpackage  mod_j2store_categories
 *
 * @since       1.5
 */
abstract class ModJ2storeCategoriesHelper
{
	/**
	 * Get list of articles
	 *
	 * @param   JRegistry  &$params  module parameters
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function getList(&$params)
	{
		$options               = array();
		$options['countItems'] = $params->get('numitems', 0);

		$categories = J2StoreCategories::getInstance('J2Store', $options);
		$category   = $categories->get($params->get('parent', 'root'));
		if ($category != null)
		{
			$items = $category->getChildren();
			if ($params->get('count', 0) > 0 && count($items) > $params->get('count', 0))
			{
				$items = array_slice($items, 0, $params->get('count', 0));
			}
			$menus = JMenu::getInstance('site');
			$menu_items = $menus->getItems(array(),array());			
			foreach($items as $key=>$item){
				foreach($menu_items as $m_item){					
					if(isset($m_item->query['catid'])){
						if(in_array($item->id,$m_item->query['catid'])){							
							$items[$key]->menu_id = $m_item->id;
							break;
						}
					}						
				}
			}
			return $items;
		}
	}
}
