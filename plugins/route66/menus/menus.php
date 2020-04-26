<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/plugins/system/route66/lib/plugin.php';

class plgRoute66Menus extends Route66Plugin
{
	public function getSitemapItems($feed, $offset, $limit)
	{
		// No support for news sitemap
		if ($feed->settings->get('type') == 'news')
		{
			return array();
		}

		// Get model
		$model = $this->getModel();
		$model->setState('offset', $offset);
		$model->setState('limit', $limit);

		// Set category filter
		if ($feed->sources->get('menus') == 2 && is_array($feed->sources->get('menusCategories')) && count($feed->sources->get('menusCategories')))
		{
			$model->setState('categories', $feed->sources->get('menusCategories'));
		}

		$items = $model->getSitemapItems();

		return $items;
	}

	public function countSitemapItems($feed)
	{
		// No support for news sitemap
		if ($feed->settings->get('type') == 'news')
		{
			return 0;
		}

		// Get model
		$model = $this->getModel();

		// Set category filter
		if ($feed->sources->get('menus') == 2 && is_array($feed->sources->get('menusCategories')) && count($feed->sources->get('menusCategories')))
		{
			$model->setState('categories', $feed->sources->get('menusCategories'));
		}

		return $model->countSitemapItems();
	}
}
