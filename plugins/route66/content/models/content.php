<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66ModelContent extends JModelLegacy
{
	private static $cache = array();

	public function getSitemapItems()
	{
		$user = JFactory::getUser();
		$date = JFactory::getDate();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->qn('article.id'));
		$query->select($db->qn('article.title'));
		$query->select($db->qn('article.alias'));
		$query->select($db->qn('article.catid'));
		$query->select($db->qn('article.language'));
		$query->select($db->qn('article.images'));
		$query->select($db->qn('article.publish_up'));
		$query->from($db->qn('#__content', 'article'));
		$query->where($db->qn('article.state') . ' IN(1,2)');
		$query->where($db->qn('article.access') . ' IN(' . implode(',', $user->getAuthorisedViewLevels()) . ')');
		$query->where('article.publish_up <= ' . $db->q($date->toSql()))->where('(article.publish_down = ' . $db->q($db->getNullDate()) . ' OR article.publish_down >= ' . $db->q($date->toSql()) . ')');

		if ($this->getState('categories'))
		{
			$query->where($db->qn('article.catid') . ' IN(' . implode(',', $this->getState('categories')) . ')');
		}
		$query->select($db->qn('category.title', 'categoryTitle'));
		$query->leftJoin($db->qn('#__categories', 'category') . ' ON ' . $db->qn('article.catid') . ' = ' . $db->qn('category.id'));
		$query->where($db->qn('category.published') . ' = 1')->where($db->qn('category.access') . ' IN(' . implode(',', $user->getAuthorisedViewLevels()) . ')');

		if ($this->getState('filter.days'))
		{
			$start = JFactory::getDate(strtotime('-' . $this->getState('filter.days') . ' day', $date->toUnix()));
			$query->where($db->qn('article.publish_up') . ' >= ' . $db->q($start->toSql()));
		}
		$query->order($db->qn('article.id'));
		$db->setQuery($query, $this->getState('offset'), $this->getState('limit'));
		$items = $db->loadObjectList();

		return $items;
	}

	public function countSitemapItems()
	{
		$user = JFactory::getUser();
		$date = JFactory::getDate();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(article.id)')->from($db->qn('#__content', 'article'))->where($db->qn('article.state') . ' IN(1,2)')->where($db->qn('article.access') . ' IN(' . implode(',', $user->getAuthorisedViewLevels()) . ')');
		$query->where('article.publish_up <= ' . $db->q($date->toSql()))->where('(article.publish_down = ' . $db->q($db->getNullDate()) . ' OR article.publish_down >= ' . $db->q($date->toSql()) . ')');

		if ($this->getState('categories'))
		{
			$query->where($db->qn('article.catid') . ' IN(' . implode(',', $this->getState('categories')) . ')');
		}

		if ($this->getState('filter.days'))
		{
			$start = JFactory::getDate(strtotime('-' . $this->getState('filter.days') . ' day', $date->toUnix()));
			$query->where($db->qn('article.publish_up') . ' >= ' . $db->q($start->toSql()));
		}
		$query->leftJoin($db->qn('#__categories', 'category') . ' ON ' . $db->qn('article.catid') . ' = ' . $db->qn('category.id'));
		$query->where($db->qn('category.published') . ' = 1')->where($db->qn('category.access') . ' IN(' . implode(',', $user->getAuthorisedViewLevels()) . ')');
		$db->setQuery($query);

		return $db->loadResult();
	}

	public function getInstantArticles()
	{
		$user = JFactory::getUser();
		$date = JFactory::getDate();
		$before = JFactory::getDate($date->toUnix() - (60 * 60));
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->qn('article') . '.*')->from($db->qn('#__content', 'article'))->where($db->qn('article.state') . ' IN(1,2)')->where($db->qn('article.access') . ' IN(' . implode(',', $user->getAuthorisedViewLevels()) . ')');
		$query->where('article.publish_up <= ' . $db->q($date->toSql()))->where('(article.publish_down = ' . $db->q($db->getNullDate()) . ' OR article.publish_down >= ' . $db->q($date->toSql()) . ')');
		$query->where('(article.publish_up >= ' . $db->q($before->toSql()) . ' OR article.modified >= ' . $db->q($before->toSql()) . ')');

		if ($this->getState('categories'))
		{
			$query->where($db->qn('article.catid') . ' IN(' . implode(',', $this->getState('categories')) . ')');
		}
		$query->leftJoin($db->qn('#__categories', 'category') . ' ON ' . $db->qn('article.catid') . ' = ' . $db->qn('category.id'));
		$query->where($db->qn('category.published') . ' = 1')->where($db->qn('category.access') . ' IN(' . implode(',', $user->getAuthorisedViewLevels()) . ')');
		$db->setQuery($query);
		$items = $db->loadObjectList();

		return $items;
	}
}
