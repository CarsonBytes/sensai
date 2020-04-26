<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66ModelMenus extends JModelLegacy
{
	private static $cache = array();

	public function getSitemapItems()
	{
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->qn('id') . ',' . $db->qn('type') . ',' . $db->qn('params') . ',' . $db->qn('home') . ',' . $db->qn('language'));
		$query->from($db->qn('#__menu'));
		$query->where($db->qn('client_id') . ' = 0');
		$query->where($db->qn('published') . ' = 1');
		$query->where($db->qn('access') . ' IN (' . implode(',', $user->getAuthorisedViewLevels()) . ')');
		$query->where('(' . $db->qn('type') . ' = ' . $db->q('component') . ' OR ' . $db->qn('type') . ' = ' . $db->q('alias') . ')');

		if ($this->getState('categories'))
		{
			$menutypes = $this->getState('categories');
			$conditions = array();

			foreach ($menutypes as $menutype)
			{
				$conditions[] = $db->qn('menutype') . ' = ' . $db->q($menutype);
			}
			$query->where('(' . implode(' OR ', $conditions) . ')');
		}
		$query->order($db->qn('id'));
		$db->setQuery($query, $this->getState('offset'), $this->getState('limit'));
		$items = $db->loadObjectList();
		$application = JFactory::getApplication();
		$ssl = $application->get('force_ssl') == 2 ? 1 : 2;

		foreach ($items as $item)
		{
			if ($item->type == 'alias')
			{
				$params = new JRegistry($item->params);
				$query = $db->getQuery(true);
				$query->select($db->qn('id') . ',' . $db->qn('home'));
				$query->from($db->qn('#__menu'));
				$query->where($db->qn('id') . ' = ' . (int) $params->get('aliasoptions'));
				$db->setQuery($query, 0, 1);
				$item = $db->loadObject();
			}

			if ($item->home)
			{
				$url = rtrim(JUri::root(false), '/');
			}
			else
			{
				$route = 'index.php?Itemid=' . $item->id;

				if (JLanguageMultilang::isEnabled() && $item->language != '*')
				{
					$route .= '&lang=' . $item->language;
				}
				$url = JRoute::_($route, false, $ssl);
			}
			$row = new stdClass();
			$row->url = $url;
			$row->images = array();
			$row->videos = array();
			$rows[$row->url] = $row;
		}

		return array_values($rows);
	}

	public function countSitemapItems()
	{
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->qn('#__menu'));
		$query->where($db->qn('client_id') . ' = 0');
		$query->where($db->qn('published') . ' = 1');
		$query->where($db->qn('access') . ' IN (' . implode(',', $user->getAuthorisedViewLevels()) . ')');
		$query->where('(' . $db->qn('type') . ' = ' . $db->q('component') . ' OR ' . $db->qn('type') . ' = ' . $db->q('alias') . ')');

		if ($this->getState('categories'))
		{
			$menutypes = $this->getState('categories');
			$conditions = array();

			foreach ($menutypes as $menutype)
			{
				$conditions[] = $db->qn('menutype') . ' = ' . $db->q($menutype);
			}
			$query->where('(' . implode(' OR ', $conditions) . ')');
		}
		$db->setQuery($query);
		$result = $db->loadResult();

		return $result;
	}
}
