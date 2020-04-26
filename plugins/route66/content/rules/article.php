<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/plugins/system/route66/lib/rule.php';

class Route66RuleContentArticle extends Route66Rule
{
	private static $cache = array();
	protected $variables = array('option' => 'com_content', 'view' => 'article', 'id' => '@', 'catid' => '');

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
			if ($token == '{articleId}')
			{
				$values[] = (int) $query['id'];
				$dbQuery->select($db->qn('article.id'));
			}
			// Alias
			elseif ($token == '{articleAlias}')
			{
				if (strpos($query['id'], ':'))
				{
					$parts = explode(':', $query['id']);
					$values[] = $parts[1];
				}
				$dbQuery->select($db->qn('article.alias'));
			}
			// Category alias
			elseif ($token == '{categoryAlias}')
			{
				$dbQuery->select($db->qn('category.alias'));
			}
			// Category path
			elseif ($token == '{categoryPath}')
			{
				$dbQuery->select($db->qn('category.path'));
			}
			// Article year
			elseif ($token == '{articleYear}')
			{
				$dbQuery->select('YEAR(' . $db->qn('article.created') . ')');
			}
			// Article month
			elseif ($token == '{articleMonth}')
			{
				$dbQuery->select('DATE_FORMAT(' . $db->qn('article.created') . ', "%m")');
			}
			// Article day
			elseif ($token == '{articleDay}')
			{
				$dbQuery->select('DATE_FORMAT(' . $db->qn('article.created') . ', "%d")');
			}
			// Article date
			elseif ($token == '{articleDate}')
			{
				$dbQuery->select('DATE(' . $db->qn('article.created') . ')');
			}
			// Article author
			elseif ($token == '{articleAuthor}')
			{
				$dbQuery->select('CASE WHEN ' . $db->qn('article.created_by_alias') . ' = ' . $db->q('') . ' THEN ' . $db->qn('article.created_by') . ' ELSE ' . $db->qn('article.created_by_alias') . ' END ');
			}
		}

		// Check if we already have what we need
		if (count($this->tokens) === count($values))
		{
			self::$cache[$key] = $values;

			return $values;
		}

		// If not let's query the database
		$dbQuery->from($db->qn('#__content', 'article'));
		$dbQuery->innerJoin($db->qn('#__categories', 'category') . ' ON ' . $db->qn('article.catid') . ' = ' . $db->qn('category.id'));
		$dbQuery->where($db->qn('article.id') . ' = ' . (int) $query['id']);
		$db->setQuery($dbQuery);
		$values = $db->loadRow();

		// Some values need processing
		$author = array_search('{articleAuthor}', $this->tokens);

		if ($author !== false)
		{
			if (is_numeric($values[$author]))
			{
				$values[$author] = JFactory::getUser($values[$author])->name;
			}
			$values[$author] = JFilterOutput::stringURLUnicodeSlug($values[$author]);
		}
		self::$cache[$key] = $values;

		return $values;
	}

	public function getQueryValue($key, $tokens)
	{
		if ($key == 'id')
		{
			// First check that ID is not already in the URL
			if (isset($tokens['{articleId}']))
			{
				return $tokens['{articleId}'];
			}

			// Check for alias
			if (isset($tokens['{articleAlias}']))
			{
				return $this->getArticleIdFromAlias($tokens['{articleAlias}']);
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
		$query->select($db->qn('id'))->select($db->qn('catid'))->select($db->qn('language'))->from($db->qn('#__content'))->where($db->qn('id') . ' = ' . $db->q($variables['id']));
		$db->setQuery($query);
		$article = $db->loadObject();

		// Joomla! 3.7 broke it
		if (version_compare(JVERSION, '3.7.0', 'ge'))
		{
			include_once JPATH_SITE . '/plugins/route66/content/helpers/route.php';
			$route = Route66ContentHelperRoute::getArticleRoute($article->id, $article->catid, $article->language);
		}
		else
		{
			include_once JPATH_SITE . '/components/com_content/helpers/route.php';
			$route = ContentHelperRoute::getArticleRoute($article->id, $article->catid, $article->language);
		}

		parse_str($route, $result);
		$Itemid = isset($result['Itemid']) ? $result['Itemid'] : '';

		return $Itemid;
	}

	private function getArticleIdFromAlias($alias)
	{
		if (strpos($alias, '/') !== false)
		{
			$parts = explode('/', $alias);
			$alias = end($parts);
		}
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id')->from('#__content')->where('alias = ' . $db->q($alias));

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
