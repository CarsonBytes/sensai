<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/plugins/system/route66/lib/rule.php';

class Route66RuleTagsTag extends Route66Rule
{
	private static $cache = array();
	protected $variables = array('option' => 'com_tags', 'view' => 'tag', 'id' => '@');

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
			if ($token == '{tagId}')
			{
				$values[] = (int) $query['id'];
				$dbQuery->select($db->qn('id'));
			}
			// Alias
			elseif ($token == '{tagAlias}')
			{
				if (strpos($query['id'], ':'))
				{
					$parts = explode(':', $query['id']);
					$values[] = $parts[1];
				}
				$dbQuery->select($db->qn('alias'));
			}
			// Title
			elseif ($token == '{tagTitle}')
			{
				$dbQuery->select($db->qn('title'));
			}
		}

		// Check if we already have what we need
		if (count($this->tokens) === count($values))
		{
			self::$cache[$key] = $values;

			return $values;
		}

		// If not let's query the database
		$dbQuery->from($db->qn('#__tags'));
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
			if (isset($tokens['{tagId}']))
			{
				return $tokens['{tagId}'];
			}

			// Check for alias
			if (isset($tokens['{tagAlias}']))
			{
				return $this->getTagIdFromAlias($tokens['{tagAlias}']);
			}
		}
		else
		{
			return;
		}
	}

	public function getItemid($variables)
	{
		include_once JPATH_SITE . '/components/com_tags/helpers/route.php';
		$route = TagsHelperRoute::getTagRoute($variables['id']);
		parse_str($route, $result);
		$Itemid = isset($result['Itemid']) ? $result['Itemid'] : '';

		return $Itemid;
	}

	private function getTagIdFromAlias($alias)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id')->from('#__tags')->where('alias = ' . $db->q($alias));
		$application = JFactory::getApplication();

		if ($application->isSite() && $application->getLanguageFilter())
		{
			$query->where($db->qn('language') . ' IN(' . $db->q('*') . ', ' . $db->q($this->getLanguage()) . ')');
		}
		$db->setQuery($query);
		$id = $db->loadResult();

		return $id;
	}
}
