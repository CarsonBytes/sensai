<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class Route66ModelSitemap extends JModelAdmin
{
	protected $text_prefix = 'COM_ROUTE66';

	public function getTable($type = 'Sitemap', $prefix = 'Route66Table', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_route66.sitemap', 'sitemap', array('control' => 'jform', 'load_data' => false));

		if (empty($form))
		{
			return false;
		}

		JPluginHelper::importPlugin('route66');
		$dispatcher = JEventDispatcher::getInstance();
		$dispatcher->trigger('onRoute66LoadExtensionForm', array(&$form, 'sitemap'));

		$data = $this->loadFormData();
		$form->bind($data);

		//$form->removeField('virtuemartFilter', 'sources');
		//$form->removeField('virtuemartCategories', 'sources');

		return $form;
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_route66.edit.sitemap.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);

		if ($item)
		{
			$registry = new Registry();
			$item->sources = $registry->loadString($item->sources);

			$registry = new Registry();
			$item->settings = $registry->loadString($item->settings);
		}

		return $item;
	}

	public function getSitemapIndex($sitemap)
	{
		$urls = array();

		$params = JComponentHelper::getParams('com_route66');
		$limit = (int) $params->get('sitemapUrlsLimit', 500);

		JPluginHelper::importPlugin('route66');
		$dispatcher = JEventDispatcher::getInstance();
		$results = $dispatcher->trigger('onRoute66CountSitemapItems', array($sitemap));

		$application = JFactory::getApplication();
		$ssl = $application->get('force_ssl') == 2 ? 1 : 2;

		foreach ($results as $result)
		{
			if ($result['count'] > 0)
			{
				$urls[] = JRoute::_('index.php?option=com_route66&view=sitemap&id=' . $sitemap->id . '&extension=' . $result['extension'] . '&format=xml', true, $ssl);

				if ($result['count'] > $limit)
				{
					$pages = (int) ceil($result['count'] / $limit);

					for ($page = 1; $page < $pages; ++$page)
					{
						$urls[] = JRoute::_('index.php?option=com_route66&view=sitemap&id=' . $sitemap->id . '&extension=' . $result['extension'] . '&limitstart=' . $page * $limit . '&format=xml', true, $ssl);
					}
				}
			}
		}

		return $urls;
	}

	public function getSitemapItems($sitemap, $extension, $offset = 0)
	{
		$items = array();

		$params = JComponentHelper::getParams('com_route66');
		$limit = (int) $params->get('sitemapUrlsLimit', 500);

		if ($sitemap->sources->get($extension))
		{
			JPluginHelper::importPlugin('route66', $extension);
			$dispatcher = JEventDispatcher::getInstance();
			$results = $dispatcher->trigger('onRoute66GetSitemapItems', array($sitemap, $extension, $offset, $limit));

			foreach ($results as $result)
			{
				$items = array_merge($items, $result);
			}
		}

		return $items;
	}
}
