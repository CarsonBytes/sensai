<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66SefRouter
{
	private $rules = array();
	private $vars = array();
	private $route = '';
	private $menu;
	private $isMenuItem = false;
	private $languages;
	private $defaultLanguage;
	private $currentLanguage;

	public function __construct()
	{
		$this->setParams();
		$this->setLanguage();
		$this->setMenu();
		$this->loadPlugins();
		$this->attachRules();
	}

	private function setParams()
	{
		$this->params = JComponentHelper::getParams('com_route66');
	}

	private function setLanguage()
	{
		$this->languages = JLanguageHelper::getLanguages('lang_code');
		$default = JComponentHelper::getParams('com_languages')->get('site', 'en-GB');
		$this->defaultLanguage = isset($this->languages[$default]) ? $this->languages[$default]: current($this->languages);
		$current = JFactory::getLanguage()->getTag();
		$this->currentLanguage = isset($this->languages[$current]) ? $this->languages[$current] : $this->defaultLanguage;

		$application = JFactory::getApplication();

		if ($application->isSite() && $application->getLanguageFilter())
		{
			$uri = JUri::getInstance();
			$path = ltrim($uri->getPath(), '/');

			if ($path && $path != '/')
			{
				foreach ($this->languages as $language)
				{
					if (strpos($path, $language->sef . '/') === 0 || $path == $language->sef)
					{
						$this->currentLanguage = $this->languages[$language->lang_code];

						break;
					}
				}
			}
		}
	}

	private function setMenu()
	{
		$application = JFactory::getApplication();
		$this->menu = $application->getMenu();
		$attributes = array();
		$values = array();

		if ($application->isSite() && $application->getLanguageFilter())
		{
			$languages = array('*');

			foreach ($this->languages as $language)
			{
				$languages[] = $language->lang_code;
			}
			$attributes = array('language');
			$values = array($languages);
			$items = $this->menu->getItems($attributes, $values);
		}
		else
		{
			$items = $this->menu->getItems($attributes, $values);
		}

		foreach ($items as &$item)
		{
			$isParent = count($this->menu->getItems('parent_id', $item->id));
			$menuLinksSuffixExclusions = $this->params->get('menuLinksSuffixExclusions', array());
			$menuLinksTrailingSlashExclusions = $this->params->get('menuLinksTrailingSlashExclusions', array());

			if ($this->params->get('menuLinksSuffix') == 1 || ($this->params->get('menuLinksSuffix') == 2 && !$isParent))
			{
				if (!in_array($item->id, $menuLinksSuffixExclusions))
				{
					$item->route = $this->addSuffix($item->route, $this->params->get('menuLinksSuffixText'));
				}
			}

			if ($this->params->get('menuLinksTrailingSlash') == 1 || ($this->params->get('menuLinksTrailingSlash') == 2 && $isParent))
			{
				if (!in_array($item->id, $menuLinksTrailingSlashExclusions))
				{
					$item->route = $this->addTrailingSlash($item->route);
				}
			}
		}
	}

	private function loadPlugins()
	{
		JPluginHelper::importPlugin('route66');
		$dispatcher = JEventDispatcher::getInstance();
		$results = $dispatcher->trigger('onRoute66AddRules');

		foreach ($results as $result)
		{
			foreach ($result as $rule)
			{
				$this->rules[] = $rule;
			}
		}
		usort($this->rules, array($this, 'sort'));
	}

	public function sort($a, $b)
	{
		$aLength = $a->getLength();
		$bLength = $b->getLength();

		if ($aLength == $bLength)
		{
			return 0;
		}

		return ($aLength > $bLength) ? -1 : 1;
	}

	private function attachRules()
	{
		$application = JFactory::getApplication();
		$router = $application->getRouter('site');
		$uri = JUri::getInstance();
		$path = $uri->getPath();

		$router->attachParseRule(array($this, 'preParseMenu'), 'preprocess');
		$router->attachParseRule(array($this, 'preParseExtension'), 'preprocess');
		$router->attachParseRule(array($this, 'postParse'), 'postprocess');

		$router->attachBuildRule(array($this, 'preBuildExtension'), 'preprocess');
		$router->attachBuildRule(array($this, 'postBuild'), 'postprocess');
	}

	public function preParseMenu($router, $uri)
	{
		$application = JFactory::getApplication();
		$path = $uri->getPath();

		if ($application->isSite() && $application->getLanguageFilter())
		{
			if ($path == $this->currentLanguage->sef)
			{
				$this->isMenuItem = true;

				return;
			}

			if (strpos($path, $this->currentLanguage->sef . '/') === 0)
			{
				$path = $this->removePrefix($path);
			}

			$languages = array('*');

			foreach ($this->languages as $language)
			{
				$languages[] = $language->lang_code;
			}

			$conditions = array('route', 'language');
			$values = array($path, $languages);
			$items = $this->menu->getItems($conditions, $values);

			if (!count($items) && $this->params->get('menuLinksTrailingSlash'))
			{
				$values = array($path . '/', $languages);
				$items = $this->menu->getItems($conditions, $values);
			}
		}
		else
		{
			$items = $this->menu->getItems('route', $path);
		}

		if (!count($items) && $path == '')
		{
			$this->isMenuItem = true;

			return;
		}

		if (!count($items) && $this->params->get('menuLinksTrailingSlash'))
		{
			$items = $this->menu->getItems('route', $path . '/');
		}

		if (count($items))
		{
			$item = $items[0];
			$this->isMenuItem = true;
			$query = parse_url($item->link, PHP_URL_QUERY);
			parse_str($query, $vars);
			$this->vars = $vars;
			$this->vars['Itemid'] = $item->id;

			return $this->vars;
		}
	}

	public function preParseExtension($router, $uri)
	{
		if ($this->isMenuItem)
		{
			return;
		}

		$path = $uri->getPath();

		if ($path != '/')
		{
			$path = ltrim($path, '/');
		}

		$application = JFactory::getApplication();

		if ($application->get('sef_suffix'))
		{
			$path = substr($path, 0, strrpos($path, '.'));
		}

		foreach ($this->rules as $rule)
		{
			preg_match_all($rule->getRegex(), $path, $matches, PREG_SET_ORDER);

			if (is_array($matches) && count($matches))
			{

				// Get values
				$values = array_combine($rule->getTokens(), array_slice($matches[0], 1));

				// Iterate over the rule variables
				foreach ($rule->getVariables() as $key => $var)
				{

					// If it's empty it's not required
					if (!$var)
					{
						continue;
					}

					// If it's a dynamic variable fetch it from the rule. Otherwise it's plain text
					if ($var == '@')
					{
						$value = $rule->getQueryValue($key, $values);
						$var = $value ? $value : '@';
						$this->vars[$key] = $var;
					}
					else
					{
						$this->vars[$key] = $var;
					}
				}

				// No match here
				if (in_array('@', $this->vars))
				{
					$this->vars = array();

					continue;
				}

				// Ensure that ID is numeric
				if (isset($this->vars['id']) && $this->vars['id'] && !is_numeric($this->vars['id']))
				{
					continue;
				}

				// Ensure we are not matching a route that has a menu link
				if ($this->hasMenuItem($this->vars))
				{
					$this->vars = array();

					continue;
				}

				// Restore Itemid so the module assignments keep working
				$this->vars['Itemid'] = $rule->getItemid($this->vars);

				// Fix for new Joomla router
				JComponentHelper::getParams($this->vars['option'])->set('sef_advanced', 0);

				// Return our vars
				return $this->vars;
			}
		}
	}

	public function postParse($router, $uri)
	{
		$router->setVars($this->vars);

		if (isset($this->vars['Itemid']))
		{
			$this->menu->setActive($this->vars['Itemid']);
		}
	}

	public function preBuildExtension($router, $uri)
	{
		// Get application
		$application = JFactory::getApplication();

		// Get query
		$query = $uri->getQuery(true);

		// Reset route
		$this->route = '';

		// If it's a menu skip
		if ($this->hasMenuItem($query))
		{
			return;
		}

		// Iterate over rules
		foreach ($this->rules as $rule)
		{

			// Filter by language
			if ($application->isSite() && $application->getLanguageFilter())
			{
				if (!isset($query['lang']) || !$query['lang'])
				{
					$language = $this->defaultLanguage->lang_code;
				}
				else
				{
					$language = $this->languages[$query['lang']]->lang_code;
				}

				if ($rule->getLanguage() != $language)
				{
					continue;
				}
			}

			// First check, all rule keys should exist in the query
			$difference = array_diff($rule->getRouteKeys(), array_keys($query));

			if (count($difference))
			{
				continue;
			}

			// Second check, all rule values that are not dynamic or empty should match in the query
			$match = true;

			foreach ($rule->getRouteValues() as $name => $value)
			{
				if (!isset($query[$name]) || $query[$name] != $value)
				{
					$match = false;

					break;
				}
			}

			if (!$match)
			{
				continue;
			}

			// Unset the Itemid
			if (isset($query['Itemid']))
			{
				if ($query['Itemid'])
				{
					$active = $this->menu->getItem($query['Itemid']);
				}
				unset($query['Itemid']);
			}

			// The new route is the pattern with the tokens replaced with the corresponsing variables
			$this->route = str_replace($rule->getTokens(), $rule->getTokensValues($query), $rule->getPattern());

			// Unset all route variables
			foreach ($rule->getVariables() as $variable => $value)
			{
				if (isset($query[$variable]))
				{
					unset($query[$variable]);
				}
			}

			// Unset menu variables since they are not direct menu link. We already have all we need
			if (isset($active))
			{
				foreach ($active->query as $variable => $value)
				{
					if (isset($query[$variable]))
					{
						unset($query[$variable]);
					}
				}
			}

			// Update the query
			$query = array_filter($query);
			$uri->setQuery($query);

			// Remove language prefix - Joomla will handle this
			if ($rule->getPrefix())
			{
				$this->route = $this->removePrefix($this->route);
			}
		}
	}

	public function postBuild($router, $uri)
	{
		if ($this->route)
		{
			$uri->setPath($uri->getPath() . '/' . $this->route);
		}
	}

	private function hasMenuItem($query)
	{
		if (!isset($query['option']))
		{
			return false;
		}

		$result = false;
		$component = JComponentHelper::getComponent($query['option']);

		$conditions = array('component_id');
		$values = array($component->id);

		$application = JFactory::getApplication();

		if ($application->isSite() && $application->getLanguageFilter())
		{
			$languages = array('*');

			foreach ($this->languages as $language)
			{
				$languages[] = $language->lang_code;
			}
			$conditions[] = 'language';
			$values[] = $languages;
		}

		$items = $this->menu->getItems($conditions, $values);

		foreach ($items as $item)
		{
			$vars = $item->query;
			$total = count($vars);
			$matching = 0;

			foreach ($vars as $key => $value)
			{
				$check = isset($query[$key]) && $query[$key] == $value;

				if (is_numeric($value))
				{
					$check = isset($query[$key]) && (int) $query[$key] == (int) $value;
				}

				if ($check)
				{
					$matching++;
				}
			}

			if ($matching == $total)
			{
				$result = true;

				break;
			}
		}

		return $result;
	}

	private function removePrefix($path)
	{
		$parts = explode('/', $path);
		$parts = array_filter($parts);
		array_shift($parts);
		$path = implode('/', $parts);

		return $path;
	}

	private function addSuffix($path, $suffix)
	{
		return $path .= $suffix;
	}

	private function addTrailingSlash($path)
	{
		if ($path == '/')
		{
			return $path;
		}

		return $path .= '/';
	}
}
