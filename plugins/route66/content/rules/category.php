<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/plugins/system/route66/lib/rule.php';

class Route66RuleContentCategory extends Route66Rule
{
	private static $cache = array();
	protected $variables = array('option' => 'com_content', 'view' => 'category', 'id' => '@');

	public function getTokensValues($query)
	{
		// Cache key
		$key = (int) $query['id'];

		// Check cache
		if (isset(self::$cache[$key]))
		{
			return self::$cache[$key];
		}

		// Get database
		$db = JFactory::getDbo();

		// Get query
		$dbQuery = $db->getQuery(true);

		// Initialize values
		$values = array();

		// Iterate over the tokens
		foreach ($this->tokens as $token)
		{

			// ID
			if ($token == '{categoryId}')
			{
				$values[] = (int) $query['id'];
				$dbQuery->select($db->qn('id'));
			}
			// Alias
			elseif ($token == '{categoryAlias}')
			{
				if (strpos($query['id'], ':'))
				{
					$parts = explode(':', $query['id']);
					$values[] = $parts[1];
				}
				$dbQuery->select($db->qn('alias'));
			}
			// Path
			elseif ($token == '{categoryPath}')
			{
				$dbQuery->select($db->qn('path'));
			}
		}

		// Check if we already have what we need
		if (count($this->tokens) === count($values))
		{
			self::$cache[$key] = $values;

			return $values;
		}

		// If not let's query the database
		$dbQuery->from($db->qn('#__categories'));
		$dbQuery->where($db->qn('id') . ' = ' . (int) $query['id']);
		$db->setQuery($dbQuery);
		$values = $db->loadRow();
		self::$cache[$key] = $values;

		return $values;
	}

	public function getQueryValue($key, $tokens)
	{
		if ($key == 'id')
		{
			// First check that ID is not already in the URL
			if (isset($tokens['{categoryId}']))
			{
				return $tokens['{categoryId}'];
			}

			// Check for alias
			if (isset($tokens['{categoryAlias}']))
			{
				return $this->getCategoryIdFromAlias($tokens['{categoryAlias}']);
			}

			// Check for path
			if (isset($tokens['{categoryPath}']))
			{
				return $this->getCategoryIdFromPath($tokens['{categoryPath}']);
			}
		}
		else
		{
			return;
		}
	}

	public function getItemid($variables)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->qn('id'))->select($db->qn('language'))->from($db->qn('#__categories'))->where($db->qn('id') . ' = ' . $db->q($variables['id']));
		$db->setQuery($query);
		$category = $db->loadObject();

		// Joomla! 3.7 broke it
		if (version_compare(JVERSION, '3.7.0', 'ge'))
		{
			include_once JPATH_SITE . '/plugins/route66/content/helpers/route.php';
			$route = Route66ContentHelperRoute::getCategoryRoute($category->id, $category->language);
		}
		else
		{
			include_once JPATH_SITE . '/components/com_content/helpers/route.php';
			$route = ContentHelperRoute::getCategoryRoute($category->id, $category->language);
		}

		parse_str($route, $result);
		$Itemid = isset($result['Itemid']) ? $result['Itemid'] : '';

		return $Itemid;
	}

	private function getCategoryIdFromAlias($alias)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id')->from('#__categories')->where('alias = ' . $db->q($alias));
		$application = JFactory::getApplication();

		if ($application->isSite() && $application->getLanguageFilter())
		{
			$query->where($db->qn('language') . ' IN(' . $db->q('*') . ', ' . $db->q($this->getLanguage()) . ')');
		}
		$db->setQuery($query);
		$id = $db->loadResult();

		return $id;
	}

	private function getCategoryIdFromPath($path)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id')->from('#__categories')->where($db->qn('path') . ' = ' . $db->q($path));
		$db->setQuery($query);
		$id = $db->loadResult();

		if (!$id)
		{
			$application = JFactory::getApplication();

			if ($application->isSite() && $application->getLanguageFilter() && $path != '/')
			{
				$parts = explode('/', $path);
				$parts = array_filter($parts);
				array_shift($parts);
				$path = implode('/', $parts);
				$query = $db->getQuery(true);
				$query->select('id')->from('#__categories')->where($db->qn('path') . ' = ' . $db->q($path));
				$db->setQuery($query);
				$id = $db->loadResult();
			}
		}

		return $id;
	}
}
